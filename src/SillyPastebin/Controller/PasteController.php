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

    public function addNewPaste()
    {
        if(empty($_POST["content"]))
            throw new \InvalidArgumentException("Submitted content empty or null");

        R::setup();
        $paste = R::dispense("paste");

        $paste->content = $_POST["content"];

        return R::store($paste);
    }

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
