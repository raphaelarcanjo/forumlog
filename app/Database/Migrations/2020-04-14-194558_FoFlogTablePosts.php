<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FoFlogTablePosts extends Migration
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
			'message' 	=> [
					'type'           => 'TEXT',
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
		$this->forge->createTable('posts');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->createTable('posts');
	}
}
