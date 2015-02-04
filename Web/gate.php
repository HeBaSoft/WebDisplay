<?php
	

	if (isset($_POST['WriteText'])) {
		$text = $_POST['WriteText'];
		
		$file = fopen("Files/Database.txt", "w");
		fwrite($file, $text . "\n");
		fclose($file);
		
	} else if(isset($_POST['ReadText'])) {
		$file = fopen("Files/Database.txt", "r");
		$data = substr(fgets($file), 0, -1);
		echo $data;
		fclose($file);
		
	} else if(isset($_POST['TextShownBy'])) {
		$deviceId = $_POST['TextShownBy'];
		$IsDeviceWritten = false;
		
		$file = fopen("Files/Database.txt", "r");
		fgets($file);
		while(!feof($file)){
			if(substr(fgets($file), 0, -1) == $deviceId) {
				$IsDeviceWritten = true;
				break;
			}
		}
		
		if($IsDeviceWritten == false) {
			$file = fopen("Files/Database.txt", "a");
			fwrite($file, $deviceId . "\n");
			fclose($file);
		}
	
		fclose($file);
	} else if(isset($_POST['TextShownByList'])) {
		$file = fopen("Files/Database.txt", "r");
		fgets($file);
		
		while(!feof($file)){
			$user = fgets($file);
			echo $user;
		}
		
		fclose($file);
	}
?>