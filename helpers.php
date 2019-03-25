<?php

use tiFy\Plugins\Seo\Contracts\SeoManager;

if (!function_exists('seo')) {
    /**
     * Récupération de l'instance de l'extension de gestionnaire de référencement.
     *
     * @return SeoManager
     */
    function seo(): ?SeoManager
    {
        return app()->get('seo');
    }
}