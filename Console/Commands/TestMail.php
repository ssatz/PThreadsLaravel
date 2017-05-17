<?php

namespace Artisan\Console\Commands;

use Illuminate\Console\Command;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Mail check with smtp server.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mail = new \PHPMailer();
        $mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.neononlinemarketing.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );                          // Enable SMTP authentication
        $mail->Username = 'neon-online-marketing/paisaclub';                 // SMTP username
        $mail->Password = 'zJDXnWdePgvWFTdwSbTJHOhz';                           // SMTP password
        $mail->SMTPSecure = 'SSL';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 25;                                    // TCP port to connect to
        $mail->setFrom('no-reply@paisaclub.com', 'Mailer');
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Increased Threads with 30,000';
        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->addAddress('sathish.thi@gmail.com','sathish');
        $mail->addAddress('sathish.thi@gmail.com','sathish');
        $mail->send();
        $mail->ClearAddresses();
        $mail->ClearAttachments();

    }
}
