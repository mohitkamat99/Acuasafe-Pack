<?php

// Define some constants
define("RECIPIENT_NAME", "John Doe");
define("RECIPIENT_EMAIL", "mohitkamat99@gmail.com");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';


$mail = new PHPMailer(true);

// Read the form values
$success = false;
$userName = isset($_POST['username']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['username']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$userPhone = isset($_POST['phone']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone']) : "";
$userSubject = isset($_POST['subject']) ? preg_replace("/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message']) : "";

// If all values exist, send the email
if ($userName && $senderEmail && $userPhone && $userSubject && $message) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $userName . "";
  // $msgBody = " Name: " . $userName . " Email: " . $senderEmail . " Phone: " . $userPhone . " Subject: " . $userSubject . " Message: " . $message . "";
  // $success = mail($recipient, $headers, $msgBody);

  //make a msg body with proper format 
  $msgBody = " Name: " . $userName . "\n Email: " . $senderEmail . "\n Phone: " . $userPhone . "\n Subject: " . $userSubject . "\n Message: " . $message . "";

  //Create an instance; passing `true` enables exceptions
  try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'mohitkamat0110@gmail.com';                     //SMTP username
    $mail->Password = 'neig qxoz pejx jyue';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port = 465;                                    //TCP port to connect to
    $mail->setFrom("mohitkamat0110@gmail.com", "Mohit Kamat");
    $mail->addAddress(RECIPIENT_EMAIL, $userName);     //Add a recipient
    $mail->addReplyTo(RECIPIENT_EMAIL, RECIPIENT_NAME);
    $mail->isHTML(false);                                //Set email format to HTML
    $mail->Subject = $userSubject;
    $mail->Body = $msgBody;
    $mail->send();
    // echo 'Message has been sent';

    header('Location: contact.html?message=Successfull');
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }



  //Set Location After Successsfull Submission

} else {
  //Set Location After Unsuccesssfull Submission
  header('Location: contact.html?message=Failed');
}

?>