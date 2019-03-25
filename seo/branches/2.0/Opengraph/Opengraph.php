<?php

namespace tiFy\Plugins\Seo\Opengraph;

use tiFy\Support\ParamsBag;
use tiFy\Plugins\Seo\Contracts\SeoManager;
use tiFy\Plugins\Seo\Metabox\OptionsOpengraph\OptionsOpengraph;

class Opengraph extends ParamsBag
{
    /**
     * Instance du gestionnaire de référencement.
     * @var SeoManager
     */
    protected $manager;

    /**
     * CONSTRUCTEUR.
     *
     * @param SeoManager $manager Instance du gestionnaire de référencement.
     *
     * @return void
     */
    public function __construct(SeoManager $manager)
    {
        $this->manager = $manager;

        add_action('init', function () {
            $this->set(config('seo.opengraph', []))->parse();

            if ($this->get('admin')) :
                $this->manager->addOptionsMetabox('SeoOptionsOpengraph', [
                    'parent'    => 'SeoOptions',
                    'content'   => OptionsOpengraph::class
                ]);
            endif;
        }, 999998);

        add_filter('language_attributes', function ($output) {
            return is_admin() ? $output : $output . ' xmlns:og="http://opengraphprotocol.org/schema/"';
        });
    }

    /**
     * @inheritdoc
     */
    public function defaults()
    {
        return [
            'admin'   => true
        ];
    }
}