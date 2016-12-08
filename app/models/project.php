<?php
	class Project extends BaseModel {
		public $id, $name, $person;

		public function __construct($attributes) {
			parent::__construct($attributes);
			//$this->validators = array('validate_description', 'validate_priority'); // TODO: add other validators
		}

		public static function all(){ 
			$query = DB::connection()->prepare('SELECT * FROM Project WHERE person = :person');
			$query->execute(array('person' => $_SESSION['user'])); // does not work with booleans! check out bindValue
			$rows = $query->fetchAll();
			$tasks = array();

			foreach ($rows as $row) {
				$projects[] = new Project(array(
					'id' => $row['id'],
					'name' => $row['name']
				));
			}
			return $projects;
		}

		public function destroy() {
			$query = DB::connection()->prepare('DELETE FROM Project WHERE id = :id');
			$query->execute(array('id' => $this->id));
			$row = $query->fetch();
		}
	}
?>