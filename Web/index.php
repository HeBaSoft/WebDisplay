<?php include "Php/MsgHandler.php"; ?>

<html>
	<head>
		<meta charset="UTF-8">
		
		<!--FavIcon-->
		<link rel="shortcut icon" href="Graphics/favicon.ico" type="image/x-icon">
		<link rel="icon" href="Graphics/favicon.ico" type="image/x-icon">
		
		<!--CSS-->
		<link rel="stylesheet" type="text/css" href="Styles/common.css">
		<link rel="stylesheet" type="text/css" href="Styles/index.css">
		
		<!--JQuery-->
		<script src="Libraries/jquery-2.0.3.js"></script>
		<script src="Libraries/jquery.color-2.1.2.js"></script>
		<script src="Libraries/jquery.scrollTo.js"></script>
		
		<!--ScrollToTop Library-->
		<script src="Libraries/scrolltopcontrol.js"></script>	
		
		<!--Scripts-->
		<script src="Scripts/index.js"></script>
		
		<title>WebDisplay</title>
	</head>
	<body>
		<!--FrontPage-->
		<div class="PageBaseWrapper" id="PageTitleWrapper">
			<div class="PageCenter DisabledSelection">
				<div id="WebDisplayLogo"></div>
				<div id="Title">Web Display</div>
				<div class="SubLine"></div>
				<div id="SubTitle">Simple display with network connectivity</div>
				<div id="MessageManagerLink" onclick="window.location.assign('messageManager.php');">Open Message Manager</div>
				<div id="ArrowDown" onclick="ScrollTo('PageDescriptionWrapper');"></div>
			</div>
		</div>
		
		<!--DescriptionPage-->
		<div class="PageBaseWrapper" id="PageDescriptionWrapper">
		
			<div class="PageCenter" style="width: 200px; background-color: #CECECE;">
				<div id="StatusInfoText">
					<div class="StatusText">Status</div>
					MySQL Database: <span id="StatusSQL"> <?php if(SqlConnect()) { echo "Online"; } else { echo "Offline"; }?> </span><br>
					<br>
					<div class="StatusText">Statistics</div>
					GetMessage requests: <?php echo GetStatisticsProperty("GetRequest");?>
					<br>
					WriteMessage requests: <?php echo GetStatisticsProperty("WriteRequest");?>
				</div>
			</div>
			
			<div class="PageCenter">
				<div id="LogoWrapper" class="DisabledSelection">
					<span id="DescriptionTitle">Web Display</span> <span id="DescriptionText">by</span> <br>
					<div id="LogoHeBaSoft"></div>
				</div>
				<div id="BaseTextWrapper">
					<b>WebDisplay</b> is a Arduino based device containing display with ability to show text messages that are send from website interface<br>
					<br>
					Principal of <b>WebDisplay</b> is based around sending <i>HTTP GET</i> requests to your web server to save message and on periodical <i>HTTP POST</i> requests from Arduino to web server to receive current message status<br>
					<br>
					<b>Project consists of:</b><br>
					&nbsp <i>Software part</i> - Website interface and Arduino program<br>
					&nbsp <i>Hardware part</i> - Receiving device with display and Ethernet port<br>
					<br>
					Currently there is only one prototype of receiving device and it is located at school <b>Brno, Čichnova 23</b> at classroom <b>D2/408</b><br>
					<span style="font-size: 10px; color: #A5A8AF;">If classroom is locked the key can be found under doormat in front of the doors. Plase do not steal anything, but we are not police so do whatever you want. Right?</span>
				</div>
			</div>
			
		</div>
		
		<!--InfoPage-->
		<div class="PageBaseWrapper" id="PageInfoWrapper">
			<div class="InfoLine">
				<div class="InfoCell">
					<div class="InfoIcon" id="InfoIconHtml"></div>
					<div class="InfoName">Web Interface</div>
					<div class="InfoDescription">
						<b>Web interface</b> is one of two main parts of <b>WebDisplay</b> project. This website is responsible for sending messages, storing logs, displaying current message and handling messages history.
					</div>
				</div>
				
				<div class="InfoCell">
					<div class="InfoIcon" id="InfoIconTech"></div>
					<div class="InfoName">Technology</div>
					<div class="InfoDescription">
						<b>Arduino</b> is project is based on a family of microcontroller boards that are using various <b>Atmel AVR</b> microcontrollers
						First prototype of our receiving device is based on this microcontroller board and Ethernet shield for it.
					</div>
				</div>
				
				<div class="InfoCell">
					<div class="InfoIcon" id="InfoIconGit"></div>
					<div class="InfoName">Open source</div>
					<div class="InfoDescription">
						<b>Open source</b> is changing the world! Entire <b>WebDisplay</b> project is open sourced. Every line of code from web server and Arduino program is publicly available at our <a href="https://github.com/HeBaSoft/WebDisplay">GitHub</a> repository. Project is licensed under GNU GPL v2, feel free to fork it.
					</div>
				</div>
			</div>
			
			<div class="DivineLine"></div>
		
			<div class="InfoLine">
				<div class="InfoCell">
					<div class="InfoIcon" id="InfoIconDatabase"></div>
					<div class="InfoName">SQL Database</div>
					<div class="InfoDescription">
						<b>MySQL</b> is the world's most popular open-source database system. With its speed, reliability, and ease of use interface, <b>MySQL</b> has become the preferred choice for web development. Our message logs are stored in our <b>MySQL</b> database and data are publicly available by using our public <b>API</b> or through our website.
					</div>
				</div>
				
				<div class="InfoCell">
					<div class="InfoIcon" id="InfoIconStorage"></div>
					<div class="InfoName">Message logging</div>
					<div class="InfoDescription">
						System is currently set up to log and store up to <b>100</b> messages with information about name of user and date when message was created.
					</div>
				</div>
				
				<div class="InfoCell">
					<div class="InfoIcon" id="InfoIconApi"></div>
					<div class="InfoName">Public API</div>
					<div class="InfoDescription">
						Our website in not the only way to send messages and access to our data. You can also use our public <b>API</b> to easily retrieve informations by sending HTTP GET requests to your public <b>API</b>.
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>