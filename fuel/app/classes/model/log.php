<?php

class Model_Log extends \Orm\Model
{

	protected static $_properties = array(
		'id',
		'type',
		'user_id',
		'action',
		'data_1',
		'data_2',
		'data_3',
		'data_4',
		'data_5',
		'created_at',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
	);
	protected static $_table_name = 'log';

	public static function write($type, $user, $action, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
	{

		$row = self::forge();
		$row->type = $type;
		$row->user_id = empty($user) ? 'anyone' : $user->get_id();
		$row->action = $action;
		$row->data_1 = $data1;
		$row->data_2 = $data2;
		$row->data_3 = $data3;
		$row->data_4 = $data4;
		$row->data_5 = $data5;
		$row->created_at = System::now();
		$row->save();
	}

}
