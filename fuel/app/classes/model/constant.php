<?php

class Ope
{

	const ADD = 1;
	const MODIFY = 2;
	const DELETE = 3;

}

class St
{

	const VALID = 1;
	const INVALID = 9;

	public static $name = array(
		self::VALID => "有効",
		self::INVALID => "無効",
	);

}

class UserStatus
{

	const VALID = 1;
	const INVALID = 9;

	public static $name = array(
		self::VALID => "有効",
		self::INVALID => "無効",
	);

}

class SettingType
{

	const PASSWORD = 1;
	const MAILADDRESS = 2;

	public static $name = array(
		self::PASSWORD => "パスワード",
		self::MAILADDRESS => "メールアドレス",
	);

}

class RestResult
{

	const SUCCESS = "SUCCESS";
	const FAILED = "FAILED";
	const UNAUTHORIZED = "UNAUTHORIZED";

}

class Deli
{

	const NAME = "　";
	const PLAN = "-";

}
