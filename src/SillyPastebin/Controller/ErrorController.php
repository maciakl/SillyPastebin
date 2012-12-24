<?php namespace SillyPastebin\Controller;

class ErrorController
{
    private $twig;

    public function __construct()
    {
        $this->twig = \SillyPastebin\Helper\TwigFactory::getTwig();
    }

    public function show404()
    {
        //header('HTTP/1.0 404 Not Found');
        $template = $this->twig->loadTemplate("404.html");
        echo $template->render(array('title'=>'404'));
    }

    public function showGenericError($errorMessage)
    {
        $message = empty($errorMessage) ? "Unexpected error." : $errorMessage;

        $template = $this->twig->loadTemplate("error.html");
        echo $template->render(array('title' => 'Error', 'errorMessage' => $message));
    }
}
