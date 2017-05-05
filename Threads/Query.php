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
        require '././vendor/phpmailer/PHPMailerAutoload.php';
        $mysql = $this->worker->createConnection();
        $sth = $mysql->prepare($this->sql);
        $sth->execute();
        $results = $sth->fetchAll();
        $mail = new \PHPMailer();
        print_r($mail);
        //$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'node4.mailpixels.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'dinu.865@gmail.com';                 // SMTP username
        $mail->Password = 'spiceuser';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('no-reply@freshworker.com', 'Mailer');
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        foreach ($results as $result){
            $mail->addAddress($result['email'], $result['name']);
            print_r($result);
            $mail->send();
        }

    }
}