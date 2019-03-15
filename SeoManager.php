<?php

namespace tiFy\Plugins\Seo;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Plugins\Seo\Contracts\SeoManager as SeoManagerContract;

/**
 * Class SeoManager
 *
 * @desc Extension PresstiFy de gestion des données de référencement.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package tiFy\Plugins\Seo
 * @version 2.0.12
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
    use SeoResolverTrait;

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
    public function __construct()
    {
        add_action('init', function () {
            if ($this->optionsMetabox) :
                /** @var MetaboxManager $metabox */
                $metabox = resolve('metabox');

                foreach($this->optionsMetabox as $name => $attrs) :
                    $metabox->add(
                        $name,
                        'tify_options@options',
                        $attrs
                    );
                endforeach;

                $metabox
                    ->add(
                        'SeoOptions',
                        'tify_options@options',
                        [
                            'title' => __('Référencement', 'tify'),
                        ]
                    );
            endif;
        }, 999999);
    }

    /**
     * Ajout d'une métaboxe de réglage des options de référencement.
     *
     * @param string $name Nom de qualification.
     * @param array $attrs Liste des attributs de configuration de la métabox.
     *
     * @return $this
     */
    public function addOptionsMetabox($name, $attrs = [])
    {
        $this->optionsMetabox[$name] = array_merge($attrs, ['parent' => 'SeoOptions']);

        return $this;
    }
}
