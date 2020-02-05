<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/article", name="admin_article")
     * @param ArticleRepository $articleRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy([], ['date' => 'DESC']);
        return $this->render('admin_article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/admin/article/new", name="admin_article_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article); //pertmet de créer un formulaire

        $form->handleRequest($request); //permet d'hydrater l'entité article
        if ($form->isSubmitted() && $form->isValid()) {
           $entityManager->persist($article); //permet l'ajout en bdd avec entityManager et persist qui prend en compte avec doctrine
           $entityManager->flush();
           $this->addFlash('success', "L' atricle a été crée");

           return $this->redirectToRoute('admin_article');
        }

        return $this->render('admin_article/new.html.twig', [
            'form' => $form->createView(), //permet d'afficher le formuaire créée et à afficher dans la vue new.html.twig
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="admin_article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('warning', "L'article' a été modifiée");

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('admin_article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
}

