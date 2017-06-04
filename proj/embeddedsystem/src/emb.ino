
/* DEL/POLI/UFRJ
   Projeto Integrado 2017.1
   Código Fonte - Sistema Embarcado
   Autores:
   William Barbosa de Macedo - william.macedo@poli.ufrj.br
   Matheus Hoffmann Fernandes Santos - hoffmann@poli.ufrj.br

*/
//#include "TinyGPS++.h"
#include "auxiliares.h"

/* Declaração de Variáveis/Objetos */
//TinyGPSPlus gps;         // Objeto GPS
int dadoGPS;             // Variável para armazenar dado instantâneo do GPS
String mensagem, telefone;
int dadoInicial;

void sendSMS(String mensagem);
void goGPS(void);
void go2G(void);      // setar APN da operadora
void lerSerial(void); // testar
void sendEmail(String);

void setup()   /* Essa rotina é executada apenas uma vez */
{
    Serial.begin(9600);   /* abre a porta serial de comunicação entre o MSP432 e o PC. Será útil para enviar informações de debug ao Serial Monitor */
    Serial1.begin(9600);  /* abre a porta serial de comunicação entre o MSP432 e o Módulo GSM/GPS */
    pinMode(RED_LED, OUTPUT);
    pinMode(GREEN_LED, OUTPUT);
    pinMode(BLUE_LED, OUTPUT);
    delay(100);
    comandoAT("AT");                              // sim808, are you alive?
    //goGPS();                                      // ativa GPS (cold start)
    go2G();                                       // configura e ativa GPRS
    sendEmail("Mensagem de Teste - Sent by MSP432 - LIOc");
}

void loop()   /* Loop principal do programa. Executado após o setup */
{
  comandoAT("AT");
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
  comandoAT("AT+SMTPBODY=41");
  comandoAT(mensagem);
  ctrlZ();
  comandoAT("AT+SMTPSEND");
}
