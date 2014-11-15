<?php
class Authorization {
	private $userID;
	private $isInsertUser;
	private $isDeleteUser;
	private $isEditUser;
	private $isEditProfile;
	private $isDeleteProfile;

	public function __construct(){
		$this -> userID = '';
		$this -> isInsertUser = false;
		$this -> isDeleteUser = false;
		$this -> isEditUser = false;
		$this -> isEditProfile = false;
		$this -> isDeleteProfile = false;
	}
	
	public function getUserID(){
		return $this -> userID;
	}
	
	public function setUserID($userID) {
		$this -> userID = $userID;
	}
	
	public function isInsertUser(){
		return $this -> isInsertUser;
	}
	
	public function setIsInsertUser($isInsertUser) {
		$this -> isInsertUser = $isInsertUser;
	}
	
	public function isDeleteUser(){
		return $this -> isDeleteUser;
	}
	
	public function setIsDeleteUser($isDeleteUser) {
		$this -> isDeleteUser = $isDeleteUser;
	}
	
	public function isEditUser(){
		return $this -> isEditUser;
	}
	
	public function setIsEditUser($isEditUser) {
		$this -> isEditUser = $isEditUser;
	}
	
	public function isEditProfile(){
		return $this -> isEditProfile;
	}
	
	public function setIsEditProfile($isEditProfile) {
		$this -> isEditProfile = $isEditProfile;
	}
	
	public function isDeleteProfile(){
		return $this -> isDeleteProfile;
	}
	
	public function setIsDeleteProfile($isDeleteProfile) {
		$this -> isDeleteProfile = $isDeleteProfile;
	}
	
}
?>