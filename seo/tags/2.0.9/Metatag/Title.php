<?php

namespace tiFy\Plugins\Seo\Metatag;

use Illuminate\Support\Arr;

class Title extends AbstractMetatag
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sep = ($sep = apply_filters('document_title_separator', '-'))
            ? " {$sep} "
            : '';
    }

    /**
     * {@inheritdoc}
     */
    public function tag()
    {
        return partial(
            'tag',
            [
                'tag'     => 'title',
                'attrs'   => [
                    'id'    => '',
                    'class' => ''
                ],
                'content' => $this->content()
            ]
        );
    }
}