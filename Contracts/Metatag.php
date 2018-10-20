<?php

namespace tiFy\Plugins\Seo\Contracts;

use tiFy\Contracts\Partial\PartialController;

interface Metatag
{
    /**
     * Résolution de sortie de la classe en tant que chaîne de caractère.
     *
     * @return string
     */
    public function __toString();

    /**
     * Ajout d'un élément selon son contexte d'affichage.
     *
     * @param string Valeur de l'élément.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function add($value, $context = '*');

    /**
     * Définition de l'élément de clôture selon son contexte d'affichage.
     *
     * @param string $value Valeur de l'élément.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function end($value = '', $context = '*');

    /**
     * Suppression de la liste des éléments déclarés selon le contexte d'affichage.
     *
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return $this
     */
    public function clear($context = '*');

    /**
     * Récupération de la liste des éléments déclarés selon le contexte d'affichage.
     *
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return array
     */
    public function get($context = '*');

    /**
     * Nom de qualification de la balise.
     *
     * @return string
     */
    public function getName();

    /**
     * Récupération du contenu de la balise.
     *
     * @return string
     */
    public function content();

    /**
     * Définition du contenu de la balise.
     *
     * @param array|string $content
     *
     * @return string
     */
    public function set($content);

    /**
     * Instance de balise représentative des élements.
     *
     * @return PartialController
     */
    public function tag();
}