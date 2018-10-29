<?php

namespace tiFy\Plugins\Seo\Contracts;

interface Seo extends SeoResolver
{
    /**
     * Ajout d'une métaboxe de réglage des options de référencement.
     *
     * @param string $name Nom de qualification.
     * @param array $attrs Liste des attributs de configuration de la métabox.
     *
     * @return $this
     */
    public function addOptionsMetabox($name, $attrs = []);
}
