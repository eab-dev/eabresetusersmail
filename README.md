eabresetusersmail
=================

Synopsis
--------
This extension provides a command line script which will reset all user emails to one email address.
This is useful when copying a live website to a test environment and you don't want the
users to receive notification emails etc from the test system.

It also provides a command line script to reset a user's password.

Disclaimer
----------
This extension is provided as is, completely free of use and charge.

Copyright
---------
Copyright Enterprise AB Ltd (c) 2012-2014 http://eab.uk

License
-------
GPL 2.0

Contact
-------
[Andy Caiger](http://eab.uk/About-Us/The-EAB-team/Andy-Caiger)

Installation
------------

1. Copy the `eabresetusersmail` folder to the `extension` folder or use git:

        cd extension
        git clone https://github.com/eab-dev/eabresetusersmail.git

2. Edit `settings/override/site.ini.append.php`

3. Under `[ExtensionSettings]` add:

        ActiveExtensions[]=eabresetusersmail

5. Clear the cache:

        bin/php/ezcache.php --clear-all

Usage
------

1. To change the default email address:

* Copy `extension/settings/override/resetusersmail.ini.append.php`
to `settings/override/resetusersmail.ini.append.php` and edit it.

* Change the value of `ResetMailAddress`.

* After saving `extension/settings/override/resetusersmail.ini.append.php` clear the cache:

            bin/php/ezcache.php --clear-all

2. To reset all users email addresses to the same one, run:

        php bin/php/ezexec.php extension/eabresetusersmail/scripts/reset_users_mail.php

3. To reset a user's password, run:

        php extension/eabresetusersmail/scripts/reset_password.php --user=username --password=newpassword
