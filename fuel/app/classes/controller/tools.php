<?php

class Controller_Tools extends Controller_Base_Site
{

	public function action_404()
	{
		$this->template->content = View_Smarty::forge('error/404');
	}

	public function action_initialize($token)
	{
		try
		{
			if (empty($token))
			{
				echo "no data";
				exit;
			}

			// 非同期実行
			$pathOil = realpath(APPPATH . '/../../');
			if (Fuel::$env == Fuel::PRODUCTION)
			{
				exec("FUEL_ENV=production php {$pathOil}/oil r registdummy {$count} {$init} > /dev/null &");
			}
			else if (Fuel::$env == Fuel::STAGING)
			{
				exec("FUEL_ENV=staging php {$pathOil}/oil r registdummy {$count} {$init} > /dev/null &");
			}
			else if (Fuel::$env == Fuel::TEST)
			{
				exec("FUEL_ENV=test php {$pathOil}/oil r registdummy {$count} {$init} > /dev/null &");
			}
			else
			{
				// Windowsの場合
				$fp = popen("start php {$pathOil}/oil r registdummy {$count} {$init}", "r");
				pclose($fp);
			}

			echo "success";
		}
		catch (Exception $e)
		{

			$this->error($e);
			echo "failed";
			echo $e->getMessage();
		}
		exit;
	}

}
