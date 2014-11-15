<?php
class FileProfile {
	private $linkFile;
	private $idProfile;
	private $dateCreated;
	
	public function __construct(){
		$this -> linkFile = '';
		$this -> idProfile = '';
		$this -> dateCreated = '';
	}
	
	public function getLinkFile(){
		return $this -> linkFile;
	}
	
	public function setLinkFile($linkFile) {
		$this -> linkFile = $linkFile;
	}
	
	public function getIdProfile(){
		return $this -> idProfile;
	}
	
	public function setIdProfile($idProfile) {
		$this -> idProfile = $idProfile;
	}
	
	public function getDateCreated(){
		return $this -> dateCreated;
	}
	
	public function setDateCreated($dateCreated) {
		$this -> dateCreated = $dateCreated;
	}
}
?>