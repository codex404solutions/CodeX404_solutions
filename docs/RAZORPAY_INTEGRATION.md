# CodeX404 Solutions — Razorpay Integration Specification

## Overview

Razorpay will be used for:
- Invoice payments (clients paying for services)
- Recurring retainer payments (future)
- Subscription billing (future SaaS products)

**Integration Type:** Server-side integration with Razorpay Checkout

---

## Razorpay Account Setup

### Step 1: Create Account
```text
1. Visit: https://razorpay.com/
2. Sign up with business email: info@codex404solutions.com
3. Verify email and phone
4. Complete KYC (business documents)
```

### Step 2: Get API Keys
```text
Dashboard → Settings → API Keys

Test Mode:
- Key ID: rzp_test_xxxxxxxxxxxxxxx
- Key Secret: xxxxxxxxxxxxxxxxxxxxxxxx

Live Mode (after KYC approval):
- Key ID: rzp_live_xxxxxxxxxxxxxxx
- Key Secret: xxxxxxxxxxxxxxxxxxxxxxxx
```

### Step 3: Configure Webhooks
```text
Dashboard → Settings → Webhooks → Add Webhook

URL: https://crm.codex404solutions.online/api/razorpay/webhook
Events to subscribe:
- payment.authorized
- payment.captured
- payment.failed
- refund.created
- order.paid

Webhook Secret: whsec_xxxxxxxxxxxxxxxxxx
```

---

## Installation

### Composer Installation
```bash
cd /path/to/crm
composer require razorpay/razorpay:^2.9
```

### Environment Variables
```env
# .env file
RAZORPAY_KEY_ID=rzp_test_xxxxxxxxxxxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxxxxxxxxxxxxxxxx
RAZORPAY_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxx
RAZORPAY_MODE=test  # 'test' or 'live'
```

---

## Database Schema

### Orders Table
```sql
CREATE TABLE razorpay_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id VARCHAR(100) UNIQUE NOT NULL, -- Razorpay order_id
    invoice_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'INR',
    receipt VARCHAR(100),
    status ENUM('created', 'attempted', 'paid', 'cancelled') DEFAULT 'created',
    notes JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id),
    INDEX idx_order_id (order_id),
    INDEX idx_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Payments Table
```sql
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_id VARCHAR(100) UNIQUE NOT NULL, -- Razorpay payment_id
    order_id VARCHAR(100), -- Razorpay order_id
    invoice_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'INR',
    status ENUM('created', 'authorized', 'captured', 'failed', 'refunded') DEFAULT 'created',
    method VARCHAR(20), -- 'card', 'upi', 'netbanking', 'wallet'
    email VARCHAR(255),
    contact VARCHAR(20),
    error_code VARCHAR(50),
    error_description TEXT,
    captured_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id),
    INDEX idx_payment_id (payment_id),
    INDEX idx_order_id (order_id),
    INDEX idx_invoice (invoice_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Refunds Table
```sql
CREATE TABLE refunds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    refund_id VARCHAR(100) UNIQUE NOT NULL, -- Razorpay refund_id
    payment_id VARCHAR(100) NOT NULL,
    invoice_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'INR',
    reason TEXT,
    status ENUM('pending', 'processed', 'failed') DEFAULT 'pending',
    processed_at TIMESTAMP NULL,
    created_by INT, -- User who initiated refund
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id),
    FOREIGN KEY (created_by) REFERENCES users(id),
    INDEX idx_refund_id (refund_id),
    INDEX idx_payment_id (payment_id),
    INDEX idx_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Webhook Logs Table
```sql
CREATE TABLE razorpay_webhook_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    event VARCHAR(50) NOT NULL,
    payload JSON NOT NULL,
    signature VARCHAR(255),
    signature_valid BOOLEAN,
    processed BOOLEAN DEFAULT FALSE,
    error TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP NULL,
    INDEX idx_event (event),
    INDEX idx_processed (processed),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## Payment Flow Implementation

### Step 1: Create Invoice (CRM)
```php
// InvoiceController.php
public function createInvoice($clientId, $items, $dueDate) {
    // Create invoice in database
    $invoice = [
        'client_id' => $clientId,
        'invoice_number' => generateInvoiceNumber(),
        'subtotal' => calculateSubtotal($items),
        'tax' => calculateTax($items),
        'total' => calculateTotal($items),
        'currency' => 'INR',
        'due_date' => $dueDate,
        'status' => 'draft'
    ];
    
    $invoiceId = DB::insert('invoices', $invoice);
    
    // Insert invoice items
    foreach ($items as $item) {
        DB::insert('invoice_items', [
            'invoice_id' => $invoiceId,
            'description' => $item['description'],
            'quantity' => $item['quantity'],
            'unit_price' => $item['unit_price'],
            'amount' => $item['amount']
        ]);
    }
    
    // Update status to 'sent'
    DB::update('invoices', ['status' => 'sent'], ['id' => $invoiceId]);
    
    // Send invoice email to client
    sendInvoiceEmail($invoiceId);
    
    return $invoiceId;
}
```

### Step 2: Generate Payment Link
```php
// PaymentController.php
require 'vendor/autoload.php';

use Razorpay\Api\Api;

public function generatePaymentLink($invoiceId) {
    // Get invoice
    $invoice = DB::select('invoices', ['id' => $invoiceId]);
    $client = DB::select('clients', ['id' => $invoice['client_id']]);
    
    // Initialize Razorpay API
    $api = new Api(
        getenv('RAZORPAY_KEY_ID'), 
        getenv('RAZORPAY_KEY_SECRET')
    );
    
    // Create Razorpay Order
    $orderData = [
        'receipt' => 'INV-' . $invoice['invoice_number'],
        'amount' => $invoice['total'] * 100, // Amount in paise (INR smallest unit)
        'currency' => $invoice['currency'],
        'notes' => [
            'invoice_id' => $invoice['id'],
            'invoice_number' => $invoice['invoice_number'],
            'client_name' => $client['name']
        ]
    ];
    
    try {
        $order = $api->order->create($orderData);
        
        // Store order in database
        DB::insert('razorpay_orders', [
            'order_id' => $order['id'],
            'invoice_id' => $invoice['id'],
            'amount' => $invoice['total'],
            'currency' => $invoice['currency'],
            'receipt' => $orderData['receipt'],
            'status' => 'created',
            'notes' => json_encode($orderData['notes'])
        ]);
        
        // Generate payment URL
        $paymentUrl = "https://crm.codex404solutions.online/pay/{$invoice['id']}?order_id={$order['id']}";
        
        // Update invoice with payment link
        DB::update('invoices', [
            'payment_link' => $paymentUrl
        ], ['id' => $invoice['id']]);
        
        return [
            'success' => true,
            'order_id' => $order['id'],
            'payment_url' => $paymentUrl
        ];
        
    } catch (Exception $e) {
        logError('Razorpay order creation failed: ' . $e->getMessage());
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
```

### Step 3: Payment Page (Client-Facing)
```php
// pay.php (Public payment page)
<?php
require 'config/database.php';

$invoiceId = $_GET['invoice_id'] ?? null;
$orderId = $_GET['order_id'] ?? null;

if (!$invoiceId || !$orderId) {
    die('Invalid payment link');
}

// Get invoice and order
$invoice = DB::select('invoices', ['id' => $invoiceId]);
$order = DB::select('razorpay_orders', ['order_id' => $orderId]);
$client = DB::select('clients', ['id' => $invoice['client_id']]);

if (!$invoice || !$order || $invoice['status'] === 'paid') {
    die('Invoice not found or already paid');
}

$razorpayKeyId = getenv('RAZORPAY_KEY_ID');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Invoice #<?= $invoice['invoice_number'] ?></title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f8fafc;
        }
        .invoice-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            margin: 30px 0;
            padding: 20px;
            background: #f1f5f9;
            border-radius: 8px;
        }
        .amount {
            font-size: 36px;
            font-weight: bold;
            color: #2563EB;
            text-align: center;
            margin: 20px 0;
        }
        .pay-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .pay-button:hover {
            transform: translateY(-2px);
        }
        .secure-badge {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="invoice-card">
        <div class="logo">
            <h1>CodeX404 Solutions</h1>
        </div>
        
        <div class="invoice-details">
            <p><strong>Invoice Number:</strong> <?= htmlspecialchars($invoice['invoice_number']) ?></p>
            <p><strong>Client:</strong> <?= htmlspecialchars($client['name']) ?></p>
            <p><strong>Due Date:</strong> <?= date('d M Y', strtotime($invoice['due_date'])) ?></p>
        </div>
        
        <div class="amount">
            <?= $invoice['currency'] ?> <?= number_format($invoice['total'], 2) ?>
        </div>
        
        <button id="rzp-button" class="pay-button">
            Pay Now with Razorpay
        </button>
        
        <div class="secure-badge">
            🔒 Secure payment powered by Razorpay
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('rzp-button').onclick = function(e) {
            var options = {
                "key": "<?= $razorpayKeyId ?>",
                "amount": "<?= $order['amount'] * 100 ?>", // Amount in paise
                "currency": "<?= $order['currency'] ?>",
                "name": "CodeX404 Solutions",
                "description": "Invoice #<?= $invoice['invoice_number'] ?>",
                "order_id": "<?= $order['order_id'] ?>",
                "prefill": {
                    "name": "<?= htmlspecialchars($client['name']) ?>",
                    "email": "<?= htmlspecialchars($client['email']) ?>",
                    "contact": "<?= htmlspecialchars($client['phone'] ?? '') ?>"
                },
                "theme": {
                    "color": "#2563EB"
                },
                "handler": function (response) {
                    // Payment successful
                    // Send to verification endpoint
                    fetch('/api/razorpay/verify-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            invoice_id: <?= $invoiceId ?>
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/payment-success?invoice=<?= $invoice['invoice_number'] ?>';
                        } else {
                            alert('Payment verification failed. Please contact support.');
                        }
                    })
                    .catch(err => {
                        alert('Error: ' + err.message);
                    });
                },
                "modal": {
                    "ondismiss": function() {
                        console.log('Payment cancelled');
                    }
                }
            };
            
            var rzp = new Razorpay(options);
            rzp.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
```

### Step 4: Verify Payment (Server-Side)
```php
// api/razorpay/verify-payment.php
<?php
require 'vendor/autoload.php';
require 'config/database.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

$paymentId = $data['razorpay_payment_id'];
$orderId = $data['razorpay_order_id'];
$signature = $data['razorpay_signature'];
$invoiceId = $data['invoice_id'];

// Verify signature
$api = new Api(getenv('RAZORPAY_KEY_ID'), getenv('RAZORPAY_KEY_SECRET'));

try {
    // Verify payment signature
    $attributes = [
        'razorpay_order_id' => $orderId,
        'razorpay_payment_id' => $paymentId,
        'razorpay_signature' => $signature
    ];
    
    $api->utility->verifyPaymentSignature($attributes);
    
    // Signature valid - fetch payment details
    $payment = $api->payment->fetch($paymentId);
    
    // Store payment in database
    DB::insert('payments', [
        'payment_id' => $payment['id'],
        'order_id' => $payment['order_id'],
        'invoice_id' => $invoiceId,
        'amount' => $payment['amount'] / 100, // Convert paise to rupees
        'currency' => $payment['currency'],
        'status' => $payment['status'], // 'captured' if auto-capture enabled
        'method' => $payment['method'],
        'email' => $payment['email'],
        'contact' => $payment['contact'],
        'captured_at' => date('Y-m-d H:i:s', $payment['created_at'])
    ]);
    
    // Update invoice status
    DB::update('invoices', [
        'status' => 'paid',
        'paid_at' => date('Y-m-d H:i:s')
    ], ['id' => $invoiceId]);
    
    // Update order status
    DB::update('razorpay_orders', [
        'status' => 'paid'
    ], ['order_id' => $orderId]);
    
    // Send payment confirmation email
    sendPaymentConfirmationEmail($invoiceId, $paymentId);
    
    // Log activity in CRM
    logActivity([
        'type' => 'payment_received',
        'invoice_id' => $invoiceId,
        'amount' => $payment['amount'] / 100,
        'payment_id' => $paymentId
    ]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Payment verified successfully',
        'payment_id' => $paymentId
    ]);
    
} catch (SignatureVerificationError $e) {
    // Invalid signature
    logError('Payment signature verification failed: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'error' => 'Payment verification failed'
    ]);
    
} catch (Exception $e) {
    logError('Payment verification error: ' . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'error' => 'An error occurred'
    ]);
}
```

### Step 5: Webhook Handler
```php
// api/razorpay/webhook.php
<?php
require 'vendor/autoload.php';
require 'config/database.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

// Get webhook payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

// Log webhook
$webhookLogId = DB::insert('razorpay_webhook_logs', [
    'event' => json_decode($payload)->event ?? 'unknown',
    'payload' => $payload,
    'signature' => $signature,
    'signature_valid' => false,
    'processed' => false
]);

try {
    // Verify webhook signature
    $webhookSecret = getenv('RAZORPAY_WEBHOOK_SECRET');
    $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
    
    if (!hash_equals($expectedSignature, $signature)) {
        throw new SignatureVerificationError('Invalid webhook signature');
    }
    
    // Update log: signature valid
    DB::update('razorpay_webhook_logs', [
        'signature_valid' => true
    ], ['id' => $webhookLogId]);
    
    // Parse payload
    $data = json_decode($payload, true);
    $event = $data['event'];
    $paymentEntity = $data['payload']['payment']['entity'];
    
    // Handle different events
    switch ($event) {
        case 'payment.captured':
            handlePaymentCaptured($paymentEntity);
            break;
            
        case 'payment.failed':
            handlePaymentFailed($paymentEntity);
            break;
            
        case 'refund.created':
            handleRefundCreated($data['payload']['refund']['entity']);
            break;
            
        case 'order.paid':
            handleOrderPaid($data['payload']['order']['entity']);
            break;
            
        default:
            logInfo('Unhandled webhook event: ' . $event);
    }
    
    // Mark as processed
    DB::update('razorpay_webhook_logs', [
        'processed' => true,
        'processed_at' => date('Y-m-d H:i:s')
    ], ['id' => $webhookLogId]);
    
    http_response_code(200);
    echo json_encode(['status' => 'ok']);
    
} catch (SignatureVerificationError $e) {
    logError('Webhook signature verification failed');
    http_response_code(400);
    echo json_encode(['error' => 'Invalid signature']);
    
} catch (Exception $e) {
    logError('Webhook processing error: ' . $e->getMessage());
    
    DB::update('razorpay_webhook_logs', [
        'error' => $e->getMessage()
    ], ['id' => $webhookLogId]);
    
    http_response_code(500);
    echo json_encode(['error' => 'Processing failed']);
}

function handlePaymentCaptured($payment) {
    // Update payment status
    DB::update('payments', [
        'status' => 'captured',
        'captured_at' => date('Y-m-d H:i:s')
    ], ['payment_id' => $payment['id']]);
    
    // Find invoice from order notes
    $order = DB::select('razorpay_orders', ['order_id' => $payment['order_id']]);
    $notes = json_decode($order['notes'], true);
    $invoiceId = $notes['invoice_id'];
    
    // Update invoice if not already paid
    $invoice = DB::select('invoices', ['id' => $invoiceId]);
    if ($invoice['status'] !== 'paid') {
        DB::update('invoices', [
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s')
        ], ['id' => $invoiceId]);
        
        sendPaymentConfirmationEmail($invoiceId, $payment['id']);
    }
}

function handlePaymentFailed($payment) {
    DB::update('payments', [
        'status' => 'failed',
        'error_code' => $payment['error_code'],
        'error_description' => $payment['error_description']
    ], ['payment_id' => $payment['id']]);
    
    // Optionally notify client about failed payment
}

function handleRefundCreated($refund) {
    // Store refund
    $payment = DB::select('payments', ['payment_id' => $refund['payment_id']]);
    
    DB::update('refunds', [
        'status' => 'processed',
        'processed_at' => date('Y-m-d H:i:s')
    ], ['refund_id' => $refund['id']]);
    
    // Update payment status
    DB::update('payments', [
        'status' => 'refunded'
    ], ['payment_id' => $refund['payment_id']]);
    
    // Update invoice status
    DB::update('invoices', [
        'status' => 'refunded'
    ], ['id' => $payment['invoice_id']]);
}

function handleOrderPaid($order) {
    DB::update('razorpay_orders', [
        'status' => 'paid'
    ], ['order_id' => $order['id']]);
}
```

---

## Refund Implementation

```php
// RefundController.php
public function createRefund($paymentId, $amount, $reason) {
    // Check authorization
    if (!currentUser()->can('payment.refund')) {
        return ['success' => false, 'error' => 'Unauthorized'];
    }
    
    // Get payment
    $payment = DB::select('payments', ['payment_id' => $paymentId]);
    
    if (!$payment || $payment['status'] === 'refunded') {
        return ['success' => false, 'error' => 'Payment not found or already refunded'];
    }
    
    // Initialize Razorpay
    $api = new Api(getenv('RAZORPAY_KEY_ID'), getenv('RAZORPAY_KEY_SECRET'));
    
    try {
        // Create refund
        $refund = $api->payment->fetch($paymentId)->refund([
            'amount' => $amount * 100, // Amount in paise
            'speed' => 'normal', // 'normal' or 'optimum'
            'notes' => [
                'reason' => $reason
            ]
        ]);
        
        // Store refund
        DB::insert('refunds', [
            'refund_id' => $refund['id'],
            'payment_id' => $paymentId,
            'invoice_id' => $payment['invoice_id'],
            'amount' => $amount,
            'currency' => $payment['currency'],
            'reason' => $reason,
            'status' => 'pending',
            'created_by' => currentUser()->id
        ]);
        
        // If full refund, update invoice
        if ($amount >= $payment['amount']) {
            DB::update('invoices', [
                'status' => 'refunded'
            ], ['id' => $payment['invoice_id']]);
        } else {
            DB::update('invoices', [
                'status' => 'partially_refunded'
            ], ['id' => $payment['invoice_id']]);
        }
        
        // Send refund notification
        sendRefundNotificationEmail($payment['invoice_id'], $refund['id'], $amount);
        
        return [
            'success' => true,
            'refund_id' => $refund['id'],
            'message' => 'Refund initiated successfully'
        ];
        
    } catch (Exception $e) {
        logError('Refund failed: ' . $e->getMessage());
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}
```

---

## Testing

### Test Mode
```php
// Use test keys in .env
RAZORPAY_KEY_ID=rzp_test_xxxxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxxxxxxxx
RAZORPAY_MODE=test
```

### Test Cards (Razorpay Provided)
```text
Success:
Card: 4111 1111 1111 1111
CVV: Any 3 digits
Expiry: Any future date
Name: Any name

Failure:
Card: 4111 1111 1111 1234
CVV: Any 3 digits
Expiry: Any future date
```

### Test UPI
```text
UPI ID: success@razorpay
```

### Test Checklist
- [ ] Create invoice
- [ ] Generate payment link
- [ ] Open payment page
- [ ] Complete payment with test card
- [ ] Verify payment recorded in CRM
- [ ] Verify invoice marked as paid
- [ ] Verify webhook received
- [ ] Test refund flow
- [ ] Test failed payment
- [ ] Test partial refund

---

## Security Best Practices

### 1. Never Store Card Data
```php
// ❌ NEVER DO THIS
$cardNumber = $_POST['card_number'];
DB::insert('payments', ['card_number' => $cardNumber]);

// ✅ DO THIS
// Let Razorpay Checkout handle card data
// Store only payment_id from Razorpay
```

### 2. Always Verify Signatures
```php
// Payment verification
$api->utility->verifyPaymentSignature($attributes);

// Webhook verification
$expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);
if (!hash_equals($expectedSignature, $signature)) {
    die('Invalid signature');
}
```

### 3. Use HTTPS Only
```apache
# .htaccess
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 4. Validate Amounts
```php
// Never trust client-side amounts
// Always fetch from database
$invoice = DB::select('invoices', ['id' => $invoiceId]);
$amount = $invoice['total']; // Use this, not $_POST['amount']
```

### 5. Log Everything
```php
// Log all payment operations
logPayment([
    'action' => 'payment_created',
    'payment_id' => $paymentId,
    'invoice_id' => $invoiceId,
    'amount' => $amount,
    'user_id' => currentUser()->id
]);
```

---

## Production Checklist

Before going live:
- [ ] Complete Razorpay KYC
- [ ] Switch to live API keys
- [ ] Update webhook URL to production
- [ ] Test live payment with small amount
- [ ] Set up bank account for settlements
- [ ] Enable 2FA on Razorpay dashboard
- [ ] Review Razorpay pricing/fees
- [ ] Set up payment failure alerts
- [ ] Document refund policy
- [ ] Train team on refund process

---

## Currency Support

### Current: INR (Indian Rupee)
```php
'currency' => 'INR'
```

### Future: Multi-Currency
```php
// Supported by Razorpay:
- USD, EUR, GBP
- AED, SAR (Middle East)
- SGD, MYR (Southeast Asia)
```

### Implementation
```php
$client = DB::select('clients', ['id' => $clientId]);
$currency = $client['country'] === 'India' ? 'INR' : 'USD';

// Store currency in invoice
'currency' => $currency
```

---

## Monitoring

### Razorpay Dashboard
- Daily settlement reports
- Failed payment reports
- Refund reports
- Dispute/chargeback alerts

### CRM Dashboard
```php
// Finance → Payment Analytics
- Total payments (today, week, month)
- Success rate
- Failed payments
- Pending refunds
- Average transaction value
```

### Alerts
```php
// Send email alert when:
- Payment fails 3 times for same invoice
- Refund requested
- Chargeback received
- Settlement delayed
```

---

## Support

### Razorpay Support
- Email: support@razorpay.com
- Phone: +91 80 68179111
- Dashboard: Raise ticket
- Docs: https://razorpay.com/docs/

### Common Issues

**Payment not captured:**
- Check webhook logs
- Verify signature validation
- Check Razorpay dashboard for payment status

**Webhook not received:**
- Verify webhook URL is HTTPS
- Check webhook secret matches
- Test webhook with Razorpay dashboard test feature

**Settlement delayed:**
- Usually 2-3 business days
- Check Razorpay dashboard → Settlements

---

**Last Updated:** October 2026  
**Version:** 1.0  
**Integration Status:** Test Mode (Switch to Live after KYC)
