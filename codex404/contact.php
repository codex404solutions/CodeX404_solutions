<?php
include 'includes/header.php';
include 'connection/connection.php';

date_default_timezone_set('Asia/Kolkata');

$success = "";
$msgError = "";
$projectError = "";

/* =========================
   MESSAGE FORM SUBMIT
========================= */
if (isset($_POST['send_message'])) {

    $name    = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email   = strtolower(mysqli_real_escape_string($conn, trim($_POST['email'])));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $msg     = mysqli_real_escape_string($conn, trim($_POST['message']));
    $time    = date('Y-m-d H:i:s');

    if (!$name || !$email || !$msg) {
        $msgError = "Please fill all required fields.";
    } else {

        $sql = "
        INSERT INTO contact_messages (name, email, subject, message, created_at)
        VALUES ('$name', '$email', '$subject', '$msg', '$time')
        ";

        if (mysqli_query($conn, $sql)) {
            $success = "Message sent successfully!";
            $_POST = [];
        } else {
            $msgError = "Something went wrong. Please try again.";
        }
    }
}

/* =========================
   PROJECT FORM SUBMIT
========================= */
if (isset($_POST['send_project'])) {

    $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email    = strtolower(mysqli_real_escape_string($conn, trim($_POST['email'])));
    $phone    = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $type     = mysqli_real_escape_string($conn, trim($_POST['project_type']));
    $budget   = mysqli_real_escape_string($conn, trim($_POST['budget']));
    $timeline = mysqli_real_escape_string($conn, trim($_POST['timeline']));
    $msg      = mysqli_real_escape_string($conn, trim($_POST['message']));
    $time     = date('Y-m-d H:i:s');

    if (!$timeline) {
        $projectError = "";
    }
    elseif (!$name || !$email || !$msg) {
        $projectError = "Please fill all required fields.";
    }
    else {

        $sql = "
        INSERT INTO project_requests
        (name, email, phone, project_type, budget, timeline, message, created_at)
        VALUES
        ('$name', '$email', '$phone', '$type', '$budget', '$timeline', '$msg', '$time')
        ";

        if (mysqli_query($conn, $sql)) {
            $success = "Project request submitted successfully!";
            $_POST = [];
        } else {
            $projectError = "Something went wrong. Please try again.";
        }
    }
}
?>

<section class="contact">
    <div class="container">
        <h2>Contact Us</h2>
        <p>Let’s discuss your idea or project.</p>

        <!-- SUCCESS MESSAGE -->
        <?php if ($success): ?>
            <p class="success auto-hide"><?= $success ?></p>
        <?php endif; ?>

        <!-- ERROR MESSAGES -->
        <?php if ($msgError): ?>
            <p class="error"><?= $msgError ?></p>
        <?php endif; ?>

        <?php if ($projectError): ?>
            <p class="error"><?= $projectError ?></p>
        <?php endif; ?>

        <!-- TABS -->
        <div class="contact-tabs">
            <button class="tab-btn active" data-tab="message">Message</button>
            <button class="tab-btn" data-tab="project">Project Form</button>
        </div>

        <!-- MESSAGE FORM -->
        <form method="post" class="contact-form tab-content active" id="message">
            <input type="text" name="name" placeholder="Your Name *" required>
            <input type="email" name="email" placeholder="Your Email *" required>
            <input type="text" name="subject" placeholder="Subject">
            <textarea name="message" placeholder="Your Message *" required></textarea>
            <button type="submit" name="send_message" class="btn primary">
                Send Message
            </button>
        </form>

        <!-- PROJECT FORM -->
        <form method="post" class="contact-form tab-content" id="project">
            <input type="text" name="name" placeholder="Your Name *" required>
            <input type="email" name="email" placeholder="Your Email *" required>
            <input type="text" name="phone" placeholder="Phone Number">

            <select name="project_type">
                <option value="">Project Type</option>
                <option>Website</option>
                <option>Web Application</option>
                <option>Mobile App</option>
                <option>AI Automation</option>
            </select>

            <select name="budget">
                <option value="">Estimated Budget</option>
                <option>Below ₹50,000</option>
                <option>₹50,000 – ₹1,00,000</option>
                <option>₹1,00,000+</option>
            </select>

            <select name="timeline" required>
                <option value="">Project Timeline *</option>
                <option>Immediately</option>
                <option>Within 1 Month</option>
                <option>1 – 3 Months</option>
                <option>3 – 6 Months</option>
                <option>Flexible</option>
            </select>

            <textarea name="message" placeholder="Project Details *" required></textarea>

            <button type="submit" name="send_project" class="btn primary">
                Submit Project
            </button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
