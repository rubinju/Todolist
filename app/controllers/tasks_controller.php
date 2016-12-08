<?php

	class TaskController extends BaseController	{
		
		public static function index() {
			self::check_logged_in();
			$tasks = Task::all(); //Get all tasks from db
			View::make('task/index.html', array('tasks' => $tasks));
		}

		public static function store() { // What do we do about parms that need to be put in a different db-table?
			self::check_logged_in();
			$params = $_POST;
			$attributes = array(
				'description' => $params['description'],
				'priority' => $params['priority'],
				'status' => 0 // this doesn't get relayed from new.html
			);

			$task = new Task($attributes);
			$errors = $task->errors(); // Calls all validators

			//Kint::dump($params); // Debug, comment out Redirect if used!

			if (count($errors) == 0) {
				$task->save(); // Tell task-model to save this object to DB

			Redirect::to('/task/' . $task->id, array('message' => 'Task added to database!'));
			} else {
				//Kint::dump($errors);
				View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes));
			}

		}

		public static function show($id) {
			self::check_logged_in();
			$task = Task::find($id);
			View::make('task/show.html', array('task' => $task));
		}

		public static function create() {
			self::check_logged_in();
			$projects = Project::all();
			View::make('task/new.html', array('projects' => $projects));
		}

		public static function edit($id) {
			self::check_logged_in();
			$task = Task::find($id);
			$projects = Project::all();
			View::make('task/edit.html', array('attributes' => $task, 'projects' => $projects));
		} 

		public static function update($id) { // push edits to DB
			self::check_logged_in();
			$params = $_POST;
			$attributes = array(
				'id' => $id,
				'description' => $params['description'],
				'priority' => $params['priority'],
				'status' => $params['status']
			);

			$task = new Task($attributes);
			$errors = $task->errors();

			if (count($errors) > 0) {
				View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes));
			} else {
				$task->update();
				Redirect::to('/task/' . $task->id, array('message' => 'Task edited successfully'));
			}
		}

		public static function destroy($id) {
			self::check_logged_in();
			$task = new Task(array('id' => $id));
			$task->destroy();
			Redirect::to('/task', array('message' => 'Task removed successfully'));
		}

		public static function done($id) {
			self::check_logged_in();
			$params = $_POST;
			$attributes = array('id' => $id, 'status' => $params['status']);

			$task = new Task($attributes);
			$task->done();
			Redirect::to('/task', array('message' => 'Task done'));
		}
	}

?>