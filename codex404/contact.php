<?php
include 'includes/header.php';
include 'connection/connection.php';

$success = $error = "";

if (isset($_POST['submit'])) {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if ($name && $email && $message) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message)
                VALUES ('$name', '$email', '$subject', '$message')";

        if (mysqli_query($conn, $sql)) {
            $success = "Message sent successfully!";
        } else {
            $error = "Something went wrong. Try again.";
        }
    } else {
        $error = "Please fill all required fields.";
    }
}
?>

<section class="contact">
    <div class="container">
        <h3>Contact Us</h3>
        <p>Have a question or project? Send us a message.</p>

        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="post" class="contact-form">
            <input type="text" name="name" placeholder="Your Name *" required>
            <input type="email" name="email" placeholder="Your Email *" required>
            <input type="text" name="subject" placeholder="Subject">
            <textarea name="message" placeholder="Your Message *" required></textarea>
            <button type="submit" name="submit" class="btn primary">Send Message</button>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
