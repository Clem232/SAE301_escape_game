<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig');
    }

    #[Route('/jeux', name: 'jeux')]
    public function jeux(): Response
    {
        // Lire le fichier JSON
        $jsonPath = $this->getParameter('kernel.project_dir') . '/public/data/jeux.json';
        $jsonData = file_get_contents($jsonPath);
        $jeux = json_decode($jsonData, true);

        // Organiser les jeux par catégorie
        $categories = [];
        foreach ($jeux as $jeu) {
            $categorie = $jeu['Catégorie escape game'];
            $categories[$categorie][] = $jeu;
        }

        return $this->render('accueil/jeux.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/a-propos', name: 'a_propos')]
    public function aPropos(): Response
    {
        return $this->render('accueil/a_propos.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('accueil/contact.html.twig');
    }

    #[Route('/fiche/{code}', name: 'app_fiche')]
    public function fiche($code): Response
    {
        // Traitez votre code ici
        return $this->render('accueil/fiche.html.twig', ['code' => $code]);
    }

    #[Route('/reservation/{jeu}', name: 'reservation')]
    public function reservation(string $jeu): Response
    {
        // Lire le fichier JSON
        $jsonPath = $this->getParameter('kernel.project_dir') . '/public/data/jeux.json';
        $jsonData = file_get_contents($jsonPath);
        $jeux = json_decode($jsonData, true);

        // Trouver les informations du jeu sélectionné
        $jeuSelectionne = null;
        foreach ($jeux as $j) {
            $nomJeuFormatte = strtolower(str_replace(' ', '-', str_replace("'", '', $j['Nom jeux'])));
            if ($nomJeuFormatte === $jeu) {
                $jeuSelectionne = $j;
                break;
            }
        }

        if (!$jeuSelectionne) {
            throw $this->createNotFoundException('Jeu non trouvé');
        }

        return $this->render('accueil/reservation.html.twig', [
            'jeu' => $jeuSelectionne,
        ]);
    }
}
