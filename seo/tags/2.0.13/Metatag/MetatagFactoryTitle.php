<?php

namespace tiFy\Plugins\Seo\Metatag;

class MetatagFactoryTitle extends MetatagFactory
{
    /**
     * @inheritdoc
     */
    public function boot()
    {
        $this->sep = ($sep = apply_filters('document_title_separator', '-'))
            ? " {$sep} "
            : '';
    }

    /**
     * @inheritdoc
     */
    public function tag()
    {
        return partial('tag', [
            'tag'     => 'title',
            'attrs'   => [
                'id'    => '',
                'class' => ''
            ],
            'content' => $this->content()
        ]);
    }
}