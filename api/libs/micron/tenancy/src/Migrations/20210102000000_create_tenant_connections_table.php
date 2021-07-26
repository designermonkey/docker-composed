<?php declare(strict_types=1);

namespace MicronResearch\Tenancy\Migrations;

use Phinx\Migration\AbstractMigration;

final class CreateTenantConnectionsTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tenant_connections');

        $table->addColumn('tenant_id', 'integer', [
            'length' => 11,
            'null' => false,
            'signed' => true,
        ]);

        $table->addForeignKey('tenant_id', 'tenants', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE',
        ]);

        $table->addColumn('name', 'string', [
            'length' => 255,
            'null' => false,
        ]);

        $table->addColumn('driver', 'string', [
            'length' => 255,
            'null' => false,
            'default' => 'mysql',
        ]);

        $table->addColumn('host', 'string', [
            'length' => 255,
            'null' => false,
        ]);

        $table->addColumn('database', 'string', [
            'length' => 255,
            'null' => false,
        ]);

        $table->addColumn('username', 'string', [
            'length' => 255,
            'null' => false,
        ]);

        $table->addColumn('password', 'string', [
            'length' => 255,
            'null' => false,
        ]);

        $table->addColumn('port', 'integer', [
            'length' => 12,
            'null' => false,
            'default' => 3306,
        ]);

        $table->addColumn('options', 'text', [
            'default' => 'charset=utf8mb4',
        ]);

        $table->save();
    }

    public function down(): void
    {
        $this->table('tenant_connections')->drop()->save();
    }
}
