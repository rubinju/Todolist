<?php
	class Task extends BaseModel{
		public $id, $description, $status, $created, $person_id, $priority_name; // should i use _id /_name here?

		public function __construct($attributes) {
			parent::__construct($attributes);
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
					'person_id' => $row['person_id'],
					'priority_name' => $row['priority_name']
				));
			}
			return $tasks
		}

		public function find($id) {
			$query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
			$query->execute(array('id' => $id));
			$row = $query->fetch();

			if ($row) {
				$task = new Task(array(
				'id' => $row['id'],
				'description' => $row['description'],
				'status' => $row['status'], // Boolean!
				'created' => $row['created'],
				'person_id' => $row['person_id'],
				'priority_name' => $row['priority_name']
				));
				return $task;
			}
			return null;
		}

		public function save(/*$id*/) {
			$query = DB::connection()->prepare('INSERT INTO Task (description, status, created, person_id, priority_name) VALUES (:description, :status, :created, :person_id, :priority_name)'); //like this?
			$query->execute(array('description' => $this->description, 'status' => $this->status, 'created' => $this->created, 'person_id' => $this->person_id, 'priority_name' => $this->priority_name));
			$row = $query->fetch(); // is this needed?

			// ToBeDone...
			// what else are we modifying&saving here
		}


	} 

?>