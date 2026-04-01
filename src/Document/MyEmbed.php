<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Attribute as ODM;

#[ODM\EmbeddedDocument]
class MyEmbed
{
    #[ODM\Field]
    protected ?string $myEmbeddedValue = null;

    public function getMyEmbeddedValue(): ?string
    {
        return $this->myEmbeddedValue;
    }

    public function setMyEmbeddedValue(?string $myEmbeddedValue): MyEmbed
    {
        $this->myEmbeddedValue = $myEmbeddedValue;

        return $this;
    }
}
