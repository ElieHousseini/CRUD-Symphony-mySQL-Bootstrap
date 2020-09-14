<?php
namespace App\Controller;

// Importing Article file from Entity Folder
// I am using it in the save function.
use App\Entity\Article;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
   * @Route("/article/new", name = "new_article")
   * Method({"GET", "POST"})
   */
  public function new(Request $request){
    $article = new Article();

    $form = $this->createFormBuilder($article)->add('title', TextType::class, array('attr'
  => array('class' => 'form-control')
  ))->add('body',TextareaType::class, array(
    'required' => false,
    'attr' => array('class' => 'form-control')
  ))
  ->add('save', submitType::class, array(
    'label' => 'Create',
    'attr' => array('class' => 'btn btn-primary my-3')
  ))
  ->getForm();
  
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
      $article = $form->getData();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($article);
      $entityManager->flush();

      return $this->redirectToRoute('article_list');
    }

return $this->render('articles/new.html.twig', array(
  'form' => $form->createView()
));
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