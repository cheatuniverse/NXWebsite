<?php

declare(strict_types=1);

namespace App\Entity\Order;

use App\Entity\License;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order")
 */
class Order extends BaseOrder
{
    /**
     * @var License|null
     * @ORM\JoinColumn(name="license_id", nullable=true)
     * @ORM\OneToOne(targetEntity=License::class, inversedBy="order")
     */
    private $license = null;

    public function getLicense(): ?License
    {
        return $this->license;
    }

    public function setLicense(?License $license): self
    {
        $this->license = $license;
        return $this;
    }
}
