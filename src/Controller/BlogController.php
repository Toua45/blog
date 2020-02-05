<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleSearchType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     */
    public function index(ArticleRepository $articleRepository, Request $request)
    {
        $form = $this->get('form.factory')->createNamed('', ArticleSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $search = $data['search'];
            $category = $data['category'];
            $articles = $articleRepository->findLikeName($search, $category); //requête pour cherche les articles avec une queryBuiilder dans ArticleRepository
        } else {
            $articles = $articleRepository->findBy([], ['date' => 'DESC']);
            /**permet de trier par date la plus récente**/
        }

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/show-article/{slug}", name="blog_show")
     */
    public function show(Article $article)
    {
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
}
