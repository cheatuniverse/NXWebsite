<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Decorator\Order;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\AdminBundle\EmailManager\OrderEmailManagerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class AdminOrderEmailManager implements OrderEmailManagerInterface
{
    /** @var SenderInterface */
    private $emailSender;

    /** @var EntityManagerInterface */
    private $manager;

    /** @var OrderManagerCommon */
    private $common;

    public function __construct(OrderEmailManagerInterface $o, SenderInterface $emailSender, EntityManagerInterface $manager, OrderManagerCommon $common)
    {
        $this->common = $common;
        $this->emailSender = $emailSender;
        $this->manager = $manager;
    }

    public function sendConfirmationEmail(OrderInterface $order): void
    {
        $this->common->sendConfirmationEmail($order);
    }
}
