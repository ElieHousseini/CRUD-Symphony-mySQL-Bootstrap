<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ArticleController {
  /**
   * @Route("/")
   */
  public function index(){
    return new Response('<html><body>Hello</body></html>');
  }
}