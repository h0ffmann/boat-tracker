//#include <TinyGps.h>   /* baixei essa, mas depois vi que tem essa ++ nova. Baixa e instala a mais nova no teu Energia */
//#include "TinyGPS++.h"
#include <HardwareSerial.h>   /* nativa do Energia. Nem precisa dar include */

/* Declaração de Variáveis/Objetos */
//TinyGPSPlus gps; // Inicia GPS
//int dadoInicial; // Variável para armazenar dado do GPS

void setup()   /* essa rotina é executada apenas uma vez */
{
    Serial.begin(9600);   /* abre a porta serial de comunicação entre o MSP432 e o PC. Será útil para enviar informações de debug ao Serial Monitor */
    Serial1.begin(9600);
    pinMode(RED_LED, OUTPUT);
    pinMode(GREEN_LED, OUTPUT);
    pinMode(BLUE_LED, OUTPUT);

    /*while (Serial1.available() > 0)
    {
      //dadoInicial = Serial1.read();
      // gps.encode(dadoInicial);  // alimentando o objeto gps com os dados recebidos. Ainda incompleto.
      if (gps.altitude.isUpdated())
      {
        Serial.println(gps.altitude.meters());
      }
    }
    */
      sendSMS();
}

void loop()   /* Loop principal do programa. Executado após o setup */
{

}

void sendSMS()
{
    Serial1.println("AT+CMGF=1");
    delay(500);
    Serial1.println("AT+CMGS=00000000000");
    delay(500);
    Serial1.println("Ola. Eu sou o SIM808");
    delay(500);
    Serial1.write(0x1A);
    delay(500);
}

void sendSMS(void);
