<?php

namespace tiFy\Plugins\Seo;

use tiFy\Contracts\Views\ViewInterface;
use tiFy\Contracts\Views\ViewsInterface;
use tiFy\Plugins\Seo\Seo;
use tiFy\Plugins\Seo\SeoTitle;

trait SeoResolverTrait
{
    /**
     * Instance du moteur de gabarits d'affichage.
     * @return ViewsInterface
     */
    protected $viewer;

    /**
     * Récupération de l'url d'une ressource du répertoire des assets.
     *
     * @param string $path Chemin relatif de la ressource.
     *
     * @return string
     */
    public function assetsUrl($path = '')
    {
        $cinfo = class_info($this);
        $path = '/Resources/assets/' . ltrim($path, '/');

        return file_exists($cinfo->getDirname() . $path) ? class_info($this)->getUrl() . $path : '';
    }

    /**
     * Récupération de l'instance de traitement du titre de la page.
     *
     * @return SeoTitle
     */
    public function title()
    {
        return app('seo.title');
    }

    /**
     * Récupération d'un instance du controleur de liste des gabarits d'affichage ou d'un gabarit d'affichage.
     * {@internal Si aucun argument n'est passé à la méthode, retourne l'instance du controleur de liste.}
     * {@internal Sinon récupére l'instance du gabarit d'affichage et passe les variables en argument.}
     *
     * @param null|string view Nom de qualification du gabarit.
     * @param array $data Liste des variables passées en argument.
     *
     * @return ViewsInterface|ViewInterface
     */
    public function viewer($view = null, $data = [])
    {
        if (!$this->viewer) :
            $default_dir = __DIR__ . '/Resources/views';
            $this->viewer = view()
                ->setDirectory(is_dir($default_dir) ? $default_dir : null)
                ->setOverrideDir($default_dir);
        endif;

        if (func_num_args() === 0) :
            return $this->viewer;
        endif;

        return $this->viewer->make("_override::{$view}", $data);
    }
}
