<?php

namespace tiFy\Plugins\Seo\Metatag;

use tiFy\Plugins\Seo\Contracts\Metatag;

abstract class AbstractMetatag implements Metatag
{
    /**
     * Liste des éléments de clotûre déclarés par contexte.
     * @var string[]
     */
    protected $appends = [];

    /**
     * Valeur du contenu de la balise.
     * @var string
     */
    protected $content = '';

    /**
     * Liste des éléments déclarés par contexte.
     * @var array
     */
    protected $items = [];

    /**
     * Caractère de séparation des éléments de contenu.
     * @var string
     */
    protected $sep = ', ';

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->tag();
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function clear($context = '*')
    {
        if (isset($this->items[$context])) :
            unset($this->items[$context]);
        endif;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($context = '*')
    {
        $items = [];
        if (isset($this->items[$context])) :
            $items = $this->items[$context];
        endif;

        if (isset($this->appends[$context])) :
            $items[] = $this->appends[$context];
        endif;

        return $items;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return class_info($this)->getKebabName();
    }

    /**
     * {@inheritdoc}
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function tag()
    {
        return partial(
            'tag',
            [
                'tag'     => 'meta',
                'attrs'   => [
                    'id'    => '',
                    'class' => '',
                    'name'  => $this->getName(),
                    'content' => $this->content(),
                ]
            ]
        );
    }
}