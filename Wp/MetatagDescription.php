<?php

namespace tiFy\Plugins\Seo\Wp;

use tiFy\Kernel\Tools;
use tiFy\Plugins\Seo\Contracts\WpMetatag;

class MetatagDescription extends AbstractMetatag implements WpMetatag
{
    /**
     * Nombre de caractères maximum.
     * @return int
     */
    protected $max = 156;

    /**
     * {@inheritdoc}
     */
    public function is404()
    {
        return __('Le contenu de cette page est actuellement indisponible.', 'tify');
    }

    /**
     * {@inheritdoc}
     */
    public function isArchive()
    {
        $desc = is_post_type_archive()
            ? sprintf(
                __('Page liste des %s.', 'tify'),
                post_type_archive_title('', false)
            )
            : __('Page liste des archives.', 'tify');


        if (is_paged()) :
            $desc = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $desc
            );
        endif;

        return $desc;
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthor()
    {
        return sprintf(
            __('Page liste des contenus édités par %s.', 'tify'),
            get_the_author_meta('display_name', get_query_var('author'))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isAttachment()
    {
        return $this->getPost() ? : sprintf(
            __('Page du contenu média %s.', 'tify'),
            get_the_title()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isCategory()
    {
        /** @var \WP_Term $term */
        return  (($term = get_category(get_query_var('cat'))) && (!$term instanceof \WP_Error))
            ? sprintf(__('Page liste des contenus de la catégorie %s.', 'tify'), $term->name)
            : __('Page liste des contenus d\'une catégorie indéterminée', 'tify');
    }

    /**
     * {@inheritdoc}
     */
    public function isDate()
    {
        if (is_day()) :
            return sprintf(
                __('Page liste des contenus du %s', 'tify'),
                get_the_date()
            );
        elseif (is_month()) :
            return sprintf(
                __('Page liste des contenus du %s', 'tify'),
                get_the_date('F Y')
            );
        elseif (is_year()) :
            return sprintf(
                __('Page liste des contenus du %s', 'tify'),
                get_the_date('Y')
            );
        endif;
    }

    /**
     * {@inheritdoc}
     */
    public function isFrontPage()
    {
        $desc = ($page_on_front = get_option('page_on_front'))
            ? $this->getPost($page_on_front)
            : sprintf(
                __('%s - %s - Bienvenue sur la page d\'accueil du site', 'tify'),
                get_bloginfo('name'),
                get_bloginfo('description')
            );

        if (is_paged()) :
            $desc = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $desc
            );
        endif;

        return $desc;
    }

    /**
     * {@inheritdoc}
     */
    public function isHome()
    {
        $desc = ($page_for_posts = get_option('page_for_posts'))
            ? $this->getPost($page_for_posts)
            : sprintf(
                __('%s - %s - Bienvenue sur la page d\'actualités du site', 'tify'),
                get_bloginfo('name'),
                get_bloginfo('description')
            );

        if (is_paged()) :
            $desc = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $desc
            );
        endif;

        return $desc;
    }

    /**
     * {@inheritdoc}
     */
    public function isPage()
    {
        return $this->getPost() ? : sprintf(
            __('Page de contenu de %s.', 'tify'),
            get_the_title()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isPostTypeArchive()
    {
        $desc = sprintf(
            __('Page liste des %s.', 'tify'),
            post_type_archive_title('', false)
        );

        if (is_paged()) :
            $desc = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $desc
            );
        endif;

        return $desc;
    }

    /**
     * {@inheritdoc}
     */
    public function isSearch()
    {
        $desc = sprintf(
            __('Résultats de recherche de "%s".', 'tify'),
            get_search_query()
        );

        if (is_paged()) :
            $desc = sprintf(
                __('Page %s sur %s - %s', 'tify'),
                (get_query_var('paged') ? get_query_var('paged') : 1),
                $this->query()->max_num_pages,
                $desc
            );
        endif;

        return $desc;
    }

    /**
     * {@inheritdoc}
     */
    public function isSingle()
    {
        return $this->getPost() ? : sprintf(
            __('Page de contenu de l\'article %s.', 'tify'),
            get_the_title()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isSingular()
    {
        return $this->getPost() ? : sprintf(
            __('Page de contenu de %s.', 'tify'),
            get_the_title()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function isTag()
    {
        /** @var \WP_Term $term */
        return  (($term = get_tag(get_query_var('tag'))) && (!$term instanceof \WP_Error))
            ? sprintf(__('Page liste des contenus de l\'étiquette %s.', 'tify'), $term->name)
            : __('Page liste des contenus d\'une étiquette indéterminée', 'tify');
    }

    /**
     * {@inheritdoc}
     */
    public function isTax()
    {
        /** @var \WP_Term $term*/
        $term = get_queried_object();

        return sprintf(
            __('Page liste des contenus %s en relation avec %s.', 'tify'),
            get_taxonomy($term->taxonomy)->label,
            $term->name
        );
    }

    /**
     * Récupération de la description générée à partir des information d'un contenu.
     *
     * @param null|int $post_id Identifiant de qualification du contenu. Courant par défaut.
     *
     * @return string
     */
    public function getPost($post_id = null)
    {
        return ($post = get_post($post_id))
             ? esc_html(
                Tools::Str()->excerpt(
                    $post->post_excerpt ? : $post->post_content,
                    [
                        'length' => $this->max,
                        'teaser' => '',
                    ]
                )
            )
            : '';
    }
}