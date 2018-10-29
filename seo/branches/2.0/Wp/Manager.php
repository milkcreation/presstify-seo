<?php

namespace tiFy\Plugins\Seo\Wp;

use tiFy\Contracts\Metabox\MetaboxManager;
use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Plugins\Seo\Metabox\PostMetatag\PostMetatag;
use tiFy\Plugins\Seo\SeoResolverTrait;

class Manager extends AbstractParametersBag
{
    use SeoResolverTrait;

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        add_action(
            'init',
            function () {
                $attrs = config('seo.wp', []);
                $this->parse($attrs);

                /** @var MetaboxManager $metabox */
                $metabox = resolve('metabox');

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

                foreach ($post_types as $post_type) :
                    /** @var WP_Post_Type $wp_post_type */
                    if (!$wp_post_type = get_post_type_object($post_type)) :
                        continue;
                    elseif (!$wp_post_type->public) :
                        continue;
                    elseif (!$wp_post_type->publicly_queryable && ($post_type !== 'page')) :
                        continue;
                    endif;
                    /*
                    $metabox->add(
                        "SeoPostMetatag--{$post_type}",
                        "{$post_type}@post_type",
                        [
                            'content' => PostMetatag::class
                        ]
                    );
                    */
                endforeach;
            },
            999999
        );
    }
}