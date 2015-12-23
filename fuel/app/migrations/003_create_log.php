<?php

namespace Fuel\Migrations;

class Create_log
{

	public function up()
	{
		\DBUtil::create_table('log', array(
			'created_at' => array('type' => 'timestamp'),
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'type' => array('constraint' => 50, 'type' => 'varchar'),
			'user_id' => array('constraint' => 11, 'type' => 'int', 'unsigned' => true),
			'action' => array('constraint' => 50, 'type' => 'varchar'),
			'data_1' => array('type' => 'text'),
			'data_2' => array('type' => 'text'),
			'data_3' => array('type' => 'text'),
			'data_4' => array('type' => 'text'),
			'data_5' => array('type' => 'text'),
			'created_at' => array('type' => 'timestamp'),
				), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('log');
	}

}
