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
					'priority_name' => $row['priority_name'],
				));
			}
			return $tasks
		}

		

	} 

?>