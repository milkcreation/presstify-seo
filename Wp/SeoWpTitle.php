<?php

namespace tiFy\Plugins\Seo\Wp;

class SeoWpTitle
{
    public function get()
    {
        $title = '';

        if (!is_feed()) :
            /**
             * Page 404.
             */
            if (is_404()) :
                $title = __('Erreur 404 - Impossible de trouver la page', 'tify');

            /**
             * Résultats de recherche.
             */
            elseif (is_search()) :
                $title = sprintf(
                    '%1$s %2$s',
                    __('Recherche de', 'tify'),
                    get_search_query()
                );

            /**
             * Archive d'une taxonomie.
             */
            elseif (is_tax()) :
                $tax = get_queried_object();

                $title = sprintf(
                    '%1$s %2$s',
                    get_taxonomy($tax->taxonomy)->label,
                    $tax->name
                );

            /**
             * Page d'accueil.
             */
            elseif (is_front_page()) :
                if ($page_for_posts = get_option('page_on_front')) :
                    $title = esc_html(
                        wp_strip_all_tags(
                            get_the_title($page_for_posts)
                        )
                    );

                else :
                    if (is_paged()) :
                        global $wp_query;
                        $title = sprintf(
                            __('Actualités page %1$s sur %2$s', 'tify'),
                            (get_query_var('paged') ? get_query_var('paged') : 1),
                            $wp_query->max_num_pages
                        );
                    else :
                        $title = __('Actualités', 'tify');
                    endif;
                endif;

            /**
             * Page liste des actualités.
             */
            elseif (is_home()) :
                if ($page_for_posts = get_option('page_for_posts')) :
                    $title = esc_html(
                        wp_strip_all_tags(
                            get_the_title($page_for_posts)
                        )
                    );
                elseif (is_paged()) :
                    global $wp_query;
                    $title = sprintf(
                        __('Actualités page %1$s sur %2$s', 'tify'),
                        (get_query_var('paged') ? get_query_var('paged') : 1),
                        $wp_query->max_num_pages
                    );
                else :
                    $title = __('Actualités', 'tify');
                endif;

            /**
             * Page de fichier média.
             */
            elseif (is_attachment()) :
                $title = esc_html(
                    wp_strip_all_tags(get_the_title())
                );

            /**
             * Article.
             */
            elseif (is_single()) :
                $title = esc_html(
                    wp_strip_all_tags(get_the_title())
                );

            /**
             * Page.
             */
            elseif (is_page()) :
                $_title = esc_html(
                    wp_strip_all_tags(get_the_title())
                );

            /**
             * Page liste des élements associés à une catégorie.
             */
            elseif (is_category()) :
                if ($category = get_category(get_query_var('cat'), false)) :
                    $title = esc_html(
                        wp_strip_all_tags($category->name)
                    );
                else :
                    $title = __('Catégorie non définie', 'tify');
                endif;

            /**
             * Page liste des élements associés à une étiquette.
             */
            elseif (is_tag()):
                $title = sprintf(
                    __('Mot clef : %1$s', 'tify'),
                    get_query_var('tag')
                );

            /**
             * Page liste des élements associés à un auteur.
             */
            elseif (is_author()) :


            /**
             * Page liste des élements associés à une date.
             */
            elseif (is_date()) :
                if (is_day()) :
                    $title = sprintf(
                        __('Archive quotidienne : %1$s', 'tify'),
                        get_the_date()
                    );
                elseif (is_month()) :
                    $title = sprintf(
                        __('Archive mensuelle : %1$s', 'tify'),
                        get_the_date('F Y')
                    );
                elseif (is_year()) :
                    $title = sprintf(
                        __('Archive annuelle : %1$s', 'tify'),
                        get_the_date('Y')
                    );
                endif;

            /**
             * Page liste des élements.
             */
            elseif (is_archive())    :
                if (is_post_type_archive()) :
                    $title = post_type_archive_title('', false);
                else:
                    $title = __('Archives', 'tify');
                endif;

            /**
             * @todo
             */
            elseif (is_comments_popup()) :
            elseif (is_paged()) :
            else :
            endif;
        endif;

        return $title;
    }

    /** == == **/
    final public function tify_seo_title_for_singular($title)
    {
        global $post;

        if (($seo_meta = get_post_meta($post->ID, '_tify_seo_meta', true)) && !empty($seo_meta['title'])) {
            return $seo_meta['title'];
        }

        return $title;
    }

    /** == == **/
    final public function tify_seo_title_for_archive($title)
    {
        global $post;

        if (is_home() && ($page_for_posts = get_option('page_for_posts')) && ($seo_meta = get_post_meta($page_for_posts,
                '_tify_seo_meta', true)) && !empty($seo_meta['title'])) {
            return $seo_meta['title'];
        }

        return $title;
    }
}