<?php

class Common
{

	public static function setCookie($k, $v)
	{
		$tmp = json_encode($v);
		$tmp = base64_encode($tmp); // ダブルクオーテーションがエスケープされるため
		Cookie::set($k, $tmp);
	}

	public static function getCookie($k)
	{
		$tmp = Cookie::get($k);
		$tmp = base64_decode($tmp);
		$tmp = json_decode($tmp, true);
		return $tmp;
	}

	/**
	 * PostgreSQLのpoint型から配列に変換します
	 * @param type $point
	 * @return type
	 */
	public static function point2array($point)
	{
		$point = str_replace(array('(', ')'), array('', ''), $point);
		$tmp = explode(',', $point);
		return array(
			'lat' => @$tmp[0],
			'lon' => @$tmp[1],
		);
	}

	public static function csv2arr($data, $enc = 'sjis-win', $ln = '\r\n')
	{
		$data = mb_convert_encoding($data, 'utf8', $enc); // ハイフンが文字化けるためsjis-winで
		$csv = array();
		$rs = explode($ln, $data);
		foreach ($rs as $r)
		{
			if (!empty($r))
			{
				$csv[] = explode(',', $r);
			}
		}
		return $csv;
	}

	public static function base64_urlsafe_encode($val)
	{
		$val = base64_encode($val);
		return str_replace(array('+', '/', '='), array('_', '-', '.'), $val);
	}

	public static function base64_urlsafe_decode($val)
	{
		$val = str_replace(array('_', '-', '.'), array('+', '/', '='), $val);
		return base64_decode($val);
	}

	public static function base64_image_decode($val)
	{
		$val = str_replace(array('_', '-', '.'), array('+', '/', '='), $val);
		return base64_decode($val);
	}

	public static function today()
	{
		$baseDate = Config::get('base_date');
		if (!empty($baseDate))
		{
			return $baseDate;
		}
		else
		{
			return date('Y-m-d');
		}
	}

	public static function now($adjust = '')
	{
		$baseTime = Config::get('base_time');
		if (!empty($baseTime))
		{
			return self::today() . ' ' . $baseTime;
		}
		else
		{

			if (!empty($adjust))
			{
				return date('Y-m-d H:i:s', strtotime($adjust));
			}
			else
			{
				return date('Y-m-d H:i:s');
			}
		}
	}

	public static function nowTimestamp()
	{
		$t = time();
		$mt = explode(' ', microtime());
		$mt = explode('.', $mt[0]);
		$mt = substr($mt[1], 0, 3);
		return date('YmdHis', $t) . $mt;
	}

	public static function sendmail($email, $bccAdmin = false)
	{
		try
		{
			// 管理者宛のBCC
			if ($bccAdmin || Config::get('mail.send_bcc'))
			{
				$email->bcc(Config::get('mail.account.admin.addr'), Config::get('mail.account.admin.addr') . '（BCC）');
			}

			// 返信先（個々で設定されていなければデフォを設定）
			$replyTo = $email->get_reply_to();
			if (empty($replyTo))
			{
				$email->reply_to(Config::get('mail.account.admin.addr'));
			}
			// エラー送信先（個々で設定されていなければデフォを設定）
			$email->return_path(Config::get('mail.account.admin.addr'));

			$email->send();
			return true;
		}
		catch (Exception $e)
		{
			$from = $email->get_from();
			$from = $from['email'];
			$to = $email->get_to();
			$to = (count($to) == 0) ? '' : key($to);
			$cc = $email->get_cc();
			$cc = (count($cc) == 0) ? '' : key($cc);
			Log::error('メール送信に失敗しました。（from:' . $from . '／to:' . $to . '／cc:' . $cc . '／subject:' . $email->get_subject() . '）');
			Common::error($e);
			return false;
		}
	}

	public static function error($e)
	{
		Log::error('* ▼ **********************************************************************');
		Log::error('MESSAGE\t:' . $e->getMessage());
		Log::error('FILE\t:' . $e->getFile());
		Log::error('LINE\t:' . $e->getLine());
		Log::error('TRACE\t:\r\n' . $e->getTraceAsString());
		Log::error('* ▲ ***********************************************************************');
	}

	public static function zipcode2address($zipcode)
	{
		$zipcode = Model_Db_Mzipcode::find_by('m_zipcode_zipcode', $zipcode);
		if (empty($zipcode))
		{
			return '';
		}
		$zipcode = $zipcode[0];
		return $zipcode->m_zipcode_pref . ' ' . $zipcode->m_zipcode_city . ' ' . $zipcode->m_zipcode_town;
	}

	public static function zipcode2eachcode($zipcode)
	{
		$zipcode = Model_Db_Mzipcode::find_by('m_zipcode_zipcode', $zipcode);
		if (empty($zipcode))
		{
			return array('', '', '');
		}
		$zipcode = $zipcode[0];
		$prefCd = substr($zipcode->m_zipcode_code, 0, 2);
		$cityCd = substr($zipcode->m_zipcode_code, 2, 3);
		$townCd = $zipcode->m_zipcode_zipcode;
		return array($prefCd, $cityCd, $townCd);
	}

	/**
	 * メールアドレスから＠マーク前の部分を取得します
	 * @param type $mailAddress
	 * @return type
	 */
	public static function mailaddress2nickname($mailAddress)
	{
		$tmp = explode('@', $mailAddress);
		return @$tmp[0];
	}

	public static function get_device($level = 1)
	{
		require_once APPPATH . 'vendor/Mobile-Detect-2.8.17/Mobile_Detect.php';

		$md = new Mobile_Detect();

		if ($md->isMobile())
		{
			if ($md->isTablet())
			{
				return 'tablet';
			}
			else
			{
				return 'phone';
			}
		}
		else
		{
			return 'desktop';
		}
	}

	public static function decorate($head, $c = '*')
	{
		$ret = $c . ' ' . $head . ' ';
		//$remain = 100 - mb_strwidth($ret, mb_detect_encoding($ret));
		$remain = 70 - mb_strwidth($ret);
		for ($i = 0; $i < $remain; $i++)
		{
			$ret .= $c;
		}
		return $ret;
	}

}

class Page
{

	public static function get_page($action, $c, $count, $per_page = 10, $name = 'bootstrap3_ma')
	{
		$segment = 'p';

		// ページ数
		$crr_page = 1;
		if (array_key_exists($segment, $c))
		{
			if (is_numeric($c[$segment]))
			{
				$crr_page = (int) $c[$segment];
			}
		}

		// ページャ用GETパラメータ生成
		$get_param = [];
		foreach ($c as $k => $v)
		{
			if (is_array($v))
			{
				foreach ($v as $item)
				{
					$get_param[] = $k . '[]=' . $item;
				}
			}
			else
			{
				if ($k != $segment)
				{
					$get_param[] = $k . '=' . $v;
				}
			}
		}
		$get_param = '?' . implode('&', $get_param);


		$config = array(
			'name' => 'default',
			'total_items' => $count,
			'per_page' => $per_page,
			'uri_segment' => $segment,
			'current_page' => $crr_page,
			'pagination_url' => $action . $get_param,
			'num_links' => 2,
			'show_first' => true,
			'show_last' => true,
			'name' => $name,
		);

		return Pagination::forge('revision', $config);
	}

}

class FileUtil
{

	public static function deleteFile($dir)
	{
		if ($dirhandle = opendir($dir))
		{
			while (false !== ($fileName = readdir($dirhandle)))
			{
				if ($fileName != '.' && $fileName != '..')
				{
					unlink($dir . Config::get('slash') . $fileName);
				}
			}
			closedir($dirhandle);
		}
	}

	public static function delete_old_file($dir, $expire = '24 hours ago', $prefix = '')
	{
		$expire = strtotime($expire);

		// 取得ファイル分ループ
		$files = File::read_dir($dir);
		foreach ($files as $fileName)
		{
			$file = $dir . $fileName;
			if (!is_file($file))
			{
				continue;
			}

			// 指定プレフィックス以外はスルー
			if (!empty($prefix) && !strstr($fileName, $prefix))
			{
				continue;
			}

			$mod = filemtime($file);
			if ($mod < $expire)
			{
				File::delete($file);
			}
		}
	}

}

class Api
{

	public static function get($method, $url, $param, $format = 'xml', $encode = 'UTF8', $header = array())
	{
		$res = null;
		$curl = null;
		try
		{

			// URL生成
			if ($method == 'GET' && !empty($param))
			{
				$tmp = array();
				foreach ($param as $k => $v)
				{
					$tmp[] = $k . '=' . $v;
				}
				$tmp = implode('&', $tmp);
				$url .= '?' . $tmp;
			}

			// CURL設定
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
			if (!empty($header))
			{
				curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			if ($method == 'POST' && !empty($param))
			{
				curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
			}

			// CURL実行
			$result = curl_exec($curl);
			if (!$result)
			{
				throw new Exception(curl_error($curl));
			}

			// 形式変換
			if ($format == 'xml')
			{
				$result = mb_convert_encoding($result, 'UTF8', $encode);
				$result = str_replace($encode, 'UTF-8', $result);
				$res = new SimpleXMLElement($result);
				if (is_null($res))
				{
					throw new Exception('形式変換できません');
				}
			}
			else if ($format == 'json')
			{
				$res = $result; // TODO
			}
			else
			{
				$res = $result;
			}

			curl_close($curl);
		}
		catch (Exception $e)
		{
			Common::error($e);
			curl_close($curl);
		}

		return $res;
	}

}
