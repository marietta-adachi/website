<?php

/**
 * 編集モード
 */
class EditMode
{

	const ADD = 1;
	const MOD = 2;
	const DEL = 3;

}

/**
 * 汎用ステータス
 */
class GeneralStatus
{

	const VALID = 1;
	const INVALID = 9;

	public static $name = array(
		self::VALID => "有効",
		self::INVALID => "無効",
	);

}

/**
 * 病院ステータス
 */
class HospitalStatus
{

	const VALID = 1;
	const INVALID = 9;
	const INVALID_ADDRESS = 8;
	const INVALID_ADDRESS_ERR = 7;
	const INVALID_ACCESS = 19;
	const CLINIC = 20;

	public static $name = array(
		self::VALID => "有効",
		self::INVALID => "無効",
	);

}

/**
 * こだわり種別
 */
class FeaturesType
{

	const COMMON = 9;
	const TIME = 8;

}

/**
 * 病院クチコミステータス
 */
class ReviewStatus
{

	const PUBLISH = 1;
	const CLOSED = 2;
	const INVALID = 9;

	public static $name = array(
		self::PUBLISH => "公開",
		self::CLOSED => "非公開",
		self::INVALID => "無効",
	);

}

/**
 * 病院評価ステータス
 */
class EvaluateStatus
{

	const VALID = 1;
	const INVALID = 9;

	public static $name = array(
		self::VALID => "有効",
		self::INVALID => "無効",
	);

}


/**
 * CSVインポート種別
 */
class CsvType
{

	const BASIS = 1;
	const OTHER = 2;
	const TIMETABLE = 3;
	const ACCESS = 4;
	const COURSE = 5;
	const CATEGORY = 6;

	public static $name = array(
		self::BASIS => "基本情報",
		self::OTHER => "付帯情報",
		self::TIMETABLE => "診療時間",
		self::ACCESS => "交通機関",
		self::COURSE => "診療科目",
		self::CATEGORY => "病院分類",
	);

}

/**
 * 管理者ステータス
 */
class AdminStatus
{

	const VALID = 1;
	const INVALID = 9;

	public static $name = array(
		self::VALID => "有効",
		self::INVALID => "無効",
	);

}

/**
 * 設定種類
 */
class SettingType
{

	const PASSWORD = 1;
	const MAILADDRESS = 2;

	public static $name = array(
		self::PASSWORD => "パスワード",
		self::MAILADDRESS => "メールアドレス",
	);

}

/**
 * REST通信ステータス
 */
class RestStatus
{

	const SUCCESS = "SUCCESS";
	const FAILED = "FAILED";
	const UNAUTHORIZED = "UNAUTHORIZED";

}

/**
 * 各種区切り文字
 */
class Deli
{

	const NAME = "　";
	const PLAN = "-";

}

?>
