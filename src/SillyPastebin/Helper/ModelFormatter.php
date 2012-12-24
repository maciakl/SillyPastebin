<?php namespace SillyPastebin\Helper;

class ModelFormatter implements \RedBean_IModelFormatter
{
    public function formatModel($model)
    {
        return "\\SillyPastebin\\Model\\".$model;
    }
}

