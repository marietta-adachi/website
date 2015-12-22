<?php

class Model_User extends \Orm\Model
{

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
	protected static $_table_name = 'users';

	public static function login($email, $password, $remember)
	{
		$row = self::find_one_by(array('email' => $email, 'status' => St::VALID,));
		if (empty($row))
		{
			return false;
		}

		if ($row->password != Auth::hash_password($password))
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
		$row->created_at = System::now(); // TODO
		return $row;
	}

	public function del_logical()
	{
		$row = parent::forge();
		$row->deleted_at = System::now(); // TODO
		if ($row->save() == 1)
		{
			return true;
		}
		return false;
	}

	public static function byTest()
	{
		$tmp = self::exec('select email from user where false');
		return $tmp;
	}

	public static function unique_name($id, $name)
	{
		$list = self::exec('select id from user where name = :name', ['name' => $name]);
		return count($list) == 0;
	}

	public static function unique_email($id, $email)
	{
		$list = self::exec('select id from user where email = :email', ['email' => $email]);
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
			$sql .= ' count(u.id) as count ';
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
		$sql .= ' and u.status = ' . St::VALID;
		if (!empty($c['freeword']))
		{
			$sql.= ' and (false ';
			$sql.= ' or u.name like :name ';
			$p['name'] = '%' . $c['freeword'] . '%';

			$sql.= ' or u.email like :email ';
			$p['email'] = '%' . $c['freeword'] . '%';
			$sql.= ' ) ';
		}

		/*
		 * ORDER BY
		 */
		if (!$count)
		{
			$orders[] = 'id asc';
			if (!empty($c['order']))
			{
				if (array_key_exists($c['order'], self::$order))
				{
					$tmp = self::$order[$c['order']][0];
					$tmp = explode('-', $tmp);
					$nulls = (@$tmp[2] == 'l') ? 'nulls last' : 'nulls first';
					$orders[] = $tmp[0] . ' ' . $tmp[1] . ' '; // . $nulls;
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
		'id' => ['id-asc', '順'],
		'name' => ['name-asc', '順'],
		'email' => ['email-asc', '順'],
		'stamp' => ['updated_at-desc', '順'],
	);

	public function get_id()
	{
		return $this->id;
	}

	public function get_email()
	{
		return $this->email;
	}

}
