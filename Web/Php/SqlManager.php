<?php
	function SqlConnect() {
		include dirname(__FILE__) . "/SqlLogin.php";
		
		$conn = new mysqli($servername, $username, $password);
		if ($conn) {
			mysqli_set_charset($conn, "utf8");
			mysqli_select_db($conn, $databaseName);
		}
		
		return $conn;
	}
		
	function SqlGetOneValue($query) {
		$conn = SqlConnect();
		if (!$conn) return;
		
		$result = mysqli_query($conn, $query);	
		$row = mysqli_fetch_row($result);
		mysqli_free_result($result);
		
		return $row[0];
	}
	
	function SqlQuery($query) {
		$conn = SqlConnect();
		if (!$conn) return;
		
		mysqli_query($conn, $query);
		mysqli_close($conn); 
	}
	
	function GetNextMessageLogId() {
		return SqlGetOneValue("SELECT t1.`Id` + 1 FROM MessageLog t1 WHERE NOT EXISTS ( SELECT * FROM MessageLog t2 WHERE t2.`Id` = t1.`Id` + 1 ) LIMIT 1 UNION SELECT 0 LIMIT 1");
	}
	
	function GetStatisticsProperty($propertyName) {
		return SqlGetOneValue("SELECT `PropertyValue` FROM `Statistics` WHERE `PropertyName` = '" . $propertyName . "'");
	}
	
	function IncreaseStatisticsProperty($propertyName) {
		return SqlQuery("UPDATE `Statistics` SET `PropertyValue` = `PropertyValue` + 1 WHERE `PropertyName` = '" . $propertyName . "'");
	}
	
?>
