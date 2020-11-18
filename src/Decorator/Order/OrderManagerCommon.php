<?php


namespace App\Decorator\Order;


use App\Entity\License;
use App\Entity\Order\Order;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Sylius\Bundle\CoreBundle\Mailer\Emails;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

class OrderManagerCommon
{

    public function __construct(SenderInterface $emailSender, EntityManagerInterface $manager)
    {
        $this->emailSender = $emailSender;
        $this->manager = $manager;
    }

    public function sendConfirmationEmail(OrderInterface $order): void
    {
        if ($order instanceof Order && null === $order->getLicense()) {
            $license = new License();
            $license->setEnable(true);
            $license->setLicenseKey((Uuid::uuid4())->toString());
            $license->setOrder($order);

            $this->manager->persist($license);
            $order->setLicense($license);

            $this->manager->flush();
        }

        $this->emailSender->send(
            Emails::ORDER_CONFIRMATION_RESENT,
            [$order->getCustomer()->getEmail()],
            [
                'order' => $order,
                'channel' => $order->getChannel(),
                'localeCode' => $order->getLocaleCode(),
            ]
        );
    }
}
