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
				'priority' => $params['priority']
				//'status' => $params['status'] // this doesn't get relayed from new.html
			));

			//Kint::dump($params); // Debug, comment out Redirect if used!

			$task->save(); // Tell task-model to save this object to DB

			Redirect::to('/task/' . $task->id, array('message' => 'Task added to database!')); 
		}

		public static function show($id) {
			$task = Task::find($id);
			View::make('task/show.html', array('task' => $task));
		}

		public static function create(){
		  View::make('task/new.html');
		}
	}

?>