###### ApacheFriends XAMPP (Basispaket) version 1.7.1 ######

  + Apache 2.2.11
  + MySQL 5.1.33 (Community Server)
  + PHP 5.2.9 + PEAR (PHP 4 wird nicht mehr unterst�tzt) 
  + XAMPP Control Version 2.5 from www.nat32.com
  + XAMPP CLI Bundle 1.3 from Carsten Wiedmann	
  + XAMPP Security 1.0	
  + SQLite 2.8.15
  + OpenSSL 0.9.8i
  + phpMyAdmin 3.1.3.1
  + ADOdb 5.06a
  + Mercury Mail Transport System v4.62
  + FileZilla FTP Server 0.9.31
  + Webalizer 2.01-10
  + Zend Optimizer 3.3.0 
  + eAccelerator 0.9.5.3 f�r PHP 5.2.9 (auskommentiert php.ini)

--------------------------------------------------------------- 

* System-Voraussetzungen:
  
  + 64 MB RAM (EMPFOHLEN)
  + 250 MB freier Speicherplatz
  + Windows NT, 2000, 2003, XP (EMPFOHLEN), VISTA
  + 32 Bit Systeme (NICHT 64 bit) 

* SCHNELLINSTALLATION:

[HINWEIS: Auf die obersten Hirachie eines beliebigen Laufwerks bzw. auf dem Wechseldatentr�ger des USB-Sticks entpacken => E:\ oder W:\. Es entsteht E:\xampp oder W:\xampp. F�r den USB-Stick nicht die "setup_xampp.bat" nutzen, um ihn auch transportabel nutzen zu k�nnen!]

Schritt 1: Das Setup mit der Datei "setup_xampp.bat" im XAMPP-Verzeichnis starten. Bemerkung: XAMPP macht selbst keine Eintr�ge in die Windows Registry und setzt auch keine Systemvariablen.

Schritt 2: Starten Sie den Apache2 mit PHP5.x mit dem Control Panel (xampp-control.exe) oder wahlweise mit => \xampp\apache_start.bat. 
Stoppen Sie den Apache2 mit PHP5.x mit dem Control Panel (xampp-control.exe) oder wahlweise mit => \xampp\apache_stop.bat. 

Schritt 3: Starten Sie MySQL mit dem Control Panel (xampp-control.exe) oder wahlweise mit => \xampp\mysql_start.bat.
Stoppen Sie MySQL mit dem Control Panel (xampp-control.exe) oder wahlweise mit => \xampp\mysql_stop.bat.

Schritt 4: �ffne deinen Browser und gebe http://127.0.0.1 oder http://localhost ein. Danach gelangst du zu den zahlreichen ApacheFriends-Beispielen auf Ihrem lokalen Server.

Schritt 5: Das Root-Verzeichnis (Hauptdokumente) f�r HTTP (oft HTML) ist => C:\xampp\htdocs. PHP kann die Endungen  *.php, *.php3, *.php4, *.php5, *.phtml haben, *.shtml f�r SSI, *.cgi f�r CGI (z. B.: Perl).

Schritt 6: XAMPP DEINSTALLIEREN?
Einfach das "XAMPP"-Verzeichnis l�schen. Vorher aber alle Server stoppen 
bzw. als Dienste deinstallieren.

---------------------------------------------------------------

* PASSW�RTER:

1) MySQL:

   Benutzer: root
   Passwort:
   (also kein Passwort!)

2) FileZilla FTP:

   Benutzer: newuser
   Passwort: wampp 

   Benutzer: anonymous
   Passwort: some@mail.net

3) Mercury: 

   Postmaster: Postmaster (postmaster@localhost)
   Administrator: Admin (admin@localhost)

   TestUser: newuser  
   Passwort: wampp 

4) WEBDAV: 

   Benutzer: wampp
   Password: xampp 

---------------------------------------------------------------

* NUR F�R NT-SYSTEME! (NT4 | Windows 2000 | Windows XP | Windows 2003):

- \xampp\apache\apache_installservice.bat 
  ===> Installiert den Apache 2 als Dienst

- \xampp\apache\apache_uninstallservice.bat 
  ===> Deinstalliert den Apache 2 als Dienst

- \xampp\mysql\mysql_installservice.bat 
  ===> Installiert MySQL als Dienst

- \xampp\mysql\mysql_uninstallservice.bat 
  ===> Deinstalliert MySQL als Dienst

==> Nach allen De- / Installationen der Dienste, System unbedingt neustarten! 

---------------------------------------------------------------

* DAS THEMA SICHERHEIT:

Wie schon an anderer Stelle erw�hnt ist XAMPP nicht f�r den Produktionseinsatz gedacht, sondern nur f�r Entwickler in Entwicklungsumgebungen. Das hat zur Folge, dass XAMPP absichtlich nicht restriktiv sondern im Gegenteil sehr offen vorkonfiguriert ist. F�r einen Entwickler ist das ideal, da er so keine Grenzen vom System vorgeschrieben bekommt.
F�r einen Produktionseinsatz ist das allerdings �berhaupt nicht geeignet!
Hier eine Liste, der Dinge, die an XAMPP absichtlich (!) unsicher sind:

- Der MySQL-Administrator (root) hat kein Passwort.
- Der MySQL-Daemon ist �bers Netzwerk erreichbar.
- phpMyAdmin ist �ber das Netzwerk erreichbar.
- In dem XAMPP-Demo-Seiten (die man unter http://localhost/ findet) gibt es den Punkt "Sicherheitscheck".
  Dort kann man sich den aktuellen Sicherheitszustand seiner XAMPP-Installation anzeigen lassen.

Will man XAMPP in einem Netzwerk betreiben, so dass der XAMPP-Server auch von anderen erreichbar ist, dann sollte man unbedingt die folgende URL aufrufen, mit dem man diese Unsicherheiten einschr�nken kann:

	http://localhost/security/

Hier kann das Root-Passwort f�r MySQL und phpMyAdmin und auch ein Verzeichnisschutz f�r die 
XAMPP-Seiten eingerichtet werden.

---------------------------------------------------------------

* MYSQL-Hinweise:

(1) Um den MySQL-Daemon zu starten bitte Doppelklick auf \xampp\mysql_start.bat.
Der MySQL Server startet dann im Konsolen-Modus. Das dazu geh�rige Konsolenfenster muss offen bleiben (!!) Zum Stop bitte die mysql_stop.bat benutzen!

(2) Wer MySQL als Dienst unter NT / 2000 / XP benutzen m�chte, muss unbedingt (!) vorher die "my" bzw."my.ini unter C:\ (also C:\my.ini) implementieren. Danach die "mysql_installservice.bat" im Ordner "mysql" aktivieren. Dienste funktionieren generell NICHT unter Windows Home-Versionen. 

(3) Der MySQL-Server startet ohne Passwort f�r MySQl-Administrator "root".
F�r eine Zugriff in PHP s�he das also aus:

	mysql_connect("localhost", "root", "");

Ein Passwort f�r "root" k�nnt ihr �ber den MySQL-Admin in der Eingabeaufforderung
setzen. Z. B.: 

	C:\xampp\mysql\bin\mysqladmin.exe -u root -p geheim

Wichtig: Nach dem Einsetzen eines neuen Passwortes f�r Root muss auch phpMyAdmin informiert werden! Das geschieht �ber die Datei "config.inc.php"; zu finden als C:\xampp\phpmyadmin\config.inc.php. Dort also folgenden 
Zeilen editieren:
   
	$cfg['Servers'][$i]['user']            = 'root';   // MySQL User
	$cfg['Servers'][$i]['auth_type']       = 'http';   // HTTP-Authentifzierung

So wird zuerst das "root"-Passwort vom MySQL-Server abgefragt, bevor phpMyAdmin zugreifen darf.
    
---------------------------------------------------------------	
    
		Have a lot of fun! | Viel Spa�! | Bonne Chance!
