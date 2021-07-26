<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetLandlord extends MigrateLandlord
{
    protected function configure(): void
    {
        $this->setName("landlord:reset")
            ->setDescription("Reset the Landlord database to a clean migration");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $arguments = [
            'command' => 'rollback',
            // '--target' => 0,
            '--environment' => 'landlord',
            '--configuration' => dirname(dirname(__DIR__)) . '/phinx.php',
            '-vvv'
        ];

        $this->phinx->run(new ArrayInput($arguments), $output);

        // return parent::execute($input, $output);
    }
}
