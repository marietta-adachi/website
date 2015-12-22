<?php

class Model_Base extends Model_Crud
{

	protected static function exec($sql, $p = [], $limit = 1000, $offset = 0, $cache = false)
	{
		try
		{
			$p = is_null($p) ? [] : $p;
			$limit = is_null($limit) ? 1000 : $limit;
			$offset = is_null($offset) ? 0 : $offset;

			$bean = get_called_class();
			$query = DB::query($sql . " limit " . $limit . " offset " . $offset)->parameters($p);
			if ($cache)
			{
				$sec = intval(Config::get("const.query_cache_seconds"));
				$res = $query->cached($sec)->as_object($bean)->execute()->as_array();
			}
			else
			{
				$res = $query->as_object($bean)->execute()->as_array();
				Log::info("\r\n*** SQL ***********************************************************\r\n" . DB::last_query() . "\r\n" . "*******************************************************************\r\n");
			}

			return $res;
		}
		catch (Exception $e)
		{
			list($unified_code, $platform_code, $error_text) = DB::error_info();
			Log::error("unified\t:" . $unified_code);
			Log::error("platform\t:" . $platform_code);
			Log::error("ERROR\t:" . $error_text);
			Log::error("SQL\t:" . DB::last_query());
			throw $e;
		}
	}

	public static function get_recent_id($tabale)
	{
		$re = DB::query("select currval('{$tabale}_{$tabale}_id_seq') as id")->execute();
		$id = $re->get("id");
		return $id;
	}

	public static function insert($row)
	{
		try
		{
			list($insert_id, $rows_affected) = DB::insert(static::$_table_name)
					->set($row)
					->execute();
			return $rows_affected;
		}
		catch (Exception $e)
		{
			// キー重複等のエラーは0で返す
			return 0;
		}
	}

	public static function update($row)
	{
		try
		{
			$result = DB::update(static::$_table_name)
					->set($row)
					->where(self::getWhere(static::$_primary_keys, $row))
					->execute();
			return $result;
		}
		catch (Exception $e)
		{
			return 0;
		}
	}

	public static function remove($row) // deleteだと怒られる
	{
		try
		{
			$result = DB::delete(static::$_table_name)
					->where($row)
					->execute();
			return $result;
		}
		catch (Exception $e)
		{
			return 0;
		}
	}

	private static function getWhere($keys, $row)
	{
		$where = array();
		foreach ($row as $k => $v)
		{
			foreach ($keys as $key)
			{
				if ($k == $key)
				{
					$where[$k] = $v;
				}
			}
		}
		return $where;
	}

}
?>

