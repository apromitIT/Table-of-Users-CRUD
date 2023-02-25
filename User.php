<?php


class User
{
	public $connection;

	public function __construct()
	{
		$this->connection = new PDO("mysql:host=localhost;dbname=skillbox;charset=utf8", 'root', 'root');
	}

	public function create($arr) {
		$statement = $this->connection->prepare("INSERT INTO users(id,first_name,last_name,email,age,date_created) values(null, :first_name, :last_name, :email, :age, :date_created)");
		$statement->execute($arr);
	}

	public function update($arr, $id) {
		$statementUp = $this->connection->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, age = :age, date_created = :date_created WHERE id = $id");
		$statementUp->execute($arr);
	}

	public function delete($id) {
		$statementDel = $this->connection->query("DELETE FROM users WHERE id = $id");
		$statementDel->execute();
	}

	public function list() {
		$statement = $this->connection->query('SELECT * FROM users');
		$statement->execute();
		$data = $statement->fetchAll();
		return $data;
	}

}
