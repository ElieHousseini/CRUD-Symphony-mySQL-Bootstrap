<?php
namespace App\Controller;

// Importing Article file from Entity Folder
// I am using it in the save function.
use App\Entity\Article;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController{
  /**
   * @Route("/", name = "article_list")
   * @Method({"GET"})
   */
  public function index(){
    // return new Response('<html><body>Hello</body></html>');

    // $articles = ['Article 1', 'Article 2'];
    // getRepository(Article::class) function will get the Article class from entity
    // findAll() function will get everything from that Article Class
    $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
    
    // rending the page articles/index.html.twig
    // passing the array arrticles under the name articles.
    return $this->render('articles/index.html.twig', array('articles' => $articles));
  }

  /**
   * @Route("/article/{id}", name="article_show")
   */
  public function show($id){
    
    $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

    return $this->render('articles/show.html.twig', array('article' => $article));
  }

  /**
   * 
   * @Route("/article/save")
   */

   // Storing Articles in the DB
   // When you go to /article/save, it will automatically
   // Save a new article using doctrine to the mySQL DB. 
  public function save(){
    $entityManager = $this->getDoctrine()->getManager();

    // Creating a new Article Object
    $article = new Article();

    // Adding the info needed according to the fields in the DB
    // those functions must be created in Entity/Article.php
    // I did not added the setId() function because it's auto-increment
    // in the mySQL DB
    $article->setTitle('Article One');
    $article->setBody('This is the body for article One');

    // It's hard to write what persist does in few lines
    // Here is a link about it on stack overflow: https://bit.ly/2FxSF9l
    $entityManager->persist($article);

    // executing the query
    $entityManager->flush();

    // a feedback on the screen to show that the query was actually executed 
    // And the mySQL DB was updated accordingly
    return new Response('Saves an article with the id of '.$article->getId());
  }
}