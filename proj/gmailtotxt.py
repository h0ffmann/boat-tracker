import email
import imaplib
import ctypes
import getpass

mail = imaplib.IMAP4_SSL('imap.gmail.com',993)

unm = 'lioc.boat.tracker@gmail.com'
pwd = getpass.getpass("Enter the password:")

mail.login(unm,pwd)

mail.select("INBOX")

def loop():
   mail.select("INBOX")
   (validation, messages) = mail.search(None, '(UNSEEN)')
   if validation == 'OK':
     
      for num in messages[0].split() :
         print " "
         print " === New Email! === "
         print " "
         typ, data = mail.fetch(num,'(RFC822)')
         for response_part in data:
            if isinstance(response_part, tuple):
                newmessage = email.message_from_string(response_part[1])               
                print newmessage['From']
                data = newmessage['Subject']                
                print data


                file = open("GPSLoggertxt","a")

                file.write(str(newmessage['From']))
                file.write("\n")
                file.write(str(newmessage['Date']))                
                file.write("\n")
                file.write(str(data))                
                file.write("\n")

                file.close()

                for part in newmessage.walk():
                    if part.get_content_type() == 'text/plain':
                        print part.get_payload()
                        file = open("GPSLoggertxt","a")
                        file.write(part.get_payload(None, True))
                        file.write("\n")
                        file.close()
     
 
                if data == 'eject':                                                            
                    ctypes.windll.WINMM.mciSendStringW(u"set cdaudio door open", None, 0, None)               
                typ, data = mail.store(num,'+FLAGS','\\Seen')                                  

   print "..........................................................................................................Searching new emails..."

if __name__ == '__main__':
      try:        
        while True:
            loop()
      finally:
         print" " 
         print" Obrigado por usar Boat Tracker "
         print" "
