<?php

namespace tiFy\Plugins\Seo\Opengraph;

use tiFy\Kernel\Params\ParamsBag;
use tiFy\Plugins\Seo\Metabox\OptionsOpengraph\OptionsOpengraph;
use tiFy\Plugins\Seo\SeoResolverTrait;

class Opengraph extends ParamsBag
{
    use SeoResolverTrait;

    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [
        'admin'   => true
    ];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'init',
            function () {
                $attrs = config('seo.opengraph', []);
                $this->parse($attrs);

                if ($this->get('admin')) :
                    app('seo')->addOptionsMetabox(
                        'SeoOptionsOpengraph',
                        [
                            'parent'    => 'SeoOptions',
                            'content'   => OptionsOpengraph::class
                        ]
                    );
                endif;
            },
            999998
        );

        add_filter(
            'language_attributes',
            function ($output) {
                return is_admin() ? $output : $output . ' xmlns:og="http://opengraphprotocol.org/schema/"';
            }
        );
    }
}