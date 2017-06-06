
/* DEL/POLI/UFRJ
   Projeto Integrado 2017.1
   Código Fonte - Sistema Embarcado
   Autores:
   William Barbosa de Macedo - william.macedo@poli.ufrj.br
   Matheus Hoffmann Fernandes Santos - hoffmann@poli.ufrj.br

*/
#include "auxiliares.h"
#define DEBUG true

/* Declaração de Variáveis/Objetos */
//TinyGPSPlus gps;         // Objeto GPS
char gprmc[100];
String mensagem, telefone;

void sendSMS(String mensagem);
void goGPS(void);
void go2G(void);      // setar APN da operadora
void lerSerial(void); // testar
void sendEmail(String);
void sendData(String, const int, boolean);

void setup()   /* Essa rotina é executada apenas uma vez */
{
    Serial.begin(9600);   /* abre a porta serial de comunicação entre o MSP432 e o PC. Será útil para enviar informações de debug ao Serial Monitor */
    Serial1.begin(9600);  /* abre a porta serial de comunicação entre o MSP432 e o Módulo GSM/GPS */
    pinMode(RED_LED, OUTPUT);
    pinMode(GREEN_LED, OUTPUT);
    pinMode(BLUE_LED, OUTPUT);
    delay(15000);         /* Delay para fixação da Rede GPRS (Nextel no LIOc - por volta de 15s */
    comandoAT("AT");                              // sim808, are you alive?
    sendData( "AT+CGPSPWR=1",1000,DEBUG);
    sendData( "AT+CGNSPWR=1",1000,DEBUG);
    sendData( "AT+CGPSOUT=255",1000,DEBUG);
    sendData( "AT+CGNSTST=1",1000,DEBUG);
    sendData( "",1000,DEBUG);
    sendData( "",1000,DEBUG);
    sendData( "",1000,DEBUG);
    //sendData( "AT+CGPSPWR=0",1000,DEBUG);
    go2G();                                       // configura e ativa GPRS
    sendEmail(gprmc);
}

void loop()   /* Loop principal do programa. Executado após o setup */
{
  sendData( "AT+CGPSPWR=1",1000,DEBUG);
  sendData( "AT+CGPSOUT=255",1000,DEBUG);
  sendData( "AT+CGNSTST=1",1000,DEBUG);
  sendData( "",1000,DEBUG);
  sendData( "",1000,DEBUG);
  sendEmail(gprmc);
}

void sendSMS(String mensagem)
{
    comandoAT("AT+CMGF=1");
    comandoAT("AT+CMGS=\"00000000000\"");
    Serial1.print(mensagem);
    delay(500);
    ctrlZ();
}

void lerSerial(void)
{
  String respostaAT;

  respostaAT = "";
  while(Serial1.available() > 0) // aguarda recebimento de mensagem de confirmacao. Quando for -1, indica que não há mais dados a serem processados.
  {
    char c = Serial1.read();
    respostaAT += c; // le mensagem recebida. Concatena os chars em uma string. Typecast pq read retorna int.
  }

  if (respostaAT.length() >0)
  {
    Serial.print("Leitura Serial: ");
    Serial.println(respostaAT);
  }
}

void goGPS(void)
{
  comandoAT("AT+CGNSPWR=1");
  comandoAT("AT+CGNSTST=1");
}

void go2G(void)
{
  comandoAT("AT+SAPBR=3,1,\"Contype\",\"GPRS\"");   // APN ou Contype
  comandoAT("AT+SAPBR=3,1,\"APN\",\"modem.nextel3g.net.br\"");   // atencao: trocar APN para sua respectiva operadora
  comandoAT("AT+SAPBR=1,1");
  comandoAT("AT+SAPBR=2,1");
}

void sendEmail(String mensagem)
{
  comandoAT("AT+EMAILCID=1");
  comandoAT("AT+EMAILTO=45");
  comandoAT("AT+EMAILSSL=2");
  comandoAT("AT+SMTPSRV=\"smtp.gmail.com\",25");
  comandoAT("AT+SMTPAUTH=1,\"lioc.boat.tracker@gmail.com\",\"REMOVED\"");
  comandoAT("AT+SMTPFROM=\"lioc.boat.tracker@gmail.com\",\"TRACKER01\"");
  comandoAT("AT+SMTPRCPT=0,0,\"lioc.boat.tracker@gmail.com\",\"Server\"");
  comandoAT("AT+SMTPRCPT=1,0,\"william.macedo@poli.ufrj.br\",\"William\"");
  comandoAT("AT+SMTPSUB=\"BT01\"");
  comandoAT("AT+SMTPBODY=70");
  comandoAT(mensagem);
  ctrlZ();
  comandoAT("AT+SMTPSEND");
  delay(15000);
}

void sendData(String command, const int timeout, boolean debug){
    String response = "";

    Serial1.println(command);
    delay(150);
    if(debug){
    long int time = millis();
    while( (time+timeout) > millis()){
      while(Serial1.available()){
        response += char(Serial1.read());
      }
    }
//      Serial.println("\nInicio da Resposta");
//      Serial.print(response);
//      Serial.println("\nFim da Resposta");
    int index=0, indice=0;
      index = response.indexOf("$GPRMC",0);  // if(index != -1)
      if(index >=0)
      {
        time = millis();
        do
        {
          gprmc[indice] = response[index];
          indice++;
          index++;
          if(indice==95)
            break;
        }
        while((response[index] != '$') && ((time+timeout) > millis()));

        //gprmc[indice] = '\0';
        Serial.println("\Inicio do GPRMC:");
        Serial.print(gprmc);
        Serial.println("Fim do GPRMC\n");
      }
    }
}
