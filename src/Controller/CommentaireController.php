<?php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Core\Security\Security;
use Symfony\Component\Security\Core\Security;

class CommentaireController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/commentaire', name: 'app_commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }
    #[Route('/commentaire/new/{articleId}', name: 'app_commentaire_new_for_article', methods: ['GET', 'POST'])]
    public function newForArticle(Request $request, Security $security, $articleId): Response
    {
        $article = $this->entityManager->getRepository(Article::class)->find($articleId);
    
        if (!$article) {
            throw $this->createNotFoundException('Article not found');
        }
    
        $commentaire = new Commentaire();
        $commentaire->setArticle($article);
        $commentaire->setAuteur($security->getUser());
    
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($commentaire);
            $this->entityManager->flush();
    
            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/commentaire/{id}', name: 'app_commentaire_show', methods: ['GET'])]
    public function show($id, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = $commentaireRepository->find($id);
    
        if (!$commentaire) {
            throw $this->createNotFoundException('Commentaire not found');
        }
    
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }
    
    

    #[Route('/commentaire/{id}/edit', name: 'app_commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/commentaire/{id}', name: 'app_commentaire_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
