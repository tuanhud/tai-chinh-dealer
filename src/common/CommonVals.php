<?php
class CommonVals
{
	// Table
	public static $tbl_linkfile = 'linkfile_tbl';
	public static $tbl_status_proccess_profile = 'status_proccess_profile';
	public static $tbl_type_loan = 'type_loan_tbl';
	public static $tbl_profile_customer = 'profile_customer_tbl';
	public static $tbl_authorization_link = 'authorization_link_tbl';
	public static $tbl_dealer_bank = 'dealer_bank_tbl';
	public static $tbl_authorization = 'authorization_tbl';
	public static $tbl_user_manager = 'user_manager_tbl';
	public static $tbl_bank = 'banks';
	
	// Property
	// table user_manager_tbl
	public static $user_id = 'user_id';
	public static $fullname = 'fullname';
	public static $password_user = 'password_user';
	public static $password_old = 'password_old';
	public static $is_root = 'is_root';
	public static $is_lock = 'is_lock';
	public static $date_lock = 'date_lock';
	public static $user_reset = 'user_reset';
	public static $date_reset_pass = 'date_reset_pass';
	public static $user_create = 'user_create';
	public static $datecreate = 'datecreate';
	public static $dateupdate = 'dateupdate';
	
	// table authorization_tbl
	public static $AllowInsertUser = 'insert_user';
	public static $AllowDeleteUser = 'delete_user';
	public static $AllowEditUser = 'edit_user';
	public static $AllowEditProfile = 'edit_profile';
	public static $AllowDeleteProfile = 'delete_profile';
	public static $DateLock = 'date_lock';
	
	// table dealer_bank_tbl
	public static $IDCODE = 'IDCODE';
	public static $EmailDealer = 'email_dealer';
	public static $PassDealer = 'pass_dealer';
	public static $NameDealer = 'regis_name';
	public static $Gender = 'gender';
	public static $DayOfBirth = 'dayofbirth';
	public static $Mobile = 'mobile';
	public static $HomePhone = 'home_phone';
	public static $Address = 'address';
	public static $Province = 'province';
	public static $CompanyWork = 'company_work';
	public static $AddressWork = 'address_work';
	public static $IntroInfoWork = 'intro_info_work';
	public static $IntroInfoKill = 'introinfokinhnghiem';
	public static $CardNumber = 'cardNumber';
	public static $BankID = 'BankID';
	public static $DateRegis = 'date_regis';
	public static $IsAccept = 'isaccept';
	public static $DateAccept = 'dateaccept';
	public static $IsLock = 'islock';
	
	
	// table profile_customer_tbl
	public static $IDPro = 'idpro';
	public static $UserManager = 'user_manager';
	public static $NameCustomer = 'namecustomer';
	public static $PhoneNumber = 'phonenumber';
	public static $InfoPro = 'infopro';
	public static $InfoRequest = 'inforequest';
	public static $AmountLoan = 'amount_loan';
	public static $BankLoan = 'bank_loan';
	public static $HoaHong = 'hoa_hong';
	public static $Isgnore = 'isgnore';
	public static $IsBackup = 'is_backup';
	public static $UserBackup = 'user_backup';
	public static $IsDelete = 'is_delete';
	public static $DateDelete = 'date_delete';
	public static $UserDelete = 'user_delete';
	public static $DateCreateFirst = 'datecreatefirst';
	
	// table type_loan_tbl
	public static $LoanID = 'loan_id';
	public static $LoanName = 'loan_name';
	
	// table status_proccess_profile
	public static $StatusID = 'status_id';
	public static $StatusName = 'status_name';
	
	// table linkfile_tbl
	public static $LinkImage = 'link_image';
	
	// table banks
	//public static $BankID = 'bankid';
	public static $BankName = 'bankname';
	public static $BankLogo = 'banklogo';
}
?>