<?php

namespace Fuel\Migrations;

class Create_templates
{

	public function up()
	{
		// 'null' => true //null許可
		// 'unsigned' => true
		// 'auto_increment' => true
		\DBUtil::create_table('templates', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'varchar' => array('constraint' => 255, 'type' => 'varchar'),
			'enum' => array('constraint' => '"valid","invalid"', 'type' => 'enum'),
			'string' => array('constraint' => 255, 'type' => 'varchar'),
			'int' => array('constraint' => 11, 'type' => 'int'),
			'decimal' => array('constraint' => '5,2', 'type' => 'decimal'),
			'float' => array('constraint' => '10,5', 'type' => 'float'),
			'text' => array('type' => 'text'),
			'blob' => array('type' => 'blob'),
			'datetime' => array('type' => 'datetime'),
			'date' => array('type' => 'date'),
			'timestamp' => array('type' => 'timestamp'),
			'time' => array('type' => 'time'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
				), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('templates');
	}

}
