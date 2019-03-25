<?php

namespace tiFy\Plugins\Seo\Wordpress;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Support\ParamsBag;
use tiFy\Plugins\Seo\Contracts\SeoManager;
use tiFy\Plugins\Seo\Contracts\WpManager as WpManangerContract;
use tiFy\Plugins\Seo\Metabox\PostMetatag\PostMetatag;
use WP_Post_Type;

class WpManager extends ParamsBag implements WpManangerContract
{
    /**
     * Instance du gestionnaire de référencement.
     * @var SeoManager
     */
    protected $manager;

    /**
     * CONSTRUCTEUR.
     *
     * @param SeoManager $manager Instance du gestionnaire de référencement.
     *
     * @return void
     */
    public function __construct(SeoManager $manager)
    {
        $this->manager = $manager;

        add_action('init', function () {
            $this->set(config('seo.wp', []))->parse();

            /** @var MetaboxManager $metabox */
            $metabox = app('metabox');

            $post_types = $this->has('post_type')
                ? $this->get('post_type', [])
                : array_keys(get_post_types());

            $post_types = array_diff(
                $post_types, [
                    'attachment',
                    'custom_css',
                    'customize_changeset',
                    'nav_menu_item',
                    'oembed_cache',
                    'revision',
                    'user_request'
                ]
            );

            foreach ($post_types as $post_type) {
                /** @var WP_Post_Type $wp_post_type */
                if (!$wp_post_type = get_post_type_object($post_type)) {
                    continue;
                } elseif (!$wp_post_type->public) {
                    continue;
                } elseif (!$wp_post_type->publicly_queryable && ($post_type !== 'page')) {
                    continue;
                }

                $metabox->add("SeoPostMetatag--{$post_type}", "{$post_type}@post_type", [
                    'content' => PostMetatag::class
                ]);
            }
        },  999999);
    }
}