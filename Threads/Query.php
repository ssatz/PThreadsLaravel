<?php

namespace Threads;


class Query extends \Threaded
{
    protected $sql;
    protected $result;
    public function __construct($sql) {
        $this->sql = $sql;

    }

    public function run()    {
        require '././vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        $mysql = $this->worker->createConnection();
        $sth = $mysql->prepare($this->sql);
        $sth->execute();
        $results = $sth->fetchAll();
        try {
            $mail = new \PHPMailer();
            $mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'node4.mailpixels.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );                          // Enable SMTP authentication
            $mail->Username = 'dinu.865@gmail.com';                 // SMTP username
            $mail->Password = 'spiceuser';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->setFrom('no-reply@freshworkers.com', 'Mailer');
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->addAddress('sathish.thi@gmail.com','sathish');
            if(!$mail->send()){
                print_r("Mailer Error: " . $mail->ErrorInfo);
            }
            else{
                print_r('Mail Sent');
            }
            $mail->ClearAddresses();
           /* foreach ($results as $result) {
                $mail->addAddress($result['email'], $result['name']);
                $mail->send();
                $mail->ClearAddresses();
                $mail->ClearAttachments();
            } */
        }
        catch (\Exception $e) {
            print_r($e);
        }

    }
}