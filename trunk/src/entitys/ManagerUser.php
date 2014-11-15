<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Authorization.php');

class ManageUser {
	private $userID;
	private $fullname;
	private $password;
	private $password_old;
	private $is_root;
	private $is_lock;
	private $date_lock;
	private $user_reset;
	private $date_reset_pass;
	private $user_create;
	private $datecreate;
	private $dateupdate;
	private $authorization;

	public function __construct(){
		$this -> userID = '';
		$this -> fullname = '';
		$this -> password = '';
		$this -> password_old = '';
		$this -> is_root = false;
		$this -> is_lock = false;
		$this -> date_lock = '';
		$this -> user_reset = '';
		$this -> date_reset_pass = '';
		$this -> user_create = '';
		$this -> datecreate = '';
		$this -> dateupdate = '';
		$this -> authorization = new Authorization();
	}
	
	public function getUserID(){
		return $this -> userID;
	}
	
	public function setUserID($userID) {
		$this -> userID = $userID;
	}
	
	public function getFullname(){
		return $this -> fullname;
	}
	
	public function setFullname($fullname) {
		$this -> fullname = $fullname;
	}
	
	public function getPassword(){
		return $this -> password;
	}
	
	public function setPassword($password) {
		$this -> password = $password;
	}
	
	public function getPasswordOld(){
		return $this -> password_old;
	}
	
	public function setPasswordOld($password_old) {
		$this -> password_old = $password_old;
	}
	
	public function isRoot(){
		return $this -> is_root;
	}
	
	public function setIsRoot($is_root) {
		$this -> is_root = $is_root;
	}
	
	public function isLock(){
		return $this -> is_lock;
	}
	
	public function setIsLock($is_lock) {
		$this -> is_lock = $is_lock;
	}
	
	public function getDateLock(){
		return $this -> date_lock;
	}
	
	public function setDateLock($date_lock) {
		$this -> date_lock = $date_lock;
	}
	
	public function getUserReset(){
		return $this -> user_reset;
	}
	
	public function setUserReset($user_reset) {
		$this -> user_reset = $user_reset;
	}
	
	public function getDateResetPass(){
		return $this -> date_reset_pass;
	}
	
	public function setDateResetPass($date_reset_pass) {
		$this -> date_reset_pass = $date_reset_pass;
	}
	
	public function getUserCreate(){
		return $this -> user_create;
	}
	
	public function setUserCreate($user_create) {
		$this -> user_create = $user_create;
	}
	
	public function getDateCreate(){
		return $this -> datecreate;
	}
	
	public function setDateCreate($datecreate) {
		$this -> datecreate = $datecreate;
	}
	
	public function getDateUpdate(){
		return $this -> dateupdate;
	}
	
	public function setDateUpdate($dateupdate) {
		$this -> dateupdate = $dateupdate;
	}
	
	public function getAuthorization(){
		return $this -> authorization;
	}
	
	public function setAuthorization($authorization) {
		$this -> authorization = $authorization;
	}
	
}
?>