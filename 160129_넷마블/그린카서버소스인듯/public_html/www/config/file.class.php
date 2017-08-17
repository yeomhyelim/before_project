<?
#/*====================================================================*/# 
#|화일명	: file.class.php											|#
#|작성자	: 박영미													|#
#|작성일	: 2011.02.09												|#
#|작성내용	: 파일업로드 클래스											|#
#/*====================================================================*/# 

class FileHelper
{
	var $uid;
	var $upload_dir;
	var $limit_filesize=20971520; 
	var $limit_extension='html;htm;phtml;php;php4;php3;inc;pl;cgi;asp;jsp;aspx;php3;in;pl;shtml;exe';
	var $msg;

	function FileHelper(){
	}
 
	##############################################################
	# 제한할 파일크기를 정한다.
	##############################################################	
	function set_limit_filesize($limit_size)
	{
		$this->limit_filesize = $limit_size;
		return true;
	}
	
	##############################################################
	# 등록할 파일의 파일 크기를 체크한다.
	##############################################################	
	function check_limit_filesize($file_size)
	{
		
		if($file_size > $this->limit_filesize)        
		{
			$size = $this->limit_filesize/1024/1024;
			$this->msg='허용된 파일사이즈('.$size.'MB)를 초과했습니다.';
			return false;
		}
		return true;
	}

	##############################################################
	# 등록할 파일의 파일 확장자를 체크한다.
	#############################################################	    
	function check_limit_extension($file_name)
	{
		$extension=explode(".",$file_name);
		$extension=strtolower($extension[sizeOf($extension)-1]);
		$limit=explode(";",$this->limit_extension);

		for($i=0; $i<count($limit); $i++)
		{
			if(!strcmp($extension,$limit[$i]) )
			{
				$this->msg=$file_name.'은 금지된 확장자를 가진 파일입니다';
				return false;
				break;
			}
		}
		return true;
	}

	##############################################################
	# 등록할 파일의 확장자를 알려준다.
	#############################################################		
	function getFileExtension($file_name)
	{
		$extension=explode(".",$file_name);
		$extension=strtolower($extension[sizeOf($extension)-1]);
		return $extension;
	}

	##############################################################
	# 업로드 디렉토리의 존재 여부와 퍼미션 체크
	#############################################################	    
	function check_upload_dir($upload_dir)
	{
		if(is_writable($upload_dir) )
		{
			$this->msg='업로드 폴더에 쓰기권한이 없습니다.(폴더 경로:'.$upload_dir.')';
			return false;
		}

		return true;
	}

	##############################################################
	# 업로드 디렉토리의 이름이 같은 파일이 존재할 경우
	# 다른 이른으로 변경
	#############################################################	        
	function check_rename_file($upload_dir,$file_name,$uid)
	{
		
		$extension = substr(strrchr($file_name, "."), 1);

		if ($uid) {
			$file_real_name = $uid;
		} else {
			$file_real_name = substr($file_name, 0, strlen($file_name) - strlen($extension) - 1);
		}
		
		$ret = "$file_real_name.$extension";
		
		$file_cnt = 0;
		while(file_exists($upload_dir."/".$ret))
		{
			$file_cnt++;
			$ret = $file_real_name."_".$file_cnt.".".$extension;
		}

		return($ret);
	}

	##############################################################
	# 파일업로드 메서드
	# uid : 파일업로드명의 구분자
	# upload_dir : 업로드할 폴더명
	# file_name : 파일명
	# file_tmp_name : 업로드할 임시 파일명
	# file_size : 업로드할 파일 크기
	# file_type : 업로드할 파일 타입
	# file_real_name :파일명 사용자가 정의
	#############################################################	        
	function doUpload($uid,$upload_dir,$file_name,$file_tmp_name,$file_size,$file_type, $file_real_name="")
	{

		$this->uid=$uid;
		$this->upload_dir=$upload_dir;

		if(!$this->check_limit_filesize($file_size) )        return false;
		
		if(!$this->check_limit_extension($file_name)) {
			return false;
		}

		if($file_real_name == "") :
			$file_real_name= $this->check_rename_file($upload_dir,$file_name,$uid);
		endif;
		

		if(is_uploaded_file($file_tmp_name) )
		{
			if(!move_uploaded_file($file_tmp_name,$upload_dir.DIRECTORY_SEPARATOR.$file_real_name) )
			{
				$this->msg='파일업로드에 실패했습니다.';

				return false;
			}
			else
			{
				$this->msg='파일업로드가 완료되었습니다.';
				$RETURN=array('uid'=>$uid,
							'upload_dir'=>        $upload_dir,
							'file_name'=>        $file_name,
							'file_real_name'=>    $file_real_name,
							'file_tmp_name'=>    $file_tmp_name,
							'file_size'=>        $file_size,
							'file_type'=>        $file_type);
				return $RETURN;
			}
		}
		else
		{
			$this->msg=$file_name.'은 실제 업로드된 파일이 아닙니다.';
			return false;
		}
	}

	##############################################################
	# 업로드할 파일 삭제
	#############################################################	        
	function fileDelete($upload_dir){
		if ($upload_dir) $file = $upload_dir;
		else $file = $file_name;
		
		if(file_exists($file)) unlink($file);
	}

	##############################################################
	# 하위 디렉토리까지 모두 삭제
	#############################################################	
	function dirDelete($path) {
		$directory			= dir($path); 
		if ( $directory ) :
			while ( $entry = $directory->read() ) :
				if ( $entry != "." && $entry != ".." ) :
	//				echo $path . "/" . $entry . "<br>";
					if ( is_dir ( $path . "/" . $entry ) ) :
						$this->dirDelete ( $path . "/" . $entry ) ;
					else :
						unLink ( $path . "/" . $entry );
					endif;
				endif;
			endwhile;
			$directory->close();
			rmdir($path);
		endif;
	}

	function doUploadEasy($fileName, $bufName) {
		
		$FILE				= $_FILES[$bufName];

		if(!is_uploaded_file($FILE['tmp_name'])) :
			// 업데이트 파일이 없음
			return false;
		endif;

		if(file_exists($fileName)) :
			// 파일 존재함..
			return false;
		endif;
		
		if(!move_uploaded_file($FILE['tmp_name'], $fileName)):
			// 파일 업로드 실패
			return false;	
		endif;
		
		@chmod($fileName, 0707);
		return true;
	}

	function getFileInfo($fileName) {

		return pathinfo($fileName);
	}

	##############################################################
	# 파일을 생성하고 문자열 저장
	##############################################################	
	function doStringSave($fileName, $string)
	{
		$handle = fopen($fileName, "w");
		fwrite($handle, $string);
		fclose($handle);
		@chmod($fileName, 0707);
	}
}

$fh = new FileHelper;

?>