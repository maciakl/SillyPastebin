Silly Pastebin
==============

Silly Pastebin is a simple Pastebin clone written in PHP using Twig as the templating engine, RedBean as ORM and GeSHi for code highlighting. The code also includes unit tests written for PHPUnit framework and acceptance tests written for Codeception framework.

This project was an exercise in writing standards compliant, manageable PHP code attempting to use industry's best practices and popular third party tools and frameworks.

Dependencies
------------

Silly Pastebin was written and tested on a LAMP platform running:

* Ubuntu 10.4
* PHP 5.3.2
* MySQL 14.14
* SQLite 2.8.17

It was not tested and is not guaranteed on Mac or Windows (though there is no reason why it shouldn't). If you are running Ubuntu the following command should download and install all the required system wide dependencies:

    sudo aptitude install php5 php5-mysql php5-sqlite php5-curl apache2 mysql-server

If you are running something else, make sure that mysql, sqlite and curl modules are enabled in your PHP installation. Curl is actually only needed for testing so you can skip it.

Silly Pastebin uses [Composer][1] for dependency management. If you don't have it, install it right now:

    cd /tmp
    curl -s https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    
Besides composer, Silly Pastebin depends on the following packages:

* [Twig][2]
* [RedBean][3]
* [GeSHi][4]

You do not need to download any of these. Composer will handle these dependencies for you.

There are also two development time dependencies not handled by Composer. These are:

* [PHPUnit][5] 3.6 (or higher)
* [Codeception][6]

You may want to download these if you're planning to modify the code and run the tests. If you are having issues getting PHPUnit 3.6 to work on Ubuntu [follow this guide][10].

Silly pastebin is also commented using the PHPDoc standard. If you want to generate the html documentation you will need to get the following:

* [PHPDocumentor2][9]

If you install via Pear on Ubuntu you may also need to grab `php5-xsl` and `graphviz` packages in order to make it work.

Installation
------------

To install Silly Pastebin clone it into a web accessible directory (like `/var/www` or something similar):

    cd /var/www
    git clone https://github.com/maciakl/SillyPastebin.git

Make sure your apache has mod-rewrite enabled and that it supports `.htaccess` files. If you don't want to use the supplied file, make sure your site is configured using these mod-rewrite rules:

    RewriteEngine On
    RewriteBase /  
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /index.php [L]

Next run composer:

    composer install

This will pull in all the run time dependencies.

Finally, open up `src/SillyPastebin/Config.php` and configure it. If you are just planning to test the application locally, I recommend to use the following setup:

* Set `dev_mode_enabled` to `true`
* Set `production_mode_enabled` to `false`
* Leave rest as is.

This will tell Silly Pastebin to use SQLite database and store its data in a temporary location (namely `/tmp/red.db`).

If you want to use Silly Pastebin with MySQL database, and have it ready to go, here is the setup you want:

* Set `dev_mode_enabled` to `false`
* Set `production_mode_enabled` to `false`
* Configure `mysql_host`, `mysql_db`, `mysql_user` and `mysql_password` with your values.

Configuration Options
---------------------

Here are the config options:

* `dev_mode_enabled` - if `true` forces use of SQLite instead of MySQL. Stores data in `/tmp/red.db`.
* `production_mode_enabled` - if `true` freezes database schema. Only enable if ready to deploy to production.
* `mysql_host` - hostname or ip address of the MySQL database server. If using nonstandard port, specify it like so `host:portnumber`.
* `mysql_db` - name of the database to use for Silly Pastebin.
* `mysql_user` - user with adequate privileges. If not in production mode, grant all privs so the DB tables can be created.
* `mysql_password` - password for `mysql_user`.

Testing
-------

To run the unit tests run the following command from the project root:

    phpunit tests

To run acceptance tests for the first time run the following command from the project root:

    codecept build
    codecept run

Please note that if running in dev-mode the SQLite database can sometimes get locked for writing due to various reasons. This causes tests to fail with an appropriate error message. If that happens I recommend deleting the database:

    sudo rm /tmp/red.db

You should not use dev-mode and SQLite for production, so this will only wipe out your test data which should not be a problem.

Screenshots
-----------

Because a picture is worth a thousand words.

Here is the actual pastebin form:

![Paste Form][pf]

Here is how a PHP paste will look like:

![Actual Paste][pd]

There is no paste list. There is no search feature. You have to remember your paste address. That's why it is a silly pastebin. You probably should not use it for anything serious.

Deploying to Production
-----------------------

If you want to deploy Silly Pastebin into live production environment you probably should:

* Set `production_mode_enabled` to `true` in `src/SillyPastebin/Config.php` to freeze the database schema.
* Prune the project directory:
    * Delete `.git/` folder
    * Delete `.gitignore` file
    * Delete `tests/` folder
    * Delete `codception.yaml` file
    * Delete `composer.json` and `composer.lock` files
    * Delete `readme.markdown` file
* Prune the `vendor/` directory deleting test, doc and git folders
* Pray! 

Silly Pastebin has no spam filtering and no CAPTCHA. You gon' get spammed son. You have been warned.

Future Work
-----------

Here are things I might add in the future in the order of importance:

* CAPTCHA support (maybe using [reCAPTCHA-PHP5][7])
* Spam filtering (maybe with [Akismet-PHP5][8])
* Paste search feature
* See recent pastes feature

These may or may not happen, depending on whether or not the implementation is worth blogging about.

[1]: http://getcomposer.com
[2]: http://twig.sensiolabs.org/
[3]: http://www.redbeanphp.com/
[4]: http://qbnz.com/highlighter/
[5]: https://github.com/sebastianbergmann/phpunit/
[6]: http://codeception.com/
[7]: https://github.com/AlekseyKorzun/reCaptcha-PHP-5
[8]: http://www.achingbrain.net/akismet
[9]: http://www.phpdoc.org/
[10]: http://www.terminally-incoherent.com/blog/2012/12/19/php-like-a-pro-part-2/

[pf]: http://i.imgur.com/KsJa8.png "Paste Form"
[pd]: http://i.imgur.com/FnJIT.png "Paste Display"
