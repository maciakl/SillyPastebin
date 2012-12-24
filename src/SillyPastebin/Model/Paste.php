<?php namespace SillyPastebin\Model;

/**
 * Model for the Paste table in the database.
 *
 * Using RedBean conventions for model creation. This class is bound to a
 * RedBean bean using FUSE. When a bean is stored, the update method is
 * triggered to perform validation.
 */
class Paste extends \RedBean_SimpleModel
{
    /**
     * Gets called whenever the paste bean is being stored into the db. This
     * method performs validation checks. The instance variables are
     * inherited from the RedBean bean object.
     *
     * @throws InvalidArgumentException if $this->content is empty
     */
    public function update()
    {
        if(empty($this->language))
            $this->language = 'text';

        if(empty($this->content))
            throw \InvalidArgumentException("Paste cannot be empty or null");
    }
}
