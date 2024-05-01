<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class MailService
{
    public static function sendEmail($to, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   =  Email_USERNAME;
            $mail->Password   =  Email_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('woodcraftfurnitureslk@gmail.com', 'WoodCraft Furnitures');
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $body = "<body style='font-family: Montserrat, sans-serif; margin:0; padding:0;'>
                        <table style='width: 100%; max-width: 600px; margin: 0 auto;'>
                            <tr>
                                <td style='background-color: #212121; padding: 20px; color: #6D9886; text-align: center;'>
                                    <div class='navl-cont'>
                                         <a
                                            class='nav__logo' style='font-size: 1.5rem; color: #6D9886;
                                            font-weight: 500;'> WoodCraft Furnitures </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding: 20px; background-color: #F6F6F6;'>
                                    <h3 style='color: #666;'>Dear Customer,</h3>
                                    <p style='color: #666;'>".$message."</p>
                                    <p style='color: #666;'>Best Regards,<br>WoodCraft Furniture Company.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='background-color: #212121; color: #6D9886; text-align: center; padding: 1px; padding-top: 5px; padding-bottom: 5px;'>
                                    <p style='font-size: 0.7em; margin: 0; padding: 0.2em; padding-bottom :1rem; padding-top :1rem;'>
                                        Email: <a href='mailto:woodcraftfurnitureslk@gmail.com'
                                            style='color: #6D9886;'>woodcraftfurnitureslk@gmail.com</a> |
                                        Tel: +(94)112435200
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </body>";
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->send();
            // echo 'Message has been sent';
            // return true;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // return false;
        }
    }

    public static function sendEmailwithAttachment($to, $subject, $message, $attachment)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'woodcraftfurnitureslk@gmail.com';
            $mail->Password   = 'oama sezd yjhq zjnf';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('woodcraftfurnitureslk@gmail.com', 'WoodCraft Furnitures');
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $body = "<body style='font-family: Montserrat, sans-serif; margin:0; padding:0;'>
                        <table style='width: 100%; max-width: 600px; margin: 0 auto;'>
                            <tr>
                                <td style='background-color: #212121; padding: 20px; color: #6D9886; text-align: center;'>
                                    <div class='navl-cont'>
                                         <a
                                            class='nav__logo' style='font-size: 1.5rem; color: #6D9886;
                                            font-weight: 500;'> WoodCraft Furnitures </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style='padding: 20px; background-color: #F6F6F6;'>
                                    <h3 style='color: #666;'>Dear Customer,</h3>
                                    <p style='color: #666;'>".$message."</p>
                                    <p style='color: #666;'>Best Regards,<br>WoodCraft Furniture Company.</p>
                                </td>
                            </tr>
                            <tr>
                                <td style='background-color: #212121; color: #6D9886; text-align: center; padding: 1px; padding-top: 5px; padding-bottom: 5px;'>

                                    
                                    <p style='font-size: 0.7em; margin: 0; padding: 0.2em; padding-bottom :1rem;  padding-top :1rem;'>
                                        Email: <a href='mailto:woodcraftfurnitureslk@gmail.com'
                                            style='color: #6D9886;'>woodcraftfurnitureslk@gmail.com</a> |
                                        Tel: +(94)112435200
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </body>";
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);

            $mail->addAttachment($attachment);

            $mail->send();
            // return true;
        } catch (Exception $e) {
            // return false;
        }
    }
}
