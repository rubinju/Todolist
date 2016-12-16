<?php
	class ProjectController extends BaseController	{
		
		public static function index() {
			self::check_logged_in();
			$projects = Project::all();
			View::make('project/index.html', array('projects' => $projects));
		}

		public static function create() {
			self::check_logged_in();
			View::make('project/new.html');
		}

		public static function show($id) { // Lists all tasks in project $id
			self::check_logged_in();
			$tasks = Task::listProject($id);
			$project_name = Project::getName($id);
			//Kint::dump($tasks);
			//View::make('project/show.html', array('tasks' => $tasks));
			View::make('project/show.html', array('tasks' => $tasks, 'project_name' => $project_name));
		}

		public static function store() {
			self::check_logged_in();
			$params = $_POST;
			$attributes = array('name' => $params['name']);

			$project = new Project($attributes);
			
			//$errors = $project->errors(); // Calls all validators
			$errors = $project->validateProject();

			//Kint::dump($params); // Debug, comment out Redirect if used!

			if (count($errors) == 0) {
				$project->save();
				Redirect::to('/project', array('message' => 'Project added to database!'));
			} else {
			 	//Kint::dump($errors);
			 	View::make('project/new.html', array('errors' => $errors, 'attributes' => $attributes));
			}

		}

		public static function edit($id) {
			self::check_logged_in();
			$project = Project::find($id);
			View::make('project/edit.html', array('attributes' => $project));
		}

		public static function update($id) {
			self::check_logged_in();
			$params = $_POST;
			$attributes = array(
				'id' => $id,
				'name' => $params['name']
			);

			$project = new Project($attributes);
			$errors = $project->validateProject();
			if (count($errors) == 0) {
				$project->update();
				Redirect::to('/project', array('message' => 'Project edited successfully'));
			} else {
			 	View::make('project/edit.html', array('errors' => $errors, 'attributes' => $attributes));
			}
		}

		public static function destroy($id) {
			self::check_logged_in();
			$project = new Project(array('id' => $id));
			$project->destroy();
			Redirect::to('/project', array('message' => 'Project removed successfully'));
		}

	}
?>