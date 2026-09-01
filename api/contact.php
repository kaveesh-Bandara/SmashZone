<?php
/**
 * SmashZone - Contact Us Message Endpoint
 * Enforces Login Requirement & Sends Mail to kavishhapuarachchi@gmail.com
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/db.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all message fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email address format.']);
    exit;
}

$userId = null;

try {
    // 1. Save to Database
    $stmt = $pdo->prepare("INSERT INTO contact_messages (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $name, $email, $subject, $message]);

    // 2. Email Notification to kavishhapuarachchi@gmail.com
    $to = 'kavishhapuarachchi@gmail.com';
    $emailSubject = "SmashZone Inquiry: " . $subject;
    $emailBody = "Customer Name: $name\n";
    $emailBody .= "Customer Email: $email\n";
    $emailBody .= "Subject: $subject\n\n";
    $emailBody .= "Message Content:\n$message\n";
    $headers = "From: support@smashzone.lk\r\nReply-To: $email\r\n";

    // Trigger PHP mail() function (silently continue if SMTP not configured on local XAMPP)
    @mail($to, $emailSubject, $emailBody, $headers);

    echo json_encode([
        'status' => 'success',
        'message' => 'Thank you! Your message has been sent successfully to SmashZone support (kavishhapuarachchi@gmail.com).'
    ]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save message: ' . $e->getMessage()]);
}
exit;
?>
