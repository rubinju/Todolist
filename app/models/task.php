<?php
	class Task extends BaseModel{
		public $id, $description, $status, $created, $person, $priority, $projectids;

		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validateTask');
		}

		public static function all(){ 
			$query = DB::connection()->prepare('SELECT * FROM Task WHERE person = :person ORDER BY status, priority DESC, created DESC');
			$query->execute(array('person' => $_SESSION['user']));
			$rows = $query->fetchAll();
			$tasks = array();

			foreach ($rows as $row) {
				$tasks[] = new Task(array(
					'id' => $row['id'],
					'description' => $row['description'],
					'status' => $row['status'], // Boolean!
					'created' => $row['created'],
					'person' => $row['person'],
					'priority' => $row['priority'],
					'projectids' => $row['projectids']
				));
			}
			return $tasks;
		}

		public static function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if ($row) {
				$task = new Task(array(
				'id' => $row['id'],
				'description' => $row['description'],
				'status' => $row['status'], // Boolean!
				'created' => $row['created'],
				'person' => $row['person'],
				'priority' => $row['priority'],
				'projectids' => $row['projectids']
				));
				return $task;
			}
			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Task (description, status, created, person, priority, projectids) VALUES (:description, :status, :created, :person, :priority, :projectids) RETURNING id'); // Get the id of the row via RETURNING id
			$query->execute(array('description' => $this->description, 'status' => $this->status, 'created' => date("Y-m-d"), 'person' => $_SESSION['user'], 'priority' => $this->priority, 'projectids' => implode(",", $this->projectids)));
			$row = $query->fetch(); // fetch the row so we get the id
			Kint::trace();
			Kint::dump($row); // row is false if nothing comes back from db, perhaps from wrong input type

			$this->id = $row['id']; // commented out for debugging
		}

		public function update() {
			$query = DB::connection()->prepare('UPDATE Task SET (description, status, priority, projectids) = (:description, :status, :priority, :projectids) WHERE id = :id');
			Kint::dump($query);
			$query->execute(array('id' => $this->id, 'description' => $this->description, 'status' => $this->status, 'priority' => $this->priority, 'projectids' => implode(",", $this->projectids)));
			$row = $query->fetch(); // row is false if db is angry, great for debugging
		}

		public function destroy() {
			$query = DB::connection()->prepare('DELETE FROM Task WHERE id = :id');
			$query->execute(array('id' => $this->id));
			$row = $query->fetch();
		}

		public function done() {
			$query = DB::connection()->prepare('UPDATE Task SET status = :status WHERE id = :id');
			$query->execute(array('id' => $this->id, 'status' => $this->status));
			$row = $query->fetch();
		}

		// Deprecated, switched to valitron
		// public function validate_description() { // All other fields are pre-filled in add new task, at least for now. 
		// 	$val_error = array();
		// 	// YO DAWG I PUT AN ARRAY IN YOUR ARRAY, plz merge!
		// 	$val_error = array_merge($val_error, $this->validate_string_length($this->description, 'description', 3, 60));

		// 	//Kint::dump($val_error); // DEBUG
		// 	return $val_error;
		// }

		// public function validate_priority() {
		// 	// Added to test errors() array merge
		// 	$val_error = array();
		// 	$val_error = array_merge($val_error, $this->validate_numeric($this->priority, 'priority'));
		// 	return $val_error;
		// }

		public static function listProject($projectId){ // Lists tasks included in project id
			$query = DB::connection()->prepare('
				 SELECT Task.id, Task.description, Task.created, Task.status, Task.priority, Task.projectids, Projects.project AS project_id, Project.name AS project_name FROM Task INNER JOIN Projects ON Task.id = Projects.task INNER JOIN Project ON Project.id = Projects.project WHERE project = :id ORDER BY status, priority DESC, created DESC
				');
			$query->execute(array('id' => $projectId));
			$rows = $query->fetchAll();
			$tasks = array();

			foreach ($rows as $row) {
				$tasks[] = new Task(array(
					'id' => $row['id'],
					'description' => $row['description'],
					'status' => $row['status'],
					'created' => $row['created'],
					'priority' => $row['priority'],
					'projectids' => $row['projectids']
				));
			}
			return $tasks;
		}

		public static function getMemberOfProjects($id) { // Lists projects which task id is member in
			$query = DB::connection()->prepare('SELECT project FROM Projects WHERE task = :id');
			$query->execute(array('id' => $id));
			$rows = $query->fetchAll();
			$projects = array();

			foreach ($rows as $row) {
				$projects[] = $row['project'];
			}
			//Kint::dump($rows);
			//Kint::dump($projects);
			return $projects;
		}

		public function validateTask() {
			$errors = array();

			$v1 = new Valitron\Validator(array('description' => $this->description));
			$v1->rule('lengthBetween', 'description', 3, 255);
			if (!$v1->validate()) {
				$errors[] = 'Description has to be between 3 and 255 chars.';
			}

			$v2 = new Valitron\Validator(array('projectids' => $this->projectids));
			$v2->rule('required', 'projectids');
			if (!$v2->validate()) {
				$errors[] = 'Choose at least one project';
			}

			$v3 = new Valitron\Validator(array('priority' => $this->priority));
			$v3->rule('min', 'priority', 1);
			if (!$v3->validate()) {
				$errors[] = 'Priority has to be >= 1';
			}

			return $errors;
		}
	} 
?>