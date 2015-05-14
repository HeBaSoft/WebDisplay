<?php
	header("Access-Control-Allow-Origin: *");
	
	include dirname(__FILE__) . "/MsgHandler.php";
	
	if (isset($_POST['WriteMessage']) && isset($_POST['Author'])) {
		$msgText = $_POST['WriteMessage'];
		$msgAuthor = $_POST['Author'];
		LogMessage($msgText, $msgAuthor);
		IncreaseStatisticsProperty("WriteRequest");	
		echo "Write message request completed!";
		
	} else if (isset($_POST['GetMessage'])) {
		$count = $_POST['GetMessage'];
		echo GetLastMessages($count);
		IncreaseStatisticsProperty("GetRequest");
		
	} else if (isset($_POST['GetMaxMessageLength'])) {
		echo GetMaxMessageLength();
		
	} else {
		echo "Unknown request!";
	}

?>