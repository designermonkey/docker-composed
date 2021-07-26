<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Command;

use PHPUnit\Framework\TestCase;
use Phinx\Console\PhinxApplication;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;

class LandlordTest extends TestCase
{
    private Application $phinx;

    public function setUp(): void
    {
        $this->phinx = new PhinxApplication();
        // $this->phinx->setAutoExit(false);
    }

    public function testThatCommandMigrateLandlordDatabase(): void
    {
        $subject = new MigrateLandlord($this->phinx);
        $responseCode = $subject->run(new ArrayInput([]), $output = new );

        var_dump($output);
    }

    public function tearDown(): void
    {
        $arguments = [
            'command' => 'rollback',
            '--environment' => 'landlord',
            '--target' => 0,
            '--configuration' => dirname(dirname(__DIR__)) . '/phinx.php'
        ];

        $this->phinx->run(new ArrayInput($arguments), new NullOutput());
    }
}
