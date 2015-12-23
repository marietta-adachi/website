<?php

class Model_User extends Model_Base
{

	public static function by_id($id)
	{
		return self::find($id);
	}

	public static function by_session()
	{
		return Session::get(self::$_table_name);
	}

	public static function unique_name($id, $name)
	{
		$count = self::query()->where('id', '<>', $id)->where('name', $name)->count();
		return $count == 0;
	}

	public static function unique_email($id, $email)
	{
		$count = self::query()->where('id', '<>', $id)->where('email', $email)->count();
		return $count == 0;
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
		$p=[];
		$sql .= ' where u.deleted_at is null ';

		if (!empty($c['status']))
		{
			$sql .= ' and u.status in :status';
			$p['status'] = $c['status'];
		}

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
			return parent::counta($sql, $p);
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

	public static function login($email, $password, $remember)
	{
		$row = self::query()->where('email', $email)->where('status', St::VALID)->get_one();
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

	protected static $_table_name = 'user';
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
	protected static $_soft_delete = array(
		'deleted_field' => 'deleted_at',
		'mysql_timestamp' => true,
	);

}
