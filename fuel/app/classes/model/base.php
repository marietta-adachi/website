<?php

class Model_Base extends \Orm\Model_Soft
{

	protected static function counta($sql, $p = [])
	{
		$res = DB::query($sql)->parameters($p)->as_object()->execute()->as_array();
		return $res[0]->count;
	}

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
				$sec = is_numeric($cache) ? $cache : 3600;
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

}
