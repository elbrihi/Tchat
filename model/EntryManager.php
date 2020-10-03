<?php
class EntryManager{

	//attributes
	private $_db;

	//constructor
    public function __construct($db){
        $this->_db = $db;
    }

	//BASIC CRUD OPERATIONS
	public function add(Entry $entry){
        $query = $this->_db->prepare(' INSERT INTO t_entry (
		idUser, title, content, created, createdBy)
		VALUES (:idUser, :title, :content, :created, :createdBy)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':idUser', $entry->idUser());
		$query->bindValue(':title', $entry->title());
		$query->bindValue(':content', $entry->content());
		$query->bindValue(':created', $entry->created());
		$query->bindValue(':createdBy', $entry->createdBy());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Entry $entry){
        $query = $this->_db->prepare(' UPDATE t_entry SET 
		idUser=:idUser, title=:title, content=:content, updated=:updated, updatedBy=:updatedBy
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $entry->id());
		$query->bindValue(':idUser', $entry->idUser());
		$query->bindValue(':title', $entry->title());
		$query->bindValue(':content', $entry->content());
		$query->bindValue(':updated', $entry->updated());
		$query->bindValue(':updatedBy', $entry->updatedBy());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
        $query = $this->_db->prepare(' DELETE FROM t_entry
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getOneById($id){
        $query = $this->_db->prepare(' SELECT * FROM t_entry
		WHERE id=:id')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Entry($data);
	}

	public function getAll(){
        $entrys = array();
		$query = $this->_db->query('SELECT * FROM t_entry
        ORDER BY id ASC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$entrys[] = new Entry($data);
		}
		$query->closeCursor();
		return $entrys;
	}

	public function getAllByLimits($begin, $end){
        $entrys = array();
		$query = $this->_db->query('SELECT * FROM t_entry
        ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$entrys[] = new Entry($data);
		}
		$query->closeCursor();
		return $entrys;
	}

	public function getAllNumber(){
        $query = $this->_db->query('SELECT COUNT(*) AS entrysNumber FROM t_entry');
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $entry = $data['entrysNumber'];
        return $entry;
    }

	public function getLastId(){
        $query = $this->_db->query(' SELECT id AS last_id FROM t_entry
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}