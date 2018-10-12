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
        $this->app->singleton('seo', function() {return new Seo();})->build();
        $this->app->singleton('seo.description', function() {return new SeoDescription();})->build();
        $this->app->singleton('seo.google.analytics', function() {return new SeoGoogleAnalytics();})->build();
        $this->app->singleton('seo.meta.tag', function() {return new SeoMetaTag();})->build();
        $this->app->singleton('seo.open.graph', function() {return new SeoOpenGraph();})->build();
        $this->app->singleton('seo.title', function() {return new SeoTitle();})->build();
        $this->app->singleton('seo.wp.title', function() {return new SeoWpTitle();})->build();
    }
}