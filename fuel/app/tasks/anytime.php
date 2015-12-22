<?php

namespace Fuel\Tasks;

class Anytime extends Base
{

	public function a()
	{
		$task = new \Tasks_Anytime_A();
		$task->run();
	}

	public function b()
	{
		$task = new \Tasks_Anytime_B();
		$task->run();
	}

}
