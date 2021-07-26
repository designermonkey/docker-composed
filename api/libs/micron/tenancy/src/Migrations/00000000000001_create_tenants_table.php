<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Migrations;

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;
use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class CreateTenantsTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tenants');

        $this->addColumns($table);

        if ($this->isMySQLAdapter()) {
            $this->createForMySQL($table);
        }

        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('tenants');
        $table->drop();

        if ($this->isMySQLAdapter()) {
            $this->dropMySQL($table);
        }

        $table->save();
    }

    private function addColumns(Table $table): void
    {
        $table->addColumn('uuid_bin', 'binary', [
            'length' => 16,
            'null' => false,
        ]);

        $table->addColumn('uuid', 'string', [
            'length' => 36,
            'null' => false,
        ]);

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
            'default' => 1,
        ]);
    }

    private function isMySQLAdapter(): bool
    {
        return $this->getAdapter() instanceof MysqlAdapter;
    }

    private function createForMySQL(Table $table): void
    {
        $table->removeColumn('uuid');

        $table->addColumn('uuid', Literal::from(
            'varchar(36) generated always as lcase(insert(insert(insert(insert(hex(`uuid_bin`),9,0,'-'),14,0,'-'),19,0,'-'),24,0,'-')) stored'
        ), [
            'after' => 'uuid_bin',
        ]);

        $table->save();

        $this->addMySQLTrigger();
    }

    private function addMySQLTrigger(): void
    {
        $this->getAdapter()->execute('
            drop trigger if exists `insert_uuid_bin`;
            create trigger `insert_uuid_bin`
            before insert on `tenants` for each row
            begin
                if new.`uuid` is not null
                    set new.`uuid_bin` unhex(replace(new.`uuid`,"-",""));
                    set new.`uuid` null;
                end if;
            end
        ');
    }

    private function dropMySQL(Table $table): void
    {
        $this->getAdapter()->execute('
            drop trigger if exists `insert_uuid_bin`
        ');

        $table->save();
    }
}
