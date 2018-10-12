<?php

namespace tiFy\Plugins\Seo;

use Illuminate\Support\Arr;
use tiFy\Route\Route;

class SeoTitle
{
    /**
     * Liste des éléments de finaux déclarés par contexte.
     * @var string[]
     */
    protected $appends = [];

    /**
     * Liste des éléments de titre déclarés par contexte.
     * @var array
     */
    protected $items = [];

    /**
     * Liste des éléments du titre courant.
     * @var array
     */
    protected $title = [];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_filter(
            'document_title_parts',
            function (array $title) {
                return $this->title ?: $title;
            },
            99
        );

        add_action(
            'wp',
            function () {
                if ((($c = app(Route::class)->currentName()) || ($c = app('wp.ctags')->current())) && isset($this->items[$c])) :
                    $this->title = $this->items[$c];
                    if (isset($this->appends[$c])) :
                        $this->title[] = $this->appends[$c];
                    elseif (isset($this->appends['*'])) :
                        $this->title[] = $this->appends['*'];
                    endif;
                endif;

                if (!$this->title && isset($this->items['*'])) :
                    $this->title = $this->items['*'];
                    if (isset($this->appends['*'])) :
                        $this->title[] = $this->appends['*'];
                    endif;
                endif;
            },
            999999
        );

        if (has_action('wp_head', '_wp_render_title_tag') == 1) :
            remove_action('wp_head', '_wp_render_title_tag', 1);
            add_action('wp_head', function () { echo $this; }, 1);
        endif;
    }

    /**
     * Résolution de sortie de la classe en tant que chaîne de caractère.
     *
     * @return string
     */
    public function __toString()
    {
        return (string)partial(
            'tag',
            [
                'tag'     => 'title',
                'attrs'   => [
                    'id'    => '',
                    'class' => '',
                ],
                'content' => wp_get_document_title()
            ]
        );
    }

    /**
     * Ajout d'un élément au titre de la page selon son contexte d'affichage.
     *
     * @param array|string Valeur de l'intitulé.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function add($title, $context = '*')
    {
        if (!isset($this->items[$context])) :
            $this->items[$context] = [];
        endif;

        if (is_string($title)) :
            array_push($this->items[$context], $title);
        elseif (is_array($title)) :
            $this->items[$context] += $title;
        endif;

        return $this;
    }

    /**
     * Déclaration d'un élément de cloture du titre de la page selon son contexte d'affichage.
     *
     * @param string Valeur de l'élément de cloture.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function append($content, $context = '*')
    {
        if (!isset($this->appends[$context])) :
            $this->appends[$context] = [];
        endif;

        $this->appends[$context] = $content;

        return $this;
    }

    /**
     * Suppression des éléments du titre de la page selon le contexte d'affichage.
     *
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function clear($context = '*')
    {
        if (isset($this->items[$context])) :
            unset($this->items[$context]);
        endif;

        return $this;
    }

    /**
     * Récupération du contenu de la balise.
     *
     * @return string
     */
    public function getContent()
    {
        return esc_attr(
            strip_tags(
                stripslashes($this->title)
            )
        );
    }
}