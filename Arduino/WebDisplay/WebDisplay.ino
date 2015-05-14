#include <LiquidCrystal.h>
#include <SPI.h>
#include <Ethernet.h>

LiquidCrystal lcd(7, 6, 5, 4, 3, 2);
EthernetClient client;

byte MacAddress[] = { 0x00, 0xAA, 0xBB, 0xCC, 0xDE, 0x02 };
byte PiezoPin = A0;
byte LedPin = 8;
String DisplayText = "";
byte LedBlinkCount = 0;

void(* resetFunc) (void) = 0;

void setup() {
  pinMode(LedPin, OUTPUT);
  
  Serial.begin(9600);
  lcd.begin(40, 2);
  lcd.print(" WebDisplay by Filip Sikula, loading ...");
  delay(2500);
  
  lcd.clear();
  InitializateEthernet();
  
  lcd.clear();
  PrintIPAddress();
  delay(2000);
  
  lcd.clear();
  lcd.print("  ");
  lcd.print("Control: webdisplay.hebasoft.net");
  for(int i = 0; i < 8; i++) { lcd.print(" "); }
  lcd.print("Source:  github.com/HeBaSoft/WebDisplay");
  delay(5000);
}

void loop() {

  String jsonData = SendRequest("GetMessage=1");
  String msgText = getJSONTokenValue(jsonData, "Message");
  
  if(DisplayText != msgText) {
    lcd.clear();
    lcd.print("  ");
    lcd.print(msgText);
    for(int i = 0; i < 42 - (msgText.length() + 2); i++) { lcd.print(" "); }
    lcd.print("By: " + getJSONTokenValue(jsonData, "Author") + " | " + getJSONTokenValue(jsonData, "Date"));
    if(DisplayText != "") {
      LedBlinkCount = 20;
      tone(PiezoPin, 300, 400);
      delay(400);
      tone(PiezoPin, 400, 400);
      delay(400);
      tone(PiezoPin, 500, 400);
    }
    
    DisplayText = msgText; 
  }
  
  if(LedBlinkCount > 0) {
    digitalWrite(LedPin, !digitalRead(LedPin));
    LedBlinkCount--;
  }
  
  delay(1500);
}

String SendRequest(String request) {
  String IncomeBuffer = "";
  String Message = "";
  char OutBuf[64];
  
  if(client.connect("webdisplay.hebasoft.net", 80) == 1) {
    sprintf(OutBuf, "POST %s HTTP/1.1", "/Php/Gate.php");
    client.println(OutBuf);
    sprintf(OutBuf, "Host: %s", "webdisplay.hebasoft.net");
    client.println(OutBuf);
    client.println(F("Connection: close\r\nContent-Type: application/x-www-form-urlencoded"));
    sprintf(OutBuf, "Content-Length: %u\r\n", request.length());
    client.println(OutBuf);
    client.print(request);
    
    int connectLoop = 0;
    while(client.connected()) {
      while(client.available()) {
        IncomeBuffer += (char)client.read();
        connectLoop = 0;
      }
      
      delay(1);
      connectLoop++;
      if(connectLoop > 10000) { client.stop(); }
    }

    client.stop();
  }
  
  if(IncomeBuffer != "") {
    int ContentLengthIndex = IncomeBuffer.indexOf("Content-Length:");
    int MessageLength = (IncomeBuffer.substring(ContentLengthIndex + 16, IncomeBuffer.indexOf("\n", ContentLengthIndex + 15) - 1)).toInt();
    Message = IncomeBuffer.substring(IncomeBuffer.length() - MessageLength);
  } else {
    Message = DisplayText;
  }
  
  return Message;
}

String getJSONTokenValue(String json, String token) {
  int startP = json.indexOf(token + "\":\"") + token.length() + 3;
  int endP = json.indexOf("\"", startP);
  return json.substring(startP, endP);
}

void InitializateEthernet() {
  lcd.print("  ");
  lcd.print("Requesting IP Address from DHCP ...");
  Ethernet.maintain();
  if (Ethernet.begin(MacAddress) == 0) {
    lcd.clear();
    lcd.print("  ");
    lcd.print("Ethernet error, rebooting ...");
    delay(1500);
    resetFunc();
  }  
}

void PrintIPAddress() {
  lcd.print("  ");
  lcd.print("My IP Address: ");
  for (byte thisByte = 0; thisByte < 4; thisByte++) {
    lcd.print(Ethernet.localIP()[thisByte], DEC);
    if(thisByte < 3) { lcd.print("."); }
  } 
}
