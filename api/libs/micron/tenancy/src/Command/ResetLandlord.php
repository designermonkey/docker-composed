<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Command;

use Phinx\Console\Command\AbstractCommand;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetLandlord extends AbstractCommand
{
    protected Application $phinx;

    public function __construct(Application $phinx = null)
    {
        parent::__construct();
        $this->phinx = $phinx ?? new PhinxApplication();
    }

    protected function configure(): void
    {
        $this->setName("landlord:reset")
            ->setDescription("Reset the Landlord database to an empty database.");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $arguments = [
            'command' => 'rollback',
            '--target' => 0,
            '--environment' => 'landlord',
            '--configuration' => dirname(dirname(__DIR__)) . '/phinx.php',
        ];

        return $this->phinx->run(new ArrayInput(array_merge($arguments, [])), $output);
    }
}
