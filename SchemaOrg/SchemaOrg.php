<?php

namespace tiFy\Plugins\Seo\SchemaOrg;

use tiFy\Plugins\Seo\Contracts\SeoManager;

class SchemaOrg
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
    }


    /**
     * Langage Attribute de la balise HTML pour Schema.org
     * @TODO
     */
    function schema_language_attributes($output)
    {
        if (is_admin()) {
            return $output;
        }
        return $output . ' itemscope itemtype="http://schema.org/Article"';
    }

    /**
     * Balises Meta de Schema.org
     * @TODO
     */
    function schema_wp_head()
    {
        if (!is_singular() && !is_front_page()) {
            return;
        }

        if (is_front_page()) :
            $page_on_front = false;
            if ($page_on_front = get_option('page_on_front')) {
                $post = get_post($page_on_front);
            }

            if ($page_on_front) {
                echo '<meta itemprop="name" content="' . get_the_title($post->ID) . '"/>';
            } else {
                echo '<meta itemprop="name" content="' . get_bloginfo('name') . '"/>';
            }

            if ($page_on_front && $post->post_excerpt) {
                echo '<meta itemprop="description" content="' . apply_filters('get_the_excerpt',
                        $post->post_excerpt) . '" />';
            } else {
                echo '<meta itemprop="description" content="' . get_bloginfo('description') . '" />';
            }

        else :
            echo '<meta itemprop="name" content="' . get_the_title() . '"/>';

            echo '<meta itemprop="description" content="' . strip_tags(get_the_excerpt()) . '" />';
            if ($src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large')) :
                echo '<meta itemprop="image" content="' . esc_attr($src[0]) . '"/>';
            elseif ($src = $this->get_image_src($this->options['default_image'])) :
                echo '<meta itemprop="image" content="' . esc_attr($src) . '"/>';
            endif;
        endif;
    }
}