/* DEL/POLI/UFRJ
   Projeto Integrado 2017.1
   Código Fonte - Sistema Off-Shore
   Autores:
   William Barbosa de Macedo - william.macedo@poli.ufrj.br
   Matheus Hoffmann Fernandes Santos - hoffmann@poli.ufrj.br

*/


//#include <TinyGps.h>   /* baixei essa, mas depois vi que tem essa ++ nova. Baixa e instala a mais nova no teu Energia */
#include "TinyGPS++.h"
#include <HardwareSerial.h>   /* nativa do Energia. Nem precisa dar include */
**

#define TELEFONE  "00000000000"

/* Declaração de Variáveis/Objetos */
TinyGPSPlus gps; // Inicia GPS
int dadoGPS; // Variável para armazenar dado instantâneo do GPS. encode irá processar a string completa e fazer o parse.
String mensagem, respostaAT, telefone;
int dadoInicial;

void sendSMS(char* mensagem);
void goGPS(void);
void comandoAT(String comando);
void finalSMS(void);

void setup()   /* essa rotina é
 executada apenas uma vez */
{
    TESTANDOCOMMIT
    TESTANDOCOMITT
    TESTANDOCOMMIT

    Serial.begin(9600);   /* abre a porta serial de comunicação entre o MSP432 e o PC. Será útil para enviar informações de debug ao Serial Monitor */
    Serial1.begin(9600);  /* abre a porta serial de comunicação entre o MSP432 e o Módulo GSM/GPS */

    pinMode(RED_LED, OUTPUT);
    pinMode(GREEN_LED, OUTPUT);
    pinMode(BLUE_LED, OUTPUT);

    comandoAT("AT");
    comandoAT("AT+CSCA?");
    comandoAT("AT+CMGF=1");
    comandoAT("AT+CMGS=\"00000000000\"\r");
    delay(5000);
    comandoAT("O PAI EH CHATO. Projeto Integrado 2017.1 - First Task: Done with Sucess. By Will Fodao");
    finalSMS();

//    mensagem = "LIOC\r";
//    sendSMS(mensagem);
//    while(Serial1.available() < 0);
//    while(Serial1.available() > 0) // aguarda recebimento de mensagem de confirmacao. Quando for -1, indica que não há mais dados a serem processados.
//    {
//      delay(10);
//      if (Serial1.available() > 0)
//      {
//        char c = Serial1.read();
//        respostaAT += c; // le mensagem recebida. Concatena os chars em uma string. Typecast pq read retorna int.
//      }
//    }
//         if (respostaAT.length() >0) {
//          Serial.println("Apos o envio do SMS, o Modem respondeu: ");
//          Serial.println(respostaAT);
//         }



//    goGPS();
//    while(Serial1.available() < 0); // aguarda inicio da stream de resposta
//    while (Serial1.available() > 0)  /* Enquanto há dado disponível na saída da porta serial */
//    {
//     dadoInicial = Serial1.read();
//      gps.encode(dadoInicial);  // alimentando o objeto gps com os dados recebidos. Ainda incompleto.
//      if (gps.altitude.isUpdated())
//      {
//        Serial.println(gps.altitude.meters());
//      }
//    }
//    mensagem = "O Codigo chegou ao Final" ;
//    sendSMS(mensagem);
//    Serial.println("O Codigo chegou ao Final");
}

void loop()   /* Loop principal do programa. Executado após o setup */
{
//  int resposta;
//  Serial1.println("AT\r");
//  respostaAT = "";
//
//  while(Serial1.available() > 0) // aguarda recebimento de mensagem de confirmacao. Quando for -1, indica que não há mais dados a serem processados.
//    {
//     // delay(10);
//     // if (Serial1.available() > 0)
//        char c = Serial1.read();
//        respostaAT += c; // le mensagem recebida. Concatena os chars em uma string. Typecast pq read retorna int.
//    }
//
//    if (respostaAT.length() >0)
//    {
//      Serial.println("Resposta ao AT ");
//      Serial.println(respostaAT);
//    }
//
//    delay(1500);

  comandoAT("AT");
}

void sendSMS(String mensagem)
{
    Serial1.print("AT+CMGF=1\r");
    delay(1000);
    Serial1.print("AT+CMGS=\"00000000000\"\r");
    delay(1000);
    Serial1.print(mensagem);
    delay(1000);
    Serial1.write(0x1A);
}

void comandoAT(String comando)
{
  int resposta;

  comando += "\r";
  Serial1.println(comando);
  respostaAT = "";
  delay(1000);
  while(Serial1.available() > 0) // aguarda recebimento de mensagem de confirmacao. Quando for -1, indica que não há mais dados a serem processados.
    {
     // delay(10);
     // if (Serial1.available() > 0)
        char c = Serial1.read();
        respostaAT += c; // le mensagem recebida. Concatena os chars em uma string. Typecast pq read retorna int.
    }

    if (respostaAT.length() >0)
    {
      Serial.println("Resposta ao Comando");
      Serial.println(respostaAT);
    }

    delay(1500);
}

void finalSMS(void)
{
  int resposta;

  Serial1.write(0x1A);
 // Serial.print(1A, HEX);
  respostaAT = "";
  delay(1000);
  while(Serial1.available() > 0) // aguarda recebimento de mensagem de confirmacao. Quando for -1, indica que não há mais dados a serem processados.
    {
     // delay(10);
     // if (Serial1.available() > 0)
        char c = Serial1.read();
        respostaAT += c; // le mensagem recebida. Concatena os chars em uma string. Typecast pq read retorna int.
    }

    if (respostaAT.length() >0)
    {
      Serial.println("Resposta ao Comando Final de SMS");
      Serial.println(respostaAT);
    }

    delay(1500);
}

void lerSerial(void)
{
  int resposta;

 // Serial.print(1A, HEX);
  respostaAT = "";
  delay(1000);
  while(Serial1.available() > 0) // aguarda recebimento de mensagem de confirmacao. Quando for -1, indica que não há mais dados a serem processados.
    {
     // delay(10);
     // if (Serial1.available() > 0)
        char c = Serial1.read();
        respostaAT += c; // le mensagem recebida. Concatena os chars em uma string. Typecast pq read retorna int.
    }

    if (respostaAT.length() >0)
    {
      Serial.println("Resposta ao Comando Final de SMS");
      Serial.println(respostaAT);
    }

    delay(1500);
}

void goGPS(void)
{
  Serial1.print("AT+CGNSPWR=1");
  delay(500);
  Serial1.print("AT+CGNSTST=1");
  delay(500);
}
