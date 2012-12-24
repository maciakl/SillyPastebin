<?php namespace SillyPastebin\Controller;

// we're using RedBean installed via Composer. In the Composer version
// the R class is not available. R class is an auto-generated class
// which includes entire RedBean codebase, and uses RedBean_Facade as
// user interface. Sice we don't have that we just rename RedBean_Facade
// as R to keep the usage consistent with RedBean documentation
use RedBean_Facade as R;

/**
 * Handles adding new pastes, and displaying existing pastes
 *
 */
class PasteController
{
    private $twig;

    public function __construct()
    {
        $this->twig = \SillyPastebin\Helper\TwigFactory::getTwig();

        if(\SillyPastebin\Config::dev_mode_enabled)
        {
            // in dev mode we use SQLite instead of MySQL
            // the SQLite db is located in /tmp/red.db
            // note - this mode sometimes locks
            R::setup();
        }
        else
        {
            // these values are defined in src/SillyPastebin/Config.php

            $host = \SillyPastebin\Config::mysql_host;
            $db = \SillyPastebin\Config::mysql_db;
            $user = \SillyPastebin\Config::mysql_user;
            $pwd = \SillyPastebin\Config::mysql_password;

            R::setup('mysql:host='.$host.';dbname='.$db, $user, $pwd);
        }

        // only for production - freezes database schema and prevents
        // RedBean from creating tables if they don't exist yet
        if(\SillyPastebin\Config::production_mode_enabled)
            R::freeze( true );

        // enables RedBean to find src/SillyPastebin/Model/Paste.php
        // needed because we use different naming conventions than RedBean
        \RedBean_ModelHelper::setModelFormatter(new \SillyPastebin\Helper\ModelFormatter());

    }

    /**
     * Displays a blank form using Twig template.
     *
     */
    public function showPasteForm() 
    {
        $template = $this->twig->loadTemplate('form.html');
        echo $template->render(array('title' => 'Paste It'));
    }

    /**
     * Adds new paste to the database.
     *
     * @param string $content a new paste content
     * @param string $language a GeSHi suppoerted language (default is text)
     * @throws InvalidArgumentException if $content is null or empty
     * @return integer valid pasteID (insertion id) 
     */
    public function addNewPaste($content, $language='text')
    {
        if(empty($content))
            throw new \InvalidArgumentException("Paste content cannot be empty or null");
        else
        {
            $paste = R::dispense("paste");

            $paste->content = $content;
            $paste->language = $language;

            return R::store($paste);
        }
    }

    /**
     * Renders a thank-you message with a link to a newly created paste
     *
     * @param integer $pasteID - a valid paste ID
     */
    public function showThankYou($pasteID)
    {
        echo $this->twig->render("thanks.html", array('title' => 'Thanks', 
                                                      'pasteID' => $pasteID));
    }

    /**
     * Renders a paste as a web page.
     *
     * @param string $uri A valid URI with a paste address
     * @throws InvalidArgumentException if the URI is invalid
     */
    public function showPasteContent($uri)
    {
        if(!$this->isValidPasteURI($uri))
            throw new \InvalidArgumentException("Invalid paste ID");
        else
        {
            $pasteID = substr($uri, 1);
            $paste = R::load("paste", $pasteID);

            if(empty($paste->content))
            {
                echo $this->twig->render("nosuchpaste.html", array('title' => 'No such paste',
                                                                   'pasteID' => $pasteID));
            }
            else
            {
                if($paste->language == 'text' or empty($paste->language))
                    $highlighted = $paste->content;
                else
                {
                    $geshi = new \GeSHi($paste->content, $paste->language);
                    $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
                    $highlighted = $geshi->parse_code();
                }
                echo $this->twig->render("show.html", array('pasteID' => $pasteID,
                                                            'title' => "Paste #".$pasteID,
                                                            'content' => $highlighted,
                                                            'raw_content' => $paste->content));
            }

        }

    }

    /**
     * Returns true if $uri contains a valid (numeric) paste id.
     *
     * A valud URI should looke like /234 - anything else is not valid
     *
     * @param string $uri a REQUEST_URI value that should be numeric
     * @return boolean tru if URI is valud, false if it is not
     */
    public static function isValidPasteURI($uri)
    {
        // if starts with  
        if(strpos($uri, "/") === 0)
        {
            $tmp = substr($uri, 1);

            if(is_numeric($tmp) && $tmp > 0)
                return true;
        }

        return false;
    }
}
