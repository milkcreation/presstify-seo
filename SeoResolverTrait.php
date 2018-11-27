<?php

namespace tiFy\Plugins\Seo;

use tiFy\Contracts\View\ViewController;
use tiFy\Contracts\View\ViewEngine;
use tiFy\Plugins\Seo\Contracts\Metatag;
use tiFy\Plugins\Seo\Metatag\Manager as MetatagManager;

trait SeoResolverTrait
{
    /**
     * Récupération de l'instance du gestionnaire principal.
     *
     * @return SeoManager
     */
    public function manager()
    {
        return app('seo');
    }

    /**
     * Récupération du chemin absolu vers une ressource.
     *
     * @param string $path Chemin relatif de la ressource.
     *
     * @return resource
     */
    public function resourcesDir($path = '')
    {
        $cinfo = class_info($this->manager());
        $path = '/Resources/' . ltrim($path, '/');

        return file_exists($cinfo->getDirname() . $path) ? $cinfo->getDirname() . $path : '';
    }

    /**
     * Récupération de l'url absolue vers une ressource.
     *
     * @param string $path Chemin relatif de la ressource.
     *
     * @return resource
     */
    public function resourcesUrl($path = '')
    {
        $cinfo = class_info($this->manager());
        $path = '/Resources/' . ltrim($path, '/');

        return file_exists($cinfo->getDirname() . $path) ? $cinfo->getUrl() . $path : '';
    }

    /**
     * Récupération de l'instance du gestionnaire de balise méta ou définition d'une méta balise.
     *
     * @param null|string $tag Nom de qualification de la balise.
     * @param null|string $value Valeur de la balise à définir.
     * @param string $context Contexte associé. '*' par défaut.
     *
     * @return MetatagManager|Metatag
     */
    public function metatag($tag = null, $value = null, $context = '*')
    {
        /** @var MetatagManager $metatag */
        $metatag = app('seo.metatag.manager');

        if (is_null($tag)) :
            return $metatag;
        elseif(is_null($value)) :
            return $metatag->make($tag);
        endif;

        return $metatag->add($tag, $value, $context);
    }

    /**
     * Récupération d'un instance du controleur de liste des gabarits d'affichage ou d'un gabarit d'affichage.
     * {@internal Si aucun argument n'est passé à la méthode, retourne l'instance du controleur de liste.}
     * {@internal Sinon récupére l'instance du gabarit d'affichage et passe les variables en argument.}
     *
     * @param null|string view Nom de qualification du gabarit.
     * @param array $data Liste des variables passées en argument.
     *
     * @return ViewController|ViewEngine
     */
    public function viewer($view = null, $data = [])
    {
        if (!app()->bound('seo.viewer')) :
            app()->singleton(
                'seo.viewer',
                function () {
                    $default_dir = $this->resourcesDir('/views');

                    return view()
                        ->setDirectory(is_dir($default_dir) ? $default_dir : null)
                        ->setOverrideDir($default_dir);
                }
            );
        endif;

        /** @var ViewEngine $viewer */
        $viewer = app('seo.viewer');

        if (func_num_args() === 0) :
            return $viewer;
        endif;

        return $viewer->make("_override::{$view}", $data);
    }
}
