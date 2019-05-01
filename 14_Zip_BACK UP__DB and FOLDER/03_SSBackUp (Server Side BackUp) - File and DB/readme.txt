              SSBackUp (Server Side BackUp) - BackUps Become Easy
              ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
           By Alessandro Marinuzzi © 2015-2019. All Rights Reserved
           ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯

DESCRIPTION:
¯¯¯¯¯¯¯¯¯¯¯¯
SSBackUp (Server Side BackUp) performs full backups  of your website and  stores
them in separate folder of your  server. When backups are created you can easily
download  or delete  them. You do not  need a ftp client! All operations  can be
performed using  SSBackUp. SSBackUp excludes previous  backups during the backup
so  that the final backup is not  too large.  Backups are  sorted by date so the
last backup performed  is the first on the list. And if you need to exclude some
folders  you can do easily using a special feature included in this version. Now
I created a configuration panel for the date so you can easy choose your format!
I really hope you will find this software useful. If you want make me a donation
then visit my website and then click on PayPal. Any amount of money is welcome!
It's all. Thanks!

PS: if my scripts don't work as expected don't worry. Most likely on your server
there is a different version of tar command or the exec function not available.

To view SQLite log file you can use http://sqlitebrowser.org/


MINIMUM REQUIREMENTS:
¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
Php 5.3 & Apache 2 (Strongly suggested migrate to PHP 7+)
Tar Command available
Stat Command available
Exec Php function available
SQLite available

TARGET SERVER OS:
¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
Linux
Unix
MacOSX

USAGE:
¯¯¯¯¯¯
01) first upload ssbackup folders/files in the root of your website!
02) then browse with your web browser and open index.php.
03) follow the instructions that will appear on the screen.
04) when done, configurate your backup options.
05) now press "BackUp" button and wait until backup is done!

HISTORY:
¯¯¯¯¯¯¯¯
SSBackUp -> 1.0 -> 26/02/2015 -> Initial Project
SSBackUp -> 1.1 -> 01/03/2015 -> Improved apache-ht.php (rewrite code, used css)
                              -> Improved index.php (fixed bug js)
                              -> Improved backup.php (updated infos)
                              -> Improved backup.css (fixed bug layout)
                              -> Improved readme.txt (updated infos)
SSBackUp -> 1.2 -> 06/03/2015 -> Improved backup.css (rewrite css)
                              -> Improved apache-ht.php (fixed annoying notice)
SSBackUp -> 1.3 -> 04/04/2015 -> Improved index.php (added elapsed time code)
                              -> Improved backup.php (added elapsed time code)
                              -> Improved apache-ht.php (fixed validating bug)
                              -> Improved readme.txt (updated this readme)
                              -> Improved backup.css (updated look)
SSBackUp -> 1.4 -> 05/04/2015 -> Improved index.php (added filesize)
                              -> Improved backup.php (updated infos)
                              -> Improved apache-ht.php (updated infos)
                              -> Improved readme.txt (updated this readme)
                              -> Improved backup.css (added filesize)
SSBackUp -> 1.5 -> 07/04/2015 -> Improved index.php (added security routines)
                              -> Improved backup.php (added security code)
                              -> Improved apache-ht.php (fixed salt in password)
                              -> Improved readme.txt (updated this readme)
                              -> Improved backup.css (introduced css tooltips)
                              -> Created error.php (checks if there are errors)
                              -> Created test.php (checks functions & commands)
                              -> Folder "try" (replace "busy.gif" with others)
                              -> Php Location (compliant to standard browsers)
                              -> Fixed stupid bug (regarding apache-ht.php)
SSBackUp -> 1.6 -> 12/05/2016 -> Created exclude.php (you can exclude folders)
                              -> Fixed apache-ht.php (password is hidden now)
                              -> Edited backup.php (now accepts exclusions)
                              -> Updated all files (minor changes, this readme)
                              -> Edited some files (files with header Location)
                              -> Edited error.php (now more friendly)
                              -> Solved cosmetic issue due to wrong css rules
SSBackUp -> 1.7 -> 18/02/2017 -> Updated all files (fixed some security bugs)
SSBackUp -> 1.8 -> 19/09/2017 -> Updated all files (created date config panel)
                              -> Improved password creation under Windows
                              -> Implemented "Check For Updates" function
                              -> SQLite Log to view who has access to your files
SSBackUp -> 1.9 -> 01/01/2019 -> Migrated the whole project to HTML5


KNOWN BUGS:
¯¯¯¯¯¯¯¯¯¯¯
Tar command wont backup the file .htaccess located in the root due to limitation
of Tar command. Solution: zip .htaccess and then copy it in a subdir of the root
and now it will be backed-up as expected. Thank you!


AUTHOR:
¯¯¯¯¯¯¯
Full Name: Alessandro Marinuzzi [Alecos]
E-Mail:    alecos@alecos.it
WebSite:   https://www.alecos.it/
Country:   Italy

STATUS:
¯¯¯¯¯¯¯
SSBackUp (Server Side BackUp) · Copyright © 2015-2019, Alessandro Marinuzzi.
[Alecos]. All Rights Reserved. SSBackUp is released under G.P.L.

DISCLAIMER:
¯¯¯¯¯¯¯¯¯¯¯
THIS  SOFTWARE  IS PROVIDED  "AS IS",  WITHOUT  WARRANTY  OF  ANY  KIND,  EITHER
EXPRESSED  OR  IMPLIED, OR  OTHERWISE. BY USING  THIS  SOFTWARE, YOU  ACCEPT THE
ENTIRE RISK. ALESSANDRO MARINUZZI SHALL BE NOT LIABLE FOR ANY DIRECT OR INDIRECT
DAMAGE, INCLUDING DAMAGE FOR ANY DATA OR INFORMATION WHICH MAY BE LOST.