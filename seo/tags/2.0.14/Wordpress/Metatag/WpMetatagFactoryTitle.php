<?php

namespace tiFy\Plugins\Seo\Wordpress\Metatag;

use WP_Term;

class WpMetatagFactoryTitle extends WpMetatagFactory
{
    /**
     * Séparateur des éléments du titre.
     * @var string
     */
    protected $sep = '';

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sep = apply_filters('document_title_separator', '-');
    }

    /**
     * Récupération de l'élément de clotûre de titre.
     *
     * @return string
     */
    public function end()
    {
        return get_bloginfo('name') .
            (($desc = get_bloginfo('description')) ? " {$this->sep} {$desc}" : '');
    }

    /**
     * @inheritdoc
     */
    public function get()
    {
        return $this->defaults() . (($end = $this->end()) ? " {$this->sep} {$end}" : '');
    }

    /**
     * @inheritdoc
     */
    public function is404()
    {
        return __('Erreur 404 - Page introuvable', 'tify');
    }

    /**
     * @inheritdoc
     */
    public function isArchive()
    {
        $title = is_post_type_archive()
            ? post_type_archive_title('', false)
            : __('Archives', 'tify');

        if (is_paged()) {
            $title = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $title
            );
        }

        return $title;
    }

    /**
     * @inheritdoc
     */
    public function isAuthor()
    {
        return sprintf(
            __('Contenu de : %s', 'tify'),
            get_the_author_meta('display_name', get_query_var('author'))
        );
    }

    /**
     * @inheritdoc
     */
    public function isAttachment()
    {
        return get_the_title();
    }

    /**
     * @inheritdoc
     */
    public function isCategory()
    {
        /** @var WP_Term $term */
        return (($term = get_category(get_query_var('cat'))) && (!$term instanceof \WP_Error))
            ? sprintf(__('Catégorie : %s', 'tify'), $term->name)
            : __('Catégorie non définie', 'tify');
    }

    /**
     * @inheritdoc
     */
    public function isDate()
    {
        if (is_day()) {
            return sprintf(__('Archive quotidienne : %s', 'tify'), get_the_date());
        } elseif (is_month()) {
            return sprintf(__('Archive mensuelle : %s', 'tify'), get_the_date('F Y'));
        } elseif (is_year()) {
            return sprintf(__('Archive annuelle : %s', 'tify'), get_the_date('Y'));
        }

        return '';
    }

    /**
     * @inheritdoc
     */
    public function isFrontPage()
    {
        $title = ($page_on_front = get_option('page_on_front'))
            ? get_the_title($page_on_front)
            : __('Accueil', 'tify');

        if (is_paged()) {
            $title .= sprintf(
                __(' %1$s page %2$s sur %3$s', 'tify'),
                $this->sep,
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages
            );
        }

        return $title;
    }

    /**
     * @inheritdoc
     */
    public function isHome()
    {
        $title = ($page_for_posts = get_option('page_for_posts'))
            ? get_the_title($page_for_posts)
            : __('Actualités', 'tify');

        if (is_paged()) {
            $title .= sprintf(
                __(' %1$s page %2$s sur %3$s', 'tify'),
                $this->sep,
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages
            );
        }

        return $title;
    }

    /**
     * @inheritdoc
     */
    public function isPage()
    {
        return get_the_title();
    }

    /**
     * @inheritdoc
     */
    public function isPostTypeArchive()
    {
        $title = post_type_archive_title('', false);

        if (is_paged()) {
            $title = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $title
            );
        }

        return $title;
    }

    /**
     * @inheritdoc
     */
    public function isSearch()
    {
        $title = sprintf('%1$s %2$s', __('Recherche de', 'tify'), get_search_query());

        if (is_paged()) {
            $title = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $title
            );
        }

        return $title;
    }

    /**
     * @inheritdoc
     */
    public function isSingle()
    {
        return get_the_title();
    }

    /**
     * @inheritdoc
     */
    public function isSingular()
    {
        return get_the_title();
    }

    /**
     * @inheritdoc
     */
    public function isTag()
    {
        /** @var WP_Term $term */
        return (($term = get_tag(get_query_var('tag'))) && (!$term instanceof \WP_Error))
            ? sprintf('Etiquette : %s', $term->name)
            : __('Etiquette non définie', 'tify');
    }

    /**
     * @inheritdoc
     */
    public function isTax()
    {
        /** @var WP_Term $term */
        $term = get_queried_object();

        return sprintf(
            '%1$s : %2$s',
            get_taxonomy($term->taxonomy)->label,
            $term->name
        );
    }
}