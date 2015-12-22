<?php

class Ope
{

	const ADD = 1;
	const MODIFY = 2;
	const DELETE = 3;

	public static $name = array(
		self::ADD => '登録',
		self::MODIFY => '変更',
		self::DELETE => '削除',
	);

}

class St
{

	const VALID = 1;
	const INVALID = 9;

	public static $name = array(
		self::VALID => '有効',
		self::INVALID => '無効',
	);

}
