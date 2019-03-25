<?php

namespace tiFy\Plugins\Seo\GoogleAnalytics;

use tiFy\Support\ParamsBag;
use tiFy\Plugins\Seo\Contracts\GoogleAnalytics as GoogleAnalyticsContract;
use tiFy\Plugins\Seo\Contracts\SeoManager;
use tiFy\Plugins\Seo\Metabox\OptionsGoogleAnalytics\OptionsGoogleAnalytics;

class GoogleAnalytics extends ParamsBag implements GoogleAnalyticsContract
{
    /**
     * Instance du gestionnaire de référencement.
     * @var SeoManager
     */
    protected $manager;

    /**
     * CONSTRUCTEUR.
     *
     * @param SeoManager $manager Instance du gestionnaire de référencement.
     *
     * @return void
     */
    public function __construct(SeoManager $manager)
    {
        $this->manager = $manager;

        add_action('init', function () {
            $this->set(config('seo.google_analytics', []))->parse();

            if ($this->get('admin')) {
                $this->manager->addOptionsMetabox('SeoOptionsGoogleAnalytics', [
                    'content' => OptionsGoogleAnalytics::class,
                ]);
            }
        }, 999998);

        add_action('wp_head', function () {
            if ($ua_code = $this->get('ua_code')) {
                echo $this->manager->viewer('gtag', ['ua_code' => $ua_code])->render();
            }
        }, 999999);
    }

    /**
     * @inheritdoc
     */
    public function defaults()
    {
        return [
            'admin'   => true,
            'ua_code' => '',
        ];
    }

    /**
     * @inheritdoc
     */
    public function parse()
    {
        parent::parse();

        $this->set('ua_code', get_option('seo_ua_code') ?: config('seo.google_analytics.ua_code', ''));
    }
}