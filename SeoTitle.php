<?php

namespace tiFy\Plugins\Seo;

class SeoTitle
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'after_setup_theme',
            function () {
                add_theme_support('title-tag');
            }
        );
    }

    /**
     * Résolution de sortie de la classe en tant que chaîne de caractère.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) partial(
            'tag',
            [
                'tag'       => 'title',
                'content'   => $this->getContent()
            ]
        );
    }

    /**
     * Récupération du contenu de la balise.
     *
     * @return string
     */
    public function getContent()
    {
        $title = wp_get_document_title();

        return esc_attr(
            strip_tags(
                stripslashes($title)
            )
        );
    }
}