<?php

class Model_Db_Crudbase extends Model_Crud
{

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

