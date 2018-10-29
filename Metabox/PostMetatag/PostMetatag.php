<?php

namespace tiFy\Plugins\Seo\Metabox\PostMetatag;

use tiFy\Metabox\MetaboxWpPostController;
use tiFy\Plugins\Seo\SeoResolverTrait;

class PostMetatag extends MetaboxWpPostController
{
    use SeoResolverTrait;

    /**
     * {@inheritdoc}
     */
    public function content($post = null, $args = null, $null = null)
    {
        /*
        $value = wp_parse_args((($_value = get_post_meta($post->ID, '_tify_seo_meta', true)) ? $_value : []),
            ['title' => '', 'url' => '', 'desc' => '']);

        // Valeurs originales
        /// Titre
        $original_title = esc_attr($post->post_title) . (\tiFy\Plugins\Seo\Seo::$append_blogname ? \tiFy\Plugins\Seo\Seo::$sep . get_bloginfo('name') : '') . (\tiFy\Plugins\Seo\Seo::$append_sitedesc ? \tiFy\Plugins\Seo\Seo::$sep . get_bloginfo('description',
                    'display') : '');
        /// Url
        list($permalink, $post_name) = get_sample_permalink($post->ID);
        $original_url = str_replace(['%pagename%', '%postname%'], $post_name, urldecode($permalink));
        /// Description
        $original_desc = get_bloginfo('name') . '&nbsp;|&nbsp;' . get_bloginfo('description');
        if ($post->post_excerpt) {
            $original_desc = tify_excerpt(strip_tags(html_entity_decode($post->post_excerpt)), ['max' => 156]);
        } elseif ($post->post_content) {
            $original_desc = tify_excerpt(strip_tags(html_entity_decode($post->post_content)), ['max' => 156]);
        } */

        return 'toto';
    }

    /**
     * {@inheritdoc}
     */
    public function header($post = null, $args = null, $null = null)
    {
        return __('Référencement', 'tify');
    }

    /**
     * {@inheritdoc}
     */
    public function load($wp_screen)
    {
        add_action(
            'admin_enqueue_scripts',
            function () {
                wp_enqueue_style(
                    'SeoMetatag',
                    $this->assetsUrl('/css/admin-metatag.css'),
                    [],
                    150323
                );

                wp_enqueue_script(
                    'SeoMetatag',
                    $this->assetsUrl('/js/admin-metatag.js'),
                    ['jquery'],
                    150323,
                    true
                );
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function metadatas()
    {
        return ['_seo_meta'];
    }
}