<?php

namespace App\Controller;

use App\Repository\OutilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Outil;
use App\Form\OutilType;
use Doctrine\ORM\EntityManagerInterface;

class OutilController extends AbstractController
{
    #[Route('/outil', name: 'outil.index', methods: ['GET'])]
    public function index(
        OutilRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $outils = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/outil/index.html.twig', [
            'outils' => $outils
        ]);
    }

    #[Route('/outil/nouveau', name: 'outil.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $outil = new Outil();
        $form = $this->createForm(OutilType::class, $outil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $outil = $form->getData();

            $manager->persist($outil);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre outil a été créé avec succès !'
            );

            return $this->redirectToRoute('outil.index');
        }

        return $this->render('pages/outil/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/outil/edition/{id}', name: 'outil.edit', methods: ['GET', 'POST'])]
    public function edit(
        OutilRepository $repository,
        int $id,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $outil = $repository->findOneBy(['id' => $id]);

        if (!$outil) {
            throw $this->createNotFoundException('Outil non trouvé');
        }

        $form = $this->createForm(OutilType::class, $outil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre outil a été modifié avec succès !'
            );
            return $this->redirectToRoute('outil.index');
        }

        return $this->render('pages/outil/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/outil/suppression/{id}', name: 'outil.delete', methods: ['GET'])]
    public function delete(int $id, EntityManagerInterface $manager, OutilRepository $repository): Response
    {
        $outil = $repository->find($id);

        $manager->remove($outil);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre outil a été supprimé avec succès !'
        );

        return $this->redirectToRoute('outil.index');
    }
}
