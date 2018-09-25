<?php

namespace tiFy\Plugins\Seo;

use tiFy\Kernel\Parameters\AbstractParametersBag;
use tiFy\Metabox\Metabox;
use tiFy\Plugins\Seo\Metabox\PostMetaTag\PostMetaTag;

class SeoMetaTag extends AbstractParametersBag
{
    /**
     * Liste des attributs de configuration.
     * @var array
     */
    protected $attributes = [];

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
                $attrs = config('seo.meta_tag', []);
                $this->parse($attrs);

                /** @var Metabox $metabox */
                $metabox = resolve(Metabox::class);

                $post_types = $this->get('meta_tag.post_type', get_post_types());
                $post_types = array_diff($post_types, ['attachment', 'revision', 'nav_menu_item']);

                foreach ($post_types as $post_type) :
                    /** @var WP_Post_Type $wp_post_type */
                    if (!$wp_post_type = get_post_type_object($post_type)) :
                        continue;
                    elseif (!$wp_post_type->public) :
                        continue;
                    elseif (!$wp_post_type->publicly_queryable && ($post_type !== 'page')) :
                        continue;
                    endif;

                    $metabox->add(
                        "{$post_type}@post_type",
                        [
                            'name' => "SeoPostMetaTag-{$post_type}",
                            'content' => PostMetaTag::class
                        ]
                    );
                endforeach;
            },
            999999
        );
    }

    /**
     * {@inheritdoc}
     */
    public function defaults($attrs = [])
    {
        return [
            'ua_code' => get_option('seo_ua_code', '')
        ];
    }
}