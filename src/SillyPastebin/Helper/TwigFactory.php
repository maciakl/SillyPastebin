<?php namespace SillyPastebin\Helper;

class TwigFactory
{
    public static function getTwig()
    {
        $loader = new \Twig_Loader_Filesystem('templates');
        return new \Twig_Environment($loader, array('debug' => true, 
                                                     'autoescape' => true, 
                                                      'auto_reload' => true));
    }
}
