# ScoutingCMS
[![Coverage Status](https://coveralls.io/repos/github/DonMul/scoutingcms/badge.svg?branch=master)](https://coveralls.io/github/DonMul/scoutingcms?branch=master)
[![Build Status](https://travis-ci.org/DonMul/scoutingcms.svg?branch=master)](https://travis-ci.org/DonMul/scoutingcms)
## What is it?
Scouting CMS is a CMS which is ment for Scouting Groups in order to manage their site.

### What features are in ScoutingCMS?
* Customizable pages
* Photo albums
* Information / page per subgroup
* News items
* Agenda
* A admin panel to manage it all
* Custom downloads

## How to install
I still want to make a simple install script which automates these steps, but for now:

### Database
Create a Database at your host and execute the `install/db.sql` file in order to create the setup.

### Settings
Create a settings file: `private/Conf/settings.yaml`. The contents of this file should be as follows:
```
database:
  host: DATABASE_HOSTNAME
  username: DATABASE_USERNAME
  password: DATABASE_PASSWORD
  database: DATABASE_NAME
  prefix: OPTIONAL_DATABASE_TABLE_PREFIX
```

### Create your first user
* Decide for a username and password
* Hash the password with sha512 algorithm: https://passwordsgenerator.net/sha512-hash-generator/
* Insert the user in MySQL: `INSERT INTO user (username, password, nickname, email) VALUES ('USERNAME', 'HASHED_PASSWORD', 'NAME OF OWNER', 'EMAIL ADDRESS');`

## How to use
Go to the `/admin` URL in order to start editing your site.

## Changelog
### 0.1
* Initial setup of the entire framework
* Add admin panel
* Add photo albums
* Add customizable pages
* Add roles and permissions
* Add user management
* Add editable menu
* Add base setup script
* Add news items
* Add agenda
* Add downloads
