<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Command;

use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateLandlord extends Command
{
    protected Application $phinx;

    public function __construct(Application $phinx = null)
    {
        parent::__construct();
        $this->phinx = $phinx ?? new PhinxApplication();
    }

    protected function configure(): void
    {
        $this->setName("landlord:migrate")
            ->setDescription("Migrate the Landlord database");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->phinx = new PhinxApplication();

        $arguments = [
            'command' => 'migrate',
            '--environment' => 'landlord',
            '--configuration' => dirname(dirname(__DIR__)) . '/phinx.php',
            '-vvv'
        ];

        return $this->phinx->run(new ArrayInput($arguments), $output);
    }
}
