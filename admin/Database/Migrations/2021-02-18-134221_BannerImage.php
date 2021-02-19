<?php

namespace Admin\Database\Migrations;

use CodeIgniter\Database\Migration;

class BannerImage extends Migration
{
	public function up()
	{
		$this->forge->addField([
            'banner_image_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false, 'auto_increment' => true],
            'banner_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
            'language_id' => ['type' => 'INT', 'constraint' => 11, 'null' => false],
			'title' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => false],
			'link' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
			'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
			'sort_order' => ['type' => 'INT', 'constraint' => 3, 'null' => false, 'default' => '0']
        ]);
        $this->forge->addKey('banner_image_id', true);
        $this->forge->createTable('ci_banner_image', true);
	}

	public function down()
	{
		$this->forge->dropTable('ci_banner_image', true);
	}
}
