<?php

namespace tiFy\Plugins\Seo\Metabox\OptionsGoogleAnalytics;

use tiFy\Metabox\MetaboxWpOptionsController;

class OptionsGoogleAnalytics extends MetaboxWpOptionsController
{
    /**
     * @inheritdoc
     */
    public function content($args = null, $null1 = null, $null2 = null)
    {
        $this->set('ua_code', seo()->google_analytics()->get('ua_code'));

        return seo()->viewer('admin/options/google-analytics', $this->all());
    }

    /**
     * {@inheritdoc}
     */
    public function header($args = null, $null1 = null, $null2 = null)
    {
        return __('Google Analytics', 'tify');
    }

    /**
     * {@inheritdoc}
     */
    public function settings()
    {
        return ['seo_ua_code'];
    }
}