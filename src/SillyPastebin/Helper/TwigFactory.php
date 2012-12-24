<?php namespace SillyPastebin\Helper;

/**
 * A factory class which provides pre-configured Twig Templating engine objects.
 */
class TwigFactory
{
    /**
     * Returns a preconfigured Twig Environment object.
     *
     * @return \Twig_Environment a preconfigured Twig Environment object
     */
    public static function getTwig()
    {
        $loader = new \Twig_Loader_Filesystem('templates');
        return new \Twig_Environment($loader, array('debug' => true, 
                                                     'autoescape' => true, 
                                                      'auto_reload' => true));
    }
}
