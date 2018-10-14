<?php

namespace tiFy\Plugins\Seo\Contracts;

interface SeoWpMetaTagInterface
{
    /**
     * Récupération de la valeur par défaut de l'élément.
     *
     * @return string|void
     */
    public function defaults();

    /**
     * Récupération de l'élément.
     *
     * @param string $title Intitulé courant.
     *
     * @return string|void
     */
    public function get();

    /**
     * Elément de la page de contenus introuvables.
     *
     * @return string
     */
    public function is404();

    /**
     * Elément de la page liste de contenus standards.
     *
     * @return string
     */
    public function isArchive();

    /**
     * Elément de la page liste de contenus associés à un auteur.
     *
     * @return string
     */
    public function isAuthor();

    /**
     * Elément de la page de contenu média.
     *
     * @return string
     */
    public function isAttachment();

    /**
     * Elément de la page liste de contenus associés à une catégorie.
     *
     * @return string
     */
    public function isCategory();

    /**
     * Elément de la page liste de contenus relatifs à une date.
     *
     * @return string
     */
    public function isDate();

    /**
     * Elément de la page d'accueil du site.
     *
     * @return string
     */
    public function isFrontPage();

    /**
     * Elément de la page liste des actualités.
     *
     * @return string
     */
    public function isHome();

    /**
     * Elément de la page de contenu page.
     *
     * @return string
     */
    public function isPage();

    /**
     * Elément de la page liste de contenus personnalisés.
     *
     * @return string
     */
    public function isPostTypeArchive();

    /**
     * Elément de la page liste des résultats de recherche.
     *
     * @return string
     */
    public function isSearch();

    /**
     * Elément de la page de contenu actualité.
     *
     * @return string
     */
    public function isSingle();

    /**
     * Elément de la page de contenu personnalisé.
     *
     * @return string
     */
    public function isSingular();

    /**
     * Elément de la page liste de contenus associés à un mot-clef.
     *
     * @return string
     */
    public function isTag();

    /**
     * Elément de la page liste de contenus associés à une taxonomie.
     *
     * @return string
     */
    public function isTax();

    /**
     * Récupération de l'instance du controleur de requête globale de Wordpress.
     *
     * @return \WP_Query
     */
    public function query();
}