<?php
class Bank {
	private $bankID;
	private $bankName;
	private $bankLogo;
	private $isLock;
	private $dateCreated;
	private $dateUpdate;
	
	public function __construct(){
		$this -> bankID = '';
		$this -> bankName = '';
		$this -> isLock = false;
		$this -> dateCreated = '';
		$this -> dateUpdate = '';
		$this -> bankLogo = '';
	}
	
	public function getBankID(){
		return $this -> bankID;
	}
	
	public function setBankID($bankID) {
		$this -> bankID = $bankID;
	}
	
	public function getBankName(){
		return $this -> bankName;
	}
	
	public function setBankName($bankName) {
		$this -> bankName = $bankName;
	}
	
	public function getBankLogo(){
		return $this -> bankLogo;
	}
	
	public function setBankLogo($bankLogo) {
		$this -> bankLogo = $bankLogo;
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