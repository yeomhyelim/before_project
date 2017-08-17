<?
class MobileMgr
{
	function getMobileKeyInsert($db)
	{
		$array[MOBILE_DEVICE_KEY] = $this->getMOBILE_DEVICE_KEY();
		$array[MOBILE_DEVICE_OS] = $this->getMOBILE_DEVICE_OS();
		if($this->getM_NO()){
		$array[M_NO]= $this->getM_NO();
		}
		if($this->getM_ID()){
		$array[M_ID]= $this->getM_ID();
		}
		return $db->getInsert(TBL_MOBILE_API,$array,false);
	}

	function getMobileKeyUpdate($db)
	{
		if($this->getM_NO())
		{
			$array[M_NO]= $this->getM_NO();
		}
		
		return $db->getUpdate(TBL_MOBILE_API,$array," MOBILE_DEVICE_KEY = ".$this->getMOBILE_DEVICE_KEY());
	}

	function getMobileKeyDelete($db)
	{
		return $db->getDelete(TBL_MOBILE_API," M_NO = ".$this->getM_NO());
	}

	function getMobileKeyDelete2($db)
	{
		return $db->getDelete(TBL_MOBILE_API," M_ID = '".$this->getM_ID()."'");
	}

	// 
	function getMobileKey( $db )
	{
		$query = "SELECT MOBILE_DEVICE_KEY, MOBILE_DEVICE_OS FROM ".TBL_MOBILE_API."
					WHERE ";
		//$query .=" 	MOBILE_KEY = '".$this->getMOBILE_KEY()."'";
		if($this->getMOBILE_DEVICE_KEY()){
			$query .=" 	MOBILE_DEVICE_KEY = ".$this->getMOBILE_DEVICE_KEY()."" ;
		}
		if($this->getM_NO()){
			$query .=" 	M_NO = ".$this->getM_NO()."" ;
		}
		if($this->getM_ID()){
			$query .=" 	M_ID = '".$this->getM_ID()."'" ;
		}
		//print_r($this->getMOBILE_DEVICE_OS());
		if($this->getMOBILE_DEVICE_OS()){
			$query .=" 	MOBILE_DEVICE_OS = '".$this->getMOBILE_DEVICE_OS()."'";
		}
					//print_r($query);
					//exit;
		return $db->getSelect( $query ) ;
	}


	function getMobileKeyList( $db )
	{
		$query = "SELECT MOBILE_DEVICE_KEY, MOBILE_DEVICE_OS, M_NO FROM ".TBL_MOBILE_API."";

		if($this->getMOBILE_DEVICE_OS()){
			$where =" 	WHERE ";
			$where .=" 	MOBILE_DEVICE_OS = '".$this->getMOBILE_DEVICE_OS()."'";
		}
		$query =$query.$where;

					//print_r($query);
		return $db->getArrayTotal( $query ) ;
	}

	function setMOBILE_DEVICE_KEY($MOBILE_DEVICE_KEY){ $this->MOBILE_DEVICE_KEY = $MOBILE_DEVICE_KEY; }		
	function getMOBILE_DEVICE_KEY(){ return $this->MOBILE_DEVICE_KEY; }

	function setMOBILE_DEVICE_OS($MOBILE_DEVICE_OS){ $this->MOBILE_DEVICE_OS = $MOBILE_DEVICE_OS; }		
	function getMOBILE_DEVICE_OS(){ return $this->MOBILE_DEVICE_OS; }

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }
	
	function setM_ID($M_ID){ $this->M_ID = $M_ID; }		
	function getM_ID(){ return $this->M_ID; }
}
?>