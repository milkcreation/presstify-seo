<?php

namespace tiFy\Plugins\Seo\Wp;

class MetatagsOpengraph
{
    final public function wp_head_opengraph($output)
    {
        $tify_opengraph = get_option('tify_opengraph');

        if (!isset($tify_opengraph['active']) || ($tify_opengraph['active'] !== 'on')) {
            return $output;
        }

        global $tify_opengraph_meta;

        $meta = [];

        if (is_front_page()) :
            $page_on_front = false;
            if ($page_on_front = get_option('page_on_front')) {
                $post = get_post($page_on_front);
            }

            $meta['title'] = ($page_on_front) ? get_the_title($post->ID) : get_bloginfo('name');
            $meta['site_name'] = get_bloginfo('name') . ' | ' . get_bloginfo('description');
            $meta['url'] = home_url();
            $meta['description'] = ($page_on_front && $post->post_excerpt) ? apply_filters('get_the_excerpt',
                $post->post_excerpt) : get_bloginfo('description');

            if ($image = tify_custom_attachment_image($tify_opengraph['default_image'], [1200, 1200, false])) {
                $meta['image'] = esc_attr($image['url'] . '/' . $image['file']);
            } elseif ($image = tify_custom_attachment_image($tify_opengraph['default_image'], [600, 600, false])) {
                $meta['image'] = esc_attr($image['url'] . '/' . $image['file']);
            }

            $meta['type'] = 'website';

        elseif (is_singular()) :
            $meta['title'] = get_the_title();
            $meta['site_name'] = get_bloginfo('name');
            $meta['url'] = get_permalink();
            $meta['description'] = esc_attr(strip_tags(get_the_excerpt()));

            if ($image = tify_custom_attachment_image(get_post_thumbnail_id(get_the_ID()), [1200, 1200, false])) :
                $meta['image'] = esc_attr($image['url'] . '/' . $image['file']);
            elseif ($image = tify_custom_attachment_image(get_post_thumbnail_id(get_the_ID()), [600, 600, false])) :
                $meta['image'] = esc_attr($image['url'] . '/' . $image['file']);
            elseif ($image = tify_custom_attachment_image($tify_opengraph['default_image'], [1200, 1200, true])) :
                $meta['image'] = esc_attr($image['url'] . '/' . $image['file']);
            elseif ($image = tify_custom_attachment_image($tify_opengraph['default_image'], [600, 600, true])) :
                $meta['image'] = esc_attr($image['url'] . '/' . $image['file']);
            endif;

            $meta['type'] = 'article';
        endif;

        // Court-circuitage des metas
        $meta = apply_filters('tify_seo_opengraph_meta', $meta);
        $tify_opengraph_meta = $meta;

        // Conversion des metas pour l'affichage
        foreach ($meta as $property => $content) {
            $output .= "<meta property=\"og:{$property}\" content=\"{$content}\"/>";
        }

        echo apply_filters('tify_seo_opengraph_meta_output', $output, $meta);
    }
}