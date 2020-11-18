<?php

namespace App\Entity;

use App\Entity\Order\Order;
use App\Repository\LicenseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LicenseRepository::class)
 */
class License
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(length=1024, unique=true, nullable=true)
     */
    private $hwid;

    /**
     * @var string
     * @ORM\Column(length=1024, unique=true)
     */
    private $licenseKey;

    /**
     * @var bool
     * @ORM\Column(type="boolean", options={"default"=true})
     */
    private $enable;

    /**
     * @var Order
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="license", cascade={"persist"})
     */
    private $order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHwid(): ?string
    {
        return $this->hwid;
    }

    public function setHwid(?string $hwid): self
    {
        $this->hwid = $hwid;
        return $this;
    }

    public function getLicenseKey(): string
    {
        return $this->licenseKey;
    }

    public function setLicenseKey(string $licenseKey): self
    {
        $this->licenseKey = $licenseKey;
        return $this;
    }

    public function isEnable(): bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;
        return $this;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        $order->setLicense($this);
        return $this;
    }
}
