<?php
class ConnectDB {
	var $con;
	var $sdb;
	var $font;
	var $sql;
	var $str;
	var $value;
	var $key;
	var $strarr=array();
	var $result=array();
	var $server = 'localhost';
	var $db = 'taichinh_dealer';
	var $user = 'root';
	var $pass = '';
	
	/*var $db = 'u868290459_deale';
	var $user = 'u868290459_deale';
	var $pass = ':cwx0$3Xifo3@P@~!f';*/
	
	public function __construct() {
        $this->con=@mysql_connect($this->server,$this->user,$this->pass) or die(mysql_error());
        $this->sdb=@mysql_select_db($this->db,$this->con) or die(mysql_error());
		@mysql_set_charset("utf8", $this->con);
    }
	
	public function getvalueString($sstr) {
		$this->result=array();
		$this->value='';
		$this->str=mysql_query($sstr);
       
        while($arr=mysql_fetch_row($this->str)) {
            $this->strarr=array();
            foreach ($arr as $value) {
				array_push($this->strarr,$value);                  
			}                     
			array_push($this->result,$this->strarr); 
        }
        return $this->result;
	}
   
	public function getvalueone($tbl,$fn=array()) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->result=array();
        $this->sql="SELECT ";
        for($i=0;$i<count($fn);$i++) {
            if($i==count($fn)-1)
                {$this->sql.=$fn[$i].' ';}
            else
                {$this->sql.=$fn[$i].', ';}
        }
        $this->sql.='FROM '.$tbl;
        $this->str=mysql_query($this->sql);
       
        while($arr=mysql_fetch_row($this->str)) {
            $this->strarr=array();
            foreach ($arr as $value) {
				array_push($this->strarr,$value);                  
			}                     
			array_push($this->result,$this->strarr); 
        }
        return $this->result;
	}
	
	public function getvalue($tbl,$fn=array(),$fcon=array()) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->result=array();
        $this->sql="SELECT ";
        for($i=0;$i<count($fn);$i++) {
            if($i==count($fn)-1)
                {$this->sql.=$fn[$i].' ';}
            else
                {$this->sql.=$fn[$i].', ';}
        }
        $this->sql.='FROM '.$tbl.' WHERE ';       
        $this->key=array_keys($fcon);
        $this->value=  array_values($fcon);
        for($i=0;$i<count($fcon);$i++) {
            if($i==count($fcon)-1)
                $this->sql.=$this->key[$i]."='".$this->value[$i]."';";
            else
                $this->sql.=$this->key[$i]."='".$this->value[$i]."' AND ";
        }
        $this->str=mysql_query($this->sql);
        while($arr=mysql_fetch_row($this->str)) {
            $this->strarr=array();
            foreach ($arr as $value) {
				array_push($this->strarr,$value);            
			}                     
			array_push($this->result,$this->strarr); 
        }
        return $this->result;
	}
	
	public function getvalueorderby($tbl,$fn=array(),$fcon=array(), $orderby) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->result=array();
        $this->sql="SELECT ";
        for($i=0;$i<count($fn);$i++) {
            if($i==count($fn)-1)
                {$this->sql.=$fn[$i].' ';}
            else
                {$this->sql.=$fn[$i].', ';}
        }
        $this->sql.='FROM '.$tbl;
		if(count($fcon) > 0) {
			$this->sql.=' WHERE ';
			$this->key=array_keys($fcon);
			$this->value=  array_values($fcon);
			for($i=0;$i<count($fcon);$i++) {
				if($i==count($fcon)-1)
					$this->sql.=$this->key[$i]."='".$this->value[$i]."'";
				else
					$this->sql.=$this->key[$i]."='".$this->value[$i]."' AND ";
			}
		}
		
		//order by
		$this->sql.=' ORDER BY '.$orderby.' DESC';
		
        $this->str=mysql_query($this->sql);
        while($arr=mysql_fetch_row($this->str)) {
            $this->strarr=array();
            foreach ($arr as $value) {
				array_push($this->strarr,$value);            
			}                     
			array_push($this->result,$this->strarr); 
        }
        return $this->result;
	}
	
	// get value all
	public function getvalueall($tbl,$fn=array(),$fcon=array(),$flike=array(), $orderby) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->result=array();
        $this->sql="SELECT ";
        for($i=0;$i<count($fn);$i++) {
            if($i==count($fn)-1)
                {$this->sql.=$fn[$i].' ';}
            else
                {$this->sql.=$fn[$i].', ';}
        }
        $this->sql.='FROM '.$tbl;
		// where
		if(count($fcon) > 0) {
			$this->sql.=' WHERE ';
			$this->key=array_keys($fcon);
			$this->value=  array_values($fcon);
			for($i=0;$i<count($fcon);$i++) {
				if($i==count($fcon)-1)
					$this->sql.=$this->key[$i]."='".$this->value[$i]."'";
				else
					$this->sql.=$this->key[$i]."='".$this->value[$i]."' AND ";
			}
		}
		
		// like
		if(count($flike) > 0) {
			if(count($fcon) > 0) {
				$this->sql.=' AND ';
			} else {
				$this->sql.=' WHERE ';
			}
			$this->key=array_keys($flike);
			$this->value=  array_values($flike);
			for($i=0;$i<count($flike);$i++) {
				if($i==count($flike)-1)
					$this->sql.=$this->key[$i]." LIKE '%".$this->value[$i]."%'";
				else
					$this->sql.=$this->key[$i]." LIKE '%".$this->value[$i]."%' AND ";
			}
		}
		
		//order by
		if($orderby != '') {
			$this->sql.=' ORDER BY '.$orderby.' DESC';
		}
		
        $this->str=mysql_query($this->sql);
        while($arr=mysql_fetch_row($this->str)) {
            $this->strarr=array();
            foreach ($arr as $value) {
				array_push($this->strarr,$value);
			}
			array_push($this->result,$this->strarr);
        }
        return $this->result;
	}
               
	public function insert($table,$inserts) {
        $this->key='';
        $this->value='';
        $this->value = array_map('mysql_real_escape_string', array_values($inserts));
        $this->key = array_keys($inserts);
		echo("INSERT INTO ".$table." (`".implode("`,`", $this->key)."`) VALUES ('".implode("','", $this->value)."');");
        return mysql_query("INSERT INTO ".$table." (`".implode("`,`", $this->key)."`) VALUES ('".implode("','", $this->value)."');");
	}  

	public function update($tblname,$setvalue=array(),$convalue=array()) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->sql='UPDATE '.$tblname.' SET ';
        $this->key=array_keys($setvalue);
        $this->value=array_values($setvalue);
        for($i=0;$i<count($setvalue);$i++) {
            if($i==count($setvalue)-1)
                $this->sql.=$this->key[$i]."='".$this->value[$i]."'";
            else
                $this->sql.=$this->key[$i]."='".$this->value[$i]."', ";
		}
		$this->sql.=' WHERE ';
		$this->value='';
		$this->key='';
		$this->key=array_keys($convalue);
		$this->value=array_values($convalue);
		for($i=0;$i<count($convalue);$i++) {
            if($i==count($convalue)-1)
                $this->sql.=$this->key[$i]."='".$this->value[$i]."';";
            else
                $this->sql.=$this->key[$i]."='".$this->value[$i]."' AND ";
		}
        return mysql_query($this->sql);
	}
	
	public function updateStr($sql) {
		return mysql_query($sql);
	}
	
	
	public function updatedels($tblname,$setvalue=array(), $idrowdel,$convalue=array()) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->sql='UPDATE '.$tblname.' SET ';
        $this->key=array_keys($setvalue);
        $this->value=array_values($setvalue);
        for($i=0;$i<count($setvalue);$i++) {
            if($i==count($setvalue)-1)
                $this->sql.=$this->key[$i]."='".$this->value[$i]."'";
            else
                $this->sql.=$this->key[$i]."='".$this->value[$i]."', ";
		}
		$this->sql.=' WHERE '.$idrowdel.' IN (';
		$this->value='';
		$this->key='';
		$this->key=array_keys($convalue);
		$this->value=array_values($convalue);
		for($i=0;$i<count($convalue);$i++) {
            if($i==count($convalue)-1)
                $this->sql.="'".$this->value[$i]."')";
            else
                $this->sql.="'".$this->value[$i]."',";
		}
         return mysql_query($this->sql);
	}
	
	public function deletelists($tblname, $idrowdel, $convalue=array()) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->sql='DELETE FROM '.$tblname.' WHERE '.$idrowdel.' IN (';
		$this->value='';
		$this->key='';
		$this->key=array_keys($convalue);
		$this->value=array_values($convalue);
		for($i=0;$i<count($convalue);$i++) {
            if($i==count($convalue)-1)
                $this->sql.="'".$this->value[$i]."')";
            else
                $this->sql.="'".$this->value[$i]."',";
		}
         return mysql_query($this->sql);
	}
       
	public function delete($tblname,$condition=array()) {
        $this->sql='';
        $this->key='';
        $this->value='';
        $this->sql='DELETE FROM '.$tblname.' WHERE ';        
        $this->key=array_keys($condition);
        $this->value=  array_values($condition);
		for($i=0;$i<count($condition);$i++) {
            if($i==count($condition)-1)
                $this->sql.=$this->key[$i]."='".$this->value[$i]."';";
            else
                $this->sql.=$this->key[$i]."='".$this->value[$i]."' AND ";
		}          
        return mysql_query($this->sql);
	}
       
	public function __destruct() {
        return mysql_close($this->con);
	}   
	
	public function updateBySQL($sql) {
         return mysql_query($sql);
	}
}
?>