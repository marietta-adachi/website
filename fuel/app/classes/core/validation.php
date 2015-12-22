<?php

class Validation extends Fuel\Core\Validation
{

	public function _validation_valid_tel($val)
	{
		if (mb_ereg("^\d{1,4}-\d{1,4}-\d{1,4}$", $val))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function _validation_valid_katakana($val)
	{
		mb_regex_encoding("UTF-8");
		$val = trim($val);
		if (mb_ereg("^[ア-ン゛゜ァ-ォャ-ョー「」、　]+$", $val))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function _validation_valid_zenkaku($val)
	{
		$encoding = mb_internal_encoding();
		$len = mb_strlen($val, $encoding);
		for ($i = 0; $i < $len; $i++)
		{
			$char = mb_substr($val, $i, 1, $encoding);
			if ($this->isHankaku($char, true, true, $encoding))
			{
				return false;
			}
		}
		return true;
	}

	public function _validation_valid_hankaku($val)
	{
		return $this->isHankaku($val);
	}

	private function isHankaku($str, $include_kana = false, $include_controls = false, $encoding = null)
	{
		if (!$include_controls && !ctype_print($str))
		{
			return false;
		}

		if (is_null($encoding))
		{
			$encoding = mb_internal_encoding();
		}
		if ($include_kana)
		{
			$to_encoding = 'SJIS';
		}
		else
		{
			$to_encoding = 'UTF-8';
		}
		$str = mb_convert_encoding($str, $to_encoding, $encoding);

		if (strlen($str) === mb_strlen($str, $to_encoding))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/*
	 * メールアドレスRF2822非準拠チェック
	 */

	public function _validation_valid_email($val)
	{
		$val = $this->parse($val);
		return $this->_empty($val) || filter_var($val, FILTER_VALIDATE_EMAIL);
		//return $this->_empty($val) || $this->filter_var_mail($val);
	}

	/*
	 * メールアドレス（複数）RF2822非準拠チェック
	 */

	public function _validation_valid_emails($val, $separator = ',')
	{
		if ($this->_empty($val))
		{
			return true;
		}

		$emails = explode($separator, $val);

		foreach ($emails as $e)
		{
			$e = $this->parse($e);
			if (!filter_var(trim($e, FILTER_VALIDATE_EMAIL)))
			//if (!$this->filter_var_mail(trim($e)))
			{
				return false;
			}
		}
		return true;
	}

	/*
	 * RF2822非準拠の部分を除去
	 */

	private function parse($email)
	{
		$email = explode("@", $email);
		$name = @$email[0];
		$domain = @$email[1];

		// ドットの連続を除去
		for ($i = 0; $i < 5; $i++)
		{
			$name = str_replace("..", ".", $name);
		}

		// @の前のドットを除去
		for ($i = 0; $i < 5; $i++)
		{
			$last = substr($name, -1);
			if ($last == ".")
			{
				$name = substr($name, 0, -1);
			}
		}

		return $name . "@" . $domain;
	}

}
