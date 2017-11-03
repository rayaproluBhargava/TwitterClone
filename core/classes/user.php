<?php

/* User class which contains different methods for login, logout, create user, access userData and to check user input */

class User{
	protected $pdo;

	function __construct($pdo){
		$this->pdo = $pdo;
	}

	//checks the input passed by the user
	public function checkInput($var){ 
		$var = htmlspecialchars($var);
		$var = trim($var);
		$var = stripcslashes($var);
		return $var;
	}

	//login method for the user to login
	public function login($email, $password){
		$stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `email` = :email AND `password` = :password");
		$passwordHash = md5($password);
		$stmt->bindParam(":email", $email, PDO::PARAM_STR);
		$stmt->bindParam(":password", $passwordHash, PDO::PARAM_STR);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_OBJ);
		$count = $stmt->rowCount();

		if($count > 0){
			$_SESSION['user_id'] = $user->user_id;
			header('Location: home.php');
		} else {
			return false;
		}
	}
	//Method to access the user data
	public function userData($user_id){
		$stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id`= :user_id");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_OBJ);
	}

	//Create method to insert new record into the database
	public function create($table, $fields = array()){
		$columns = implode(',', array_keys($fields));
		$values = ':'.implode(', :', array_keys($fields));
		$sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
		if($stmt = $this->pdo->prepare($sql)){
			foreach ($fields as $key=>$data) {
				$stmt->bindValue(':'.$key, $data);
			}
			$stmt->execute();
			return $this->pdo->lastInsertId();
		}
	}
	
	//Logout user from the session
	public function logout(){
		$_SESSION = array();
		session_destroy();
		header('Location: ../index.php');
	}
}
?>