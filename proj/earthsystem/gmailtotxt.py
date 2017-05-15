import email
import imaplib
import ctypes
import getpass
import re
import pynmea2

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

                fromvalidation = re.search("lioc.boat.tracker@gmail.com", str(newmessage['From']))
                if fromvalidation != None:
                    for part in newmessage.walk():
                        if part.get_content_type() == 'text/plain':
                            print part.get_payload()

                            gprmcstr = str(part.get_payload()).split(' ', 1)[0]

                            gpsinformation = pynmea2.parse(str(gprmcstr))


                            gpsdatestamp = gpsinformation.datestamp
                            gpstimestamp = gpsinformation.timestamp
                            gpsstatus = gpsinformation.status
                            gpslat = gpsinformation.lat
                            gpslon = gpsinformation.lon
                            gpsspeed = gpsinformation.spd_over_grnd

                            logtitle = str(newmessage['Subject']) + '_' + str(gpsdatestamp)

                            logmessage = str(gpslat) + '_'\
                            + str(gpslon) + '_'\
                            + str(gpsdatestamp) + '_'\
                            + str(gpstimestamp) + '_'\
                            + str(gpsstatus) + '_'\
                            + str(gpsspeed)

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
