<?php

class Tasks_Anytime_A extends Model
{

	public function run($type = "")
	{

		DB::start_transaction();

		try
		{


			DB::commit_transaction();
			Log::error("{$type} migration finish");
		}
		catch (Exception $e)
		{
			DB::rollback_transaction();
			Logger::error($e);
			throw $e;
		}
	}

}
