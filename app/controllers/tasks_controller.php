<?php

	class TaskController extends BaseController	{
		
		public static function index() {
			self::check_logged_in();
			$tasks = Task::all(); //Get all tasks from db
			View::make('task/index.html', array('tasks' => $tasks));
		}

		public static function store() {
			self::check_logged_in();
			$params = $_POST;
			if (empty($_POST['projects'])) {
				$errors[] = 'Select at least one project!';
				$projects = '';
			} else {
				$projects = $_POST['projects'];
			}
			$attributes = array(
				'description' => $params['description'],
				'priority' => $params['priority'],
				'status' => 0, // New tasks gets marked as not done
				'projectids' => $projects // stringconversion has to be done in Task, not here
			);

			$task = new Task($attributes);
			//$errors = $task->errors(); // Deprecated: Switched to valitron. Calls all validators
			$errors = $task->validateTask(); // Valitron takes care of putting all errors in one array
			//Kint::dump($params); // Debug, comment out Redirect if used!
			//Kint::dump($task);

			 if (count($errors) == 0) {
				$task->save(); // Tell task-model to save this object to DB
				foreach ($projects as $project) {
					Project::addTask($task->id, $project); // We don't know the id before it is saved!
					Project::updateCount($project);
				}

				Redirect::to('/task/' . $task->id, array('message' => 'Task added to database!'));
			} else {
				Kint::dump($errors);
				$projects = Project::all();
				Kint::dump($attributes);
				Kint::dump($projects);
				View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes, 'projects' => $projects));
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
			$task->projectids = explode(",", $task->projectids);
			$projects = Project::all();
			View::make('task/edit.html', array('attributes' => $task, 'projects' => $projects));
		} 

		public static function update($id) { // push edits to DB
			self::check_logged_in();
			$params = $_POST;
			if (empty($_POST['projects'])) {
				$errors[] = 'Select at least one project!';
				$projects = '';
			} else {
				$projects = $_POST['projects'];
			}
			$attributes = array(
				'id' => $id,
				'description' => $params['description'],
				'priority' => $params['priority'],
				'status' => $params['status'],
				'projectids' => $projects
			);

			$task = new Task($attributes);
			//$errors = $task->errors();
			$errors = $task->validateTask();

			if (count($errors) > 0) {
				View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes));
			} else {
				self::updateProjectMembership($id, $projects);
				$task->update();
				Redirect::to('/task/' . $task->id, array('message' => 'Task edited successfully'));
			}
		}

		public static function destroy($id) {
			self::check_logged_in();
			$task = new Task(array('id' => $id));
			$projects = Task::getMemberOfProjects($id);
			$task->destroy();
				foreach ($projects as $project) {
					Project::updateCount($project); 					
				}
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

		private static function updateProjectMembership($taskid, $projects) { // projects: task should belong to these
			$memberOf = Task::getMemberOfProjects($taskid); // a member of before we update
			
			foreach ($projects as $project) {
				if (!in_array($project, $memberOf)) { // not a member yet
					Project::addTask($taskid, $project);
					Project::updateCount($project);
				}
			}

			foreach ($memberOf as $memberProj) {
				if (!in_array($memberProj, $projects)) { // a member, but should not be anymore
					Project::removeTask($taskid, $memberProj);
					Project::updateCount($memberProj);
				}
			}
		}

	}

?>