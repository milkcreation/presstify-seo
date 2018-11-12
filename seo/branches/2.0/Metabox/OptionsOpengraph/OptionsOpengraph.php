<?php

namespace tiFy\Plugins\Seo\Metabox\OptionsOpengraph;

use tiFy\Metabox\MetaboxWpOptionsController;
use tiFy\Plugins\Seo\SeoResolverTrait;

class OptionsOpengraph extends MetaboxWpOptionsController
{
    use SeoResolverTrait;

    /**
     * {@inheritdoc}
     */
    public function content($args = null, $null1 = null, $null2 = null)
    {
        $this->set(
            'opengraph',
            array_merge(
                [
                    'active' => 'off',
                    'image' => 0
                ],
                get_option('seo_opengraph', [])
            )
        );

        return $this->viewer('admin/options/opengraph', $this->all());
    }

    /**
     * {@inheritdoc}
     */
    public function header($args = null, $null1 = null, $null2 = null)
    {
        return __('Metadonnées de l\'Opengraph', 'tify');
    }

    /**
     * {@inheritdoc}
     */
    public function load($wp_screen)
    {
        add_action(
            'admin_enqueue_scripts',
            function () {
                field('toggle-switch')->enqueue_scripts();
                field('media-image')->enqueue_scripts();
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function settings()
    {
        return ['seo_opengraph'];
    }
}