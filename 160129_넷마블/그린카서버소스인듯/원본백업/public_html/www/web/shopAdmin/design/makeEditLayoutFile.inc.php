<?
	
	function makeEditLayerFile()
	{
		global $db, $maindesignMgr;

		/* ��ǰ����Ʈ ������ ȣ�� */
		$setingRow = $maindesignMgr->getMaindesignList($db);

		
		while($aRow = mysql_fetch_array($setingRow))
		{		
			$intDE_NO				= $aRow[DE_NO];
			$intDE_CODE				= $aRow[DE_CODE];
			$intDE_EDIT_GROUP		= $aRow[DE_EDIT_GROUP];
			$intDE_EDIT_SECTION		= $aRow[DE_EDIT_SECTION];	
			$intDE_EDIT_TEXT		= $aRow[DE_EDIT_TEXT];	
			
			$responseText = "";
			switch($intDE_EDIT_SECTION){

				//���� ������ ������
				case "main":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				//������ ���̾ƿ�(��ũ���� ���� ����)
				case "topArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "leftArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "bodyArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "rightArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "bottomArea":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				//���������� �⺻ ���̾ƿ�
				case "layout":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				//�� �������� ���̾ƿ�
				case "prodlist":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "prodview":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "login":
					$responseText .= $intDE_EDIT_TEXT;
				break;

				case "join":
					$responseText .= $intDE_EDIT_TEXT;
				break;				
			}


			/* make the file */
			$file = "../layout/html/".$intDE_EDIT_GROUP."_".$intDE_EDIT_SECTION.".inc.php";
			@chmod($file,0707);
			$fw = fopen($file, "w");
			fwrite($fw, $responseText);	
			fclose($fw);
			/* ���� ���� */	

		}//while

		
		
	}
	?>