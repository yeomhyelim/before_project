<?
#/*====================================================================*/#
#|화일명	: common.lib.php											|#
#|작성자	: 박영미													|#
#|작성일	: 2011.02.09												|#
#|작성내용	: 공통함수													|#
#/*====================================================================*/#

if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

##############################################################
# 배열관련													 #
##############################################################

//배열 삽입 ~
//해당배열에 위치를 지정하여 배열값 등록
function arrayPutPosition(&$array, $key, $position, $val = null)
{
	$count = 0;
	$return = array();
	foreach ($array as $k => $v)
	{
			// insert new key
			if ($count == $position)
			{
					if (!$val) $val = $count;
					$return[$val] = $key;
					$inserted = true;
			}
			// insert old key
			$return[$k] = $v;
			$count++;
	}
	if (!$val) $val = $count;
	if (!$inserted) $return[$val];
	$array = $return;
	return $array;
}


/*
	설명 : 일차원배열에 임의의 값이 존재하는지 체크해서 존재하면 true반환
*/
function searchAryKeyword($aryX, $searchKeyword)
{
	if (sizeof($aryX)>0)
	{
		for($i=0; $i<=sizeof($aryX)-1; $i++){
			if($aryX[$i]==$searchKeyword){
				return true;
			}
		}
		return false;
	}

	return false;
}

/*
	설명 : (키,값)배열에 임의의 키가 존재하는지 체크해서 존재하면 키의 해당값을 반환
*/
function searchAryKey($aryX, $searchKey){
	if (sizeof($aryX)>0) {
		while(list($key,$val) = each($aryX)){
			if($key == $searchKey){
				return $val;
			}
		}
		return "";
	}else{
		return "";
	}
}

/*
	설명 : (키,값)배열에 임의의 값이 존재하는지 체크해서 존재하면 값의 해당키를 반환
*/
function searchAryVal($aryX, $searchVal){
	if (sizeof($aryX)>0) {
		while(list($key,$val) = each($aryX)){
			if($val == $searchVal){
				return $key;
			}
		}
		return "";
	}else{
		return "";
	}
}

/*
	설명 : (키,값)배열에 임의의 키가 존재하는지 체크해서 존재하면 키의 해당값을 반환
		   searchAryKey은 찾는키가 하나이나  searchAryKeyAry는 찾는키가 여러개이며,
		   여러개값을 구분자로 구분하여 반환함.
*/
function searchAryKeyAry($aryX, $arySearchKey, $delimiter=","){
	$value = "";
	if (sizeof($aryX)>0) {
		while(list($mkey,$mval) = each($aryX)){
			$aryY = $arySearchKey;
			if (sizeof($aryY)>0) {
				for($j=0; $j<=sizeof($aryY)-1; $j++){
					if($mkey == $aryY[$j]){
						if($value==""){
							$value = $mval;
						}else{
							$value .= $delimiter . $mval;
						}
					}
				}
			}
		}
	}

	return $value;
}

##############################################################
# HTML														 #
##############################################################
/*
	설명 : 배열 -> check box(value check : 1)
	인자 : check box name		-> name 	,	options		-> array
		   choice value			-> checked	,	class name	-> design
		   disabled				-> readonly	,	blank		-> gap
		   행에 보여지는 갯수	-> colCnt
*/
function drawCheckBox($name="check",$array,$checked="",$design="",$readonly=false, $gap="&nbsp;", $colCnt=0,$onclick="")
{
	$content = "";
	$cnt = 0;
	while(list($key,$val) = each($array)){
		$content .= "<input type='checkbox' name='$name' class='$design' value='$key'";
//		if($checked == $key) $content .= " checked";
		if(strstr($checked, $key)) $content .= " checked";
		if($readonly == true) $content .= " disabled";
		if($onclick) $content .= " onClick=\"javascript:$onclick;\"";
		$content .= ">&nbsp;$val$gap";
		$cnt++;
		if($colCnt>=1 && $cnt % $colCnt==0){
			$content .= "<br>";
		}
	}

	return $content;
}

/*
	설명 : 배열 -> check box(value check : multi)
	인자 : check box name		-> name 		,	options		-> array
		   choice value			-> aryChecked	,	class name	-> design
		   disabled				-> aryReadonly	,	blank		-> gap
*/
function drawCheckBoxMulti($name ="check",$array,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick=""){
	$content = "";
	while(list($key,$val) = each($array)){
		$content .= "<input type='checkbox' name='$name' id='$name' class='$design' value='$key'";
		if($aryChecked!=""){
			if(searchAryKeyword($aryChecked, $key)==true){
				$content .= " checked";
			}
		}
		if($aryReadonly=="ALL"){
			$content .= " disabled";
		}else if($aryReadonly!=""){
			if(searchAryKeyword($aryReadonly, $key)==true){
				$content .= " disabled";
			}
		}

		if($onclick) $content .= " onClick=\"javascript:$onclick;\"";
		$content .= ">&nbsp;$val$gap";
	}
	return $content;
}

/*
	설명 : 배열 -> radio box
	인자 : radio box name		-> name 		,	options		-> array
		   choice value			-> checked		,	class name	-> design
		   disabled				-> readonly		,	blank		-> gap
		   행에 보여지는 갯수	-> colCnt		,	etc			-> etc
		   onchange 함수		-> onchange
*/
function drawRadioBox($name ="radio",$array,$checked="",$design="",$readonly=false, $gap="&nbsp;", $colCnt=0, $etc="",$onchange=""){
	$content = "";
	$cnt = 0;
	while(list($key,$val) = each($array)){
		$content .= "<input type='radio' class='$design' value='$key' name='$name' ";
		if($checked == $key) $content .= " checked ";
		if($readonly == true) $content .= " disabled ";
		$content .= $etc;

		if ($onchange) $content .= "onclick=\"$onchange\" ";
		$content .= ">&nbsp;$val$gap";
		$cnt = $cnt + 1;
		if($colCnt>=1 && ($cnt%$colCnt)==0){
			$content .= "<br>";
		}
	}
	return $content;
}

function drawRadioBoxMulti($name ="radio",$array,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick=""){
	$content = "";
	while(list($key,$val) = each($array)){
		$content .= "<input type='radio' name='$name' id='$name' class='$design' value='$key'";
		if($aryChecked!=""){
			if(searchAryKeyword($aryChecked, $key)==true){
				$content .= " checked";
			}
		}
		if($aryReadonly=="ALL"){
			$content .= " disabled";
		}else if($aryReadonly!=""){
			if(searchAryKeyword($aryReadonly, $key)==true){
				$content .= " disabled";
			}
		}

		if($onclick) $content .= " onClick=\"javascript:$onclick;\"";
		$content .= ">&nbsp;$val$gap";
	}
	return $content;
}
/*
	설명 : 1차 배열 -> select box
	인자 : select name   -> name 	,	select options -> array
		   choice value  -> selected,	class name	   -> design
		   onchange 함수 -> onchange,	etc			   ->  etc
*/
function drawSelectBox($name = "select",$array,$selected ="",$design ="",$onchange="",$etc="",$firstItem="",$firstItemValue="")
{
	$content = "<select name='$name' id='$name' class='$design' ";
	if ($onchange) $content .= "onchange=\"$onchange\" ";
	$content .= " $etc >";
	if (!$firstItemValue) $firstItemValue = "";
	if ($firstItem) $content .= "<option value='".$firstItemValue."'>".$firstItem."</option>";
	if($array!=""){
		for($i=0; $i<sizeOf($array); $i++){
			$content .= "<option value='$array[$i]'"; if($selected ==$array[$i]) $content .="selected"; $content .=">$array[$i]</option>";
		}
	}

	return $content .="</select>";
}

/*
	설명 : 2차 배열 -> select box
	인자 : select name   -> name 	,	select options -> array
		   choice value  -> selected,	class name	   -> design
		   onchange 함수 -> onchange,	etc			   ->  etc
*/
function drawSelectBoxMore($name = "select",$array,$selected ="",$design ="",$onchange="",$etc="",$firstItem="",$html="N")
{
	$content = "<select name='$name' id='$name' class='$design' ";
	if ($onchange) $content .= "onchange=\"$onchange\" ";
	$content .= " $etc >";
	if ($firstItem) $content .= "<option value=''>".$firstItem."</option>";
	if($array!=""){
		while(list($key,$val) = each($array)){
			if ($html=="Y") {
				$content .= "<option value='$key'"; if($selected ==$key) $content .="selected"; $content .=">".strConvertCut($val,0,'Y')."</option>";
			} else {
				$content .= "<option value='$key'"; if($selected ==$key) $content .="selected"; $content .=">".$val."</option>";
			}
		}
	}
	return $content .="</select>";
}

//array total 에서 키/값을 지정한다.
function drawSelectBoxMoreQuery($name = "select",$array,$selected ="",$design ="",$onchange="",$etc="",$firstItem="",$html="N",$key="",$val="")
{
	$content = "<select name='$name' id='$name' class='$design' ";
	if ($onchange) $content .= "onchange=\"$onchange\" ";
	$content .= " $etc >";
	if ($firstItem) $content .= "<option value=''>".$firstItem."</option>";

	if(IS_ARRAY($array)){
		for($x=0;$x<sizeof($array);$x++){
			$optVal=$array[$x][$key];
			$viewNm=$array[$x][$val];
			if ($html=="Y") {
				$content .= "<option value='$optVal'"; if($selected ==$optVal) $content .="selected"; $content .=">".strConvertCut($viewNm,0,'Y')."</option>";
			} else {
				$content .= "<option value='$optVal'"; if($selected ==$optVal) $content .="selected"; $content .=">".$viewNm."</option>";
			}
		}
	}
	return $content .="</select>";
}



/*
	설명 : 연도,월,일 셀렉트 박스 표시
	예제 : drawSelectBoxNum("year",  $mSYear+1,$mSYear-1, -1, "$date[0]", " class=\"F_input\" ", " ")년
		   drawSelectBoxNum("month", $mSMonth, $mEMonth, 1, "$date[1]", " class=\"F_input\" ", " ")월
		   drawSelectBoxDate("day",   $mSDay,   $mEDay,   1, "$date[2]", " class=\"F_input\" ", " ","")일
*/
function drawSelectBoxDate($name = "select", $startNum, $endNum, $step=1, $selected ="", $etc="", $firstItem="", $lenStr=0)
{
	$content = "<select name='$name' id='$name' $etc >";
	if($firstItem!=""){
		$content .= "<option value=''>$firstItem</option>";
	}
	$i = $startNum;
	if($lenStr==0){
		if (strlen($startNum)==4){
			$len = 4;
		}else{
			$len = 2;
		}
	}else{
		$len = $lenStr;
	}
	if($step>0){
		while($i<=$endNum){
			$value    = "0".$i;
			$value    = substr($value, strlen($value)-$len, $len);
			$content .= "<option value='$value'"; if($selected ==$value) $content .="selected"; $content .=">$i</option>";
			$i = $i + $step;
		}
	}else{
		while($i>=$endNum){
			$value    = "0".$i;
			$value	  = substr($value, strlen($value)-$len, $len);
			$content .= "<option value='$value'"; if($selected ==$value) $content .="selected"; $content .=">$i</option>";
			$i = $i + $step;
		}
	}

	return $content .="</select>";
}

/*
	설명 : 쿼리 결과 -> select box
	인자 : select name   -> name 	,	select options -> result
		   choice value  -> selected,	class name	   -> design
		   onchange 함수 -> onchange,	etc			   ->  etc
*/
function drawSelectBoxQuery($name = "select",$result,$selected ="",$design ="",$onchange="",$etc="",$firstItem="",$key,$val)
{
	$content = "<select name='$name' class='$design'";
	if ($onchange) $content .= "onchange='$onchange'";
	$content .= " $etc >";
	if ($firstItem) $content .= "<option value=''>".$firstItem."</option>";

	while($srow = mysql_fetch_array($result)) {
		$content .= "<option value='$srow[$key]'"; if($selected ==$srow[$key]) $content .="selected";
		$content .=">$srow[$val]</option>";
	}

	return $content .="</select>";
}

/*
	설명 : 목록 페이징
	인자 : 현재페이지		-> page 	 ,	화면에 보여질 갯수 -> pageline
		   pageblock		-> pageblock ,	총 레코드 수	   -> total_record
		   전체 페이지 수	-> total_page,	링크 경로		   ->  link
		   숫자 구분자		-> flag ('|')	스크립스 실행	   -> scriptFunc
	수정 : 2012.08.04 -- KIM HEE-SUNG -- scriptFunc 추가
	수정 : 3024.05.07 -- KIM HEE-SUNG -- 정리
*/
function drawPagingEx($page,$pageline="10",$pageblock="10",$total_record,$total_page,$link="#",$pre,$next,$first="",$last="",$flag="",$scriptFunc="", &$scriptPara=""){
	$total_block = ceil($total_page /$pageblock);
	$block       = ceil($page /$pageblock);
	$first_page  = ($block -1)*$pageblock;
	$last_page   = $block * $pageblock;
	if($total_block <= $block) $last_page =$total_page;

	if($first) { echo("<a href='javascript:goPageMoveEvent(0)'><img src='$first' align='absmiddle'></a>"); }

	if($block >1):
		$my_page =$first_page;
		echo("<a href='javascript:goPageMoveEvent({$my_page})' class='pre'> <img src='/shopAdmin/himg/common/btn_page_prev.gif' alt='prev'/></a>");
	endif;

	for($direct =$first_page +1;$direct <= $last_page; $direct++){
		if($page==$direct):
			echo "<strong><span>$direct</span></strong>";
		else:
			echo "<a href='javascript:goPageMoveEvent({$direct})'><span>$direct</span></a>";
		endif;

		if($flag):
			if(($direct != $last_page) && ($direct<$last_page)){ echo $flag; };
		endif;
	}

	if($block <$total_block){
		$my_page =$last_page +1;
		echo("<a href='javascript:goPageMoveEvent({$my_page})' class='next'><img src='/shopAdmin/himg/common/btn_page_next.gif' alt='next'/> </a>");
	}

	if($last) { echo("<a href='javascript:goPageMoveEvent({$total_page})'><img src='$last' align='absmiddle'></a>"); }
}

/*
	설명	:	목록 페이징
	인자	:	$page					: 현재 페이지
				$total_page				: 총 페이지 수
*/
function drawPaging2($page, $pageline, $pageblock, $total_record, $total_page, $link, $pre, $next, $first, $last, $flag, $scriptFunc, $scriptPara) {

	## 기본 설정
	$result						 = "";
	$linkForm					 = "<a href=\"javascript:goPagingEvent('%s')\" class=\"%s\">%s</a>\n";

	## 이전 버튼 설정
	$result		.= sprintf($linkForm, "", "pre", "<img src=\"/shopAdmin/himg/common/btn_page_prev.gif\" alt=\"prev\">");

	## 페이지 번호 설정
	for($i=1;$i<=$total_page;$i++):
		if($i == $page) { $result		.= "<strong><span>{$i}</span></strong>\n";	}
		else			{ $result		.= sprintf($linkForm, $i, "page", "<span>{$i}</span>");		}
	endfor;

	## 이전 버튼 설정
	$result		.= sprintf($linkForm, "", "next", "<img src=\"/shopAdmin/himg/common/btn_page_next.gif\" alt=\"next\">");

	## 마무리
	return $result;
}

/*
	설명 : 목록 페이징
	인자 : 현재페이지		-> page 	 ,	화면에 보여질 갯수 -> pageline
		   pageblock		-> pageblock ,	총 레코드 수	   -> total_record
		   전체 페이지 수	-> total_page,	링크 경로		   ->  link
		   숫자 구분자		-> flag ('|')	스크립스 실행	   -> scriptFunc
	수정 : 2012.08.04 -- KIM HEE-SUNG -- scriptFunc 추가
*/
function drawPaging($page,$pageline="10",$pageblock="10",$total_record,$total_page,$link="#",$pre,$next,$first="",$last="",$flag="",$scriptFunc="", &$scriptPara=""){
	$total_block = ceil($total_page /$pageblock);
	$block       = ceil($page /$pageblock);
	$first_page  = ($block -1)*$pageblock;
	$last_page   = $block * $pageblock;
	if($total_block <= $block) $last_page =$total_page;

	$responseText= "";
	if ($first)
		if(!$scriptFunc)
			echo("<a href='$link1'><img src='$first' align='absmiddle'></a>");
		else
			$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$my_page\", \"\", \"road\")'><img src='$first' align='absmiddle'></a>";

	if($block >1)
	{
		$my_page =$first_page;
		if(!$scriptFunc)
//			echo("<a href=\"{$link}$my_page\" class='pre'> <img src='/shopAdmin/himg/common/btn_page_prev.gif' alt='prev'/></a>");
			echo("<a href=\"{$link}$my_page\" class='pre'><span>prev</span></a>");
		else
//			$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$my_page\", \"\", \"road\")' class='pre'><img src='/shopAdmin/himg/common/btn_page_prev.gif' alt='prev'/></a>";
			$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$my_page\", \"\", \"road\")' class='pre'><sapn>prev</span></a>";
	}

	if(!$scriptFunc) echo "";

	for($direct =$first_page +1;$direct <= $last_page; $direct++){
		if($page==$direct){
			if(!$scriptFunc)
				echo "<strong><span>$direct</span></strong>";
			else
				$responseText .= "<strong><span>$direct</span></strong>";
		}else{
			if(!$scriptFunc)
				echo "<a href=\"{$link}$direct\"><span>$direct</span></a>";
			else
				$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$direct\", \"\", \"load\")'><span>$direct</span></a>";
		}
		if($direct<$last_page){
			//echo "";
		}

		if ($flag){
			if (($direct != $last_page) && ($direct<$last_page)) {
				echo $flag;
			}
		}
	}
	if($block <$total_block){
		$my_page =$last_page +1;
		if(!$scriptFunc)
//			echo("<a href=\"{$link}$my_page\" class='next'><img src='/shopAdmin/himg/common/btn_page_next.gif' alt='next'/> </a>");
			echo("<a href=\"{$link}$my_page\" class='next'><span>next</span></a>");
		else
//			$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$my_page\", \"\", \"road\")' class='next'><img src='/shopAdmin/himg/common/btn_page_next.gif' alt='next'/> </a>";
			$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$my_page\", \"\", \"road\")' class='next'><sapn>next</span></a>";
	}

	if ($last)
		if(!$scriptFunc)
			echo("<a href='$link$total_page'><img src='$last' align='absmiddle'></a>");
		else
			$responseText .= "<a href='javascript:$scriptFunc(\"$scriptPara[strP_CODE]\", \"$scriptPara[strB_CODE]\", \"$my_page\", \"\", \"road\")'><img src='$last' align='absmiddle'></a>";

		if(!$scriptFunc)
			echo "";
		else
			return $responseText;
}


/*
	설명 : 목록 페이징
	인자 : 현재페이지		-> page 	 ,	화면에 보여질 갯수 -> pageline
		   pageblock		-> pageblock ,	총 레코드 수	   -> total_record
		   전체 페이지 수	-> total_page,	링크 경로		   -> link
		   숫자 구분자		-> flag ('|'),
*/
function drawUserPaging($page,$pageline="10",$pageblock="10",$total_record,$total_page,$link="#",$pre,$next,$first="",$last="",$flag=""){
	$total_block = ceil($total_page /$pageblock);
	$block       = ceil($page /$pageblock);
	$first_page  = ($block -1)*$pageblock;
	$last_page   = $block * $pageblock;
	if($total_block <= $block) $last_page =$total_page;

	if($flag) { $flag =  "<span class='bar'>{$flag}</span>"; }

	/*if ($first)
		echo("&nbsp;<a href='$link1'><img src='$first' align='absmiddle'></a>");
	*/

	if($block >1)
	{
		$my_page =$first_page;
		echo("&nbsp;<a href='$link$my_page' class='direction'> ‹ <span>Prev</span></a>");
	}

	echo "&nbsp;";
	for($direct =$first_page +1;$direct <= $last_page; $direct++){
		if($page==$direct){
			echo "<strong>$direct</strong>";
		}else{
			echo "<a href='$link$direct'>$direct</a>";
		}
		if($direct<$last_page){
			//echo "&nbsp;&nbsp;";
		}

		if ($flag){
			if (($direct != $last_page) && ($direct<$last_page)) {
				echo $flag;
			}
		}
	}
	if($block <$total_block){
		$my_page =$last_page +1;
		echo("&nbsp;<a href='$link$my_page' class='direction'><span>Next</span> › </a>");
	}

	/*if ($last)
		echo("&nbsp;<a href='$link$total_page'><img src='$last' align='absmiddle'></a>");
	*/
}

/*
	설명 : 목록 페이징
	인자 : 현재페이지		-> page 	 ,	화면에 보여질 갯수 -> pageline
		   pageblock		-> pageblock ,	총 레코드 수	   -> total_record
		   전체 페이지 수	-> total_page,	링크 경로		   ->  link
		   숫자 구분자		-> flag ('|')
*/
function drawUserJsonPaging($page,$pageline="10",$pageblock="10",$total_record,$total_page,$link="#",$pre,$next,$first="",$last="",$flag="",$intB_NO=""){
	echo drawUserJsonPagingRet($page,$pageline,$pageblock,$total_record,$total_page,$link,$pre,$next,$first,$last,$flag,$intB_NO);
}

function drawUserJsonPagingRet($page,$pageline="10",$pageblock="10",$total_record,$total_page,$link="#",$pre,$next,$first="",$last="",$flag="",$intB_NO=""){

	global $strB_CODE;
	$total_block = ceil($total_page /$pageblock);
	$block       = ceil($page /$pageblock);
	$first_page  = ($block -1)*$pageblock;
	$last_page   = $block * $pageblock;
	if($total_block <= $block) $last_page =$total_page;

	/*if ($first)
		echo("&nbsp;<a href='$link1'><img src='$first' align='absmiddle'></a>");
	*/

	$res = "";
	if($block >1)
	{
		$my_page =$first_page;
//		echo("&nbsp;<a href='javascript:goJsonPage($my_page,$intB_NO);' class='direction'> ‹ <span>Prev</span></a>");
//		echo("&nbsp;<a href='javascript:goJsonPage($my_page);' class='direction'> ‹ <span>Prev</span></a>");
//		echo("&nbsp;<a href='#cmLink' onclick='javascript:goJsonPage($my_page);' class='direction'> ‹ <span>Prev</span></a>");
		$res .= "&nbsp;<a href='#cmLink' onclick=\"javascript:goJsonPage($my_page, '$strB_CODE');\" class='direction'> ‹ <span>Prev</span></a>";
	}

//	echo "&nbsp;";
	$res .= "&nbsp;";
	for($direct =$first_page +1;$direct <= $last_page; $direct++){
		if($page==$direct){
//			echo "<strong>$direct</strong>";
			$res .= "<strong>$direct</strong>";
		}else{
//			echo "<a href='javascript:goJsonPage($direct,$intB_NO);'>$direct</a>";
//			echo "<a href='javascript:goJsonPage($direct);'>$direct</a>";
//			echo "<a href='#cmLink' onclick='javascript:goJsonPage($direct);'>$direct</a>";
			$res .= "<a href='#cmLink' onclick=\"javascript:goJsonPage($direct, '$strB_CODE');\">$direct</a>";
		}
		if($direct<$last_page){
			//echo "&nbsp;&nbsp;";
		}

		if ($flag){
			if (($direct != $last_page) && ($direct<$last_page)) {
//				echo $flag;
				$res .= $flag;;
			}
		}
	}
	if($block <$total_block){
		$my_page =$last_page +1;
//		echo("&nbsp;<a href='javascript:goJsonPage($my_page,$intB_NO);' class='direction'><span>Next</span> › </a>");
//		echo("&nbsp;<a href='javascript:goJsonPage($my_page);' class='direction'><span>Next</span> › </a>");
//		echo("&nbsp;<a href='#cmLink' onclick='javascript:goJsonPage($my_page);' class='direction'><span>Next</span> › </a>");
		$res .= "&nbsp;<a href='#cmLink' onclick=\"javascript:goJsonPage($my_page, '$strB_CODE');\" class='direction'><span>Next</span> › </a>";
	}

	/*if ($last)
		echo("&nbsp;<a href='$link$total_page'><img src='$last' align='absmiddle'></a>");
	*/

	return $res;
}

/*
	설명 : 목록 페이징
	인자 : 현재페이지		-> page 	 ,	화면에 보여질 갯수 -> pageline
		   pageblock		-> pageblock ,	총 레코드 수	   -> total_record
		   전체 페이지 수	-> total_page,	링크 경로		   ->  link
*/
function drawPagingAll($page,$total_page,$link ="#"){
	$first_page  = 1;
	$last_page   = $total_page;
	if($total_block <= $block) $last_page =$total_page;

	for($direct =$first_page;$direct <= $last_page; $direct++){
		if($page==$direct){
			echo "<strong><font color='#FF6600'>$direct</font></strong>&nbsp;";
		}else{
			echo "<a href='$link$direct'>[$direct]</a>&nbsp;";
		}
	}
}


/*
	설명 : 사용자가 원하는 페이지 이동
	인자 : form 이름			    -> form 	 ,	이동될 페이지 -> action
		   hidden으로 처리할 values -> array
*/
function drawPageRedirect($form,$action,$array,$paramList="") {

	 //$paramList = "";
	 $linkPage = "";
	 while(list($field,$val) = each($array)){
		 $paramList .= "<input type=\"hidden\" name=\"$field\" value=\"$val\">";
	 }

	 $linkPage .= "<html>\n";
	 $linkPage .= "<body onLoad=\"$form.submit();\">\n";
	 //$linkPage .= "<body>\n";
	 $linkPage .= "<form name=\"$form\" action=\"$action\" method=\"post\">";
	 $linkPage .= $paramList;
	 $linkPage .= "</form>";
	 $linkPage .= "</body>\n";
	 $linkPage .= "</html>\n";

	 echo $linkPage;
}

##############################################################
# 문자열													 #
##############################################################
/*
	설명 : 문자열 공백 제거 및 태그 제거
	html N -> strTrim($str,'','N');
*/
function strTrim($str,$len=false,$tags=false){
	//$str = trim($str);
	if ($tags) $str = htmlspecialchars($str);
	if ($len) $str = strHanCut($str,$len,false);
	return $str;
 }

/*
	설명 : 문자열 $len 만큼 자르기
*/
function strHanCut($str,$len,$point=true,$charset="UTF-8")
{
	if ($len >= strlen($str)) {
		return $str;
	} else {

		$str = substr($str,0,$len);
		$han_char = 0;
		for ($i=$len-1;$i>=0;$i--){
			$last_char = ord(substr($str,$i,1)); //->아스키코드값으로 변환
			if (127 > $last_char){
				break;
			}else{
				$han_char++;
			}
		}

		if (strtoupper($charset) != 'UTF-8') {
			if ($han_char%2==1){
				$str = substr($str,0,$len-1);
			}
		}

		if ($point){
			return $str."...";
		}else{
			return $str;
		}
	}
}

/*
	설명 : 문자열 $len 만큼 자르기
*/

function strHanCutUtf($str, $len, $checkmb=false, $tail='...') {
    preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);

    $m    = $match[0];
    $slen = strlen($str);  // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m); // length of matched characters

    if ($slen <= $len) return $str;
    if (!$checkmb && $mlen <= $len) return $str;

    $ret   = array();
    $count = 0;

    for ($i=0; $i < $len; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1)?2:1;

        if ($count + $tlen > $len) break;
        $ret[] = $m[$i];
    }

    return join('', $ret).$tail;
}

/*
	설명 : 문자열 $len 만큼 자르기 (New Style)
	날짜 : 2013.04.11
*/
function strHanCutUtf2($str, $len, $checkmb=false, $tail='...') {
	if(!$len) { return $str; }
	$strLen = mb_strlen($str, "UTF-8");
	if($strLen > $len):
		$str	= mb_substr($str, 0, $len, "UTF-8");
		$str	=  $str . $tail;
	endif;
	return $str;
}



/*
	설명 : 문자열 URL자동 링크,EMAIL자동링크
*/
function strAutoLink($str) {

	$str=ereg_replace("(http://|ftp://|telnet:)[[:alnum:]-]+(\.[[:alnum:]-]+)+(:[[:digit:]]+)?(/[^\/:*\"<>|&?]+)*(\?[^\/:*\"<>|&?]+(&amp;[^\/:*\"<>|&?]+)*)?", "<A href=\"\\0\" target=\"_blank\">\\0</A>", $str);

	$str=ereg_replace("[[:alnum:]._-]+@[[:alnum:]-]+(\.[[:alnum:]-]+)+", "<A href=\'mailto:\\0\'>\\0</A>", $str);

	return $str;
}

/*
	설명 : 텍스트 내용중 '\'제거
		   html 사용여부에 따른 표현방법 제어,문자열 URL자동 링크,EMAIL자동링크
		   len 길이만큼 텍스트 내용 자르기
*/
function strConvertCut($content,$len ="0",$html ='N'){
	if(!strcmp($len,"") || !strcmp($len,"0")) $len ="9000000";
	$content = stripslashes($content);
	if($html == 'N') {
		$content = nl2br(htmlspecialchars($content));
		$content = strAutoLink($content);
	} else {
		$content = strAboidCrack($content);
	}
	return $content = strHanCutUtf($content,$len);
}

function strConvertCut2($content,$len ="0",$html ='N'){
	if(!strcmp($len,"") || !strcmp($len,"0")) $len ="9000000";
	$content = stripslashes($content);
	if($html == 'N') {
		$content = nl2br(htmlspecialchars($content));
		$content = str_replace("'","\'",$content);
		$content = strAutoLink($content);
	} else {
		$content = strAboidCrack($content);
	}
	return $content = strHanCutUtf($content,$len);
}

## 2015.01.15 kim hee sung
## UTF8 길이 체크 함수
function getUTF8Length($str) {
	
	$len = strlen($str);

	for ($i = $length = 0; $i < $len; $length++) {

		$high = ord($str{$i});

		if ($high < 0x80)			//0<= code <128 범위의 문자(ASCII 문자)는 인덱스 1칸이동
			$i += 1;
		else if ($high < 0xE0)		//128 <= code < 224 범위의 문자(확장 ASCII 문자)는 인덱스 2칸이동
			$i += 2;
		else if ($high < 0xF0)		//224 <= code < 240 범위의 문자(유니코드 확장문자)는 인덱스 3칸이동
			$i += 3;
		else						//그외 4칸이동 (미래에 나올문자)
			$i += 4;
	}

	return $length;
}

## 2015.01.15 kim hee sung
## UTF8 길이많큼 짜르기
function getUTF8Strcut($str, $chars, $tail = '...') {
	
	if (getUTF8Length($str) <= $chars)		//전체 길이를 불러올 수 있으면 tail을 제거한다.
		$tail = '';
	else
		$chars -= getUTF8Length($tail);		//글자가 잘리게 생겼다면 tail 문자열의 길이만큼 본문을 빼준다.

	$len = strlen($str);
	
	for ($i = $adapted = 0; $i < $len; $adapted = $i) {

			$high = ord($str{$i});

			if ($high < 0x80)
				$i += 1;
			else if ($high < 0xE0)
				$i += 2;
			else if ($high < 0xF0)
				$i += 3;
			else
				$i += 4;

			if (--$chars < 0)
				break;
	}

	return trim(substr($str, 0, $adapted)) . $tail;
 }


/*
	설명 : HTML 중 공격 태그 삭제
*/
function strAboidCrack($str) {

	$str = eregi_replace("<\?","&lt;?",$str);
	$str = eregi_replace("\?>","?&gt;",$str);
	$str = eregi_replace("vbscript","",$str);
	$str = eregi_replace("url(.*)","",$str);
	$str = eregi_replace("codebase=","",$str);
	$str = eregi_replace("while","",$str);
	$str = eregi_replace("{.*}","",$str);
	$str = eregi_replace("<iframe.*>","",$str);
//	$str = eregi_replace("<param.*>","",$str); // 2014.07.10 kim hee sung, 동영상 태그를 사용할때 param 값이 있어서 해재함.(버즈몬 사이트)
	$str = eregi_replace("<plaintext.*>","",$str);
	$str = eregi_replace("<xml.*>","",$str);
	$str = eregi_replace("<base.*>","",$str);
	$str = eregi_replace("<applet.*>","",$str);
	$str = eregi_replace("c\|/con/con/","",$str);

    return $str;
}

##############################################################
# 유틸 함수													 #
##############################################################
/*
	설명 : 문자열 영문,숫자 확인 -> 1 리턴
*/
function isEngNum($str) {
    if(eregi("[^0-9a-zA-Z\_]",$str)) { return 0; } else { return 1; }
}

/*
	설명 : 문자열 숫자 확인 -> 1 리턴
*/
function isNum($str) {
    if(is_numeric($str)) { return 1; } else { return 0; }
}

/*
	설명 : 빈문자열 경우 1을 리턴
*/
function isBlank($str) {
    if(eregi("[^[:space:]]",$str)) { return 0; } else { return 1; }
    return 0;
}

/*
	설명 : 빈문자가 아니면서 숫자 일경우 1 리턴
*/
function isBlankNum($str) {
	if(eregi("[^[:space:]]",$str)) { if(is_numeric($str)) { return 1; } else { return 0; } }
    return 0;
}

/*
	설명 : 년도, 월, 일을 flag로 연결하여 반환한다.
*/
function dateFormat($year,$month,$day,$flag="-"){
	$newFormat = $year.$flag.$month.$flag.$day;
	return $newFormat;
}

/*
	설명 : YYYYMMDD 년도,월,일 flag로 연결하여 반환한다.
*/
function dateFullFormat($datefull,$flag="-"){
	$newFormat = "";

	$newFormat = dateFormat(substr($datefull,0,4),substr($datefull,4,2),substr($datefull,6),$flag);
	return $newFormat;
}

/*
	설명 : YYYYMMDD 년도,월,일 flag로 연결하여 반환한다.
*/
function dateFullFormatA($datefull,$flag="-"){
	$newFormat = "";

	$newFormat = dateFormat(substr($datefull,0,4),substr($datefull,5,2),substr($datefull,8,2),$flag);
	return $newFormat;
}


/*
	설명 : 스트링으로 된코드를 키,값을 갖는 배열로 반환함
	       ex) aryX = convToAry("1,회사원|2,학생|3,공무원", "|", ",")
*/
function convToAry($strX, $delimiterRow, $delimiterCol){
	$aryCode = "";
	$aryRow  = explode($delimiterRow, $strX);
	for($row=0; $row<=sizeof($aryRow)-1; $row++){
		$aryCol = explode($delimiterCol, $aryRow[$row]);
		$aryCode[$aryCol[0]] = $aryCol[1];
	}
	return $aryCode;
}

/*
	설명 : 3개의 문자열로 나뉘어져 있는 전화번호를 "-"으로 연결된 하나의 문자열로 변환하여 반환한다.
*/
function convTelNumber($str1,$str2,$str3) {

	$telNumber = "";

	if (!$str1) $str1 = "";
	if (!$str2) $str2 = "";
	if (!$str3) $str3 = "";

	$telNumber = $str1."-".$str2."-".$str3;
	return $telNumber;
}

/*
	설명 : 2개의 문자열로 나뉘어져 있는 우편번호를 "-"으로 연결된 하나의 문자열로 변환하여 반환한다.
*/
function convZipcode($str1,$str2) {

	$newZipcode = "";

	if (!$str1) $str1 = "";
	if (!$str2) $str2 = "";

	$newZipcode = $str1."-".$str2;
	return $newZipcode;
}

/*
	설명 : 우편번호 6자리를 받아 size가 2인 1차원 배열에 3자리씩 끊어 담아 반환한다.
*/
function convAryZipcode($str) {

	$newZipcode = "";
	$zipcode = trim($str);

	if (strlen($zipcode)>=3) {
		$newZipcode[0] = substr($zipcode,0,3);
		$newZipcode[1] = substr($zipcode,3);
	} else {
		$newZipcode[0] = substr($zipcode,0,strlen($zipcode));
		$newZipcode[1] = "";
	}
	return $newZipcode;
}

/*
	설명 : 주민번호 13자리를 받아 6, 7자리로 각각 끊어 flag로 구분하여 연결한 문자열로 반환한다..
*/
function convRegitNumber($str,$flag="-") {

	$newRegitNumber = "";
	$RegitNumber = trim($str);

	if (strlen($RegitNumber)>=6) {
		$newRegitNumber = substr($RegitNumber,0,6).$flag.substr($RegitNumber,6);
	} else {
		$newRegitNumber = $RegitNumber.$flag;
	}
	return $newRegitNumber;
}

/*
	설명 : 주민번호 13자리를 받아 6, 7자리로 각각 끊어 배열에 담아 반환한다.
*/
function convAryRegitNumber($str) {

	$newRegitNumber = "";
	$RegitNumber = trim($str);

	if (strlen($RegitNumber)>=6) {
		$newRegitNumber[0] = substr($RegitNumber,0,6);
		$newRegitNumber[1] = substr($RegitNumber,6);
	} else {
		$newRegitNumber[0] = substr($RegitNumber,0,strlen($RegitNumber));
		$newRegitNumber[1] = "";
	}
	return $newRegitNumber;
}

/*
	설명 : timpstamp로 입력된 데이타 날짜를 원하는 flag로 날짜 표현하기
*/
function dateSeek($str,$time ="",$division="."){
	if(empty($time)) $time =mktime();
	if($str =="year")       return date('Y',$time);
	else if($str =="month") return date('m',$time);
	else if($str =="day")   return date('d',$time);
	else if($str =="all")   return date('Y'.$division.'m'.$division.'d',$time);
	else if($str =="time")  return $time;
	else return date('Y'.$division.'m'.$division.'d',$time);
}

/*
	설명 : 입력된 데이타 날짜를 timestamp로 변환
*/
function dateToTime($str,$division){
	$aryStr = $str = explode($division,$str);

	return mktime(0,0,0,$aryStr[1],$aryStr[2],$aryStr[0]);
}


/*
	설명 : 잔여 일자 반환
*/
function getDateDiff($date1, $date2)
{

 $_date1 = explode("-", $date1);
 $_date2 = explode("-", $date2);

 $tm1 = mktime(0,0,0,$_date1[1],$_date1[2],$_date1[0]);
 $tm2 = mktime(0,0,0,$_date2[1],$_date2[2],$_date2[0]);

 return ($tm1 - $tm2) / 86400;
}

/*
	설명 : 숫자자리앞에 '0'붙이기
*/
function pushHeadZero($num,$len){

	$putNum = "";
	for($i=1;$i<=$len+1;$i++) {
		if($i==$len || strlen($num) >= $len) break;
		else $putNum .= "0";
	}
	$rtnX = $putNum.$num;
	$rtnX = substr($rtnX, strlen($rtnX)-$len, strlen($rtnX));
	return $rtnX;
}

/*
	설명 : 숫자자리뒤에 '0'붙이기
*/
function pushBackZero($num,$len){

	$putNum = $num;
	for($i=1;$i<=$len+1;$i++) {

		if($i==$len || strlen($putNum) == $len) break;
		else $putNum .= "0";
	}

	return $putNum;
}

/*
	설명 : 입력한 데이타의 시간에 따른 new 이미지 제어하기
	인자 : 입력한 데이타의 시간 -> dbtime	,	new 이미지 제어 주기 -> time
		   이미지 경로			-> src
*/
function newImgSrc($dbtime,$time="1",$src){
	if(!strcmp($time,"1")){
		$db_date =date('Y-m-d',$dbtime);
		$n_date  =date('Y-m-d');
		if(!strcmp($db_date,$n_date)) $img ="<img src='$src' border=0 align='absmiddle'>";
		else                          $img ="";
	}else{
		$time_limit =60 * 60 * 24 * $time;
		$date_diff  =time() -$dbtime;
		if($date_diff < $time_limit)  $img ="<img src='$src' border=0 align='absmiddle'>";
		else                          $img ="";
	}
	return $img;
}

/*
	설명 : 랜덤 문자열 유일키 발생한 후 길이에 따라 자르기
*/
function getCode($len) {
	$sid	= md5(uniqid(rand()));
	$code	= substr($sid, 0, $len);
	return $code;
}

function getOrderRandCode($nc, $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
	 $l = strlen($a) - 1; $r = '';
	 while($nc-->0) $r .= $a{mt_rand(0,$l)};
	 return $r;
}
/*
	설명 : 자기디렉토리 알아내기
*/
function directName($dir){
	$ary_dir = explode("/",$dir);
	$dirname = $ary_dir[sizeof($ary_dir)-1];

	return $dirname;
}

/*
	설명 : 이메일보내기
*/

function sendMail($name,$email,$title,$content,$html,$to_name,$to_email,$charset){

	/* 한글 깨짐 추가 코드 */
	$title					= "=?".$charset."?B?".base64_encode($title)."?=\n";
	$name					= "=?".$charset."?B?".base64_encode($name)."?=\n";
	$to_name				= "=?".$charset."?B?".base64_encode($to_name)."?=\n";
	/* 한글 깨짐 추가 코드 */

	$from	= "$name <$email>";
	$mailto	= "$to_name <$to_email>";
	$title	= "$title";
	if (!$charset) $charset = "EUC-KR";

	$additional_headers ="From: $from \n";
	if (!$html) $html="N";
	if(!strcmp($html,'Y'))
		$additional_headers .="Content-Type: text/html;charset=$charset\n";

	$content =$content;



	return mail($mailto,$title,$content,$additional_headers);
}

/*
	설명 : 숫자를 알파벳으로 변경
*/
function strNumberToAscii($str)
{
	if (!$str) return "A";
	if ($str=="Z") return "-1";

	$aryFormat = array();
	//역순으로 알파벳 아스키코드값을 +1 해준다.
	for($i=strlen($str)-1;$i>=0;$i--)
	{

		$asciiStr = ord(substr($str,$i,1));

		$j = $i+1;
		if ($aryFormat[$j]){
			if (ord($aryFormat[$j]) == 65) $aryFormat[$i] = chr($asciiStr + 1);
			else $aryFormat[$i] = chr($asciiStr);
		} else {

			if ($asciiStr>= 65 && $asciiStr< 90) $aryFormat[$i] .= chr($asciiStr + 1);
			else $aryFormat[$i] .= chr(65);
		}

	}

	$aryFormat = array_reverse($aryFormat);
	return join("", $aryFormat);
}
##############################################################
# 이미지 관련함수											 #
##############################################################
/*
	설명 : 파일존재확인 후 파일이 존재하면 경로를 되돌려주고 존재하지 않으면 빈문자열반환
	       ex) $fileName = IM_FileExists("$G_menuTypeName" "$mode.php");
*/
function IM_FileExists($path, $filename) {
	if (file_exists($path."/".$filename)) {
		return $filename;
	}else{
		return "";
	}
}

/*
	설명 : $strX가 빈문자열이면 $replace_value를 반환 빈문자열이 아니면 $strX를 반환
	       ex) $mode = IM_isblank($mode, "list");
*/
function IM_IsBlank($strX, $replace_value){
	if(trim($strX)==""){
		return $replace_value;
	}else{
		return $strX;
	}
}

/*
	설명 : 이미지파일의 가로,세로 길이를 배열에 담는다.
*/
function imgSpec($file,$savedir,$basicImg){

	$dir = $savedir;

	$pos = strpos($file,".");
	$ext = substr($file,$pos+1);

	if(!strcmp($ext,"jpg") || !strcmp($ext,"JPG") || !strcmp($ext,"gif") || !strcmp($ext,"GIF") || !strcmp($ext,"jpeg")){
		if(file_exists($dir)){

			$size    = @GetImageSize("$savedir");
			$widths  = $size[0];
			$heights = $size[1];

			$putfile[dir]    = $dir;
			$putfile[width]  = $widths;
			$putfile[height] = $heights;
		}else{
			$putfile[dir]    = $basicImg;
		}
	} else {
		$putfile[dir]    = $basicImg;
	}

	return $putfile;
}

/*
	설명 : $width에 따른 이미지 파일의 가로길이 조정
*/
function imgViewSize($file,$savedir,$width ="450"){


	if ($savedir) $size    = @GetImageSize("$savedir/$file");
	else $size    = @GetImageSize("$file");

	$widths  = $size[0];
	$heights = $size[1];

	//$height 오타로 보여서 수정. 남덕희
	//if (!$height) $height = $heights;
	if (!$heights) $heights = $heights;

	if ($width > 0){
		if($widths >= $width){

			$sizes[width]  = $width;
			$sizes[height] = intval($heights * $width / $widths);
		}else{
			$sizes[width]  = $widths;
			$sizes[height] = $heights;
		}
	} else {
		$sizes[width]  = $widths;
		$sizes[height] = $heights;
	}
	return $sizes;
}


/*
	설명 :파일확장자에 따른 이미지 찾기
*/
function imgFileExt($file){
	$pos =strpos($file,".");
	$ext =substr($file,$pos+1);

	if (!strcmp($ext,"zip") || !strcmp($ext,"alz")){
		$file_ext = "tip_zip.gif";
	} elseif (!strcmp($ext,"hwp")) {
		$file_ext = "tip_han.gif";
	} elseif (!strcmp($ext,"doc")) {
		$file_ext = "tip_word.gif";
	} elseif (!strcmp($ext,"txt")) {
		$file_ext = "tip_text.gif";
	} elseif (!strcmp($ext,"xls")) {
		$file_ext = "tip_excel.gif";
	} elseif (!strcmp($ext,"ppt")) {
		$file_ext = "tip_power.gif";
	} else {
		$file_ext = "tip_etc.gif";
	}

	return $file_ext;
}

/*
	설명 :파일확장자 제한
*/
/**
 * @param 파일명
 * @param 제한할 확장자명
 * @return bool
 */
function getLimitFileExt($file,$limitExt){
	$pos	= strpos($file,".");
	$aryExt = explode(".",strtolower(substr($file,$pos+1)));

	$strLimitFile = "html|htm|phtml|php|php4|php3|inc|pl|cgi|asp|jsp|aspx|php3|in|pl|shtml|exe";
	if($limitExt){
		$strLimitFile = $limitExt;
	}


	for($i=0;$i<count($aryExt);$i++){

		if (@ereg($aryExt[$i],$strLimitFile)){
			return false;
			break;
		}
	}

	return true;
}

/*
	설명 : 파일확장자(이미지파일만 업로드 가능)
	옵션 : 플래시 파일 사용을 원하면 $flash 를 "Y"로 전달
*/
/**
 * @param 파일이름
 * @param 플레시 사용 여부, YN
 * @return Allow 확장자가 있으면 false
 */
function getAllowImgFileExt($file,$flash="N"){
	//getAllowImgFileExt 위에꺼 에러 나서 새로 만듬. 남덕희
	$strAllowFile = "jpg|jpeg|gif|png";
	$strAllowFile .= ($flash=="Y") ? "|swf" : "";

	$filename = explode(".",$file);
	$extension = $filename[sizeof($filename)-1];
	$extension = strtolower($extension);    // 파일 확장자
	if(!preg_match('/'.$strAllowFile.'/i', $extension)){
		return false;
	}

	return true;
}

function getFileExt($file){
	$filename = explode(".",$file);
	$extension = $filename[sizeof($filename)-1];
	$extension = strtolower($extension);    // 파일 확장자
	return $extension;

}


/*
	설명 : 공통폴더 생성
*/
function getMakeFolder($makeRootPath,$makeDirName)
{
	$makeDirName = WEB_UPLOAD_PATH."/".$makeRootPath."/".$makeDirName;

	if(!is_dir($makeDirName))
	{
		@mkdir($makeDirName,0707);
		@chmod($makeDirName,0707);
	}

	for($z=1;$z<=28;$z++)
	{
		if(!is_dir($makeDirName."/prodImg".$z)) {
			@mkdir($makeDirName."/prodImg".$z,0707);
			@chmod($makeDirName."/prodImg".$z,0707);

/*			@mkdir($makeDirName."/prodImg".$z."/kr",0707);
			@chmod($makeDirName."/prodImg".$z."/kr",0707);

			@mkdir($makeDirName."/prodImg".$z."/us",0707);
			@chmod($makeDirName."/prodImg".$z."/us",0707);

			@mkdir($makeDirName."/prodImg".$z."/cn",0707);
			@chmod($makeDirName."/prodImg".$z."/cn",0707);

			@mkdir($makeDirName."/prodImg".$z."/jp",0707);
			@chmod($makeDirName."/prodImg".$z."/jp",0707);

			@mkdir($makeDirName."/prodImg".$z."/id",0707);
			@chmod($makeDirName."/prodImg".$z."/id",0707);
*/
		}
	}

	for($z=1;$z<=3;$z++)
	{
		if(!is_dir($makeDirName."/prodFile".$z)) {
			@mkdir($makeDirName."/prodFile".$z,0707);
			@chmod($makeDirName."/prodFile".$z,0707);

			@mkdir($makeDirName."/prodFile".$z."/kr",0707);
			@chmod($makeDirName."/prodFile".$z."/kr",0707);

			@mkdir($makeDirName."/prodFile".$z."/us",0707);
			@chmod($makeDirName."/prodFile".$z."/us",0707);

			@mkdir($makeDirName."/prodFile".$z."/cn",0707);
			@chmod($makeDirName."/prodFile".$z."/cn",0707);

			@mkdir($makeDirName."/prodFile".$z."/jp",0707);
			@chmod($makeDirName."/prodFile".$z."/jp",0707);

			@mkdir($makeDirName."/prodFile".$z."/id",0707);
			@chmod($makeDirName."/prodFile".$z."/id",0707);

			@mkdir($makeDirName."/prodFile".$z."/fr",0707);
			@chmod($makeDirName."/prodFile".$z."/fr",0707);

		}
	}
	return true;
}
/*
	설명 : 공통폴더 생성
*/
function getEditorMakeFolder($makeRootPath)
{
	$makeDirName = WEB_UPLOAD_PATH."/editor/".$makeRootPath;

	if(!is_dir($makeDirName))
	{
		@mkdir($makeDirName,0707);
		@chmod($makeDirName,0707);
	}

	return true;
}


function getBoardMakeFolder($makeRootPath)
{
	$makeDirName = WEB_UPLOAD_PATH."/data/".$makeRootPath;

	if(!is_dir($makeDirName))
	{
		@mkdir($makeDirName,0707);
		@chmod($makeDirName,0707);

		@mkdir($makeDirName."/file1",0707);
		@chmod($makeDirName."/file1",0707);

		@mkdir($makeDirName."/file2",0707);
		@chmod($makeDirName."/file2",0707);

		@mkdir($makeDirName."/file3",0707);
		@chmod($makeDirName."/file3",0707);

		@mkdir($makeDirName."/file4",0707);
		@chmod($makeDirName."/file4",0707);

		@mkdir($makeDirName."/file5",0707);
		@chmod($makeDirName."/file5",0707);

		@mkdir($makeDirName."/cate",0707);
		@chmod($makeDirName."/cate",0707);

	}

	return true;
}

function getLangMakeFolder($makeRootPath)
{
	$makeDirName = WEB_UPLOAD_PATH."/".$makeRootPath;

	if(!is_dir($makeDirName))
	{
		@mkdir($makeDirName,0707);
		@chmod($makeDirName,0707);

		@mkdir($makeDirName."/kr",0707);
		@chmod($makeDirName."/kr",0707);

		@mkdir($makeDirName."/us",0707);
		@chmod($makeDirName."/us",0707);

		@mkdir($makeDirName."/jp",0707);
		@chmod($makeDirName."/jp",0707);

		@mkdir($makeDirName."/cn",0707);
		@chmod($makeDirName."/cn",0707);

		@mkdir($makeDirName."/id",0707);
		@chmod($makeDirName."/id",0707);

		@mkdir($makeDirName."/fr",0707);
		@chmod($makeDirName."/fr",0707);

	}

	return true;
}
##############################################################
# 스크립트 관련함수											 #
##############################################################
/*
	설명 : 자바스크립트로 경고창의 띄워주고 지정한 url로 이동하기
*/
function goUrl($message ="",$url =""){
	if(!empty($message)){
		echo "
		<script language='javascript'>
		alert('$message');
		</script>
		";
	}
	if(!empty($url)){
// 2014.08.12 kim hee sung ' 값이 들어간 경우 주소 깨짐
//		echo "<meta http-equiv='refresh' content='0;URL=$url'>";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$url\">";
		exit;
	}
}


/*
	설명 : 레이어 팝업 창 닫고 부모창 이동
*/
function goLayerPopUrl($message, $url, $type){
	if(!empty($message)){
		echo "
		<script language='javascript'>
		alert('$message');
		</script>
		";
	}

	if(!empty($url)){
		echo "
		<script language='javascript'>
		parent.goLayerPopClose('$url','$type');
		</script>
		";
		exit;
	}
}

function goLayerPopClose($message){
	if(!empty($message)){
		echo "
		<script language='javascript'>
		alert('$message');
		</script>
		";
	}

	echo "
	<script language='javascript'>
	parent.goPopClose();
	parent.location.reload();
	</script>
	";
	exit;

}


/*
	설명 : 새창에서 자바스크립트로 경고창의 띄워주고 새창 닫기
*/
function goClose($message =""){
	if(!empty($message)){
		echo "
		<script language='javascript'>
		alert('$message');
		window.close();
		</script>
		";
	}
	exit;
}

/*
	설명 : 새창에서 자바스크립트로 그냥 닫기
*/
function goJustClose(){

	echo "
	<script language='javascript'>
	window.close();
	</script>
	";

	exit;
}

/*
	설명 : 여러가지 에러발생시 에러메세지 뿌려주기
*/
function goErrMsg($message,$back ="-1"){
	echo "
	<script language='javascript'>
	alert('$message');
	history.go('$back');
	</script>
	";
	exit;
}

/*
	설명 : 여러가지 에러발생시 에러메세지 뿌려주기, 지정된 url로 이동
*/
function goRefresh($message,$url){
	echo "
	<script language='javascript'>
	alert('$message');
	location.replace('$url');
	</script>
	";
	exit;
}

/*
	설명 : 새창에서 메세지 띄어주고 새창 닫은 후 부모창 reload
*/
function goPopReflash($message){
	echo "
	<script language='javascript'>
	alert('$message');
	opener.location.reload();
	window.close();
	</script>
	";
	exit;
}

/*
	설명 : 새창에서 메세지 띄어주고 새창 닫은 후 부모창 reload
*/
function goPopWindowReflash($message,$url,$width=300,$height=300){
	echo "
	<script language='javascript'>
	alert('$message');

	window.close();

	var intLeft = screen.width / 2 - $width / 2;
	var intTop  = screen.height / 2 - $height / 2;
	var opt = ',toolbar=no,menubar=no,location=no,scrollbars=yes,status=yes';
	window.open('$url', 'pop', 'left=' + intLeft + ',top=' +  intTop + ',width='+$width + ',height=' + $height + opt);

	</script>
	";
	//"450","260"
	exit;
}

/*
	설명 : 새창에서 메세지 띄어주고 새창 닫은 후 iframe reload
*/
function goIfrmReflash($message, $method=""){
	echo "
	<script language='javascript'>
	alert('$message');";

	if (!$method){
	echo "parent.opener.location.reload();
	window.close();";
	} else {
	echo "parent.".$method.";";
	}
	echo "
	</script>
	";
	exit;
}


/*
	설명 : 공통파일업로드 함수(하나의파일)
	인자 : 테이블명			-> tab		, primary key	-> key
		   구분				-> gb		, 파일명		-> file
		   업로드 폴더명	-> $folder
*/
function uploadFileModule($tab,$key,$gb,$file,$path,$folder,$sort,$del="Y")
{
	global $db, $fh, $S_DOCUMENT_ROOT, $S_SHOP_HOME;

	if(is_uploaded_file($_FILES[$file]["tmp_name"])) {

//		$makeDirName = $S_DOCUMENT_ROOT . $S_SHOP_HOME . $folder;
//		echo $makeDirName;
//		if ( !is_dir ( $makeDirName ) ) :
//			@mkdir($makeDirName, 0707);
//			@chmod($makeDirName, 0707);
//		endif;

		//이전 파일 존재 삭제
		if ($del == "Y"){
			uploadFileMultiDel($tab,$key,$gb,$path,$sort,"");
		}

		$fileUid = $tab."_".$key."_".$gb."_".date("ymdHis");
		$aryFile = $fh->doUpload($fileUid,$path.$folder,$_FILES[$file][name],$_FILES[$file][tmp_name],$_FILES[$file][size],$_FILES[$file][type]);

		$arrData = array(
					 "F_NO"		=>""
					,"F_ORG_NAME"	=>$aryFile[file_name]
					,"F_SAVE_NAME"	=>$aryFile[file_real_name]
					,"F_TABLE"		=>$tab
					,"F_TABLE_KEY"	=>$key
					,"F_GUBUN"		=>$gb
					,"F_FILE_PATH"	=>$folder."/".$aryFile[file_real_name]
					,"F_FILE_TYPE"	=>$aryFile[file_type]
					,"F_FILE_SIZE"	=>$aryFile[file_size]
					,"F_FILE_SORT"	=>$sort
					,"F_REG_DT"		=>date("Y-m-d H:i:s"));

		if ($db->getInsert(TBL_COMM_FILE,$arrData,true)>0) return $arrData;
		else return false;

	} else {
		return false;
	}
}

/*
	설명 : 공통파일업로드 삭제(멀티)
	인자 : 테이블명			-> tab		, primary key	-> key
		   구분				-> gb		, 경로			-> path
		   업로드 폴더명	-> $folder
*/
function uploadFileMultiDel($tab,$key,$gb,$path,$sort,$file_no)
{
	global $db,$fh;

	$linkTab = "";
	$where = "";
	$sql   = "SELECT * FROM ".TBL_COMM_FILE;

	if ($file_no) {
		$where = " WHERE F_NO = ".$file_no;
	} else {
		$where  = "	WHERE F_TABLE		 = '$tab'";
		$where .= "		AND F_TABLE_KEY  = '".$key."'";
		if ($gb) $where .= "	AND F_GUBUN		 = '$gb'";
		//$where .= "		AND F_SORT		 = '$sort'";
	}
	$result = $db->getResult($sql.$where);

	if ($result[cnt] > 0)
	{
		while($row = mysql_fetch_array($result[result]))
		{
			if ($row[F_FILE_PATH]) {
				$fh->fileDelete($path.$row[F_FILE_PATH],"");
			}
		}

		//데이터삭제
		$db->getExecSql("DELETE FROM ".TBL_COMM_FILE.$where);
	}

	return true;
}

/*
	설명 : 공통 코드를 가지고 온다.
*/

function getCommCodeList($code,$etc="N"){
	global $db;
	global $S_SITE_LNG;

	$query  = "SELECT CC_CODE,CC_NAME_".$S_SITE_LNG." CC_NAME	";
	$query .= "FROM ".TBL_COMM_VIEW ;
	$query .= "	WHERE CG_CODE  ='".$code."'		";

	if ($etc == "N") $query .= "	AND (CC_ETC IS NULL OR  CC_ETC ='')		";

	return $db->getArray($query);
}

function getDeliveryUrlList(){
	global $db;
	$query  = "SELECT CC_CODE,CC_ETC 			";
	$query .= "FROM ".TBL_COMM_VIEW ;
	$query .= "	WHERE CG_CODE  = 'DELIVERY'				";

	return $db->getArray($query);
}

function getCountryList()
{
	global $db;
	global $S_SITE_LNG;

	//요청으로 중문을 영문으로 변환. 남덕희
	$CountryCode = $S_SITE_LNG;
	if($CountryCode == 'CN'){
		$CountryCode = 'US';
	}

	$query  = "SELECT ";
	$query .= " CT_CODE,CT_NAME_".$CountryCode." 			";
	$query .= "FROM ".TBL_COUNTRY ;
	$query .= "	WHERE IFNULL(CT_CODE,'') != ''		";
	$query .= "	ORDER BY CT_NAME_US ASC			";

	return $db->getArray($query);
	
}

function getCountryListTotalAry()
{
	global $db;
	global $S_SITE_LNG;

	$query  = "SELECT ";
	$query .= " CT_CODE,CT_NAME_".$S_SITE_LNG." 			";
	$query .= "FROM ".TBL_COUNTRY ;
	$query .= "	WHERE IFNULL(CT_CODE,'') != ''		";
	$query .= "	ORDER BY CT_NAME_US ASC			";

	return $db->getArrayTotal($query);
	
}


/*################################# KIM HEE-SUNG MAKE THE FUNCTION ###############################################*/

/*
	설명 : 공통 코드 그룹을 등록 한다.
	insert into COMM_GRP( CG_NO,CG_NAME,CG_CODE,CG_USE )values( , , ,  )
*/
function setCommGrpList($name, $code, $use='Y'){
	global $db;
	$arrData = array(
				 "CG_NAME"		=>$name
				,"CG_CODE"		=>$code
				,"CG_USE"		=>$use);

	return $db->getInsert(TBL_COMM_GRP,$arrData,true);
}

/*
	설명 : 공통 코드 그룹 번호(CG_NO)을 가지고 온다.
*/
function getCommGrpNo($code) {
	global $db;

	$query  = "SELECT CG_CODE, CG_NO		";
	$query .= "FROM ".TBL_COMM_GRP;
	$query .= "	WHERE CG_CODE  ='".$code."'		";

	return $db->getArray($query);
}


// 10000  입력시 1 만원 으로 변환
function getMoneyFormatMAN($money)
{
	$m		= $money  / 10000;
	$s			= $money % 10000;
	if ( $m < 1 ) {
		$ms		=  NUMBER_FORMAT($s) . " 원";
	} else {
		$ms		=  NUMBER_FORMAT( $m . "." . $s ) . " 만원";
	}
	return $ms;
}

// getCateName(카테고리 번호)  ->  카테고리 번호를 입력하면 카테고리 이름이 출력
function getCateName($numCate,$strCateLng = "") {
	global $cateMgr, $db, $S_ST_LNG;
	$cateName = "";

	if (!$strCateLng) $strCateLng = $S_ST_LNG;

	$cateMgr->setCL_LNG($strCateLng);
	$cateMgr->setC_CODE(SUBSTR($numCate,0,3));
	$aryRow[] = $cateMgr->getView($db);
	$cateMgr->setC_CODE(SUBSTR($numCate,0,6));
	$aryRow[] = $cateMgr->getView($db);
	$cateMgr->setC_CODE(SUBSTR($numCate,0,9));
	$aryRow[] = $cateMgr->getView($db);
	$cateMgr->setC_CODE(SUBSTR($numCate,0,12));
	$aryRow[] = $cateMgr->getView($db);

	foreach ( $aryRow as $row ) {
		if($row)
			$cateName .= ( $cateName ? " / " : "" ) . $row[CL_NAME] ;
	}

	return $cateName;
}

// 플록시 서버를 통해 접속하는 클라이언트 IP를 구분
function getClientIP() {
	$clientIP = $_SERVER['REMOTE_ADDR'];

	if($_SERVER['HTTP_X_FORWARDED_FOR']) :
		$clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
	endif;

	return $clientIP;
}

// 실행시간 체크 함수
// 2015.02.14 kim hee sung iniescrow50 lib 와 함수명 충돌
//function getmicrotime() {
  function C_GetMicrotime() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

/*################################# KIM HEE-SUNG MAKE THE FUNCTION ###############################################*/

/*
	설명 : 문장 번역
*/
function callLangTrans($strText,$arr)
{
	$arySearhWord = array();

	for($i=0;$i<sizeof($arr);$i++){
		array_push($arySearhWord, "/{{단어".($i+1)."}}/");
	}

	return preg_replace($arySearhWord,$arr,$strText);
}

/*
	설명 : 나라별 IP 대역폭
*/
function callCountryIpCode($intWide,$strUseLng,$strStLng)
{
	global $db;

	$query  = "SELECT IP_COUNTRY_CODE FROM ".TBL_COUNTRY_IP." WHERE ".$intWide." BETWEEN IP_WIDE_ST AND IP_WIDE_END ";
	$query .= "LIMIT 1 ";
	$strIpCountryCode = $db->getCount($query);

	$aryUseCountryCode  = explode("/",$strUseLng);
	$intUseCountryKey   = array_search("ID", $aryUseCountryCode);
	if ($intUseCountryKey >= 0) return strtolower($strIpCountryCode);
	else return strtolower($strStLng);
}


/* 원 단위 절삭 */
function getTruncateDown($val,$d = 0){

	$intVal = ($val / pow(10,$d));
	if ($d > 0 && ($intVal >=0 && $intVal < 1)){
		return floor(($val / pow(10,$d)) * pow(10,$d));
	} else {
		return floor($val / pow(10,$d)) * pow(10,$d);
	}
}


/* 소수점 자리 버림 */
function getRoundDown($num,$d = 0)
{
	return getNumSgn($num)*getNumFloor(abs($num),$d);
}

function getNumFloor($val,$d)
{
	return floor($val * pow(10,$d))/pow(10,$d);
}

function getNumSgn($x)
{
	return $x ? ( $x > 0 ? 1 : -1) : 0;
}

/* 소수점 자리 올림 */
function getRoundUp($num,$d = 0)
{
	if ($d > 0) {
		return ceil($num * 100) / 100;
	} else {
		return ceil($num);
	}
}

function getRoundWonUp($val)
{
	return ceil($val / 10) * 10;
}

// 장바구니(Shopping Bag) 상품 개수 호출
// 2013.06.24 kim hee sung 장바구니 상품 리스트와 카운트가 틀려서 join 부분과 ifnull 부분을 추가함.
function getShoppingBagCount()
{
	global $db, $g_member_no, $g_cart_prikey;

	if ($g_member_no) $query = "SELECT COUNT(*) FROM " . TBL_PRODUCT_BASKET . " A JOIN PRODUCT_MGR B ON A.P_CODE = B.P_CODE WHERE A.M_NO = '$g_member_no'
	 AND IFNULL(A.PB_DIRECT,'N') != 'Y'" ;
	else $query = "SELECT COUNT(*) FROM " . TBL_PRODUCT_BASKET . " WHERE PB_KEY = '".$g_cart_prikey."' AND IFNULL(PB_DIRECT,'N') != 'Y' " ;
	return $db->getCount($query);

}

// 나중에 주문하기(Saved Items) 상품 개수 호출
function getSavedItemsCount()
{
	global $db, $g_member_no;

	$intCount = 0;
	if ($g_member_no) {
		$query = "SELECT COUNT(*) FROM " . TBL_PRODUCT_WISH . " WHERE M_NO = '$g_member_no'  " ;
		$intCount = $db->getCount($query);
	}

	return $intCount;
}


/* 금액 기호 표시 */
function getCurMark($strSiteCur=""){
	global $S_SITE_CUR;
	global $S_ARY_CURRENCY_ICON;

	if ($strSiteCur == "") $strSiteCur = $S_SITE_CUR;

	if ($strSiteCur != "KRW" && $strSiteCur != "JPY" && $strSiteCur != "RUB" && $strSiteCur != "MXN") {
		return $strSiteCur;
	} else if ($strSiteCur == "MXN"){
		return $S_ARY_CURRENCY_ICON["MXN"]["L"];
	} else {
		return "";
	}
}

function getCurMark2($strSiteCur=""){
	global $S_SITE_CUR;
	global $S_ARY_MONEY_ICON;

	if ($strSiteCur == "") $strSiteCur = $S_SITE_CUR;

	if ($strSiteCur == "KRW"){
		return $S_ARY_MONEY_ICON["KR"]["R"];
	} else if ($strSiteCur == "JPY") {
		return $S_ARY_MONEY_ICON["JP"]["R"];
	} else if ($strSiteCur == "RUB") {
		return $S_ARY_MONEY_ICON["RU"]["R"];
	} else {
		return "";
	}
}


/**
 * @param 상품 FOB or EXW
 * @param 사이트설정 언어
 * @param 반환 타입. 1:기호, 2:문자
 * @return string 통화기호
 */
function getCurMarkFilter($FT,$lang,$TYPE=1){


	if($FT == 'FOB'){
		if($lang=='CN'){
			$strTextPriceUnit = '￥';
		}else{ //US, KR
			$strTextPriceUnit = '＄';
		}

	}else{ //EXW
		if($lang=='CN'){
			$strTextPriceUnit = '￥';
		}else if($lang=='US'){
			$strTextPriceUnit = '＄';
		}else{
			$strTextPriceUnit = '₩';
		}
	}


	return $strTextPriceUnit;
}


function getFaceBookLogin($id,$token) {
	global $db;

	$query  = "SELECT A.*,B.G_LEVEL FROM ".TBL_MEMBER_MGR." A		";
	$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." B	";
	$query .= "ON A.M_GROUP = B.G_CODE					";
	$query .= "WHERE A.M_FACEBOOK_ID = '".$id."'		";
	$query .= "	AND A.M_FACEBOOK_TOKEN = '".$token."'	";


	return $db->getSelect($query);
}

/** 작성일 : 2013.06.20
  * 작성자 : kim hee sung
  * 내  용 : json 모드에서 종료 부분
  **/
function getJsonExit($result) {
	global $db;
	$result_array		= json_encode($result);
	echo $result_array;
	$db->disConnect();
	exit;
}

/** 작성일 : 2013.06.25
  * 작성자 : kim hee sung
  * 내  용 : 입력된 문자열을 euckr로 변경합니다.
  **/
function getEuckrString($string){
	return iconv("utf-8", "euc-kr", $string);
}


/** 작성일 : 2013.06.27
  * 작성자 : kim hee sung
  * 내  용 : 해당 언어로 text 값 return
  **/
function GET_U_TRANS( $text, $lng="") {
	global $S_SITE_LNG;
	if(!$lng) { $lng = $S_SITE_LNG; }

	$re			= "";
	$language	= substr($text,0,2);
	if(strtoupper($language) == strtoupper($lng)) { $re = substr($text, 3); }
	return $re;
}

//function getChangeLngEasy($text, $lng="") {
//	global $S_SITE_LNG;
//	$aryLanguage	= array("KR","EN","JP","CN","FR","ID","RU");
//	$intPosStart	= 0;
//	$intPosEnd		= 0;
//	if(!$lng) { $lng =$S_SITE_LNG; }
//
//	foreach($aryLanguage as $val):
//		$pos = strpos($text, "{$val}:");
//		if($pos !== false):
//			$lanPos[$pos] = $val;
//		endif;
//	endforeach;
//
//	echo substr($lng,
//}


function getTopSearchWordList(){
	global $db;

	$query  = "SELECT							";
	$query .= "    SW_WORD						";
	$query .= "FROM ".TBL_SEARCH_WORD."			";
	$query .= "ORDER BY SW_COUNT DESC LIMIT 0,5 ";

	return $db->getArrayTotal($query);
}

function getSiteInfoVal($col){
	global $db;

	$query = "SELECT VAL FROM ".TBL_SITE_INFO." WHERE COL = '{$col}'";
	return $db->getCount($query);
}

/** 작성일 : 2014.06.24
  * 작성자 : kim hee sung
  * 내  용 : 요청언어, 기준언어 체크하여 파일이 있으면 해당 언어로 변경하여 return
  **/
function getFileLang($filename) {

	## 기본 설정
	$strSiteLng = strtolower(S_SITE_LNG);
	$strStLng = strtolower(S_ST_LNG);

	## 요청 언어 체크
	$strTemp = str_replace("{lang}", $strSiteLng, $filename);
	if(is_file($strTemp)) { return $strTemp; }

	## 기준 언어 체크
	$strTemp = str_replace("{lang}", $strStLng, $filename); 
	if(is_file($strTemp)) { return $strTemp; }

	return;
}
/**
 * 작성일 : 2014.07.15
 * 작성자 : kim hee sung
 * 내  용 : degug 모드인경우 메시지를 출력합니다.
**/
function getDebug($str, $isStop = false) {

	## 기본 설정
	if(!$_SESSION['debug']) return;
	
	echo '<pre>' . print_r($str, true) . '</pre>';
	if(@$str['msg']){
		goErrMsg($str['msg']);
	}

	if($isStop) exit;
}

function getCurLeftMark($strSiteLng){

	$strCurMark = "";
	switch ($strSiteLng){
		case "CN":
			$strCurMark = "￥";
		break;
	}

	return $strCurMark;
}


?>