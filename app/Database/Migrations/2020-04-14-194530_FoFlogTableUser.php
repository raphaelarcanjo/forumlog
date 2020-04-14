<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FoFlogTableUser extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
					'type'           => 'INT',
					'constraint'     => 9,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
			],
			'name'       => [
					'type'           => 'VARCHAR',
					'constraint'     => '80',
			],
			'email' 	=> [
					'type'           => 'VARCHAR',
					'constraint'     => '80',
			],
			'password' 	=> [
					'type'           => 'VARCHAR',
					'constraint'     => '32',
			],
			'tag_name' 	=> [
					'type'           => 'VARCHAR',
					'constraint'     => '12',
			],
			'birth' 	=> [
					'type'           => 'DATE',
			],
			'photo' 	=> [
					'type'           => 'VARCHAR',
					'constraint'     => '255',
					'default'		 => 'no-img.jpg',
			],
			'ban'		=> [
					'type'			 => 'TINYINT',
					'constraint'	 => 1,
					'default'		 => 0,
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
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
