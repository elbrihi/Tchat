<?php
class UserManager{

	//attributes
    private $_db;
    private $_loginDetails;

	//constructor
    public function __construct($db){
        $this->_db = $db;
        $this->_loginDetails = new LoginDetailsManager($db);
    }

    public function getUserByName($user_id)
    {
        
        $query = "SELECT login FROM t_user WHERE id = '$user_id'";
        $statement = $this->_db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row)
        {
            return $row['login'];
        }
        
    }
    public function getUserBySession($id){
        
      
        $query = "
                SELECT * FROM t_user 
                WHERE id != '".$_SESSION['user_id']."' 
                ";

                $statement =  $this->_db->prepare($query);

                $statement->execute();

                $result = $statement->fetchAll();
                
        //print_r($result);
        $output = '
        <table class="table table-bordered table-striped">
            <tr>
                <th width="70%">Username</td>
                <th width="20%">Status</td>
                <th width="10%">Action</td>
            </tr>
        ';
        foreach($result as $row)
        {
            
            $status = '';
            $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
            $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
            $user_last_activity = $this->_loginDetails->fetch_last_user_activity($row['id']);

            

            var_dump($user_last_activity > $current_timestamp);
           
            if($user_last_activity > $current_timestamp)
            {
                $status = '<span class="label label-success">Online</span>';
            }
            else
            {
                $status = '<span class="label label-danger">Offline</span>';
            }
            //die;
            $output .= '
            <tr>
                <td>'.$row['login'].'</td>
                <td>'.$status.'</td>
                <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['id'].'" data-tousername="'.$row['login'].'">Start Chat</button></td>
            </tr>
            ';
        }
        $output .= '</table>';

        echo $output;
        return $output;






    }
    
	//BASIC CRUD OPERATIONS

    private function fetch_last_user_activity($user_id)
    {
        return '**********';
    }

  
  
	public function getOneById($id){
        $query = $this->_db->prepare(' SELECT * FROM t_user WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new User($data);
	}

	/*public function getAll(){
        $users = array();
		$query = $this->_db->query('SELECT * FROM t_user ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$users[] = new User($data);
		}
		$query->closeCursor();
		return $users;
	}*/
    public function getAll(){
        $users = array();
        $query = $this->_db->query('SELECT * FROM t_user ORDER BY id DESC');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
	}
	public function getAllByLimits($begin, $end){
        $users = array();
		$query = $this->_db->prepare('SELECT * FROM t_user ORDER BY id DESC LIMIT :begin, :end');
        $query->bindValue(':begin', $begin, PDO::PARAM_INT);
        $query->bindValue(':end', $end, PDO::PARAM_INT);
        $query->execute();     
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$users[] = new User($data);
		}
		$query->closeCursor();
		return $users;
	}

	public function getLastId(){
        $query = $this->_db->query(' SELECT id AS last_id FROM t_user ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}
    
    public function getAllNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS userNumbers FROM t_user');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['userNumbers'];
    }
    
    public function getStatus($login){
        $query = $this->_db->prepare('SELECT status FROM t_user WHERE login=:login');
        $query->bindValue(":login", $login);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['status'];
    }
    
    public function getStatusById($idUser){
        $query = $this->_db->prepare('SELECT status FROM t_user WHERE id=:idUser');
        $query->bindValue(":idUser", $idUser);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['status'];
    }
    
    public function getUserByLoginPassword($login, $password){
        $query = $this->_db->prepare('SELECT * FROM t_user WHERE login=:login AND password=:password');
        $query->bindValue(':login', $login);
        $query->bindValue(':password', $password);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new User($data);
    }
     
    /*public function getUserByLogin($login){
        $query = $this->_db->prepare('SELECT * FROM t_user WHERE login=:login');
        $query->bindValue(':login', $login);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return new User($data);
    }*/
    
    public function getUserByLogin($login){
        $query = $this->_db->prepare('SELECT * FROM t_user WHERE login=:login');
        $query->bindValue(':login', $login);
        $query->execute();
        $result = $query->fetchAll();
        return $result; 
    }
    public function getPasswordByLogin($login){
        $query = $this->_db->prepare('SELECT password FROM t_user WHERE login=:login');
        $query->bindValue(':login', $login);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data['password'];
    }
    
    public function exists($login, $password){
        $query = $this->_db->prepare('SELECT COUNT(*) FROM t_user WHERE login=:login AND password=:password');
        $query->bindValue(':login', $login);
        $query->bindValue(':password', $password);
        $query->execute();
        return (bool) $query->fetchColumn();
    }
    
    public function exist2($login){
        
        
        $query = $this->_db->prepare('SELECT COUNT(*) FROM t_user WHERE login=:login');
        $query->bindValue(':login', $login);
        
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        
        $data =     (bool)    $query->fetchColumn();

        return $data;
    }
    

}