<?php
class TypeLoan {
	private $loanID;
	private $loanName;
	private $isLock;
	private $dateCreated;
	private $dateUpdate;
	
	public function __construct(){
		$this -> loanID = '';
		$this -> loanName = '';
		$this -> isLock = false;
		$this -> dateCreated = '';
		$this -> dateUpdate = '';
	}
	
	public function getLoanID(){
		return $this -> loanID;
	}
	
	public function setLoanID($loanID) {
		$this -> loanID = $loanID;
	}
	
	public function getLoanName(){
		return $this -> loanName;
	}
	
	public function setLoanName($loanName) {
		$this -> loanName = $loanName;
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