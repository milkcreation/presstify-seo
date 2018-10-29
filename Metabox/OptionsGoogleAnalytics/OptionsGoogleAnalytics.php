<?php

namespace tiFy\Plugins\Seo\Metabox\OptionsGoogleAnalytics;

use tiFy\Metabox\MetaboxWpOptionsController;

class OptionsGoogleAnalytics extends MetaboxWpOptionsController
{
    /**
     * {@inheritdoc}
     */
    public function content($args = null, $null1 = null, $null2 = null)
    {
        $this->set(
            'ua_code',
            app('seo.google.analytics')->get('ua_code')
        );

        return $this->viewer('content', $this->all());
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