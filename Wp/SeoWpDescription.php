<?php

namespace tiFy\Plugins\Seo\Wp;

class SeoWpDescription
{
    public function get()
    {
        $desc = '';
        // PAGE 404
        if (is_404()) :
            $desc = apply_filters('tify_seo_desc_is_404', __('Erreur 404 - Impossible de trouver la page', 'tify'));
        // RECHERCHE
        elseif (is_search()) :
            $desc = apply_filters('tify_seo_desc_is_search',
                sprintf('%1$s %2$s', __('Recherche de', 'tify'), get_search_query()));
        // TAXONOMIES
        elseif (is_tax()):
            $tax = get_queried_object();
            $desc = apply_filters('tify_seo_desc_is_tax',
                sprintf('%1$s %2$s', get_taxonomy($tax->taxonomy)->label, $tax->name));
        // FRONT PAGE
        elseif (is_front_page()) :
            if ($page_for_posts = get_option('page_on_front')) :
                $desc = apply_filters('tify_seo_desc_is_page_on_front', $this->_get_singular_desc($page_for_posts));
            else :
                if (is_paged()) :
                    global $wp_query;
                    $desc = apply_filters('tify_seo_desc_is_front_paged',
                        sprintf(__('Actualités page %1$s sur %2$s', 'tify'),
                            (get_query_var('paged') ? get_query_var('paged') : 1), $wp_query->max_num_pages));
                else :
                    $desc = apply_filters('tify_seo_desc_is_front_page', __('Actualités', 'tify'));
                endif;
            endif;
        // HOME PAGE
        elseif (is_home()) :
            if ($page_for_posts = get_option('page_for_posts')) :
                $desc = apply_filters('tify_seo_desc_is_page_for_posts', $this->_get_singular_desc($page_for_posts));
            else :
                if (is_paged()) :
                    global $wp_query;
                    $desc = apply_filters('tify_seo_desc_is_home_paged',
                        sprintf(__('Actualités page %1$s sur %2$s', 'tify'),
                            (get_query_var('paged') ? get_query_var('paged') : 1), $wp_query->max_num_pages));
                else :
                    $desc = apply_filters('tify_seo_desc_is_home', __('Actualités', 'tify'));
                endif;
            endif;
        // ATTACHMENT
        elseif (is_attachment()) :
            $desc = apply_filters('tify_seo_desc_is_attachment', esc_html(wp_strip_all_tags(get_the_title())));
        // SINGLE
        elseif (is_single()) :
            $desc = apply_filters('tify_seo_desc_is_single', $this->_get_singular_desc(get_the_ID()));
        // PAGE
        elseif (is_page()) :
            $desc = apply_filters('tify_seo_desc_is_page', $this->_get_singular_desc(get_the_ID()));
        // CATEGORY
        elseif (is_category()) :
            if ($category = get_category(get_query_var('cat'), false)):
                $desc = apply_filters('tify_seo_desc_is_category', $category->name);
            endif;
        // TAG
        elseif (is_tag()):
            $desc = apply_filters('tify_seo_desc_is_tag', sprintf(__('Mot clef : %1$s', 'tify'), get_query_var('tag')));
        // AUTHOR
        elseif (is_author()):
            // DATE
        elseif (is_date()) :
            if (is_day()) :
                $desc = apply_filters('tify_seo_desc_is_day',
                    sprintf(__('Archive quotidienne : %1$s', 'tify'), get_the_date()));
            elseif (is_month()) :
                $desc = apply_filters('tify_seo_desc_is_month',
                    sprintf(__('Archive mensuelle : %1$s', 'tify'), get_the_date('F Y')));
            elseif (is_year()) :
                $desc = apply_filters('tify_seo_desc_is_year',
                    sprintf(__('Archive annuelle : %1$s', 'tify'), get_the_date('Y')));
            endif;
        // ARCHIVES
        elseif (is_archive())    :
            if (is_post_type_archive()) :
                $desc = apply_filters('tify_seo_desc_is_post_type_archive', post_type_archive_title('', false));
            else:
                $desc = __('Archives', 'tify');
            endif;
        //** TODO **/
        elseif (is_comments_popup()) :
        elseif (is_paged()) :
        else :
        endif;
    }

    /** == == **/
    final public function tify_seo_desc_for_singular($desc)
    {
        global $post;

        if (($seo_meta = get_post_meta($post->ID, '_tify_seo_meta', true)) && !empty($seo_meta['desc'])) {
            return $seo_meta['desc'];
        }

        return $desc;
    }

    /** == == **/
    final public function tify_seo_desc_for_archive($desc)
    {
        global $post;

        if (is_home() && ($page_for_posts = get_option('page_for_posts')) && ($seo_meta = get_post_meta($page_for_posts,
                '_tify_seo_meta', true)) && !empty($seo_meta['desc'])) {
            return $seo_meta['desc'];
        }

        return $desc;
    }

    /** == == **/
    private function _get_singular_desc($post_id)
    {
        // Bypass
        if (!$post = get_post($post_id)) {
            return;
        }
        /// Description
        $desc = get_bloginfo('name') . '&nbsp;|&nbsp;' . get_bloginfo('description');
        if ($post->post_excerpt) {
            $desc = tify_excerpt(strip_tags($post->post_excerpt), ['max' => 156]);
        } elseif ($post->post_content) {
            $desc = tify_excerpt(strip_tags($post->post_content), ['max' => 156]);
        }

        return esc_html(wp_strip_all_tags($desc));
    }
}