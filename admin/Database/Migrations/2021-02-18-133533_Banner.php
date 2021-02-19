<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class Banner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'banner_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => false],
            'status'  => ['type' => 'TINYINT', 'constraint' => 1, 'null' => false],
        ]);
        $this->forge->addKey('banner_id', true);
        $this->forge->createTable('ci_banner', true);
    }

    public function down()
    {
        $this->forge->dropTable('ci_banner', true);
    }
}
