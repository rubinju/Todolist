<?php

	class TaskController extends BaseController	{
		
		public static function index() {
			$tasks = Task::all(); //Get all tasks from db
			View::make('task/index.html', array('tasks' => $tasks)); // TODO task/index.. does not exist there yet! See /tasklist and suunn../list.html
		}
	}

?>