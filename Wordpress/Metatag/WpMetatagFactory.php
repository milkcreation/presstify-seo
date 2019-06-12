<?php

namespace tiFy\Plugins\Seo\Wordpress\Metatag;

use tiFy\Plugins\Seo\Contracts\WpMetatagFactory as WpMetatagFactoryContract;
use WP_Query;

class WpMetatagFactory implements WpMetatagFactoryContract
{
    /**
     * @inheritdoc
     */
    public function defaults()
    {
        $item = '';

        if (is_404()) {
            $item = $this->is404();
        } elseif (is_search()) {
            $item = $this->isSearch();
        } elseif (is_front_page()) {
            $item = $this->isFrontPage();
        } elseif (is_home()) {
            $item = $this->isHome();
        } elseif (is_post_type_archive()) {
            $item = $this->isPostTypeArchive();
        } elseif (is_tax()) {
            $item = $this->isTax();
        } elseif (is_attachment()) {
            $item = $this->isAttachment();
        } elseif (is_single()) {
            $item = $this->isSingle();
        } elseif (is_page()) {
            $item = $this->isPage();
        } elseif (is_singular()) {
            $item = $this->isSingular();
        } elseif (is_category()) {
            $item = $this->isCategory();
        } elseif (is_tag()) {
            $item = $this->isTag();
        } elseif (is_author()) {
            $item = $this->isAuthor();
        } elseif (is_date()) {
            $item = $this->isDate();
        } elseif (is_archive()) {
            $item = $this->isArchive();
        }

        return $item;
    }

    /**
     * Récupération de l'intitulé de la balise titre du site.
     *
     * @return string
     */
    public function get()
    {
        return $this->defaults();
    }

    /**
     * @inheritdoc
     */
    public function is404()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isArchive()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isAuthor()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isAttachment()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isCategory()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isDate()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isFrontPage()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isHome()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isPage()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isPostTypeArchive()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isSearch()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isSingle()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isSingular()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isTag()
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function isTax()
    {
        return '';
    }

    /**
     * Récupération de l'instance du controleur de requête globale de Wordpress.
     *
     * @return WP_Query
     */
    public function query()
    {
        global $wp_query;

        return $wp_query;
    }
}