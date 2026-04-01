<?php

declare(strict_types=1);

namespace App\Command;

use App\Document\MyEmbed;
use App\Document\WithExplicitTracking;
use App\Document\WithImplicitTracking;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:test:init', description: 'Execute bug reproduction')]
class TestInitCommand
{
    public function __construct(private DocumentManager $dm)
    {
    }

    public function __invoke(SymfonyStyle $io, Application $application): int
    {
        $io->info('Dropping MongoDB schema.');

        $resetCmd = new ArrayInput([
            'command' => 'doctrine:mongodb:schema:drop',
        ]);
        $resetCmd->setInteractive(false);
        $application->doRun($resetCmd, new NullOutput());

        $io->info('Creating MongoDB schema.');

        $createCmd = new ArrayInput([
            'command' => 'doctrine:mongodb:schema:create',
        ]);
        $createCmd->setInteractive(false);
        $application->doRun($createCmd, new NullOutput());

        $io->info('Creating test data.');

        $implicit = (new WithImplicitTracking())
            ->setMyProperty('Implicit Property')
            ->setEmbeds((new MyEmbed())->setMyEmbeddedValue('Implicit Embedded Value'))
        ;
        $this->dm->persist($implicit);

        $explicit = (new WithExplicitTracking())
            ->setMyProperty('Explicit Property')
            ->setEmbeds((new MyEmbed())->setMyEmbeddedValue('Explicit Embedded Value'))
        ;
        $this->dm->persist($explicit);

        $this->dm->flush();

        return Command::SUCCESS;
    }
}
