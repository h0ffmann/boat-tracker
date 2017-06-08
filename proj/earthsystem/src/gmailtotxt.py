#coding: utf-8
import email # Uso na lógica de carregar informações do email 
import imaplib # Para usar IMAP, que é o protocolo de acesso ao email.
import ctypes # Uso para adicionar flag de mensagem visto após a mesma ser armazenada
import getpass # Para digitar senha sem mostrar caracteres
import re # Para manipulação de strings
import pynmea2 # Biblioteca para parsear o código NMEA e armazenar separadamente as informações, por _,  e identificadas

mail = imaplib.IMAP4_SSL('imap.gmail.com',993) # Definicao do protocolo e porta

unm = 'lioc.boat.tracker@gmail.com' # Usuario
pwd = getpass.getpass("Enter the password:") # Senha

mail.login(unm,pwd) # Função para logar no email.

mail.select("INBOX") # Selecionando caixa de entrada

def loop(): # Loop que teoricamente deve rodar infinitamente enquanto o sistema estiver fucionando.
            # Falta lógica para garantir que mesmo que chege ao fim reinicie o loop.
   mail.select("INBOX")
   (validation, messages) = mail.search(None, '(UNSEEN)')
   if validation == 'OK': #Setando procura por novos emails

      for num in messages[0].split() :
         print " "
         print " === New Email! === "
         print " "
         typ, data = mail.fetch(num,'(RFC822)')
         for response_part in data:
            if isinstance(response_part, tuple): # Printa informação presente no email remetente, assunto e corpo. Pode sair com caracteres não formatados
                newmessage = email.message_from_string(response_part[1])
                print newmessage['From']
                data = newmessage['Subject']
                print data

                fromvalidation = re.search("lioc.boat.tracker@gmail.com", str(newmessage['From'])) # Validando usuário
                if fromvalidation != None:
                    for part in newmessage.walk(): # Logica para "caminhar" sobre toda a informação do email e carregar o texto plano da mensagem
                        if part.get_content_type() == 'text/plain':
                            print part.get_payload()

                            # Seleciona somente o primeiro conteúdo até  primeiro espaço
                            # IMPORTANTE! Deve ter formato $GPRMC<content> <addicional info>
                            # Se não a função de parse da string vai encerrar o loop.
                            gprmcstr = str(part.get_payload()).split(' ', 1)[0]

                            gpsinformation = pynmea2.parse(str(gprmcstr))


                            gpsdatestamp = gpsinformation.datestamp # Data 
                            gpstimestamp = gpsinformation.timestamp # Tempo
                            gpsstatus = gpsinformation.status       # Status da validação da informação
                            gpslat = gpsinformation.latitude             # Latitude -- VERIFICAR FORMATO
                            gpslon = gpsinformation.longitude            # Longitude -- VERIFICAR FORMATO
                            gpsspeed = gpsinformation.spd_over_grnd # Velocidade em nós

							#Lembrar de ver na codumentação função que converte representação, para ser aceita no mapa

                            logtitle = str(newmessage['Subject']) + '_' + str(gpsdatestamp) # Titulo do Log: Tracker + Data


							#Concatena todas as strings com a informação
                            logmessage = str(gpslat)+'_'+str(gpslon)+'_'+str(gpsdatestamp)+'_'+str(gpstimestamp)+'_'+str(gpsstatus)+'_'+ str(gpsspeed)

							#Logica para abertura, escrita e fechamento do logger
                            file = open(logtitle,"a") 
                            #print gpsinformation
                            #file.write(str(newmessage['From']))
                            #file.write("\n")
                            #file.write(str(data))
                            #file.write("\n")
                            #file.write(part.get_payload(None, True))
                            file.write(logmessage)
                            file.write("\n")

                            file.close()





				# Adicionando flag "seen" à mensagem para garantir que só seja logada uma vez.
                if data == 'eject':
                    ctypes.windll.WINMM.mciSendStringW(u"set cdaudio door open", None, 0, None)
                typ, data = mail.store(num,'+FLAGS','\\Seen')

   print "..........................................................................................................Searching new emails..."

#Definição da main com chamada do loop
if __name__ == '__main__':
      try:
        while True:
            loop()
      finally:
         print" "
         print" Obrigado por usar Boat Tracker " #Mensagem final
         print" "
