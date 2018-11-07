# Description

Last User Edit - displays the last edit by every user in a BMLT server.

# Installation

This section describes how to install the plugin and get it working.

edit the config.php file with the following variables and upload to your server. optionally could be run locally `php -f last-user-edit.php > last-user-edit.html`
if trying to run locally you may need to add your ip address in cpanel to allow remote database connections.


| config option              | value                                                          |
|:---------------------------|---------------------------------------------------------------:|
|static $bmlt_server = '';   | Your root server url                                           | 
|static $serviceBodyId = ''; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; | this can be either a parent or child service body id           |
|static $daysPassed = '60';  | the amount of days back to look for edits                      |
|static $dbServername = "";  | database servername often times 127.0.0.1 or localhost is fine |
|static $dbUsername = "";    | bmlt database username                                         |
|static $dbPassword = "";    | bmlt database password                                         |
|static $dbName = "";        | bmlt database name                                             |


# Changelog

= 1.0.0 =

* Initial Release
