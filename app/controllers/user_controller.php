<?php
class UserController extends BaseController {
	public static function login() {
		View::make('user/login.html');
	}

	public static function handle_login() {
		$params = $_POST;
		$user = User::authenticate($params['username'], $params['password']);

		if (!$user) {
			View::make('user/login.html', array('error' => 'Wrong username or password', 'username' => $params['username']));
		} else {
			$_SESSION['user'] = $user->id;

			//Kint::dump($user);
			Redirect::to('/', array('message' => 'Welcome back ' . $user->username . '. Start by creating a project if you dont have any yet, add tasks after that! The delete task-button is only visible if you click on the task'));
		}
	}

	public static function logout() {
		$_SESSION['user'] = null;
		Redirect::to('/login', array('message' => 'Successfully logged out'));
	}
}

?>