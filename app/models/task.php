<?php
	class Task extends BaseModel{
		public $id, $description, $status, $created, $person, $priority;

		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validate_description', 'validate_priority'); // TODO: add other validators
		}

		public static function all(){ 
			$query = DB::connection()->prepare('SELECT * FROM Task WHERE person = :person');
			$query->execute(array('person' => $_SESSION['user'])); // does not work with booleans! check out bindValue
			$rows = $query->fetchAll();
			$tasks = array();

			foreach ($rows as $row) {
				$tasks[] = new Task(array(
					'id' => $row['id'],
					'description' => $row['description'],
					'status' => $row['status'], // Boolean!
					'created' => $row['created'],
					'person' => $row['person'],
					'priority' => $row['priority']
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
				'priority' => $row['priority']
				));
				return $task;
			}
			return null;
		}

		public function save() {
			$query = DB::connection()->prepare('INSERT INTO Task (description, status, created, person, priority) VALUES (:description, :status, :created, :person, :priority) RETURNING id'); // Get the id of the row via RETURNING id
			$query->execute(array('description' => $this->description, 'status' => $this->status, 'created' => date("Y-m-d"), 'person' => $_SESSION['user'], 'priority' => $this->priority));
			$row = $query->fetch(); // fetch the row so we get the id
			Kint::trace();
			Kint::dump($row); // row is false if nothing comes back from db, perhaps from wrong input type

			$this->id = $row['id']; // commented out for debugging

			// ToBeDone...
			// what else are we modifying&saving here
		}

		public function update() {
			$query = DB::connection()->prepare('UPDATE Task SET (description, status, priority) = (:description, :status, :priority) WHERE id = :id');
			Kint::dump($query);
			$query->execute(array('id' => $this->id, 'description' => $this->description, 'status' => $this->status, 'priority' => $this->priority));
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

		public function validate_description() { // All other fields are pre-filled in add new task, at least for now. 
			$val_error = array();
			// YO DAWG I PUT AN ARRAY IN YOUR ARRAY, plz merge!
			$val_error = array_merge($val_error, $this->validate_string_length($this->description, 'description', 3, 60));

			//Kint::dump($val_error); // DEBUG
			return $val_error;
		}

		public function validate_priority() {
			// Added to test errors() array merge
			$val_error = array();
			$val_error = array_merge($val_error, $this->validate_numeric($this->priority, 'priority'));
			return $val_error;
		}
	} 
?>