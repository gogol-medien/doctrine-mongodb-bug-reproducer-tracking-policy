<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\Document]
#[ODM\ChangeTrackingPolicy('DEFERRED_EXPLICIT')]
#[ODM\HasLifecycleCallbacks]
class WithExplicitTracking
{
    #[ODM\Id]
    protected ?string $id = null;

    #[ODM\EmbedMany(targetDocument: MyEmbed::class)]
    protected Collection $embeds;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->embeds = new ArrayCollection();
    }

    public function setEmbeds(MyEmbed ...$embeds): self
    {
        $this->embeds->clear();
        foreach ($embeds as $embed) {
            $this->embeds->add($embed);
        }

        return $this;
    }

    #[ODM\PreFlush]
    public function onFlush(): void
    {
        echo self::class."::onFlush() called\n";
    }
}
