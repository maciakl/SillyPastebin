<?php namespace SillyPastebin;
/**
 * Global configuration file.
 *
 */
class Config
{
    /**
     * Enable Development Mode.
     *
     * In Dev-Mode Silly Pastebin will use a temporary SQLite database
     * instead of MySQL. The SQLite DB will be stored in:
     *
     *   /tmp/red.db
     *
     *  If this value is set to false, SillyPastebin will attempt to use
     * MySQL database located at mysql_host defined below.
     *
     */
    const dev_mode_enabled = true;

    /**
     * Enable Producton Mode.
     *
     * In Production Mode Silly Pastebin freezes the DB schema so that the
     * RedBean ORM cannot further modify it.
     */
    const production_mode_enabled = false;

    /**
     * The hostname or IP of MySQL host
     */
    const mysql_host = 'localhost';

    /**
     * MySQL database name
     */
    const mysql_db = "silly_db";

    /**
     * MySQL user name
     */
    const mysql_user = "silly_user";

    /**
     * MySQL password
     */
    const mysql_password = "some_silly_password";
}
