<?php namespace SillyPastebin\Controller;

/**
 * Handles displaying errors not directly related to pastes.
 *
 * @uses \SillyPastebin\Helper\TwigFactory
 */
class ErrorController
{
    /**
     * Twig templating engine environment. Initialized in constructor.
     */
    private $twig;

    /**
     * Default constructor. Initializes the Twig environment.
     */
    public function __construct()
    {
        $this->twig = \SillyPastebin\Helper\TwigFactory::getTwig();
    }

    /**
     * Displays a 404 page not found error usign Twig template
     */
    public function show404()
    {
        //header('HTTP/1.0 404 Not Found');
        $template = $this->twig->loadTemplate("404.html");
        echo $template->render(array('title'=>'404'));
    }

    /**
     * Displays generic error message using Twig template.
     *
     * @param string $errorMessage - a message to be displayed.
     */
    public function showGenericError($errorMessage)
    {
        $message = empty($errorMessage) ? "Unexpected error." : $errorMessage;

        $template = $this->twig->loadTemplate("error.html");
        echo $template->render(array('title' => 'Error', 'errorMessage' => $message));
    }
}
