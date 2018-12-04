<?php

namespace tiFy\Plugins\Seo;

use tiFy\App\Container\AppServiceProvider;
use tiFy\Plugins\Seo\GoogleAnalytics\GoogleAnalytics;
use tiFy\Plugins\Seo\Metatag\Description as MetatagDescription;
use tiFy\Plugins\Seo\Metatag\Manager as MetatagManager;
use tiFy\Plugins\Seo\Metatag\MetatagItemController;
use tiFy\Plugins\Seo\Metatag\Robots as MetatagRobots;
use tiFy\Plugins\Seo\Metatag\Title as MetatagTitle;
use tiFy\Plugins\Seo\Opengraph\Opengraph;
use tiFy\Plugins\Seo\Wp\Manager as WpManager;
use tiFy\Plugins\Seo\Wp\MetatagDescription as WpMetatagDescription;
use tiFy\Plugins\Seo\Wp\MetatagTitle as WpMetatagTitle;

class SeoServiceProvider extends AppServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->app->singleton('seo', function () {
            return new SeoManager();
        })->build();

        $this->app->singleton('seo.google.analytics', function () {
            return new GoogleAnalytics();
        })->build();

        $this->app->singleton('seo.metatag.description', function () {
            return new MetatagDescription();
        })->build();
        $this->app->singleton('seo.metatag.manager', function () {
            return new MetatagManager();
        })->build();
        $this->app->bind('seo.metatag.item.controller', function ($name) {
            return new MetatagItemController($name);
        });
        $this->app->singleton('seo.metatag.robots', function () {
            return new MetatagRobots();
        })->build();
        $this->app->singleton('seo.metatag.title', function () {
            return new MetatagTitle();
        })->build();

        $this->app->singleton('seo.opengraph', function () {
            return new Opengraph();
        })->build();

        $this->app->singleton('seo.wp.manager', function () {
            return new WpManager();
        })->build();
        $this->app->singleton('seo.wp.metatag.description', function () {
            return new WpMetatagDescription();
        })->build();
        $this->app->singleton('seo.wp.metatag.title', function () {
            return new WpMetatagTitle();
        })->build();
    }
}