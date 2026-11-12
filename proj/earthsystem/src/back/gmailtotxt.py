# coding: utf-8
"""Read the tracker's e-mails and write one log line for each GPS fix.

The tracker sends a $GPRMC sentence by e-mail. This script reads the unread
e-mails of the tracker's mailbox, parses the sentence and adds a line to the
daily log file <subject>_<date> (for example BT01_2017-06-28).

Python 3. Set BT_MAIL_USER and BT_MAIL_PASSWORD before you start it.
"""

import email
import imaplib
import os
import time

import pynmea2

IMAP_HOST = "imap.gmail.com"
IMAP_PORT = 993


def gprmc_from_payload(payload):
    """Return the $GPRMC sentence at the start of an e-mail body, without its checksum."""
    sentence = str(payload).split("*", 1)[0]
    return sentence.strip().split("\r", 1)[0]


def log_line(sentence):
    """Return 'lat,lon,date,time,status,speed' for one $GPRMC sentence."""
    fix = pynmea2.parse(sentence)
    fields = [fix.latitude, fix.longitude, fix.datestamp, fix.timestamp,
              fix.status, fix.spd_over_grnd]
    lat, lon = ("{:.12g}".format(v) for v in fields[:2])
    when = fields[3].strftime("%H:%M:%S")
    return ",".join(str(f) for f in [lat, lon, fields[2], when] + fields[4:])


def log_name(subject, sentence):
    """Return the name of the daily log file: <tracker>_<date>."""
    return "%s_%s" % (subject, pynmea2.parse(sentence).datestamp)


def plain_text(message):
    for part in message.walk():
        if part.get_content_type() == "text/plain":
            return part.get_payload(decode=True).decode("utf-8", "replace")
    return None


def poll(mail, sender, logdir="."):
    """Log each unread e-mail from the tracker, then mark it as read."""
    mail.select("INBOX")
    status, found = mail.search(None, "(UNSEEN)")
    if status != "OK":
        return
    for num in found[0].split():
        _, data = mail.fetch(num, "(RFC822)")
        for part in data:
            if not isinstance(part, tuple):
                continue
            message = email.message_from_bytes(part[1])
            body = plain_text(message)
            if sender not in str(message["From"]) or body is None:
                continue
            sentence = gprmc_from_payload(body)
            try:
                line = log_line(sentence)
            except pynmea2.ParseError:
                print("not a GPRMC sentence:", sentence[:40])
                continue
            path = os.path.join(logdir, log_name(message["Subject"], sentence))
            with open(path, "a") as log:
                log.write(line + "\n")
            print("logged", path, line)
        mail.store(num, "+FLAGS", "\\Seen")


def main():
    user = os.environ["BT_MAIL_USER"]
    password = os.environ["BT_MAIL_PASSWORD"]
    mail = imaplib.IMAP4_SSL(IMAP_HOST, IMAP_PORT)
    mail.login(user, password)
    try:
        while True:
            poll(mail, user)
            time.sleep(10)
    finally:
        mail.logout()


if __name__ == "__main__":
    main()
