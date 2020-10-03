<?php
class EntryActionController {

    //attributes
    protected $_actionMessage;
    protected $_typeMessage;
    protected $_source;
    protected $_entryManager;

    //constructor
    public function __construct($source){
    	$this->_entryManager = new EntryManager(PDOFactory::getMysqlConnection());
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
    public function add($entry){
        
        if( !empty($entry['title']) ){
            
            //$idUser = htmlentities($entry['idUser']);
            $idUser = $_SESSION['user']->id();
			$title = htmlentities($entry['title']);
			$content = htmlentities($entry['content']);
            $createdBy = $_SESSION['user']->login();
            //$createdBy = $_SESSION['user'][0]['id'];
            $created = date('Y-m-d h:i:s');
            //create object
            $entry = new Entry(array(
				'idUser' => $idUser,
				'title' => $title,
				'content' => $content,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $this->_entryManager->add($entry);
            $this->_actionMessage = "Opération Valide : Entry Ajouté(e) avec succès.";  
            $this->_typeMessage = "success";
            $this->_source = "view/dashboard";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'idUser'.";
            $this->_typeMessage = "error";
            $this->_source = "view/entry";
        }
    }
    

    public function update($entry){
        if(!empty($entry['idUser'])){
			$idUser = htmlentities($entry['idUser']);
			$title = htmlentities($entry['title']);
			$content = htmlentities($entry['content']);
			$updatedBy = $_SESSION['user']->login();
            $updated = date('Y-m-d h:i:s');
            $entry = new Entry(array(
				'id' => $idEntry,
				'idUser' => $idUser,
				'title' => $title,
				'content' => $content,
				'updated' => $updated,
            	'updatedBy' => $updatedBy
			));
            $this->_entryManager->update($entry);
            $this->_actionMessage = "Opération Valide : Entry Modifié(e) avec succès.";
            $this->_typeMessage = "success";
            $this->_source = "view/entry";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'idUser'.";
            $this->_typeMessage = "error";
            $this->_source = "view/entry";
        }
    }
    

    public function delete($entry){
        $idEntry = htmlentities($entry['idEntry']);
        $this->_entryManager->delete($idEntry);
        $this->_actionMessage = "Opération Valide : Entry supprimé(e) avec succès.";
        $this->_typeMessage = "success";
        $this->_source = "view/entry";
    }
    

    public function getEntryById($id){
        return $this->_entryManager->getEntryById($id);
    }
    

    public function getEntrys(){
        return  $this->_entryManager->getEntrys();
    }
    

    public function getEntrysByLimits($begin, $end){
        return $this->_entryManager->getEntrysByLimits($begin, $end);
    }
    

    public function getEntrysNumber(){
        return $this->_entryManager->getEntrysNumber();
    }
    

    public function getLastId(){
        return $this->_entryManager->getLastId();
    }
    
}
    