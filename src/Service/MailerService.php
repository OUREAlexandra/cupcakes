<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendRegistrationEmail($email, $firstname, $lastname)
    {
        $emailUser = new TemplatedEmail();
        $emailUser
        ->from(new Address('alexandra.oure@gmail.com', 'Yummy Cupcakes'))
        ->to($email)
        ->subject('Bienvenue sur Yummy Cupcakes')
        ->htmlTemplate('emails/customer/newregistration.html.twig')
        ->context(['firstname' => $firstname, 'lastname' => $lastname]);

    }

    public function commandConfirmationBuyer($emailAddressBuyer, $firstname, $invoice)
    {
        $emailBuyer = new TemplatedEmail();
        $emailBuyer
        ->from(new Address('alexandra.oure@gmail.com', 'Yummy Cupcakes'))
        ->to($emailAddressBuyer)
        ->subject('Votre commande a bien été prise en compte')
        ->htmlTemplate('emails/customer/buyer/neworder.html.twig');
        // ->context(['firstname' => $firstname, 'invoice' => $invoice]);

        $emailAdmin = new TemplatedEmail();
        $emailAdmin
        ->from(new Address('alexandra.oure@gmail.com', 'Yummy Cupcakes'))
        ->to('alexandra.oure@hotmail.com')
        ->subject('Une nouvelle commande a été effectuée')
        ->htmlTemplate('emails/admin/confirmationorder.html.twig');
        // ->context(['invoice' => $invoice]);

        // foreach ($invoiceProducts as $invoiceProduct) {
        //     $emailAddressSupplier = $invoiceProduct->getCatalog()->getSupplier()->getEmail();
        //     $firstname = $invoiceProduct->getCatalog()->getSupplier()->getFirstname();
        //     $emailSupplier = new TemplatedEmail();
        //     $emailSupplier
        //     ->from(new Address('contact@hall-in-bio.com', 'Alban et Arthur de Hall in Bio'))
        //     ->to($emailAddressSupplier)
        //     ->subject('Une commande a été effectuée')
        //     ->htmlTemplate('emails/customer/supplier/neworder.html.twig')
        //     ->context(['firstname' => $firstname, 'invoiceProduct' => $invoiceProduct]);

        //     $this->mailer->send($emailSupplier);
        // }

        $this->mailer->send($emailAdmin);
        $this->mailer->send($emailBuyer);
    }

    public function contactUs($firstname, $lastname, $emailSender, $telephone, $message)
    {
        $emailContact = new TemplatedEmail();
        $emailContact
        ->from($emailSender)
        ->to(new Address('contact@hall-in-bio.com'))
        ->subject('Vous avez un nouveau message')
        ->htmlTemplate('emails/admin/newcontact.html.twig')
        ->context(['firstname' => $firstname, 'lastname' => $lastname, 'emailSender' => $emailSender, 'telephone' => $telephone, 'message' => $message]);
        $this->mailer->send($emailContact);
    }

}
