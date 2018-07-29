<?php

namespace App\Controller;
use App\Entity\Category;
use App\Entity\Proverb;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    private function json_response(Array $data)
    {
      $data_json = json_encode($data);
      $res = new Response();
      $res->headers->set('Content-Type', 'application/json');
      $res->headers->set('Access-Control-Allow-Origin', '*');
      //$res->headers->set('Access-Control-Allow-Methods', '*');
      $res->headers->set('Access-Control-Allow-Headers', 'Content-Type');
      $res->setContent($data_json);
      return $res;
    }

    /**
     * @Route("/api/category", name="api_category")
     */
    public function category()
    {
          $categoryRepo =
            $this->getDoctrine()->getRepository(Category::class);

          $categories = $categoryRepo->findBy([], ['label' => 'ASC']);


          $categories_assoc = [];
          foreach($categories as $category) {
            $category_assoc = array(
              'id' => $category->getId(),
              'label' => $category->getLabel()
            );
            array_push($categories_assoc, $category_assoc);
          }

          return $this->json_response($categories_assoc);
    }



    /**
     * @Route("/api/proverb", name="api_proverb")
     */
    public function proverb(Request $request)
    {
      // récupération des paramètres d'URL
      // ->query donne accès à la superglobale $_GET
      $category_id      = intval($request->query->get('cat'));

      $filters = []; // par défaut pas de filtre
      if ($category_id != 0) $filters['category'] = $category_id;

      $proverbRepo = $this->getDoctrine()->getRepository(Proverb::class);
      $proverbes = $proverbRepo->findBy($filters, []);

      if ($proverbes) {
        //return $this->json_response(['question0' => $questions[0]->getLabel()]);
        $prov = [];
        foreach($proverbes as $proverb) {
          $proverb = [
            'id' => $proverb->getId(),
            'title' => $proverb->getTitle(),
            'auteur' => $proverb->getAuteur(),
            'category'=>$proverb->getCategory()
          ];
          array_push($prov, $proverb);
        }
        shuffle($prov); // mélange les éléments du tableau de manière aléatoire
        return $this->json_response($prov);

      } else {
        return $this->json_response(['prov' => 'aucune proverb']);
      }

    }

}
