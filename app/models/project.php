<?php
	class Project extends BaseModel {
		public $id, $name, $person, $taskcount;

		public function __construct($attributes) {
			parent::__construct($attributes);
			//$this->validators = array('validate_description', 'validate_priority'); // TODO: add other validators
		}

		public static function all(){ 
			$query = DB::connection()->prepare('SELECT * FROM Project WHERE person = :person ORDER BY id');
			$query->execute(array('person' => $_SESSION['user'])); // does not work with booleans! check out bindValue
			$rows = $query->fetchAll();
			$tasks = array();

			if ($rows) {
				foreach ($rows as $row) {
					$projects[] = new Project(array(
						'id' => $row['id'],
						'name' => $row['name'],
						'taskcount' => $row['taskcount']
						//'taskcount' => self::taskcount($row['id']) //, cant be done here, we're
					));
				}
				return $projects;
			}
			return null;
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Project WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if ($row) {
				$project = new Project(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'person' => $row['person'],
				'taskcount' => $row['taskcount']
				));
				return $project;
			}
			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Project (name, person, taskcount) VALUES (:name, :person, 0) RETURNING id');
			$query->execute(array('name' => $this->name, 'person' => $_SESSION['user']));
			$row = $query->fetch();
			$this->id = $row['id'];
		}

		public function update() {
			$query = DB::connection()->prepare('UPDATE Project SET name = :name WHERE id = :id');
			$query->execute(array('id' => $this->id, 'name' => $this->name));
			$row = $query->fetch();
		}

		public function destroy() {
			$query = DB::connection()->prepare('DELETE FROM Project WHERE id = :id');
			$query->execute(array('id' => $this->id));
			$row = $query->fetch();
		}

		public static function taskcount($id) {
			$query = DB::connection()->prepare('SELECT COUNT (project) FROM projects WHERE project = :id');
			$query->execute(array('id' => $id));
			$row = $query->fetch();
			//Kint::dump($row);
			$count = $row['count'];
			return $count;
		}

		public static function getName($id) {
			$query = DB::connection()->prepare('SELECT DISTINCT Project.name FROM Project INNER JOIN Projects on Project.id = Projects.project WHERE Project.id = :id');
			$query->execute(array('id' => $id));
			$row = $query->fetch();
			$project_name = $row['name'];
			return $project_name;
		}

		public static function updateCount($id) {
			$count = self::taskcount($id);
			Kint::dump($count);
			$query = DB::connection()->prepare('UPDATE Project SET taskcount = :taskcount WHERE id = :id');
			$query->execute(array('id' => $id, 'taskcount' => $count));
			$row = $query->fetch();
		}

		public static function addTask($taskid, $projectid) {
			$query = DB::connection()->prepare('INSERT INTO Projects (task, project) VALUES (:task, :project)');
			$query->execute(array('task' => $taskid, 'project' => $projectid));
			$row = $query->fetch();
		}

		public static function removeTask($taskid, $projectid) {
			$query = DB::connection()->prepare('DELETE FROM Projects WHERE task = :task AND project = :project');
			$query->execute(array('task' => $taskid, 'project' => $projectid));
			$row = $query->fetch();
		}

		public function validateProject() {
			$errors = array();

			$v1 = new Valitron\Validator(array('name' => $this->name));
			$v1->rule('lengthBetween', 'name', 3, 255);
			if (!$v1->validate()) {
				$errors[] = 'Name has to be between 3 and 255 chars.';
			}

			return $errors;
		}
	}
?>