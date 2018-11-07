# Description

Last User Edit - displays the last edit by every user in a BMLT server.

# Installation

This section describes how to install the plugin and get it working.

edit the config.php file with the following variables and upload to your server. optionally could be run locally `php -f last-user-edit.php > last-user-edit.html`
if trying to run locally you may need to add your ip address in cpanel to allow remote database connections.

static $bmlt_server = '';
// Your root server url


static $serviceBodyId = '';&nbsp;&nbsp;&nbsp;&nbsp;// this can be either a parent or child service body id

static $daysPassed = '60';&nbsp;&nbsp;&nbsp;&nbsp;// the amount of days back to look for edits

static $dbServername = "";&nbsp;&nbsp;&nbsp;&nbsp;// database servername often times 127.0.0.1 or localhost is fine

static $dbUsername = "";&nbsp;&nbsp;&nbsp;&nbsp;// bmlt database username

static $dbPassword = "";&nbsp;&nbsp;&nbsp;&nbsp;// bmlt database password

static $dbName = "";&nbsp;&nbsp;&nbsp;&nbsp;// bmlt database name
`

# Changelog

= 1.0.0 =

* Initial Release
