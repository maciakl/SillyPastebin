<?php namespace SillyPastebin\Controller;

use RedBean_Facade as R;

class PasteController
{
    private $twig;

    public function __construct()
    {
        $this->twig = \SillyPastebin\Helper\TwigFactory::getTwig();
    }

    public function showPasteForm() 
    {
        $template = $this->twig->loadTemplate('form.html');
        echo $template->render(array('title' => 'Paste It'));
    }

    /**
     * Adds new paste to the database.
     *
     * @param string $content a new paste content
     * @throws InvalidArgumentException if $content is null or empty
     * @return integer valid pasteID (insertion id) 
     */
    public function addNewPaste($content)
    {
        if(empty($content))
            throw new \InvalidArgumentException("Paste content cannot be empty or null");
        else
        {
            R::setup();
            $paste = R::dispense("paste");

            $paste->content = $content;

            return R::store($paste);
        }
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
            R::setup();
            $paste = R::load("paste", $pasteID);

            $template = $this->twig->loadTemplate('show.html');
            echo $template->render(array('pasteID' => $pasteID,
                                            'content' => $paste->content));

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
