<?php

//$path = APPPATH . "vendor/DmGeocoder-master/src/Dm/";
//require_once $path . 'Geocoder.php';
//require_once $path . 'Geocoder/Address.php';
//require_once $path . 'Geocoder/Prefecture.php';
//require_once $path . 'Geocoder/Query.php';
//require_once $path . 'Geocoder/GISCSV.php';
//require_once $path . 'Geocoder/GISCSV/Finder.php';
//require_once $path . 'Geocoder/GISCSV/Reader.php';

/**
 * 
 */
class Model_Task_Datamigration extends Model {

	/**
	 * 
	 * @param type $count
	 * @throws Exception
	 */
	public function run($type = "") {
		$tran = array(
			//"tpec" => false,
			//"hospital" => false,
			//"access" => false,
			//"url" => false,
			//"review" => false,
			//"evaluate" => false,
			//"course" => false,
			//"reservation" => false,
			"address" => false,
				//"features1" => false,
				//"features2" => false,
				//"image" => false,
				//"address_roma" => false,
				//"epark_url" => false,
				//"timetable" => false,
				//"geo" => false,
				//"access_re" => false,
				//"comment" => false,
		);

		$tran = @$tran[$type];
		if (is_null($tran)) {
			Log::error("{$type} migration nothing");
			return;
		}

		if ($tran) {
			DB::start_transaction();
		}
		try {
			$this->$type();
			DB::query("refresh materialized view v_hospital")->execute();
			DB::query("refresh materialized view v_hospital_access_time_from_station")->execute();
			DB::query("refresh materialized view v_hospital_evaluate")->execute();
			DB::query("refresh materialized view v_hospital_access")->execute();
			DB::query("refresh materialized view v_hospital_review")->execute();

			if ($tran) {
				DB::commit_transaction();
			}

			Log::error("{$type} migration finish");
		} catch (Exception $e) {
			if ($tran) {
				DB::rollback_transaction();
			}
			Common::error($e);
			throw $e;
		}
	}


}
?>

