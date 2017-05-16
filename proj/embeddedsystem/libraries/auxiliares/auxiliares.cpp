#include "auxiliares.h"

void comandoAT(String comando)
{
  String respostaAT;

  comando += "\r";
  Serial1.println(comando);
  respostaAT = "";
  delay(500);
  while(Serial1.available() > 0)    // aguardando dados da porta serial
  {
    char c = Serial1.read();
    respostaAT += c;                // lendo mensagem recebida. Concatena os chars em uma string
  }

  if (respostaAT.length() >0)
  {
    Serial.print("Resposta ao Comando: ");
    Serial.println(respostaAT);
  }

  delay(500);
}

void ctrlZ(void)
{
  String respostaAT;

  Serial1.write(0x1A);
  respostaAT = "";
  delay(1000);
  while(Serial1.available() > 0)
  {
    char c = Serial1.read();
    respostaAT += c;
  }

  if (respostaAT.length() > 0)
  {
    Serial.print("Resposta ao Comando CTRL-Z: ");
    Serial.println(respostaAT);
  }

    delay(1500);
}
