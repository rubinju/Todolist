<?php

	class TaskController extends BaseController	{
		
		public static function index() {
			$tasks = Task::all(); //Get all tasks from db
			View::make('task/index.html', array('tasks' => $tasks));
		}

		public static function store() { // What do we do about parms that need to be put in a different db-table? Or creation-date that's not user submitted?
			$params = $_POST;
			$task = new Task(array(
				'description' => $params['description'],
				'priority' => $params['priority'],
				'status' => $params['status']
			));

			$task->save(); // Tell task-model to save this object to DB

			Redirect::to('/task/' . $task->id, array('message' => 'Task added to database!')); 
		}
	}

?>