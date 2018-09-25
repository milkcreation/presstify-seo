<?php

namespace tiFy\Plugins\Seo;

use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Metabox\Metabox;
use tiFy\Plugins\Seo\Metabox\OptionsGoogleAnalytics\OptionsGoogleAnalytics;
use tiFy\Plugins\Seo\SeoResolverTrait;

class SeoGoogleAnalytics extends AbstractParametersBag
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

        add_action('init', function () {
            $attrs = config('seo.google_analytics', []);
            $this->parse($attrs);

            /** @var Metabox $metabox */
            $metabox = resolve(Metabox::class);
            $metabox
                ->add(
                    'tify_options@options',
                    [
                        'name'      => 'SeoOptionsGoogleAnalytics',
                        'parent'    => 'SeoOptions',
                        'content'   => OptionsGoogleAnalytics::class,
                        'position'  => 1
                    ]
                );
            },
            999999
        );
    }

    /**
     * {@inheritdoc}
     */
    public function defaults($attrs = [])
    {
        return [
            'ua_code' => get_option('seo_ua_code', '')
        ];
    }
}