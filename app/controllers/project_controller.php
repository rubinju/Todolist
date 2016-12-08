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

		public static function destroy($id) {
			self::check_logged_in();
			$project = new Project(array('id' => $id));
			$project->destroy();
			Redirect::to('/project', array('message' => 'Project removed successfully'));
		}

	}
?>