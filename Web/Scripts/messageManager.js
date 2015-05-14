var messageCont = 6;
var currentUser = "";

function GenerateLogElement(message, messageData) {
	$('<div class="DisplayLogMessageWrapper"></div>').appendTo($("#LogWrapper"));
	$('<div class="DisplayLogMessage">' + message + '</div>').appendTo($(".DisplayLogMessageWrapper").last());
	$('<div class="DisplayLogMessageData">' + messageData + '</div>').appendTo($(".DisplayLogMessageWrapper").last());	
}

function RequestMessage(count) {
	if(count < 1) { console.log("RequestMessage wrong argument"); return; }
	
	$.post("http://webdisplay.hebasoft.net/Php/Gate.php", { GetMessage: count.toString() })
		.done(function(msg) {
			var messages = jQuery.parseJSON(msg);
			
			$(".DisplayLogMessageWrapper").remove();
			
			$("#DisplayCurrentMessage").html(messages[0].Message);
			$("#DisplayCurrentMessageData").html(messages[0].Author + " | " + messages[0].Date);
			
			for(var i = 1; i < messages.length; i++) {
				GenerateLogElement(messages[i].Message, messages[i].Date + " | " + messages[i].Author);
			}
			
		});
}

function SendMessage(msg, author) {
	$.post("http://webdisplay.hebasoft.net/Php/Gate.php", { WriteMessage: msg, Author: author });
	RequestMessage(messageCont);
}

function GetMaxMessageLength() {
	$.post("http://webdisplay.hebasoft.net/Php/Gate.php", { GetMaxMessageLength: "" })
		.done(function(data) {
			$("#MsgMaxCharCount").html(data);
			CalculateRemainingMsgChars();
		});
}

function CalculateRemainingMsgChars() {
	var charLeft = parseInt($("#MsgMaxCharCount").html()) - $("#InterfaceInputText").val().length;
	if(charLeft < 0) charLeft = 0;
	$("#MsgCharCount").html(charLeft);	
}

var charTimer;
$(document).ready(function() {
	GetMaxMessageLength();
	RequestMessage(messageCont);
	
	setInterval(function() {
		RequestMessage(messageCont);
	}, 10000);
	
	$("#InterfaceButtonLogin").click(function() {
		if($("#InterfaceInputLogin").val() == "") return;
		currentUser = $("#InterfaceInputLogin").val();
		$("#InterfaceLogin").css("display", "none");
		$("#InterfaceMessager").css("display", "block");
	});
	
	$("#InterfaceInputSend").click(function() {
		var msg = $("#InterfaceInputText").val();
		if(msg == "") return;
		if(parseInt($("#MsgCharCount").html()) < 0) return;
		
		SendMessage(msg, currentUser);
		$("#InterfaceInputText").val("");
		CalculateRemainingMsgChars();
	});
	
	$("#InterfaceInputText").focus(function() {
	  	charTimer = setInterval(function() { 
			if(!$("#InterfaceInputText").is(":focus")) { clearInterval(charTimer); }
			CalculateRemainingMsgChars();
		}, 50);
	});
	
});