<?php

/**
 * @name Seo
 * @desc Gestion des données de référencement.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/seo
 * @namespace \tiFy\Plugins\Seo
 * @version 2.0.1
 */

namespace tiFy\Plugins\Seo;

use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Metabox\Metabox;

final class Seo
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', function () {
            /** @var Metabox $metabox */
            $metabox = resolve(Metabox::class);

            $metabox
                ->add(
                    'tify_options@options',
                    [
                        'name'  => 'SeoOptions',
                        'title' => __('Référencement', 'tify'),
                    ]
                );
            },
            999999
        );
    }
}
