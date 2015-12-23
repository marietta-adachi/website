<?php

class Model_Address extends \Orm\Model
{

	public static function get_prefs()
	{
		$group = ['pref_id', 'pref_name',];
		$option = [
			'select' => $group,
			'group_by' => $group,
		];

		$list = self::find('all', $option);
		return $list? : [];
	}

	public static function get_cities($pref_id)
	{
		$group = ['city_id', 'city_name',];
		$option = [
			'select' => $group,
			'where' => ['pref_id' => $pref_id],
			'group_by' => $group,
		];

		$list = self::find('all', $option);
		return $list? : [];
	}

	public static function get_towns($city_id)
	{
		$group = ['id', 'town_name', 'block_name'];
		$option = [
			'select' => $group,
			'where' => ['city_id' => $city_id],
			'group_by' => $group,
		];

		$list = self::find('all', $option);
		return $list? : [];
	}

	protected static $_properties = array(
		'id',
		'pref_id',
		'city_id',
		'town_id',
		'zip',
		'office_flg',
		'delete_flg',
		'pref_name',
		'pref_furi',
		'city_name',
		'city_furi',
		'town_name',
		'town_furi',
		'town_memo',
		'kyoto_street',
		'block_name',
		'block_furi',
		'memo',
		'office_name',
		'office_furi',
		'office_address',
		'new_id'
	);
	protected static $_table_name = 'address';

}
