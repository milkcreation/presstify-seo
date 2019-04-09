<?php

namespace tiFy\Plugins\Seo;

use Psr\Container\ContainerInterface;
use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Contracts\View\ViewEngine;
use tiFy\Plugins\Seo\Contracts\MetatagManager;
use tiFy\Plugins\Seo\Contracts\SeoManager as SeoManagerContract;

/**
 * Class SeoManager
 *
 * @desc Extension PresstiFy de gestion des données de référencement.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package tiFy\Plugins\Seo
 * @version 2.0.14
 *
 * USAGE :
 * Activation
 * ---------------------------------------------------------------------------------------------------------------------
 * Dans config/app.php ajouter \tiFy\Plugins\Seo\SeoServiceProvider à la liste des fournisseurs de services.
 * ex.
 * <?php
 * ...
 * use tiFy\Plugins\Seo\SeoServiceProvider;
 * ...
 *
 * return [
 *      ...
 *      'providers' => [
 *          ...
 *          SeoServiceProvider::class
 *          ...
 *      ]
 * ];
 *
 * Configuration
 * ---------------------------------------------------------------------------------------------------------------------
 * Dans le dossier de config, créer le fichier seo.php
 * @see /vendor/presstify-plugins/seo/Resources/config/seo.php
 */
final class SeoManager implements SeoManagerContract
{
    /**
     * Instance du conteneur d'injection de dépendances.
     * @var
     */
    protected $container;

    /**
     * Liste des metaboxes de réglages des options.
     * @var array
     */
    protected $optionsMetabox = [];

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        add_action('init', function () {
            if ($this->optionsMetabox) :
                /** @var MetaboxManager $metabox */
                $metabox = app('metabox');

                foreach($this->optionsMetabox as $name => $attrs) :
                    $metabox->add($name, 'tify_options@options', $attrs);
                endforeach;

                $metabox->add('SeoOptions', 'tify_options@options', [
                    'title' => __('Référencement', 'tify'),
                ]);
            endif;
        }, 999999);
    }

    /**
     * Résolution de service fournis par l'extension.
     *
     * @param string $alias Nom de qualification du service.
     * @param array ...$args Liste des variables passées en argument au service.
     *
     * @return mixed
     */
    private function _resolve($alias, ...$args)
    {
        return $this->container->get("seo.$alias", $args);
    }

    /**
     * @inheritdoc
     */
    public function addOptionsMetabox($name, $attrs = [])
    {
        $this->optionsMetabox[$name] = array_merge($attrs, ['parent' => 'SeoOptions']);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function google_analytics()
    {
        return $this->_resolve('google-analytics');
    }

    /**
     * @inheritdoc
     */
    public function metatag($tag = null, $value = null, $context = '*')
    {
        /** @var MetatagManager $metatag */
        $manager = $this->_resolve('metatag');

        if (is_null($tag)) :
            return $manager;
        elseif(is_null($value)) :
            return $manager->make($tag);
        endif;

        return $manager->add($tag, $value, $context);
    }

    /**
     * @inheritdoc
     */
    public function wordpress()
    {
        return $this->_resolve('wp');
    }

    /**
     * @inheritdoc
     */
    public function resourcesDir($path = '')
    {
        $cinfo = class_info($this);
        $path = '/Resources/' . ltrim($path, '/');

        return file_exists($cinfo->getDirname() . $path) ? $cinfo->getDirname() . $path : '';
    }

    /**
     * @inheritdoc
     */
    public function resourcesUrl($path = '')
    {
        $cinfo = class_info($this);
        $path = '/Resources/' . ltrim($path, '/');

        return file_exists($cinfo->getDirname() . $path) ? $cinfo->getUrl() . $path : '';
    }

    /**
     * @inheritdoc
     */
    public function viewer($view = null, $data = [])
    {
        /** @var ViewEngine $viewer */
        $viewer = $this->_resolve('viewer');

        if (func_num_args() === 0) :
            return $viewer;
        endif;

        return $viewer->make("_override::{$view}", $data);
    }
}
