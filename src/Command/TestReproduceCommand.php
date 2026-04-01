<?php

declare(strict_types=1);

namespace App\Command;

use App\Document\WithExplicitTracking;
use App\Document\WithImplicitTracking;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:test:reproduce', description: 'Hello PhpStorm')]
class TestReproduceCommand
{
    public function __construct(private DocumentManager $dm)
    {
    }
    public function __invoke(SymfonyStyle $io): int
    {
        /** @var WithImplicitTracking $implicit */
        $implicit = $this->dm->getRepository(WithImplicitTracking::class)->findOneBy([]);
        /** @var WithExplicitTracking $explicit */
        $explicit = $this->dm->getRepository(WithExplicitTracking::class)->findOneBy([]);

        $implicit->setEmbeds()->setMyProperty('Modified Implicit Property');
        $explicit->setEmbeds()->setMyProperty('Modified Explicit Property');

        $this->dm->flush();

        return Command::SUCCESS;
    }
}
