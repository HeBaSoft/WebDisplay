<?php 
	include dirname(__FILE__) . "/SqlManager.php";
	
	function GetMaxMessageLength() {
		return 40;
	}
	
	function LogMessage($msg, $author) {
		if(strlen($msg) > GetMaxMessageLength()) { echo "Message too long (>" . GetMaxMessageLength() . " characters)"; return; }
		
		SqlQuery("
			INSERT INTO `MessageLog` (`Id`, `Message`, `Author`, `Date`) VALUES (" . GetNextMessageLogId() . ", '" . $msg . "', '" . $author . "', '" . date("Y-m-d H:i:s") . "');
		");
	}
	
	function GetLastMessages($count) {
		if(!is_numeric($count)) { echo "Non numeric value!"; return;}
	
		$conn = SqlConnect();
		$result = mysqli_query($conn, "(SELECT `Id`, `Message`, `Author`, `Date` FROM MessageLog ORDER BY `Id` DESC LIMIT " . $count . ") ORDER BY `Id` DESC");
		while ($row = mysqli_fetch_assoc($result)) {
			 $records[] = $row;
		}
		
		return json_encode($records);
	}
?>