<?php

namespace tiFy\Plugins\Seo\GoogleAnalytics;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Kernel\Params\ParamsBag;
use tiFy\Plugins\Seo\Metabox\OptionsGoogleAnalytics\OptionsGoogleAnalytics;
use tiFy\Plugins\Seo\SeoResolverTrait;

class GoogleAnalytics extends ParamsBag
{
    use SeoResolverTrait;

    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [
        'admin'   => true,
        'ua_code' => ''
    ];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'wp_head',
            function () {
                if ($ua_code = $this->get('ua_code')) :
                    echo $this->viewer('gtag', ['ua_code' => $ua_code])->render();
                endif;
            },
            999999
        );

        add_action(
            'init',
            function () {
                $attrs = config('seo.google_analytics', []);
                $this->parse($attrs);

                if ($this->get('admin')) :
                    app('seo')->addOptionsMetabox(
                        'SeoOptionsGoogleAnalytics',
                        [
                            'content'   => OptionsGoogleAnalytics::class
                        ]
                    );
                endif;
            },
            999998
        );
    }

    /**
     * {@inheritdoc}
     */
    public function parse($attrs = [])
    {
        parent::parse($attrs);

        $this->set(
            'ua_code',
            get_option('seo_ua_code') ? : config('seo.google_analytics.ua_code', '')
        );
    }
}