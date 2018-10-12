<?php

namespace tiFy\Plugins\Seo;

use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Metabox\Metabox;
use tiFy\Plugins\Seo\Metabox\OptionsOpenGraph\OptionsOpenGraph;

class SeoOpenGraph extends AbstractParametersBag
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', function () {
            $attrs = config('seo.open_graph', []);
            $this->parse($attrs);

            /** @var Metabox $metabox */
            $metabox = resolve(Metabox::class);

            $metabox
                ->add(
                    'tify_options@options',
                    [
                        'name'      => 'SeoOptionsOpenGraph',
                        'parent'    => 'SeoOptions',
                        'content'   => OptionsOpenGraph::class,
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