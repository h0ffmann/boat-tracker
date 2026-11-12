"""Checks of the land system's script and of the repository."""

import re
import sys
import unittest
import xml.dom.minidom
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
sys.path.insert(0, str(ROOT / "proj" / "earthsystem" / "src" / "back"))

import gmailtotxt  # noqa: E402

LOGS = ROOT / "proj" / "earthsystem" / "logs"
VENDORED = ("NeoGPS-master", "dashboard", "siimple-2.0.1")
SECRETS = [
    re.compile(r"AIza[0-9A-Za-z_-]{35}"),                    # Google API key
    re.compile(r"AT\+CMGS=\\?\"?(?!0{11})\d{10,13}"),       # a phone number
    re.compile(r"SMTPAUTH=1,\\\"[^\\]+\\\",\\\"(?!COLOCAR|REMOVED)"),  # an SMTP password
    re.compile(r"pwd\s*=\s*['\"]"),                             # a password written in a script
    re.compile(r"encrypt_decrypt\(['\"](?!REMOVED)"),             # an obfuscated password
]


def own_text_files():
    for path in ROOT.rglob("*"):
        if not path.is_file() or {".git", "tests"} & set(path.parts) or any(v in path.parts for v in VENDORED):
            continue
        if path.suffix.lower() in {".png", ".jpg", ".psd", ".pptx", ".xlsx", ".ico"}:
            continue
        yield path


class TestScript(unittest.TestCase):
    SENTENCE = "$GPRMC,132449.000,A,2251.6565,S,04313.6657,W,0.18,0.00,280617,,,A"

    def test_same_line_as_the_2017_log(self):
        first = (LOGS / "BT01_2017-06-28").read_text().splitlines()[0]
        self.assertEqual(gmailtotxt.log_line(self.SENTENCE), first)

    def test_log_name(self):
        self.assertEqual(gmailtotxt.log_name("BT01", self.SENTENCE), "BT01_2017-06-28")

    def test_sentence_from_an_email_body(self):
        body = self.SENTENCE + "*7C\r\nBoat Tracker 01\r\n"
        self.assertEqual(gmailtotxt.gprmc_from_payload(body), self.SENTENCE)

    def test_no_credentials_in_the_script(self):
        text = (ROOT / "proj/earthsystem/src/back/gmailtotxt.py").read_text()
        self.assertIn('os.environ["BT_MAIL_PASSWORD"]', text)
        self.assertNotIn("@gmail.com", text)


class TestLogs(unittest.TestCase):
    def test_new_logs_have_six_fields(self):
        logs = sorted(p for p in LOGS.iterdir() if p.name >= "BT01_2017-06-27")
        self.assertGreaterEqual(len(logs), 3)
        for log in logs:
            for n, line in enumerate(log.read_text().splitlines(), 1):
                if not line.strip():
                    continue
                with self.subTest(log=log.name, line=n):
                    self.assertEqual(len(line.split(",")), 6, line)
                    lat, lon = map(float, line.split(",")[:2])
                    self.assertTrue(-90 <= lat <= 90 and -180 <= lon <= 180)


class TestNoSecrets(unittest.TestCase):
    def test_no_key_password_or_phone(self):
        files = list(own_text_files())
        self.assertGreater(len(files), 20)
        for path in files:
            text = path.read_text(encoding="utf-8", errors="replace")
            for pattern in SECRETS:
                with self.subTest(path=str(path.relative_to(ROOT)), pattern=pattern.pattern):
                    self.assertIsNone(pattern.search(text))

    def test_php_reads_the_key_from_the_environment(self):
        for name in ("trackermap.php", "trackermap10.php", "trackermap20.php"):
            text = (ROOT / "proj/earthsystem/src/front" / name).read_text(errors="replace")
            with self.subTest(page=name):
                self.assertIn('getenv("GOOGLE_MAPS_KEY")', text)


def prose(markdown):
    """The sentences of the README, without code, tables, HTML and links."""
    text = re.sub(r"```.*?```", "", markdown, flags=re.S)
    lines = []
    for line in text.splitlines():
        s = line.strip()
        if not s or s.startswith(("|", "<", "#", "[![", "- marola", "- ww3", "- picasso",
                                  "- closed", "- nashkell")):
            lines.append("")
            continue
        s = re.sub(r"^(> ?)+(\[!\w+\])?", "", s)
        if re.match(r"^(\d+\.|-)\s+", s):
            lines.append("")  # a list item is a sentence of its own
            s = re.sub(r"^(\d+\.|-)\s+", "", s)
        lines.append(s)
    text = "\n".join(lines)
    text = re.sub(r"\[([^\]]*)\]\([^)]*\)", r"\1", text)
    text = re.sub(r"`[^`]*`", "X", text)
    text = text.replace("**", "")
    paragraphs = re.split(r"\n\s*\n", text)
    for p in paragraphs:
        for sentence in re.split(r"(?<=[.:!?])\s+", " ".join(p.split())):
            if sentence:
                yield sentence


class TestReadme(unittest.TestCase):
    def setUp(self):
        self.text = (ROOT / "README.md").read_text(encoding="utf-8")

    def test_archive_notice(self):
        self.assertIn("**Archive notice.**", self.text)
        self.assertIn("not maintained", self.text)

    def test_logo_exists(self):
        self.assertIn('src="docs/logo.svg"', self.text)
        xml.dom.minidom.parse(str(ROOT / "docs" / "logo.svg"))

    def test_sentences_are_short(self):
        # ASD-STE100: at most 20 words in a procedural sentence, 25 in a descriptive one.
        sentences = list(prose(self.text))
        self.assertGreater(len(sentences), 40)
        for s in sentences:
            with self.subTest(sentence=s[:60]):
                self.assertLessEqual(len(s.split()), 25, s)


if __name__ == "__main__":
    unittest.main()
