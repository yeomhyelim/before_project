<?

	class Sms extends MySQL
	{
		function initConfig() {

			global $DB_SMS_PATH;

			$conf_set = parse_ini_file("$DB_SMS_PATH");

			@extract($conf_set);

			if (!$this->host){			
				$this->host = $db_host;
				$this->db = $db_name;
				$this->user = $db_user;
				$this->password = $db_pass;
			}	
		}
	}


	$smsDB	= new Sms();	
?>