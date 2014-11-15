<?php
function stripUnicode($str){
  	if(!$str) return false;
	$str = strtolower($str);
	
  	$unicode = array(
      'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
      'd'=>'đ|Đ',
      'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
      'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
      'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Ọ|Ố|Ồ|Ô|Ổ|Ỗ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
      'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
      'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
   );
   foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
   return $str;
}

function rewriteTextUrl($str) {
	$str = preg_replace('/\s+/', '-', $str);
	$str = preg_replace('/_+/', '-', $str);
	$str = preg_replace('/"+/', '', $str);
	$str = preg_replace('/,+/', '', $str);
	$str = preg_replace('/\#/', '', $str);
	$str = preg_replace('/\%/', '', $str);
	$str = preg_replace('/\?/', '', $str);
	$str = preg_replace('/\//', '-', $str);
	return $str;
}
?>