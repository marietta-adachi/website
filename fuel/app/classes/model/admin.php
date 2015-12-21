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
	protected static $_admin_last_login = 'admin_last_login';
	protected static $_admin_created_at = 'admin_created_at';
	protected static $_admin_updated_at = 'admin_updated_at';
	protected static $_admin_deleted_at = 'admin_deleted_at';
	// key
	protected static $_primary_key = 'admin_id';

	public static function login($email, $password, $remember)
	{
		$row = self::find_one_by(array('admin_email' => $email, 'admin_status' => St::VALID,));
		if (empty($row))
		{
			return false;
		}


		//if ($row->admin_password != Auth::hash_password($password))
		if ($row->admin_password != $password)
		{
			return false;
		}

		$row->admin_last_login = System::now();
		$row->save();

		Session::create();
		$close = !(boolean) $remember;
		Session::set('expire_on_close', $close);
		Session::set(self::$_table_name, $row);

		return true;
	}

	public static function logout()
	{
		Session::delete(self::$_table_name);
	}

	public static function by_session()
	{
		return Session::get('admin');
	}

	public static function by_id($id)
	{
		return self::find_by_pk($id);
	}

	public function get_id()
	{
		return $this->admin_id;
	}

	public function get_name()
	{
		return $this->admin_name;
	}

	public function get_XXXXX()
	{
		
	}

}
