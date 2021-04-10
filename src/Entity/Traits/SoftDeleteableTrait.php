<?php

namespace App\Entity\Traits;

use DateTime;
use Gedmo\Mapping\Annotation as Gedmo;

trait SoftDeleteableTrait
{

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}