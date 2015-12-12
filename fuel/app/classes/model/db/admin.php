<?php

class Model_Db_Admin extends Model_Db_Base
{

	// table
	protected static $_table_name = 'admin';
	//columns
	protected static $_admin_id = 'admin_id';
	protected static $_admin_name = 'admin_name';
	protected static $_admin_email = 'admin_email';
	protected static $_admin_password = 'admin_password';
	protected static $_admin_status = 'admin_status';
	protected static $_admin_created_at = 'admin_created_at';
	protected static $_admin_updated_at = 'admin_updated_at';
	protected static $_admin_deleted_at = 'admin_deleted_at';
	// key
	protected static $_primary_key = 'admin_id';

	public static function bySession()
	{
		$bean = Session::get('admin');
		return $bean;
	}

}
?>

