<html>
	<head>
		<meta charset="UTF-8">
		
		<!--FavIcon-->
		<link rel="shortcut icon" href="Graphics/favicon.ico" type="image/x-icon">
		<link rel="icon" href="Graphics/favicon.ico" type="image/x-icon">
		
		<!--CSS-->
		<link rel="stylesheet" type="text/css" href="Styles/common.css">
		<link rel="stylesheet" type="text/css" href="Styles/messagemanager.css">
		
		<!--JQuery-->
		<script src="Libraries/jquery-2.0.3.js"></script>
		<script src="Libraries/jquery.color-2.1.2.js"></script>
		<script src="Libraries/jquery.scrollTo.js"></script>
		
		<!--Scripts-->
		<script src="Scripts/messageManager.js"></script>
		
		<title>WebDisplay: MessageManger</title>
	</head>
	<body>
		<div id="PageBarTop">
			<div id="LogoWebDisplay"></div>
			<div id="PageBarTopTitleBackTransprent"></div>
			<div class="DisabledSelection" id="PageBarTopTitle">Web Display</div>
			<div id="LogoHeBaSoft"></div>
		</div>
		
		<div id="InterfaceLogin">
			<div>Client identification</div>
			<input type="text" id="InterfaceInputLogin" placeholder="Username"></input>
			<div class="DisabledSelection" id="InterfaceButtonLogin">Login</div>
		</div>
		
		<div id="InterfaceMessager">
			<div id="InterfaceDisplayWrapper">
				<div id="DisplayCurrentMessage">message_unknown</div>
				<div id="DisplayCurrentMessageData">date_unknown - tile_unknown - user_unknown</div>
			</div>
			
			<div id="InterfaceInput">
				<input type="text" id="InterfaceInputText" placeholder="Message text"></input>
				<div class="DisabledSelection" id="InterfaceInputSend">Send</div>
				<span id="MsgCharCount">0</span>&nbsp;/&nbsp;<span id="MsgMaxCharCount">0</span>
			</div>
			
			<div id="LogWrapper"></div>
		</div>
		
	</body>
</html>