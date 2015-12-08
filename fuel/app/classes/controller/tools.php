<?php

/**
 * 用コントローラ
 */
class Controller_Tools extends Controller_Basesite
{

	public function action_set_reservable()
	{
		try
		{
			$model = new Model_Task_Setreservable();
			$model->run();
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

	/**
	 * 
	 * @param type $type
	 */
	public function action_data_migration($type = "")
	{
		try
		{
			if (empty($type))
			{
				echo "no type";
				exit;
			}

			//$model = new Model_Task_Datamigration();
			//$model->run($type);
			// タスクを開始し、即リターンする
			$pathOil = realpath(APPPATH . '/../../');
			if (Fuel::$env == Fuel::PRODUCTION)
			{
				exec("FUEL_ENV=production php {$pathOil}/oil r datamigration {$type} > /dev/null &");
			}
			else if (Fuel::$env == Fuel::STAGING)
			{
				exec("FUEL_ENV=staging php {$pathOil}/oil r datamigration {$type} > /dev/null &");
			}
			else if (Fuel::$env == Fuel::TEST)
			{
				exec("FUEL_ENV=test php {$pathOil}/oil r datamigration {$type} > /dev/null &");
			}
			else
			{
				// Windowsの場合
				$fp = popen("start php {$pathOil}/oil r datamigration {$type}", "r");
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

	/**
	 * 
	 */
	public function action_regist_dummy($count = 0, $init = false)
	{
		try
		{
			if (empty($count))
			{
				//echo "no data";
				//exit;
			}


			// タスクを開始し、即リターンする
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

	/**
	 * 
	 */
	/* public function action_regist_area()
	  {
	  try
	  {
	  $model = new Model_Task_Registarea();
	  $model->run();

	  echo "success";
	  }
	  catch (Exception $e)
	  {

	  $this->error($e);
	  echo "failed";
	  echo $e->getMessage();
	  }
	  exit;
	  } */


	public function action_regist_geo()
	{

		try
		{

			// タスクを開始し、即リターンする
			$pathOil = realpath(APPPATH . '/../../');
			if (Fuel::$env == Fuel::PRODUCTION)
			{
				exec("FUEL_ENV=production php {$pathOil}/oil r registgeo > /dev/null &");
			}
			else if (Fuel::$env == Fuel::STAGING)
			{
				exec("FUEL_ENV=staging php {$pathOil}/oil r registgeo > /dev/null &");
			}
			else if (Fuel::$env == Fuel::TEST)
			{
				exec("FUEL_ENV=test php {$pathOil}/oil r registgeo > /dev/null &");
			}
			else
			{
				// Windowsの場合
				$fp = popen("start php {$pathOil}/oil r registgeo", "r");
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
