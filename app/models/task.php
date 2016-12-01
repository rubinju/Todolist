<?php
	class Task extends BaseModel{
		public $id, $description, $status, $created, $person, $priority; // should i use _id /_name here?

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
					'person' => $row['person'],
					'priority' => $row['priority']
				));
			}
			return $tasks;
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
				'person' => $row['person'],
				'priority' => $row['priority']
				));
				return $task;
			}
			return null;
		}

		public function save(/*$id*/) {
			$query = DB::connection()->prepare('INSERT INTO Task (description, status, created, person, priority) VALUES (:description, :status, :created, :person, :priority)'); //like this?
			$query->execute(array('description' => $this->description, 'status' => $this->status, 'created' => $this->created, 'person' => $this->person, 'priority' => $this->priority));
			$row = $query->fetch(); // is this needed?

			// ToBeDone...
			// what else are we modifying&saving here
		}


	} 

?>