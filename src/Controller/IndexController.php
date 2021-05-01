<?php
namespace App\Controller;
use App\Entity\Film;
use App\Form\FilmType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Genre;
use App\Form\GenreType;
use App\Form\PropertySearchType;
use App\Entity\PropertySearch;
use App\Entity\GenreSearch;
use App\Form\GenreySearchType;
use App\Entity\dureeSearch;
use App\Form\DureeSearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class IndexController extends AbstractController
{

/**
 *@Route("/",name="film_list")
 */
public function home(Request $request)
{
$propertySearch = new PropertySearch();
$form = $this->createForm(PropertySearchType::class,$propertySearch);
$form->handleRequest($request);
//initialement le tableau des films est vide,
//c.a.d on affiche les films que lorsque l'utilisateur
//clique sur le bouton rechercher
$films= [];

if($form->isSubmitted() && $form->isValid()) {
//on récupère le nom du film tapé dans le formulaire
$titre= $propertySearch->getTitre(); 
if ($titre!="")
//si on a fourni un nom d'article on affiche tous les films ayant ce nom
$films= $this->getDoctrine()->getRepository(Film::class)->findBy(['titre' => $titre] );
else 
//si si aucun nom n'est fourni on affiche tous les films
$films= $this->getDoctrine()->getRepository(Film::class)->findAll();
}
return $this->render('films/index.html.twig',[ 'form' =>$form->createView(), 'films' => $films]); 

}
 
 /**
 * @Route("/film/save")
 */
public function save() {
  $entityManager = $this->getDoctrine()->getManager();
  $film = new Film();
  $film->setTitre('wolf town ');
  $film->setDuree('1h30');
  $entityManager->persist($film);
  $entityManager->flush();
  return new Response('film enregisté avec id '.$film->getId());
  }

  /**
 * @IsGranted("ROLE_EDITOR")
 * @Route("/film/new", name="new_film")
 * Method({"GET", "POST"})
 */

 public function new(Request $request) {
  $film = new Film();
  $form = $this->createForm(FilmType::class,$film);
  $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid()) {
  $film = $form->getData();
  $entityManager = $this->getDoctrine()->getManager();
  $entityManager->persist($film);
  $entityManager->flush();
  return $this->redirectToRoute('film_list');
  }
  return $this->render('films/new.html.twig',['form' => $form->createView()]);
  }
 /**
 * @Route("/film/{id}", name="film_show")
 */
 public function show($id) {
 $film= $this->getDoctrine()->getRepository(Film::class)->find($id);
 return $this->render('films/show.html.twig',
 array('film' => $film));
 }
 /**
 * @IsGranted("ROLE_EDITOR")
 * @Route("/film/edit/{id}", name="edit_film")
 * Method({"GET", "POST"})
 */
public function edit(Request $request, $id) {
  $film = new Film();
  $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
  
  $form = $this->createForm(FilmType::class,$film);
  
  $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid()) {
  
  $entityManager = $this->getDoctrine()->getManager();
  $entityManager->flush();
  
  return $this->redirectToRoute('film_list');
  }
  
  return $this->render('films/edit.html.twig', ['form' =>$form->createView()]);
  }
 
  /**
 * @IsGranted("ROLE_EDITOR")
 * @Route("/film/delete/{id}",name="delete_film")
 * @Method({"DELETE"})
 */
 public function delete(Request $request, $id) {
  $film=$this->getDoctrine()->getRepository(Film::class)->find($id);
  
  $entityManager = $this->getDoctrine()->getManager();
  $entityManager->remove($film);
  $entityManager->flush();
  
  $response = new Response();
  $response->send();
  return $this->redirectToRoute('film_list');
  }

  /**
 * @Route("/Genre/newCat", name="new_Genre")
 * Method({"GET", "POST"})
 */
 public function newGenre(Request $request) {
  $Genre = new Genre();
  $form = $this->createForm(GenreType::class,$Genre);
  $form->handleRequest($request);
  if($form->isSubmitted() && $form->isValid()) {
  $film = $form->getData();
  $entityManager = $this->getDoctrine()->getManager();
  $entityManager->persist($film);
  $entityManager->flush();
  }
 return $this->render('films/newGenre.html.twig',['form'=>$form->createView()]);
  }
 
/**
 * @Route("/fil_gent/", name="film_par_gen")
 * Method({"GET", "POST"})
 */
public function FilmParGenre(Request $request) {
  $GenreSearch = new GenreSearch();
  $form = $this->createForm(GenreySearchType::class,$GenreSearch);
  $form->handleRequest($request);
  $films= [];
  if($form->isSubmitted() && $form->isValid()) {
    $Genre= $GenreSearch->getGenre();
    
    if ($Genre!="")
   $films= $Genre->getFilm();
    else 
    $films= $this->getDoctrine()->getRepository(Film::class)->findAll();
    }
    
    return $this->render('films/FilmParGenre.html.twig',['form' => $form->createView(),'films' => $films]);
    }

  
    /**
 * @Route("/fil_duree/", name="film_par_duree")
 * Method({"GET"})
 */
 public function filmParduree(Request $request)
 {
 
 $dureeSearch  = new dureeSearch ();
 $form = $this->createForm(dureeSearchType::class,$dureeSearch );
 $form->handleRequest($request);
 $films= [];
 if($form->isSubmitted() && $form->isValid()) {
 $minduree = $dureeSearch ->getMinDuree();
 $maxduree = $dureeSearch->getMaxDuree();
 
 $films= $this->getDoctrine()->
getRepository(Film::class)->findByPriceRange($minduree,$maxduree);
 }
 return $this->render('films/filmParduree.html.twig',[ 'form' =>$form->createView(), 'films' => $films]); 
 }
   
}
