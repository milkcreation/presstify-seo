<?php

namespace tiFy\Plugins\Seo\Metatag;

class Robots extends AbstractMetatag
{
    /**
     * {@inheritdoc}
     */
    public function content()
    {
        return $this->content ? : 'index, follow';
    }
}