<?php























		if(!$result):
			$result = print_r($_POST, true);
		endif;
		echo json_encode($result);
		exit;