<?php

class Ope
{

	const ADD = 'add';
	const MODIFY = 'modify';
	const DELETE = 'delete';

	public static $name = array(
		self::ADD => '登録',
		self::MODIFY => '変更',
		self::DELETE => '削除',
	);

}

class St
{

	const VALID = 'valid';
	const INVALID = 'invalid';

	public static $name = array(
		self::VALID => '有効',
		self::INVALID => '無効',
	);

}
