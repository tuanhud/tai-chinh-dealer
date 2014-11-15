<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/FileProfile.php');

class ProfileCustomer {
	private $IDProfile;
	private $status;
	private $typeLoan;
	private $IDCODE;
	private $emailDealer;
	private $userManager;
	private $nameCustomer;
	private $phoneNumber;
	private $province;
	private $infoProfile;
	private $infoRequest;
	private $amountLoan;
	private $bankLoan;
	private $hoaHong;
	private $isgnore;
	private $dateCreate;
	private $dateCreateFirst;
	private $dateUpdate;
	private $isBackup;
	private $userBackup;
	private $isDelete;
	private $dateDelete;
	private $userDelete;
	private $images;
	
	public function __construct(){
		$this -> IDProfile = '';
		$this -> status = new Status();
		$this -> typeLoan = new TypeLoan();
		$this -> IDCODE = '';
		$this -> emailDealer = '';
		$this -> userManager = '';
		$this -> nameCustomer = '';
		$this -> phoneNumber = '';
		$this -> province = '';
		$this -> infoProfile = '';
		$this -> infoRequest = '';
		$this -> amountLoan = '';
		$this -> bankLoan = '';
		$this -> hoaHong = '';
		$this -> isgnore = false;
		$this -> dateCreate = '';
		$this -> dateCreateFirst = '';
		$this -> dateUpdate = '';
		$this -> isBackup = false;
		$this -> userBackup = '';
		$this -> isDelete = false;
		$this -> dateDelete = '';
		$this -> userDelete = '';
		$this -> fileProfiles = new FileProfile();
	}
	
	public function getIDProfile(){
		return $this -> IDProfile;
	}
	
	public function setIDProfile($IDProfile) {
		$this -> IDProfile = $IDProfile;
	}
	
	public function getStatus(){
		return $this -> status;
	}
	
	public function setStatus($status) {
		$this -> status = $status;
	}
	
	public function getTypeLoan(){
		return $this -> typeLoan;
	}
	
	public function setTypeLoan($typeLoan) {
		$this -> typeLoan = $typeLoan;
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
	
	public function getUserManager(){
		return $this -> userManager;
	}
	
	public function setUserManager($userManager) {
		$this -> userManager = $userManager;
	}
	
	public function getNameCustomer(){
		return $this -> nameCustomer;
	}
	
	public function setNameCustomer($nameCustomer) {
		$this -> nameCustomer = $nameCustomer;
	}
	
	public function getPhoneNumber(){
		return $this -> phoneNumber;
	}
	
	public function setPhoneNumber($phoneNumber) {
		$this -> phoneNumber = $phoneNumber;
	}
	
	public function getProvince(){
		return $this -> province;
	}
	
	public function setProvince($province) {
		$this -> province = $province;
	}
	
	public function getInfoProfile(){
		return $this -> infoProfile;
	}
	
	public function setInfoProfile($infoProfile) {
		$this -> infoProfile = $infoProfile;
	}
	
	public function getInfoRequest(){
		return $this -> infoRequest;
	}
	
	public function setInfoRequest($infoRequest) {
		$this -> infoRequest = $infoRequest;
	}
	
	public function getAmountLoan(){
		return $this -> amountLoan;
	}
	
	public function setAmountLoan($amountLoan) {
		$this -> amountLoan = $amountLoan;
	}
	
	public function getBankLoan(){
		return $this -> bankLoan;
	}
	
	public function setBankLoan($bankLoan) {
		$this -> bankLoan = $bankLoan;
	}
	
	public function getHoaHong(){
		return $this -> hoaHong;
	}
	
	public function setHoaHong($hoaHong) {
		$this -> hoaHong = $hoaHong;
	}
	
	public function isgnore(){
		return $this -> isgnore;
	}
	
	public function setIsgnore($isgnore) {
		$this -> isgnore = $isgnore;
	}
	
	public function getDateCreate(){
		return $this -> dateCreate;
	}
	
	public function setDateCreate($dateCreate) {
		$this -> dateCreate = $dateCreate;
	}
	
	public function getDateCreateFirst(){
		return $this -> dateCreateFirst;
	}
	
	public function setDateCreateFirst($dateCreateFirst) {
		$this -> dateCreateFirst = $dateCreateFirst;
	}
	
	public function getDateUpdate(){
		return $this -> dateUpdate;
	}
	
	public function setDateUpdate($dateUpdate) {
		$this -> dateUpdate = $dateUpdate;
	}
	
	public function isBackup(){
		return $this -> isBackup;
	}
	
	public function setIsBackup($isBackup) {
		$this -> isBackup = $isBackup;
	}
	
	public function getUserBackup(){
		return $this -> userBackup;
	}
	
	public function setUserBackup($userBackup) {
		$this -> userBackup = $userBackup;
	}
	
	public function isDelete(){
		return $this -> isDelete;
	}
	
	public function setIsDelete($isDelete) {
		$this -> isDelete = $isDelete;
	}
	
	public function getDateDelete(){
		return $this -> dateDelete;
	}
	
	public function setDateDelete($dateDelete) {
		$this -> dateDelete = $dateDelete;
	}
	
	public function getUserDelete(){
		return $this -> userDelete;
	}
	
	public function setUserDelete($userDelete) {
		$this -> userDelete = $userDelete;
	}
	
	public function getFileProfiles(){
		return $this -> fileProfiles;
	}
	
	public function setFileProfiles($fileProfiles) {
		$this -> fileProfiles = $fileProfiles;
	}
}
?>