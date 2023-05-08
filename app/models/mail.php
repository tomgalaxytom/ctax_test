<?php

require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

require 'phpmailer/PHPMailerAutoload.php';

class mail
{
  
    public function __construct()
    {
        $this->db = new Database;
    }

    function send_mail($email_name,$user_name,$mail_subject,$mail_body)
    {
        $mail = new PHPMailer;
        // $mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.tn.gov.in';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        // $mail->Username = 'support-tnctp';                 // SMTP username
        // $mail->Password = '0xoMQUBn';                           // SMTP pwd
        // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        // $mail->Port = 465;                                    // TCP port to connect to
        // //$mail->Host = 'tls://smtp.gmail.com:587';
        // 'ssl' => array (
        //     'verify_peer' => false,
        //     'verify_peer_name' => false
        //     )


                $mail->Username = 'mybillmyright';                 // SMTP username
                $mail->Password = 'zoos4bah';                           // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to
                $mail->SMTPOptions = array (
               'ssl' => array (
                   'verify_peer' => false,
                   'verify_peer_name' => false
               )
           );

        $mail->setFrom('mybillmyright@tn.gov.in', 'Commercial Tax');
        $mail->FromName = 'Commercial Tax';

        $mail->addAddress($email_name,  $user_name);
        $mail->isHTML(true);                                  // Set email format to HTML
        // $mail->Subject = 'Password';
        $mail->Subject = $mail_subject;

        $mail->Body    = $mail_body;

       
        return $mail->send();
    }



}