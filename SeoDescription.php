<?php

namespace tiFy\Plugins\Seo;

class SeoDescription
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {

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
                'tag'       => 'meta',
                [
                    'name'      => 'description',
                    'content'   => $this->getContent()
                ]
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
        $desc = '';

        return esc_attr(
            strip_tags(
                stripslashes($desc)
            )
        );
    }
}