<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
public function getFilters()
{
    return array(
    new TwigFilter('texteLimiter', array($this, 'formatTexte')),
    );
}

    public function formatTexte(string $texte,int $limite)
    {
        if (strlen($texte) >= $limite)
        {
            $chaine = substr($texte,0,$limite);
            $dernier_espace = strrpos($chaine,' ');
            return substr($chaine,0,$dernier_espace).'...';
        }
    }
}