<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Migrations;

use Phinx\Db\Table;
use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class CreateTenantsTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tenants');

        $this->addColumns($table);
        $table->save();

        if ($this->canGenerateColumns()) {
            $table->addColumn('uuid_bin', 'binary', [
                'length' => 16,
                'null' => false,
                'after' => 'id',
            ]);
            $table->save();

            $this->addGeneratedColumn($table);
            $this->addTrigger();
        } else {
            $table->addColumn('uuid', 'string', [
                'length' => 36,
                'null' => false,
            ]);
            $table->save();
        }
    }

    public function down(): void
    {
        $table = $this->table('tenants');
        $table->drop();

        if ($this->canGenerateColumns()) {
            $this->dropTrigger($table);
        }

        $table->save();
    }

    private function addColumns(Table $table): void
    {
        $table->addColumn('code', 'string', [
            'length' => 127,
            'null' => false,
        ]);

        $table->addColumn('name', 'string', [
            'length' => 255,
            'null' => false,
        ]);

        $table->addColumn('is_active', 'integer', [
            'length' => 1,
            'null' => false,
            'signed' => 1,
            'default' => 0,
        ]);
    }

    private function canGenerateColumns(): bool
    {
        return in_array($this->getAdapter()->getAdapterType(), ['pgsql', 'mysql']);
    }

    private function addGeneratedColumn(Table $table): void
    {
        $this->getAdapter()->execute("
            alter table `tenants` add column `uuid` varchar(36) generated always as (lcase(insert(insert(insert(insert(hex(`uuid_bin`),9,0,'-'),14,0,'-'),19,0,'-'),24,0,'-'))) stored after `uuid_bin`
        ");
    }

    private function addTrigger(): void
    {
        $this->getAdapter()->execute('
            drop trigger if exists `insert_uuid_bin`;
        ');

        $this->getAdapter()->execute('
            create trigger `insert_uuid_bin`
            before insert on `tenants` for each row
            begin
                if new.`uuid` is not null then
                    set new.`uuid_bin` = unhex(replace(new.`uuid`,"-",""));
                    set new.`uuid` = null;
                end if;
            end;
        ');
    }

    private function dropTrigger(Table $table): void
    {
        $this->getAdapter()->execute('
            drop trigger if exists `insert_uuid_bin`
        ');
    }
}
