<?php

namespace tiFy\Plugins\Seo\Metatag;

use tiFy\Contracts\Wp\Ctags;
use tiFy\Plugins\Seo\Contracts\Metatag;
use tiFy\Plugins\Seo\Contracts\WpMetatag;
use tiFy\Plugins\Seo\SeoResolverTrait;
use tiFy\Route\Route;

class Manager
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
                foreach(config('seo.metatag', []) as $tag => $values) :
                    if (is_numeric($tag)) :
                        $tag = $values;
                    endif;

                    if (!in_array($tag, $this->metatags)) :
                        array_push($this->metatags, $tag);
                    endif;
                endforeach;

                /** @var Route $router */
                $router = app(Route::class);
                /** @var Ctags $ctags */
                $ctags = app('wp.ctags');

                $tags = [];
                if (($c = $router->currentName()) || ($c = $ctags->current())) :
                    reset($this->metatags);
                    foreach($this->metatags as $tag) :
                        $tags[$tag] = null;
                        $metatag = $this->make($tag);

                        while(is_null($tags[$tag])) :
                            // Récupération des valeurs de contexte défini.
                            if ($tags[$tag] = $metatag->get($c)) :
                                break;
                            endif;

                            // Récupération des valeurs de contexte depuis le fichier de configuration.
                            $value = config("seo.metatag.{$tag}.{$c}");
                            if (!is_null($value)) :
                                $metatag->add($value, $c);
                                $tags[$tag] = $metatag->get($c);
                                break;
                            endif;

                            // Récupération des valeurs de contexte Wordpress.
                            if ($ctags->current() && app()->bound("seo.wp.metatag.{$tag}")) :
                                /** @var WpMetatag $wpMetatag */
                                $wpMetatag = app("seo.wp.metatag.{$tag}");
                                $tags[$tag] = $wpMetatag->get();
                                break;
                            endif;

                            // Récupération des valeurs du contexte global défini.
                            if  ($tags[$tag] = $metatag->get('*')) :
                                break;
                            endif;

                            // Récupération des valeurs de contexte global depuis le fichier de configuration.
                            $value = config("seo.metatag.{$tag}");
                            if (is_string($value) || ($value === false)) :
                                $tags[$tag] = $value;
                            elseif (is_array($value) && isset($value['*'])) :
                                $tags[$tag] = $value['*'];
                            endif;
                        endwhile;
                    endforeach;
                endif;

                foreach($tags as $name => $value) :
                    /** @var Metatag $metatag */
                    $metatag = app("seo.metatag.{$name}");
                    if ($value !== false) :
                        $metatag->set($value);
                        $this->items[$name] = $metatag;
                    endif;
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

    /**
     * Ajout d'une valeur de méta-balise selon son contexte d'affichage.
     *
     * @param string $tag Nom de qualification de la méta-balise.
     * @param string $value Valeur de la méta-balise.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function add($tag, $value = '', $context = '*')
    {
        $metatag = $this->make($tag);
        $metatag->add($value, $context);

        return $this;
    }

    /**
     * Création d'une instance de controleur de méta-balise.
     *
     * @param string $tag Nom de qualification de la méta-balise.
     *
     * @return Metatag
     */
    public function make($tag)
    {
        if (!app()->bound("seo.metatag.{$tag}")) :
            app()->singleton("seo.metatag.{$tag}", function() use ($tag){
                return app("seo.metatag.item.controller", [$tag]);
            });
        endif;

        return app("seo.metatag.{$tag}");
    }
}