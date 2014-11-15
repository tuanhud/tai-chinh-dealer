<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');

class Dealer {
	private $IDCODE;
	private $emailDealer;
	private $password;
	private $fullname;
	private $gender;
	private $dayOfBirth;
	private $mobile;
	private $homePhone;
	private $address;
	private $province;
	private $companyWork;
	private $addressWork;
	private $infoIntroWork;
	private $kinhNghiem;
	private $cardNumber;
	private $bank;
	private $dateCreate;
	private $isAccept;
	private $dateAccept;
	private $isLock;
	
	public function __construct(){
		$this -> IDCODE = '';
		$this -> emailDealer = '';
		$this -> password = '';
		$this -> fullname = '';
		$this -> gender = false;
		$this -> dayOfBirth = '';
		$this -> mobile = '';
		$this -> homePhone = '';
		$this -> address = '';
		$this -> province = '';
		$this -> companyWork = '';
		$this -> addressWork = '';
		$this -> infoIntroWork = '';
		$this -> kinhNghiem = '';
		$this -> cardNumber = '';
		$this -> dateCreate = '';
		$this -> isAccept = false;
		$this -> dateAccept = '';
		$this -> isLock = false;
		$this -> bank = new Bank();
	}
	
	public function getIDCODE(){
		return $this -> IDCODE;
	}
	
	public function setIDCODE($IDCODE) {
		$this -> IDCODE = $IDCODE;
	}
	
	public function getEmailDealer(){
		return $this -> emailDealer;
	}
	
	public function setEmailDealer($emailDealer) {
		$this -> emailDealer = $emailDealer;
	}
	
	public function getPassword(){
		return $this -> password;
	}
	
	public function setPassword($password) {
		$this -> password = $password;
	}
	
	public function getFullname(){
		return $this -> fullname;
	}
	
	public function setFullname($fullname) {
		$this -> fullname = $fullname;
	}
	
	public function getGender(){
		return $this -> gender;
	}
	
	public function setGender($gender) {
		$this -> gender = $gender;
	}
	
	public function getDayOfBirth(){
		return $this -> dayOfBirth;
	}
	
	public function setDayOfBirth($dayOfBirth) {
		$this -> dayOfBirth = $dayOfBirth;
	}
	
	public function getMobile(){
		return $this -> mobile;
	}
	
	public function setMobile($mobile) {
		$this -> mobile = $mobile;
	}
	
	public function getHomePhone(){
		return $this -> homePhone;
	}
	
	public function setHomePhone($homePhone) {
		$this -> homePhone = $homePhone;
	}
	
	public function getAddress(){
		return $this -> address;
	}
	
	public function setAddress($address) {
		$this -> address = $address;
	}
	
	public function getProvince(){
		return $this -> province;
	}
	
	public function setProvince($province) {
		$this -> province = $province;
	}
	
	public function getCompanyWork(){
		return $this -> companyWork;
	}
	
	public function setCompanyWork($companyWork) {
		$this -> companyWork = $companyWork;
	}
	
	public function getAddressWork(){
		return $this -> addressWork;
	}
	
	public function setAddressWork($addressWork) {
		$this -> addressWork = $addressWork;
	}
	
	public function getInfoIntroWork(){
		return $this -> infoIntroWork;
	}
	
	public function setInfoIntroWork($infoIntroWork) {
		$this -> infoIntroWork = $infoIntroWork;
	}
	
	public function getKinhNghiem(){
		return $this -> kinhNghiem;
	}
	
	public function setKinhNghiem($kinhNghiem) {
		$this -> kinhNghiem = $kinhNghiem;
	}
	
	public function getCardNumber(){
		return $this -> cardNumber;
	}
	
	public function setCardNumber($cardNumber) {
		$this -> cardNumber = $cardNumber;
	}
	
	public function getBank(){
		return $this -> bank;
	}
	
	public function setBank($bank) {
		$this -> bank = $bank;
	}
	
	public function getDateCreate(){
		return $this -> dateCreate;
	}
	
	public function setDateCreate($dateCreate) {
		$this -> dateCreate = $dateCreate;
	}
	
	public function isAccept(){
		return $this -> isAccept;
	}
	
	public function setIsAccept($isAccept) {
		$this -> isAccept = $isAccept;
	}
	
	public function getDateAccept(){
		return $this -> dateAccept;
	}
	
	public function setDateAccept($dateAccept) {
		$this -> dateAccept = $dateAccept;
	}
	
	public function isLock(){
		return $this -> isLock;
	}
	
	public function setIsLock($isLock) {
		$this -> isLock = $isLock;
	}
}
?>