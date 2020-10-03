<?php
class ChatMessage{

	//attributes
	private $_id;
	private $_to_user_id;
	private $_from_user_id;
	private $_chat_message;
	private $_timestamp;
	private $_created;
	private $_createdBy;
	private $_updated;
	private $_updatedBy;

	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

	//setters
	public function setId($id){
        $this->_id = $id;
    }
	public function setTo_user_id($to_user_id){
        $this->_to_user_id = $to_user_id;
    }

	public function setFrom_user_id($from_user_id){
        $this->_from_user_id = $from_user_id;
    }

	public function setChat_message($chat_message){
        $this->_chat_message = $chat_message;
    }

	public function setTimestamp($timestamp){
        $this->_timestamp = $timestamp;
    }

	public function setCreated($created){
        $this->_created = $created;
    }

	public function setCreatedBy($createdBy){
        $this->_createdBy = $createdBy;
    }

	public function setUpdated($updated){
        $this->_updated = $updated;
    }

	public function setUpdatedBy($updatedBy){
        $this->_updatedBy = $updatedBy;
    }

	//getters
	public function id(){
        return $this->_id;
    }
	public function to_user_id(){
        return $this->_to_user_id;
    }

	public function from_user_id(){
        return $this->_from_user_id;
    }

	public function chat_message(){
        return $this->_chat_message;
    }

	public function timestamp(){
        return $this->_timestamp;
    }

	public function created(){
        return $this->_created;
    }

	public function createdBy(){
        return $this->_createdBy;
    }

	public function updated(){
        return $this->_updated;
    }

	public function updatedBy(){
        return $this->_updatedBy;
    }

}