<?php

namespace tiFy\Plugins\Seo\Wp;

abstract class AbstractSeoWpMetaTag
{
    /**
     * {@inheritdoc}
     */
    public function defaults()
    {
        $item = '';

        // Page de contenus introuvables.
        if (is_404()) :
            $item = $this->is404();

        // Page liste des résultats de recherche.
        elseif (is_search()) :
            $item = $this->isSearch();

        // Page d'accueil du site.
        elseif (is_front_page()) :
            $item = $this->isFrontPage();

        // Page liste des actualités.
        elseif (is_home()) :
            $item = $this->isHome();

        // Page liste de contenus personnalisés.
        elseif (is_post_type_archive()) :
            $item = $this->isPostTypeArchive();

        // Page liste de contenus associés à une taxonomie.
        elseif (is_tax()) :
            $item = $this->isTax();

        // Page de contenu média.
        elseif (is_attachment()) :
            $item = $this->isAttachment();

        // Page de contenu actualité.
        elseif (is_single()) :
            $item = $this->isSingle();

        // Page de contenu page.
        elseif (is_page()) :
            $item = $this->isPage();

        // Page de contenu personnalisé.
        elseif (is_singular()) :
            $item = $this->isSingular();

        // Page liste de contenus associés à une catégorie.
        elseif (is_category()) :
            $item = $this->isCategory();

        // Page liste de contenus associés à un mot-clef.
        elseif (is_tag()) :
            $item = $this->isTag();

        // Page liste de contenus associés à un auteur.
        elseif (is_author()) :
            $item = $this->isAuthor();

        // Page liste de contenus relatifs à une date.
        elseif (is_date()) :
            $item = $this->isDate();

        // Page liste de contenus standards.
        elseif (is_archive()) :
            $item = $this->isArchive();
        endif;

        return $item;
    }

    /**
     * Récupération de l'intitulé de la balise titre du site.
     *
     * @param string $title Intitulé courant.
     *
     * @return string|void
     */
    public function get()
    {
        return $this->defaults($title);
    }

    /**
     * Récupération de l'instance du controleur de requête globale de Wordpress.
     *
     * @return \WP_Query
     */
    public function query()
    {
        global $wp_query;

        return $wp_query;
    }
}