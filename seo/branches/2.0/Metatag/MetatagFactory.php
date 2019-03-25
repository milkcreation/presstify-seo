<?php

namespace tiFy\Plugins\Seo\Metatag;

use tiFy\Plugins\Seo\Contracts\MetatagFactory as MetatagFactoryContract;

class MetatagFactory implements MetatagFactoryContract
{
    /**
     * Valeur du contenu de la balise.
     * @var string
     */
    protected $content = '';

    /**
     * Liste des éléments de clotûre déclarés par contexte.
     * @var string[]
     */
    protected $ends = [];

    /**
     * Liste des éléments déclarés par contexte.
     * @var array
     */
    protected $items = [];

    /**
     * Nom de qualification.
     * @var string
     */
    protected $name = '';

    /**
     * Caractère de séparation des éléments de contenu.
     * @var string
     */
    protected $sep = ', ';

    /**
     * CONSTRUCTEUR.
     *
     * @param string $name Nom de qualification.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return (string)$this->tag();
    }

    /**
     * @inheritdoc
     */
    public function add($value, $context = '*')
    {
        if (!isset($this->items[$context])) :
            $this->items[$context] = [];
        endif;

        array_push($this->items[$context], $value);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {

    }

    /**
     * @inheritdoc
     */
    public function clear($context = '*')
    {
        if (isset($this->items[$context])) :
            unset($this->items[$context]);
        endif;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function end($value = '', $context = '*')
    {
        if (!isset($this->ends[$context])) :
            $this->ends[$context] = [];
        endif;

        $this->ends[$context] = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function get($context = '*')
    {
        $items = [];
        if (isset($this->items[$context])) :
            $items = $this->items[$context];
        endif;

        if (!empty($items)) :
            if (isset($this->ends[$context])) :
                $items[] = $this->ends[$context];
            elseif (($context !== '*') && isset($this->ends['*'])) :
                $items[] = $this->ends['*'];
            endif;
        endif;

        return $items;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function set($content)
    {
        if (is_array($content)) :
            $content = implode($this->sep ? $this->sep : '', array_filter($content));
        endif;

        $content = wptexturize($content);
        $content = convert_chars($content);
        return $this->content = esc_html($content);
    }

    /**
     * @inheritdoc
     */
    public function tag()
    {
        return partial('tag', [
            'tag'     => 'meta',
            'attrs'   => [
                'id'    => '',
                'class' => '',
                'name'  => $this->getName(),
                'content' => $this->content(),
            ]
        ]);
    }
}