<?php

class Model_Admin extends Model_Base
{

	public static function by_id($id)
	{
		return self::find($id);
	}

	public static function by_session()
	{
		return Session::get('admin');
	}

	public static function login($email, $password, $remember)
	{
		$row = self::query()->where('email', $email)->where('status', St::VALID)->get_one();
		if (empty($row))
		{
			return false;
		}

		//if ($row->password != Auth::hash_password($password))
		if ($row->password != $password)
		{
			return false;
		}

		$row->last_login = System::now();
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

	protected static $_properties = array(
		'id',
		'name',
		'email',
		'password',
		'status',
		'last_login',
		'created_at',
		'updated_at',
		'deleted_at',
	);
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => true,
		),
	);
	protected static $_table_name = 'admin';

}
