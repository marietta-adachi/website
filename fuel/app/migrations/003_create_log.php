<?php

namespace Fuel\Migrations;

class Create_log
{
	public function up()
	{
		\DBUtil::create_table('log', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'type' => array('constraint' => 50, 'type' => 'varchar'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),
			'data_1' => array('constraint' => '"valid","invalid"', 'type' => 'enum'),
			
			'created_at' => array('type' => 'timestamp'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('log');
	}
}