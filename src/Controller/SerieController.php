<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SerieController extends AbstractController
{
    /**
     * @Route ("/series", name="serie_list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
       // $series = $serieRepository->findBy([],['vote'=>'DESC','popularity'=>'DESC'], 30);
        $series = $serieRepository->findBestSeries();

        return $this->render('serie/list.html.twig.', [
            "series"=>$series

        ]);
    }

    /**
     * @Route ("/series/details/{id}", name="serie_details")
     */
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);

        return $this->render('serie/details.html.twig.', ["serie"=>$serie

        ]);
    }

    /**
     * @Route ("/series/create", name="serie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());
        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);
        //dump($serie);

        if($serieForm->isSubmitted() && $serieForm->isValid()){
            $entityManager->persist($serie);
            $entityManager->flush();

            $this->addFlash('success','Serie added! Good job.');

            return $this->redirectToRoute('serie_details',['id'=>$serie->getId()]);
        }

        return $this->render('serie/create.html.twig.', [
            'serieForm'=>$serieForm->createView()
        ]);
    }

    /**
     * @Route ("/series/demo", name="serie_demo")
     */
    public function demo(EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();

        $serie->setName('Breaking Bad');
        $serie->setBackdrop('darr');
        $serie->setPoster('dagfgd');
        $serie->setFirstAirDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("-1 month"));
        $serie->setGenres('dagfgd');
        $serie->setOverview('dagfgd');
        $serie->setPopularity(123);
        $serie->setVote(10);$serie->setPoster('dagfgd');
        $serie->setStatus('Fini');
        $serie->setTmdbId(5464);
        $serie->setDateCreated(new \DateTime());
        $serie->setDateModified(new \DateTime());

        dump($serie);

        $entityManager->persist($serie);
        $entityManager->flush();

        /*$entityManager->remove($serie);
        $entityManager->flush();*/

        return $this->render('serie/create.html.twig', [

        ]);
    }
}
