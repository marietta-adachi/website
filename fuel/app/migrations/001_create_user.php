<?php

namespace Fuel\Migrations;

class Create_user
{
	public function up()
	{
		\DBUtil::create_table('user', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),
			'status' => array('constraint' => '"valid","invalid"', 'type' => 'enum'),
			'last_login' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),
			'updated_at' => array('type' => 'timestamp'),
			'deleted_at' => array('type' => 'timestamp'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('user');
	}
}