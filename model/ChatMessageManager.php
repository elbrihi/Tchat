<?php
class ChatMessageManager{

	//attributes
	private $_db;
	private $_userManager;
	//constructor
    public function __construct($db){
		$this->_db = $db;
		$this->_userManager = new UserManager($db);
    }

	//BASIC CRUD OPERATIONS
	public function sentChat($chatMessage)
	{
		$data = array(
			':to_user_id'		=>	$chatMessage['to_user_id'],
			':from_user_id'		=>	$_SESSION['user_id'],
			':chat_message'		=>	$chatMessage['chat_message'],
			':status'			=>	'1'
		);
		
	
		
		$query = $this->_db->prepare(' INSERT INTO t_chatMessage (
			to_user_id, from_user_id, chat_message, status)
			VALUES (:to_user_id, :from_user_id, :chat_message, :status)');
		$query->bindValue(':to_user_id', $chatMessage['to_user_id']);
		$query->bindValue(':from_user_id', $_SESSION['user_id']);
		$query->bindValue(':chat_message', $chatMessage['chat_message']);
		$query->bindValue(':status', '1');
		
		//$statement = $this->_db->prepare($query);
		//$query->execute();
		if($query->execute())
		{
			echo $this->fetch_user_chat_history($_SESSION['user_id'], $chatMessage['to_user_id']);
		}
		
	}

	public function fetch_user_chat_history($from_user_id, $to_user_id)
	{
		
		$query = "
		SELECT * FROM t_chatMessage
		WHERE (from_user_id = '".$from_user_id."' 
		AND to_user_id = '".$to_user_id."') 
		OR (from_user_id = '".$to_user_id."' 
		AND to_user_id = '".$from_user_id."') 
		ORDER BY timestamp DESC
		";
		$statement = $this->_db->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$output = '<ul class="list-unstyled">';

		
		foreach($result as $row)
		{
			$user_name = '';
			$dynamic_background = '';
			$chat_message = '';
			if($row["from_user_id"] == $from_user_id)
			{
				if($row["status"] == '2')
				{
					$chat_message = '<em>This message has been removed</em>';
					$user_name = '<b class="text-success">You</b>';
				}
				else
				{
					$chat_message = $row['chat_message'];
					$user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['id'].'">x</button>&nbsp;<b class="text-success">You</b>';
				}
				
	
				$dynamic_background = 'background-color:#ffe6e6;';
			}
			else
			{
				if($row["status"] == '2')
				{
					$chat_message = '<em>This message has been removed</em>';
				}
				else
				{
					$chat_message = $row["chat_message"];
				}
				$user_name = '<b class="text-danger">'.$this->_userManager->getUserByName($from_user_id).'</b>';
				$dynamic_background = 'background-color:#ffffe6;';
			}
			$output .= '
			<li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
				<p>'.$user_name.' - '.$chat_message.'
					<div align="right">
						- <small><em>'.$row['timestamp'].'</em></small>
					</div>
				</p>
			</li>
			';
		}
		$output .= '</ul>';
		$query = "
		UPDATE t_chatMessage 
		SET status = '0' 
		WHERE from_user_id = '".$to_user_id."' 
		AND to_user_id = '".$from_user_id."' 
		AND status = '1'
		";
		$statement = $this->_db->prepare($query);
		$statement->execute();
		
		return $output;
	}




	

}