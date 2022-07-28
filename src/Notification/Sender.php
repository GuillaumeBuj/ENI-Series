<?php

namespace App\Notification;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\User\UserInterface;

class Sender
{

    public function __construct(protected MailerInterface $mailer){
        $this->mailer=$this->mailer;
    }

    public function sendNewUserNotificationToAdmin(UserInterface $user):void{
        //file_put_contents('debug.txt', $user->getEmail()); TEST

        $message = new Email();
        $message->from('accounts@series.com')
            ->to('admin@series.com')
            ->subject('New account created on series.com')
            ->html('<h1>New account!</h1>email: ' . $user->getEmail());

        $this->mailer->send($message);
    }
}