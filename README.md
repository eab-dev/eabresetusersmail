Disclaimer
---------
This extension is provided as is, completely free of use and charge.

Synopsis
--------
This extension provides a command line script which will reset all user emails to one email address.
This is useful when copying a live website to a test environment and you don't want the 
users to receive notification emails etc from the test system.

Contact
-------
Andy Caiger (http://www.eab.co.uk/About-Us/The-EAB-team/Andy-Caiger)

Installation
-----------
Uncompress the archive in your eZ Publish extension/ folder.

Edit extension/eabresetusersmail/settings/resetusersmail.ini.append.php and change
the value of ResetMailAddress

There's no need to enable the extension, just run the script as indicated below.

Usage
------
You can run:

php bin/php/ezexec.php extension/eabresetusersmail/scripts/reset_users_mail.php

