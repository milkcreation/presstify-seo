<?php

/**
 * Exemple de configuration.
 */

return [
    /**
     * Configuration des balises de référencement.
     * {@internal Usage :
     * - cas 1 :    ex. title
     *              Déclaration du nom de qualification de la balise en indice uniquement.
     *              Seo génére automatiquement les valeurs pour les balises de type title|description|robots.
     * - cas 2 :    ex. description
     *              Déclaration du nom de qualification de la balise en indice et tableau de contexte.
     *              Les clés des contextes peuvent être des contextes Wordpress (home|front|...) @see \tiFy\Wp\WpCtags
     *              ou un nom de qualification d'une route déclarée.
     * - cas 3 :    ex. keywords
     *              Désactivation de la balise pour tous les contextes.
     * - cas 4 :    ex. robots
     *              Déclaration du nom de qualification de la balise en indice et valeur de contexte global.
     *              La valeur de la balise sera la même sur toutes les pages du site.
     *              NB. La valeur par défaut de la balise robots est déjà 'index, follow'.
     * }
     */
    'metatag' => [
        'title',
        'description' => [
            'front' => 'Page d\'accueil du site',
            'home'  => 'Page liste des actualités'
        ],
        'keywords' => false,
        'robots' => 'index, follow',
    ],
    'wp'      => [
        'post_type' => [],
    ],
];