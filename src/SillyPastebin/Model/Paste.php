<?php namespace SillyPastebin\Model;

class Paste extends \RedBean_SimpleModel
{
    public function update()
    {
        if(empty($this->language))
            $this->language = 'text';

        if(empty($this->content))
            throw \InvalidArgumentException("Paste cannot be empty or null");
    }
}
