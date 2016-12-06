<?php
	class Task extends BaseModel{
		public $id, $description, $status, $created, $person, $priority; // should i use _id /_name here? NO!

		public function __construct($attributes) {
			parent::__construct($attributes);
			$this->validators = array('validate_description'); // TODO: add other validators
		}

		public static function all(){
			$query = DB::connection()->prepare('SELECT * FROM Task');
			$query->execute(); // does not work with boolean! check out bindValue
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
			$query->execute(array('description' => $this->description, 'status' => $this->status, 'created' => $this->created, 'person' => $this->person, 'priority' => $this->priority));
			$row = $query->fetch(); // fetch the row so we get the id
			Kint::trace();
			Kint::dump($row); // row is false if nothing comes back from db, perhaps from wrong input type

			//$this->id = $row['id']; // commented out for debugging

			// ToBeDone...
			// what else are we modifying&saving here
		}

		public function validate_description() { // All other fields are pre-filled in add new task, at least for now. 
			$errors[] = $this->validate_string_length($this->description, 'description', 3, 40);
			return $errors;
		}
	} 
?>