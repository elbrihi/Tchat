<?php
class ChatMessageActionController {

    //attributes
    protected $_actionMessage;
    protected $_typeMessage;
    protected $_source;
    protected $_chatMessageManager;

    //constructor
    public function __construct($source){
    	$this->_chatMessageManager = new ChatMessageManager(PDOFactory::getMysqlConnection());
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
    public function sentChat($chatMessage)
    {
        
        return $this->_chatMessageManager->sentChat($chatMessage);
    }
    public function fetchUserChatHistory($chatMessage)
    {
        echo$this->_chatMessageManager->fetch_user_chat_history($_SESSION['user_id'], $chatMessage['to_user_id']);
        //echo 'hello';die;
        //return $this->_chatMessageManager->sentChat($chatMessage);
    }
    public function add($chatMessage){
        if( !empty($chatMessage['to_user_id']) ){
			$to_user_id = htmlentities($chatMessage['to_user_id']);
			$from_user_id = htmlentities($chatMessage['from_user_id']);
			$chat_message = htmlentities($chatMessage['chat_message']);
			$timestamp = htmlentities($chatMessage['timestamp']);
			$createdBy = $_SESSION['user']->login();
            $created = date('Y-m-d h:i:s');
            //create object
            $chatMessage = new ChatMessage(array(
				'to_user_id' => $to_user_id,
				'from_user_id' => $from_user_id,
				'chat_message' => $chat_message,
				'timestamp' => $timestamp,
				'created' => $created,
            	'createdBy' => $createdBy
			));
            //add it to db
            $this->_chatMessageManager->add($chatMessage);
            $this->_actionMessage = "Opération Valide : ChatMessage Ajouté(e) avec succès.";  
            $this->_typeMessage = "success";
            $this->_source = "view/chatMessage";
        }
        else{
            $this->_actionMessage = "Opération Invalide : Vous devez remplir le champ 'to_user_id'.";
            $this->_typeMessage = "error";
            $this->_source = "view/chatMessage";
        }
    }
    

   
    

    
}
    