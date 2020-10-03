<?php
class LoginDetailsActionController {

    //attributes
    protected $_actionMessage;
    protected $_typeMessage;
    protected $_source;
    protected $_loginDetailsManager;

    //constructor
    public function __construct($source){
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

    public function fetch_last_user_activity($user_id)
    {
        return $this->_loginDetailsManager->upDateLastActivity();
    }
    public function add($loginDetails){
        if( !empty($loginDetails['user_id']) ){
			$user_id = htmlentities($loginDetails['user_id']);
			$latest_activity = htmlentities($loginDetails['latest_activity']);
			$createdBy = $_SESSION['user']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $loginDetails = new LoginDetails(array(
				'user_id' => $user_id,
				'latest_activity' => $latest_activity,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $this->_loginDetailsManager->add($loginDetails);
            $this->_actionMessage = "Opération Valide : LoginDetails Ajouté(e) avec succès.";  
            $this->_typeMessage = "success";
            $this->_source = "view/loginDetails";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'user_id'.";
            $this->_typeMessage = "error";
            $this->_source = "view/loginDetails";
        }
    }
    
    public function upDateLastActivity()
    {
        return $this->_loginDetailsManager->upDateLastActivity();
        return "++++";
    }
    public function update($loginDetails){
        if(!empty($loginDetails['user_id'])){
			$user_id = htmlentities($loginDetails['user_id']);
			$latest_activity = htmlentities($loginDetails['latest_activity']);
			$updatedBy = $_SESSION['user']->login();
            $updated = date('Y-m-d h:i:s');
            $loginDetails = new LoginDetails(array(
				'id' => $idLoginDetails,
				'user_id' => $user_id,
				'latest_activity' => $latest_activity,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $this->_loginDetailsManager->update($loginDetails);
            $this->_actionMessage = "Opération Valide : LoginDetails Modifié(e) avec succès.";
            $this->_typeMessage = "success";
            $this->_source = "view/loginDetails";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'user_id'.";
            $this->_typeMessage = "error";
            $this->_source = "view/loginDetails";
        }
    }
    

    public function delete($loginDetails){
        $idLoginDetails = htmlentities($loginDetails['idLoginDetails']);
        $this->_loginDetailsManager->delete($idLoginDetails);
        $this->_actionMessage = "Opération Valide : LoginDetails supprimé(e) avec succès.";
        $this->_typeMessage = "success";
        $this->_source = "view/loginDetails";
    }
    

    public function getLoginDetailsById($id){
        return $this->_loginDetailsManager->getLoginDetailsById($id);
    }
    

    public function getLoginDetailss(){
        return  $this->_loginDetailsManager->getLoginDetailss();
    }
    

    public function getLoginDetailssByLimits($begin, $end){
        return $this->_loginDetailsManager->getLoginDetailssByLimits($begin, $end);
    }
    

    public function getLoginDetailssNumber(){
        return $this->_loginDetailsManager->getLoginDetailssNumber();
    }
    

    public function getLastId(){
        return $this->_loginDetailsManager->getLastId();
    }
    
}
    