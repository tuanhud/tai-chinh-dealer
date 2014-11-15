<?php
class Status {
	private $statusID;
	private $statusName;
	private $isLock;
	private $dateCreated;
	private $dateUpdate;
	
	public function __construct(){
		$this -> statusID = '';
		$this -> statusName = '';
		$this -> isLock = false;
		$this -> dateCreated = '';
		$this -> dateUpdate = '';
	}
	
	public function getStatusID(){
		return $this -> statusID;
	}
	
	public function setStatusID($statusID) {
		$this -> statusID = $statusID;
	}
	
	public function getStatusName(){
		return $this -> statusName;
	}
	
	public function setStatusName($statusName) {
		$this -> statusName = $statusName;
	}
	
	public function isLock(){
		return $this -> isLock;
	}
	
	public function setIsLock($isLock) {
		$this -> isLock = $isLock;
	}
	
	public function getDateCreated(){
		return $this -> dateCreated;
	}
	
	public function setDateCreated($dateCreated) {
		$this -> dateCreated = $dateCreated;
	}
	
	public function getDateUpdate(){
		return $this -> dateUpdate;
	}
	
	public function setDateUpdate($dateUpdate) {
		$this -> dateUpdate = $dateUpdate;
	}
}
?>