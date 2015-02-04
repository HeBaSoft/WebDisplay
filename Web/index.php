<html>
	<head>
		<meta charset="UTF-8">
		<script src="Libraries/jquery-2.0.3.js"></script>
		<script src="Libraries/jquery.color-2.1.2.js"></script>
		<link rel="stylesheet" type="text/css" href="index.css"> 
		<title>Control</title>
		
		<script>
			var UserLoggedIn = "";
			var LastTextShown = "";
			var IntervalUpdateTimer;
			var UpdateTimerInterval = 10;
			var UpdateTimer = UpdateTimerInterval - 1;
		
			//Update timer tick function
			function UpdateTimerTick() {
				UpdateTimerBar();
				
				if(UpdateTimer > 0) {
					UpdateTimer--;
				}else{
					UpdateTimer = UpdateTimerInterval - 1;
					CheckForRefresh();
				}
			}
			
			//Update timer text
			function UpdateTimerBar() {
				var DivInitialWidth = 310;
				var Div = (DivInitialWidth / UpdateTimerInterval) * UpdateTimer;
				
				$("#DivUpdateBar").animate({
					width: Div + "px",
					"background-color": "#3F62FF"
				}, 800, function() {
					if($("#DivUpdateBar").width() == 0) { $("#DivUpdateBar").animate({ width: DivInitialWidth + "px", "background-color": "#FF6360"}, 500);}
				});
				
			}
			
			//Writes text to file
			function WriteText() {
				var TextData = $('#InputTextWrite').val();
				$.post( "gate.php", { WriteText: TextData });
				
				$("#InputTextWrite").val("");
				$("#TextShownBy").val("");
				$("#TextShownBy").html("");
				
				GetText();
			}
			
			//Reads text from file
			function GetText() {
				$("#InputTextRead").val("Načítám ...");
				$("#InputTextWrite").prop('disabled', true);
				$("#ButtonSubmit").prop('disabled', true);
				$("#ButtonLogout").prop('disabled', true);
				
				setTimeout(function(){
					$.post( "gate.php", { ReadText: "" })
						.done(function( data ) {
							ShowText(data);
						})
						.always(function() {
							$("#InputTextWrite").prop('disabled', false);
							$("#ButtonSubmit").prop('disabled', false);
							$("#ButtonLogout").prop('disabled', false);
						});
				}, 300); 
			}
			
			//Shows text on website and register that user saw the text message
			function ShowText(text) {
				$.post( "gate.php", { TextShownBy: "Website: " + UserLoggedIn });
				$("#InputTextRead").val(text);
			}
			
			//Checks if text changed, if true triggers refresh
			function CheckForRefresh() {
				if(UserLoggedIn != "") {
					$.post( "gate.php", { ReadText: "" })
						.done(function( data ) {
							if(data != $("#FileText").text()) {
								ShowText(data);
							}
							GetTextShownBy();
						});
				}
			}
			
			//Gets and sorts and shows list of users that seen message text
			function GetTextShownBy() {
				$.post( "gate.php", { TextShownByList: ""})
					.done(function( data ) {
						$("#TextShownBy").html("");
						var dataArray = data.split("\n").sort();
						$.each(dataArray, function( i, val ) {
							if(val != "") {
								$("#TextShownBy").append(val + "<br>");
							}
						});
					});
			}
			
			//Logins user, activates interface
			function UserLogin() {
				var UserName = $("#InputLogin").val();
				if(UserLoggedIn == "" && UserName != "") {
					UserLoggedIn = UserName;
					
					GetText();
					
					setTimeout(function() {
						GetTextShownBy();
					}, 500);
					
					IntervalUpdateTimer = setInterval(function(){
						UpdateTimerTick();
					}, 1000); 
					
					$("#UserName").text(UserName);
					$("#FormLogin").css("display", "none");
					$("#FormMessager").css("display", "initial");
					$("#TextShownWrapper").css("display", "initial");
				}
			}
			
			function UserLogout() {
				if(UserLoggedIn != "") {
					clearInterval(IntervalUpdateTimer);
					UpdateTimer = UpdateTimerInterval;
					UpdateTimerBar();
					
					UserLoggedIn = "";
					$("#UserName").text("");
					$("#FormLogin").css("display", "initial");
					$("#FormMessager").css("display", "none");
					$("#TextShownWrapper").css("display", "none");
				}
			}
			
		</script>
	</head>
	
	<body>
	
		<div id="FormLogin">
			<p>Zadejte libovolné uživatelské jméno: </p>
			
			<form onsubmit="UserLogin(); return false;">
				<input type="text" maxlength="10" id="InputLogin">
				<input type="submit" id="ButtonLogin" value="Login">
			</form>
		</div>
	
		<div id="FormMessager">
			<input type="button" id="ButtonLogout" value="Odhlásit se" onclick="UserLogout();">
			<br><br>
		
			<div>
				Uživatel: <br>
				<span id="UserName"></span>
			</div> <br>
			
			<div>
				Zpráva: <br>
				<form onsubmit="WriteText(); return false;" id>
					<input disabled type="text" maxlength="38" id="InputTextRead" class="InputText">
					<input type="button" id="ButtonRefresh" value="Aktualizovat" onclick="CheckForRefresh(); UpdateTimer = UpdateTimerInterval; UpdateTimerBar(); ">
					<div id="DivUpdateBar"></div>
					<input type="text" maxlength="38" id="InputTextWrite" class="InputText">
					<input type="submit" id="ButtonSubmit" value="Zapsat">
				</form>
			</div>
			
			<div id="TextShownWrapper">
				Uživatelé, kteří si zobrazili tuto zprávu: <br>
				<div id="TextShownBy" class="ElementIndentation"></div>
			</div> <br>
			
		</div>
		
	</body>
</html>