<?php

class Model_Db_Qbase extends Model
{

    public static function exec($sql, $p = array(), $limit = 10000, $offset = 0, $cache = false)
    {
	try
	{
	    $limit = is_null($limit) ? 10000 : $limit;
	    $offset = is_null($offset) ? 0 : $offset;

	    $sql .= " limit ".$limit." offset ".$offset;
	    $query = DB::query($sql);
	    $query->parameters($p);

	    if ($cache)
	    {
		$sec = intval(Config::get("const.query_cache_seconds"));
		$res = $query->cached($sec)->execute()->as_array();
	    }
	    else
	    {
		$res = $query->execute()->as_array();
		//$res = $query->as_object()->execute();
		Log::info("\r\n*** SQL ***********************************************************\r\n".DB::last_query()."\r\n"."*******************************************************************\r\n");
	    }

	    return $res;
	}
	catch (Exception $e)
	{
	    list($unified_code, $platform_code, $error_text) = DB::error_info();
	    Log::error("unified\t:".$unified_code);
	    Log::error("platform\t:".$platform_code);
	    Log::error("ERROR\t:".$error_text);
	    Log::error("SQL\t:".DB::last_query());
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
?>

