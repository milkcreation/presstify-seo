<?php

namespace tiFy\Plugins\Seo;

use tiFy\App\Container\AppServiceProvider;
use tiFy\Plugins\Seo\GoogleAnalytics\GoogleAnalytics;
use tiFy\Plugins\Seo\Metatag\MetatagFactory;
use tiFy\Plugins\Seo\Metatag\MetatagFactoryDescription;
use tiFy\Plugins\Seo\Metatag\MetatagFactoryRobots;
use tiFy\Plugins\Seo\Metatag\MetatagFactoryTitle;
use tiFy\Plugins\Seo\Metatag\MetatagManager;
use tiFy\Plugins\Seo\Opengraph\Opengraph;
use tiFy\Plugins\Seo\Wordpress\WpManager;
use tiFy\Plugins\Seo\Wordpress\Metatag\WpMetatagFactoryDescription;
use tiFy\Plugins\Seo\Wordpress\Metatag\WpMetatagFactoryTitle;

class SeoServiceProvider extends AppServiceProvider
{
    /**
     * Liste des noms de qualification des services fournis.
     * @internal requis. Tous les noms de qualification de services à traiter doivent être renseignés.
     * @var string[]
     */
    protected $provides = [
        'seo',
        'seo.google-analytics',
        'seo.metatag',
        'seo.metatag.factory',
        'seo.metatag.factory.description',
        'seo.metatag.factory.robots',
        'seo.metatag.factory.title',
        'seo.opengraph',
        'seo.viewer',
        'seo.wp',
        'seo.wp.metatag.description',
        'seo.wp.metatag.title'
    ];

    /**
     * @inheritdoc
     */
    public function boot()
    {
        add_action('after_setup_theme', function () {
            $this->getContainer()->get('seo');
            $this->getContainer()->get('seo.wp');
        });
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->getContainer()->share('seo', function () {
            return new SeoManager();
        });

        $this->getContainer()->share('seo.google-analytics', function () {
            return new GoogleAnalytics($this->getContainer()->get('seo'));
        });

        $this->getContainer()->share('seo.metatag', function () {
            return new MetatagManager($this->getContainer()->get('seo'));
        });

        $this->getContainer()->add('seo.metatag.factory', function ($name) {
            return new MetatagFactory($name);
        });

        $this->getContainer()->share('seo.metatag.factory.description', function () {
            return new MetatagFactoryDescription('description');
        });

        $this->getContainer()->share('seo.metatag.factory.robots', function () {
            return new MetatagFactoryRobots('robots');
        });

        $this->getContainer()->share('seo.metatag.factory.title', function () {
            return new MetatagFactoryTitle('title');
        });

        $this->getContainer()->share('seo.opengraph', function () {
            return new Opengraph($this->getContainer()->get('seo'));
        });

        $this->getContainer()->share('seo.wp', function () {
            return new WpManager($this->getContainer()->get('seo'));
        });

        $this->getContainer()->share('seo.wp.metatag.description', function () {
            return new WpMetatagFactoryDescription();
        });

        $this->getContainer()->share('seo.wp.metatag.title', function () {
            return new WpMetatagFactoryTitle();
        });

        $this->getContainer()->share('seo.viewer', function () {
            $default_dir = $this->getContainer()->get('seo')->resourcesDir('/views');

            return view()
                ->setDirectory(is_dir($default_dir) ? $default_dir : null)
                ->setOverrideDir($default_dir);
        });
    }
}