<?php

namespace tiFy\Plugins\Seo\Metatag;

/**
 * Class Robots
 * @package tiFy\Plugins\Seo\Metatag
 *
 * @see https://www.yakaferci.com/meta-robots/
 * noindex          Cette balise meta robot empêche l’indexation de la page qui la contient.
 *                  Notez que la page sera tout de même crawlé mais ne sera pas indexé dans les résultats.
 *                  Pour empêcher le crawling et l’indexation d’une page, utilisez plutôt le fichier robot.txt
 * nofollow         La balise meta robot nofollow empêche le robot de Google (googlebot) de suivre les liens contenus dans cette page.
 * none             Equivalent à noindex et nofollow.
 * nosnippet        La balise meta tag robot nosnippet empêche l’affichage d’un extrait du contenu dans les résultats de recherche.
 * noodp            La balise meta tag noodp interdit l’utilisation d’une description de replacement tirée des annuaires DMOZ.
 * noarchive        La balise meta robot noarchive sert à empêcher l’affichage d’un lien placé en cache et associé à une page..
 * unavailable_after: [date ]    Cette balise meta tag robot permet de préciser l’heure et la date exactes aux quelles l’exploration et l’indexation de la page en questions doivent cesser.
 * noimageindex     Cette balise meta tag robot permet d’indiquer que la page en question doit être indiquée comme source d’une image.
 */
class Robots extends AbstractMetatag
{
    /**
     * {@inheritdoc}
     */
    public function content()
    {
        return $this->content ? : 'index, follow';
    }
}