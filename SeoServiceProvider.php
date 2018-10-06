<?php

namespace tiFy\Plugins\Seo;

use tiFy\App\Container\AppServiceProvider;
use tiFy\Plugins\Seo\Seo;
use tiFy\Plugins\Seo\SeoDescription;
use tiFy\Plugins\Seo\SeoGoogleAnalytics;
use tiFy\Plugins\Seo\SeoMetaTag;
use tiFy\Plugins\Seo\SeoOpenGraph;
use tiFy\Plugins\Seo\SeoTitle;
use tiFy\Plugins\Seo\Wp\SeoWpTitle;

class SeoServiceProvider extends AppServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $singletons = [
        Seo::class,
        SeoDescription::class,
        SeoGoogleAnalytics::class,
        SeoMetaTag::class,
        SeoOpenGraph::class,
        SeoTitle::class,
        SeoWpTitle::class
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->app->resolve(Seo::class);
        $this->app->resolve(SeoDescription::class);
        $this->app->resolve(SeoGoogleAnalytics::class);
        $this->app->resolve(SeoMetaTag::class);
        $this->app->resolve(SeoOpenGraph::class);
        $this->app->resolve(SeoTitle::class);
        $this->app->resolve(SeoWpTitle::class);
    }
}