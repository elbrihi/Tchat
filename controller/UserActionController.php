<?php
class UserActionController {

    //attributes
    protected $_actionMessage;
    protected $_typeMessage;
    protected $_source;
    protected $_userManager;
    protected $_loginDetailsManager;

    //constructor
    public function __construct($source){
        $this->_userManager = new UserManager(PDOFactory::getMysqlConnection());
        $this->_loginDetailsManager = new LoginDetailsManager(PDOFactory::getMysqlConnection());
    	$this->_source = $source;
    }

    //getters
    public function actionMessage(){
        return $this->_actionMessage;
    }
    

    public function typeMessage(){
        return $this->_typeMessage;
    }
    

    public function source(){
        return $this->_source;
    }
    
    //actions
  

    public function update($user){
        if ( !empty($user['idUser']) && !empty($user['login']) ) {
            $idUser = htmlentities($_POST['idUser']);
			$login = htmlentities($user['login']);
			$password = htmlentities($user['password']);
            $password = password_hash($password, PASSWORD_DEFAULT);
			$profil = htmlentities($user['profil']);
			$status = htmlentities($user['status']);
			$updatedBy = $_SESSION['userAxaAmazigh']->login();
            $updated = date('Y-m-d h:i:s');
            $user = new User(array(
				'id' => $idUser,
				'login' => $login,
				'password' => $password,
				'profil' => $profil,
				'status' => $status,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $this->_userManager->update($user);
            $this->_actionMessage = "Opération Valide : User Modifié(e) avec succès.";
            $this->_typeMessage = "success";
            $this->_source = "view/user";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'login'.";
            $this->_typeMessage = "error";
            $this->_source = "view/user";
        }
    }
    
    public function updateProfil($user){
        if ( !empty($user['idUser']) && !empty($user['profil']) ) {
            $idUser = htmlentities($_POST['idUser']);
            $profil = htmlentities($user['profil']);
            $updatedBy = $_SESSION['userAxaAmazigh']->login();
            $updated = date('Y-m-d h:i:s');
            $user = new User(array(
                'id' => $idUser,
                'profil' => $profil,
                'updated' => $updated,
                'updatedBy' => $updatedBy
            ));
            $this->_userManager->updateProfil($user);
            $this->_actionMessage = "Opération Valide : Profil User Modifié(e) avec succès.";
            $this->_typeMessage = "success";
            $this->_source = "view/user";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'login'.";
            $this->_typeMessage = "error";
            $this->_source = "view/user";
        }
    }
    
    
   
    public function login($user){
        //Test if the user credentials are set
        //Case 1 : Something missing
        
        
        if ( empty($user['login']) || empty($user['password']) ) {
            
            $this->_actionMessage = "Opération Invalide : Tous les champs sont obligatoires.";
            $this->_typeMessage = "error";
            $this->_source = "index";
        }
       
        //Case 2 : User's credentials are set
        else{
            
            $login = htmlspecialchars($user['login']);
            $password = htmlspecialchars($user['password']);
            
            //var_dump($this->getStatus($login));
            
            if ( $this->getStatus($login) != 0 ) {
               
               // begin
               // $this->$this->_userManager->getAll();
                
                $user = $this->_userManager->getUserByLogin($login);

                //$user = $user[0];
                
                foreach($user as $row)
                {
                    if ( password_verify($password, $this->getPasswordByLogin($login)) ) {
                        
                       
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $row['login'];
                       
                        $this->_loginDetailsManager->add($row['id'],$_SESSION['username']);
                        
                        $lastId = $this->_userManager->getLastId();
                        $_SESSION['login_details_id'] = $lastId;
                        
                        //$this->_source = "view/index";
                        header('Location:../view/index.php');

                        
                    }
                    // end
                    else{
                        $this->_actionMessage = "Opération Invalide : Mot de passe incorrecte.";
                        $this->_typeMessage = "error";
                        $this->_source = "index";
                        header('Location:../index.php');
                }
                }
                
                
                
            }
            else{
                $this->_actionMessage = "Opération Invalide : Login invalide ou compte inactif.";
                $this->_typeMessage = "error";
                $this->_source = "index";
            }
        }
    }
    
    public function getUserById($id){
        return $this->_userManager->getUserById($id);
    }
    public function getUserBySession($id){
        

        return $this->_userManager->getUserBySession($_SESSION['username']);
        
        //return $this->_userManager->getUserById($id);
    }
 
    ///$user
    public function getUsers(){
        die;
        return $this->_userManager->getUsers();
    }

    

    public function getLastId(){
        return $this->_userManager->getLastId();
    }
    
    public function getUsersNumber(){
        return $this->_userManager->getUsersNumber();
    }
    
    public function getStatus($login){
        return $this->_userManager->getStatus($login);
    }
    
    public function getStatusById($idUser){
        return $this->_userManager->getStatusById($idUser);
    }
    
    public function getUserByLoginPassword($login, $password){
        return $this->_userManager->getUserByLoginPassword($login, $password);
    }
    
    public function getUserByLogin($login){
        return $this->_userManager->getUserByLogin($login);
    }
    
    public function getPasswordByLogin($login){
        return $this->_userManager->getPasswordByLogin($login);
    }
    
    public function exists($login, $password){
        return $this->_userManager->exists($login, $password);
    }
    
    public function exist2($login){

        
        return $this->_userManager->exist2($login);
    }
}