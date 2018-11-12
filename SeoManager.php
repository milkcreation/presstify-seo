<?php

/**
 * @name Seo
 * @desc Gestion des données de référencement.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/seo
 * @namespace \tiFy\Plugins\Seo
 * @version 2.0.9
 */

namespace tiFy\Plugins\Seo;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Plugins\Seo\SeoResolverTrait;

final class SeoManager
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
        add_action('init',
            function () {
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
            },
            999999
        );
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
        $this->optionsMetabox[$name] = array_merge(
            $attrs,
            [
                'parent' => 'SeoOptions'
            ]
        );

        return $this;
    }
}
