<?php

namespace tiFy\Plugins\Seo\Opengraph;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Plugins\Seo\Metabox\OptionsOpengraph\OptionsOpengraph;

class Opengraph extends AbstractParametersBag
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', function () {
            $attrs = config('seo.opengraph', []);
            $this->parse($attrs);

            /** @var MetaboxManager $metabox */
            $metabox = resolve('metabox');

            $metabox
                ->add(
                    'SeoOptionsOpengraph',
                    'tify_options@options',
                    [
                        'parent'    => 'SeoOptions',
                        'content'   => OptionsOpengraph::class,
                        'position'  => 2
                    ]
                );
            },
            999999
        );

        add_filter(
            'language_attributes',
            function ($output) {
                return is_admin() ? $output : $output . ' xmlns:og="http://opengraphprotocol.org/schema/"';
            }
        );
    }
}