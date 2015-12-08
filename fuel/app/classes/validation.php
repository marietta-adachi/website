<?php

class Validation extends Fuel\Core\Validation
{

	/**
	 * 電話番号形式かチェックします
	 * @param type $val
	 * @return type
	 */
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

	/**
	 * 全角カタカナかチェックします
	 * @param type $val
	 * @return type
	 */
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

	/**
	 * 全角かチェックします
	 * @param type $val
	 * @return boolean
	 */
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

	/**
	 * 半角かチェックします
	 * @param type $val
	 * @return boolean
	 */
	public function _validation_valid_hankaku($val)
	{
		return $this->isHankaku($val);
	}

	/**
	 * 半角かチェックします
	 * @param type $str
	 * @param type $include_kana
	 * @param type $include_controls
	 * @param type $encoding
	 * @return boolean
	 */
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

	/**
	 * メールアドレスのバリデーションチェックを行います（RF2822非準拠対応）
	 * @param type $val
	 * @return type
	 */
	public function _validation_valid_email($val)
	{
		$val = $this->parse($val);
		return $this->_empty($val) || filter_var($val, FILTER_VALIDATE_EMAIL);
		//return $this->_empty($val) || $this->filter_var_mail($val);
	}

	/**
	 * メールアドレス（複数）のバリデーションチェックを行います（RF2822非準拠対応）
	 * @param type $val
	 * @param type $separator
	 * @return boolean
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

	/**
	 * RF2822非準拠の部分を除去します
	 * @param type $email
	 * @return type
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

	/* private function filter_var_mail($email)
	  {
	  // "をエスケープ
	  $regexp = "/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\"(?:\\[^\r\n]|[^\\\"])*\")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/i";
	  // "と/をエスケープ
	  $regexp = "/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+))*)|(?:\"(?:\\[^\r\n]|[^\\\"])*\")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&'*+\/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/i";

	  // 古里さん
	  $regexp = '/^(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*")(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|"[^\\\\\x80-\xff\n\015"]*(?:\\\\[^\x80-\xff][^\\\\\x80-\xff\n\015"]*)*"))*@(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\])(?:\.(?:[^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff]+(?![^(\040)<>@,;:".\\\\\[\]\000-\037\x80-\xff])|\[(?:[^\\\\\x80-\xff\n\015\[\]]|\\\\[^\x80-\xff])*\]))*$/';
	  $regexp = '/^(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&\'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&\'*+/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&\'*+/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&\'*+/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/';

	  if (preg_match($regexp, $email))
	  {
	  return $email;
	  }
	  else
	  {
	  return false;
	  }
	  } */
}
