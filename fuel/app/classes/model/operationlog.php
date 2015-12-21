<?php

class Model_Db_Operationlog extends Model_Db_Base
{

	// table
	protected static $_table_name = 'operation_log';
	//columns
	protected static $_operation_log_id = 'operation_log_id';
	protected static $_operation_log_type = 'operation_log_type'; // admin,site
	protected static $_operation_log_user_id = 'operation_log_user_id';
	protected static $_operation_log_action = 'operation_log_action';
	protected static $_operation_log_data_1 = 'operation_log_data_1';
	protected static $_operation_log_data_2 = 'operation_log_data_2';
	protected static $_operation_log_data_3 = 'operation_log_data_3';
	protected static $_operation_log_data_4 = 'operation_log_data_4';
	protected static $_operation_log_data_5 = 'operation_log_data_5';
	protected static $_operation_log_created_at = 'operation_log_created_at';
	// key
	protected static $_primary_key = 'operation_log_id';

	public static function write($type, $user, $action, $data1 = null, $data2 = null, $data3 = null, $data4 = null, $data5 = null)
	{
		$row = self::forge();
		$row->operation_log_type = $type;
		$row->operation_log_user_id = empty($user) ? 'anyone' : $user->get_id();
		$row->operation_log_action = $action;
		$row->operation_log_data_1 = $data1;
		$row->operation_log_data_2 = $data2;
		$row->operation_log_data_3 = $data3;
		$row->operation_log_data_4 = $data4;
		$row->operation_log_data_5 = $data5;
		$row->operation_log_created_at = System::now();
		$row->save();
	}

}
?>

