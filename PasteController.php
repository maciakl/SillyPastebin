<?php

class PasteController
{

    private $twig;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem('templates');
        $this->twig = new Twig_Environment($loader, array('debug' => true, 
                                                            'autoescape' => true, 
                                                            'auto_reload' => true));

    }

    public function showPasteForm() 
    {
        $template = $this->twig->loadTemplate('form.html');
        echo $template->render(array('title' => 'Paste It'));
    }

    public function addNewPaste()
    {

    }

    public function showPasteContent($uri)
    {

    }

    public function show404()
    {

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

            if(is_numeric($tmp))
                return true;
        }

        return false;
    }
}
