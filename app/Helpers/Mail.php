<?php
namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->config();
    }
    public function config()
    {
        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Username = "kaungmyatsoe.m192@gmail.com";
        $this->mail->Password = "Kaungmyat81199";

        $this->mail->isHTML(true);
        $this->mail->setFrom("kaungmyatsoe.m192@gmail.com", "Budget App");
    }
    public function sendWelcome($data)
    {
        try {
            $this->mail->addAddress($data['address']);
            $this->mail->Subject = $data['subject'];

            $body = file_get_contents("../app/views/emails/sendWelcome.php");
            if(isset($data["template_variables"])) {
                foreach($data["template_variables"] as $key => $value) {
                    $body = str_replace('{' . strtoupper($key) . '}', $value, $body);
                }
            }
            $this->mail->msgHTML($body);
            $this->mail->send();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function sendResetPasswordToken($data) {
        try {
            $this->mail->addAddress($data['address'], $data['name']);
            $this->mail->Subject = $data['subject'];

            $body = file_get_contents("../app/views/emails/reset-password-token.php");
            if(isset($data["template_variables"])) {
                foreach($data["template_variables"] as $key => $value) {
                    $body = str_replace('{' . strtoupper($key) . '}', $value, $body);
                }
            }
            $this->mail->msgHTML($body);
            $this->mail->send();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
