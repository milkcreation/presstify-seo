<?php

namespace tiFy\Plugins\Seo\Metabox\OptionsGoogleAnalytics;

use tiFy\Metabox\AbstractMetaboxDisplayOptionsController;

class OptionsGoogleAnalytics extends AbstractMetaboxDisplayOptionsController
{
    /**
     * {@inheritdoc}
     */
    public function content($args = null, $null1 = null, $null2 = null)
    {
        $this->set('ua_code', get_option('seo_ua_code', ''));

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