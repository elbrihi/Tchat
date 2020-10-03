<?php
class LoginDetailsManager{

	//attributes
	private $_db;

	//constructor
    public function __construct($db){
        $this->_db = $db;
    }
	
	public function add($userId){
		
        $query = $this->_db->prepare(' INSERT INTO t_loginDetails (
		user_id)
		VALUES (:user_id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':user_id', $userId);
		
		$query->execute();
		$query->closeCursor();
	}

	public function upDateLastActivity()
    {
		
        $query = "
		UPDATE t_loginDetails 
		SET last_activity = now() 
		WHERE login_details_id = '".$_SESSION["login_details_id"]."'
		";

		$statement = $this->_db->prepare($query);

		$statement->execute();

				return "++++";
    }


    public function fetch_last_user_activity($user_id)
    {
		$query = "
		SELECT * FROM t_loginDetails 
		WHERE user_id = '$user_id' 
		ORDER BY last_activity DESC 
		LIMIT 1
		";
		$statement = $this->_db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			return $row['last_activity'];
			;
		}

		/*echo '<pre>';
		print_r($row);
		die;*/
		
	}
	




























	//BASIC CRUD OPERATIONS
	/*public function add(LoginDetails $loginDetails){
        $query = $this->_db->prepare(' INSERT INTO t_loginDetails (
		user_id, latest_activity, created, createdBy)
		VALUES (:user_id, :latest_activity, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':user_id', $loginDetails->user_id());
		$query->bindValue(':latest_activity', $loginDetails->latest_activity());
		$query->bindValue(':created', $loginDetails->created());
		$query->bindValue(':createdBy', $loginDetails->createdBy());
		$query->execute();
		$query->closeCursor();
	}*/
	

	public function update(LoginDetails $loginDetails){
        $query = $this->_db->prepare(' UPDATE t_loginDetails SET 
		user_id=:user_id, latest_activity=:latest_activity, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $loginDetails->id());
		$query->bindValue(':user_id', $loginDetails->user_id());
		$query->bindValue(':latest_activity', $loginDetails->latest_activity());
		$query->bindValue(':updated', $loginDetails->updated());
		$query->bindValue(':updatedBy', $loginDetails->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
        $query = $this->_db->prepare(' DELETE FROM t_loginDetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getOneById($id){
        $query = $this->_db->prepare(' SELECT * FROM t_loginDetails
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new LoginDetails($data);
	}

	public function getAll(){
        $loginDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_loginDetails
        ORDER BY id ASC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$loginDetailss[] = new LoginDetails($data);
		}
		$query->closeCursor();
		return $loginDetailss;
	}

	public function getAllByLimits($begin, $end){
        $loginDetailss = array();
		$query = $this->_db->query('SELECT * FROM t_loginDetails
        ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$loginDetailss[] = new LoginDetails($data);
		}
		$query->closeCursor();
		return $loginDetailss;
	}

	public function getAllNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS loginDetailssNumber FROM t_loginDetails');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $loginDetails = $data['loginDetailssNumber'];
        return $loginDetails;
    }

	public function getLastId(){
        $query = $this->_db->query(' SELECT id AS last_id FROM t_loginDetails
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}