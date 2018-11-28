<?php
namespace App\Actions;

use App\Entity\Contact;
use Twig\Environment;

class SendingMail
{

    private  $mailer;

    private $env;

    public function  __construct(\Swift_Mailer $mailer,Environment $env)
    {
        $this->mailer = $mailer;
        $this->env = $env;
    }


    public function sendMail(Contact $contact)
    {

        $message = (new \Swift_Message('Formulaire de Contact'))
            ->setFrom([$contact->getEmail() => 'Contact'])
            ->setTo('duhameltonyeyzo@gmail.com')
            ->setBody($this->env->render('mail/contact.html.twig',[
                'message' => $contact->getMessage()
            ]),'text/html','utf-8');

        $this->mailer->send($message);

    }






}