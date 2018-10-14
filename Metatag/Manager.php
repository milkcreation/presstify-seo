<?php

namespace tiFy\Plugins\Seo\Metatag;

use tiFy\Contracts\Wp\Ctags;
use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Plugins\Seo\Contracts\Metatag;
use tiFy\Plugins\Seo\Contracts\WpMetatag;
use tiFy\Plugins\Seo\SeoResolverTrait;
use tiFy\Route\Route;

class Manager extends AbstractParametersBag
{
    use SeoResolverTrait;

    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [];

    /**
     * Liste des éléments déclarés.
     * @var array
     */
    protected $items = [];

    /**
     * Liste des balises.
     * @var array
     */
    protected $metatags = [
        'title',
        'description',
        'keywords',
        'robots'
    ];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'wp',
            function () {
                if (config('seo.metatag', [])) :
                    $this->metatags = [];
                    foreach(config('seo.metatag', []) as $tag => $values) :
                        if (is_numeric($tag)) :
                            $tag = $values;
                        endif;
                        array_push($this->metatags, $tag);
                    endforeach;
                endif;

                foreach($this->metatags as $tag) :
                    if (!app()->bound("seo.metatag.{$tag}")) :
                        app()->singleton("seo.metatag.{$tag}", function() use ($tag){
                            return app("seo.metatag.item.controller", [$tag]);
                        });
                    endif;

                    if ($value = config("seo.metatag.{$tag}")) :
                        /** @var Metatag $metatag */
                        $metatag = app("seo.metatag.{$tag}");
                        if (is_string($value)) :
                            $metatag->add($value);
                        elseif (is_array($value)) :
                            foreach($value as $k => $v) :
                                $metatag->add($v, $k);
                            endforeach;
                        endif;
                    endif;
                endforeach;

                /** @var Route $router */
                $router = app(Route::class);
                /** @var Ctags $ctags */
                $ctags = app('wp.ctags');

                $tags = [];
                if (($c = $router->currentName()) || ($c = $ctags->current())) :
                    foreach($this->metatags as $tag) :
                        /** @var Metatag $metatag */
                        $metatag = app("seo.metatag.{$tag}");
                        $tags[$tag] = $metatag->get($c);
                    endforeach;
                endif;

                foreach($this->metatags as $tag) :
                    if (empty($tags[$tag])) :
                        /** @var Metatag $metatag */
                        $metatag = app("seo.metatag.{$tag}");
                        $tags[$tag] = $metatag->get();
                    endif;
                endforeach;

                if ($ctags->current()) :
                    foreach($this->metatags as $tag) :
                        if (empty($tags[$tag]) && app()->bound("seo.wp.metatag.{$tag}")) :
                            /** @var WpMetatag $wpMetatag */
                            $wpMetatag = app("seo.wp.metatag.{$tag}");
                            $tags[$tag] = $wpMetatag->get();
                        endif;
                    endforeach;
                endif;

                foreach($tags as $name => $value) :
                    /** @var Metatag $metatag */
                    $metatag = app("seo.metatag.{$name}");
                    $metatag->set($value);
                    $this->items[$name] = $metatag;
                endforeach;
            },
            999999
        );

        if (has_action('wp_head', '_wp_render_title_tag') == 1) :
            remove_action('wp_head', '_wp_render_title_tag', 1);
            add_action(
                'wp_head',
                function () {
                    foreach($this->items as $item) :
                        echo $item;
                    endforeach;
                },
                1
            );
        endif;
    }
}