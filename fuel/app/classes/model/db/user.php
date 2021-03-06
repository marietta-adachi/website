<?php

class Model_Db_User extends Model_Db_Base
{

	// table
	protected static $_table_name = 'user';
	// columns
	protected static $_user_id = 'user_id';
	protected static $_user_name = 'user_name';
	protected static $_user_email = 'user_email';
	protected static $_user_password = 'user_password';
	protected static $_user_status = 'user_status';
	protected static $_user_last_login = 'user_last_login';
	protected static $_user_created_at = 'user_created_at';
	protected static $_user_updated_at = 'user_updated_at';
	protected static $_user_deleted_at = 'user_deleted_at';
	// key
	protected static $_primary_key = 'user_id';

	public static function login($email, $password, $remember)
	{
		$row = self::find_one_by(array('user_email' => $email, 'user_status' => St::VALID,));
		if (empty($row))
		{
			return false;
		}

		if ($row->user_password != Auth::hash_password($password))
		{
			return false;
		}

		$row->user_last_login = System::now();
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
		return Session::get(self::$_table_name);
	}

	public static function by_id($id)
	{
		return parent::find_by_pk($id);
	}

	public static function anew()
	{
		$row = parent::forge();
		$row->user_created_at = System::now(); // TODO
		return $row;
	}

	public function del_logical()
	{
		$row = parent::forge();
		$row->user_deleted_at = System::now(); // TODO
		if ($row->save() == 1)
		{
			return true;
		}
		return false;
	}

	public static function byTest()
	{
		$tmp = self::exec('select user_email from user where false');
		return $tmp;
	}

	public static function unique_name($id, $name)
	{
		$list = self::exec('select user_id from user where user_name = :name', ['name' => $name]);
		return count($list) == 0;
	}

	public static function unique_email($id, $email)
	{
		$list = self::exec('select user_id from user where user_email = :email', ['email' => $email]);
		return count($list) == 0;
	}

	public static function count_by($c)
	{
		return self::by($c, null, true);
	}

	public static function by($c, $page, $count = false)
	{
		/*
		 * SELECT
		 */
		$sql = 'select ';
		if ($count)
		{
			$sql .= ' count(u.user_id) as count ';
		}
		else
		{
			$sql .= ' u.* ';
		}

		/*
		 * FROM
		 */
		$sql .= ' from user u ';

		/*
		 * WHERE
		 */
		$p = [];
		$sql .= ' where true ';
		$sql .= ' and u.user_status = ' . St::VALID;
		if (!empty($c['freeword']))
		{
			$sql.= ' and (false ';
			$sql.= ' or u.user_name like :name ';
			$p['name'] = '%' . $c['freeword'] . '%';

			$sql.= ' or u.user_email like :email ';
			$p['email'] = '%' . $c['freeword'] . '%';
			$sql.= ' ) ';
		}

		/*
		 * ORDER BY
		 */
		if (!$count)
		{
			$orders[] = 'user_id asc';
			if (!empty($c['order']))
			{
				if (array_key_exists($c['order'], self::$order))
				{
					$tmp = self::$order[$c['order']][0];
					$tmp = explode('-', $tmp);
					$nulls = (@$tmp[2] == 'l') ? 'nulls last' : 'nulls first';
					$orders[] = $tmp[0] . ' ' . $tmp[1] . ' ';// . $nulls;
				}
			}
			$orders = implode(',', $orders);
			$sql .= ' order by ' . $orders . ' ';
		}

		
		if ($count)
		{
			$res = self::exec($sql, $p);
			return $res[0]['count'];
		}
		else
		{
			$res = self::exec($sql, $p, $page->per_page, $page->offset);
			return $res;
		}
	}

	public static $order = array(
		'id' => ['user_id-asc', '順'],
		'name' => ['user_name-asc', '順'],
		'email' => ['user_email-asc', '順'],
		'stamp' => ['user_updated_at-desc', '順'],
	);

	public function get_id()
	{
		return $this->user_id;
	}

	public function get_email()
	{
		return $this->user_email;
	}

}
