<?php

/**
 * @name Seo
 * @desc Gestion des données de référencement.
 * @author Jordy Manner <jordy@milkcreation.fr>
 * @package presstify-plugins/seo
 * @namespace \tiFy\Plugins\Seo
 * @version 2.0.6
 */

namespace tiFy\Plugins\Seo;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Plugins\Seo\SeoResolverTrait;

final class Seo
{
    use SeoResolverTrait;

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', function () {
            /** @var MetaboxManager $metabox */
            $metabox = resolve('metabox');

            $metabox
                ->add(
                    'SeoOptions',
                    'tify_options@options',
                    [
                        'title' => __('Référencement', 'tify'),
                    ]
                );
            },
            999999
        );
    }
}
