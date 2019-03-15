<?php

namespace tiFy\Plugins\Seo\Metabox\PostMetatag;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use tiFy\Metabox\MetaboxWpPostController;
use tiFy\Plugins\Seo\SeoResolverTrait;
use tiFy\Wp\Query\QueryPost;

class PostMetatag extends MetaboxWpPostController
{
    use SeoResolverTrait;

    /**
     * {@inheritdoc}
     */
    public function content($post = null, $args = null, $null = null)
    {
        /** @var QueryPost $queryPost */
        $queryPost = app()->get('wp.query.post', [$post]);

        $datas = array_merge(
            [
                'orig_title' => $queryPost->getTitle(true),
                'orig_url'   => $queryPost->getPermalink(),
                'orig_desc'  => Str::limit($queryPost->getExcerpt(true), 155, '')
            ],
            Arr::wrap(get_post_meta($queryPost->getId(), '_seo_metatag', true))
        );

        return $this->viewer('admin/post/metatag', $datas);
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
                field('text-remaining')->enqueue_scripts();

                wp_enqueue_style(
                    'SeoMetatag',
                    $this->resourcesUrl('/assets/css/admin-post-metatag.css'),
                    [],
                    181108
                );

                wp_enqueue_script(
                    'SeoMetatag',
                    $this->resourcesUrl('/assets/js/admin-post-metatag.js'),
                    ['jquery'],
                    181108,
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
        return ['_seo_metatag'];
    }
}