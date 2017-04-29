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
        require '././vendor/swiftmailer/swiftmailer/lib/swift_required.php';
        $mysql = $this->worker->createConnection();
        $sth = $mysql->prepare($this->sql);
        $sth->execute();
        $results = $sth->fetchAll();
        $transport = \Swift_SmtpTransport::newInstance('node4.mailpixels.com', 587)
            ->setUsername('dinu.865@gmail.com')
            ->setPassword('spiceuser')
            ->setEncryption('TLS');

        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance('PHP Threads Test')
            ->setFrom(array('no-reply@freshworker.com' => 'PHP Test'))
            ->setBody('PHP Threads Test');
        print_r(count($results));
        foreach ($results as $result){
            $message->setTo($result['email']);
            $mailer->send($message);
        }
    }
}