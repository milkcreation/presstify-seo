<?php

namespace tiFy\Plugins\Seo\Contracts;

use tiFy\Contracts\View\ViewController;
use tiFy\Contracts\View\ViewEngine;

interface SeoManager
{
    /**
     * Ajout d'une métaboxe de réglage des options de référencement.
     *
     * @param string $name Nom de qualification.
     * @param array $attrs Liste des attributs de configuration de la métabox.
     *
     * @return static
     */
    public function addOptionsMetabox($name, $attrs = []);

    /**
     * Récupération de l'instance du controleur Google Analytics.
     *
     * @return GoogleAnalytics
     */
    public function google_analytics();

    /**
     * Récupération de l'instance du gestionnaire de balise méta ou définition d'une méta balise.
     *
     * @param null|string $tag Nom de qualification de la balise.
     * @param null|string $value Valeur de la balise à définir.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return MetatagManager|MetatagFactory
     */
    public function metatag($tag = null, $value = null, $context = '*');

    /**
     * Récupération de l'instance du controleur d'environnement wordpress.
     *
     * @return WpManager
     */
    public function wordpress();

    /**
     * Récupération du chemin absolu vers une ressource.
     *
     * @param string $path Chemin relatif de la ressource.
     *
     * @return resource
     */
    public function resourcesDir($path = '');

    /**
     * Récupération de l'url absolue vers une ressource.
     *
     * @param string $path Chemin relatif de la ressource.
     *
     * @return resource
     */
    public function resourcesUrl($path = '');

    /**
     * Récupération d'un instance du controleur de liste des gabarits d'affichage ou d'un gabarit d'affichage.
     * {@internal Si aucun argument n'est passé à la méthode, retourne l'instance du controleur de liste.}
     * {@internal Sinon récupére l'instance du gabarit d'affichage et passe les variables en argument.}
     *
     * @param null|string view Nom de qualification du gabarit.
     * @param array $data Liste des variables passées en argument.
     *
     * @return ViewController|ViewEngine
     */
    public function viewer($view = null, $data = []);
}
