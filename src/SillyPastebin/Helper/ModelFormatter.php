<?php namespace SillyPastebin\Helper;

/**
 * Defines custom name binding rules for RedBean's FUSE engine.
 *
 * Silly Pastebin uses namespaces and naming conventions that are different
 * from those used by RedBean so this class helps to map beans to corresponding
 * object classes.
 */
class ModelFormatter implements \RedBean_IModelFormatter
{
    /**
     * Returns a format model object that helps RedBean find Model classes.
     *
     */
    public function formatModel($model)
    {
        return "\\SillyPastebin\\Model\\".$model;
    }
}

