<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FoFlogTableForum extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'        => [
					'type'           => 'INT',
					'constraint'     => 9,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
			],
			'title'     => [
					'type'           => 'VARCHAR',
					'constraint'     => '80',
			],
			'password' 	=> [
					'type'           => 'VARCHAR',
					'constraint'     => '32',
					'null'			 => TRUE,
			],
			'private'	=> [
					'type'			 => 'TINYINT',
					'constraint'	 => 1,
					'default'		 => 0,
			],
			'created_by'=> [
					'type'			 => 'INT',
					'constraint'	 => 9,
			],
			'created_at'=> [
					'type'			 => 'DATETIME',
					'null'			 => TRUE,
			],
			'updated_at'=> [
					'type'			 => 'DATETIME',
					'null'			 => TRUE,
			],
			'deleted_at'=> [
					'type'			 => 'DATETIME',
					'null'			 => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('forum');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('forum');
	}
}
