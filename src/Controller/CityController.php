<?php
namespace App\Controller;

use App\Entity\City;
use App\Form\CityType;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/city')]
class CityController extends AbstractController
{    
    #[Route('/list', name: 'city_list')]
    public function list(CityRepository $cityRepository): Response
    {                                       
        return $this->render('city/list.html.twig', [
            'cities' => $cityRepository->findAll()
        ]);
    } 
    
    #[Route('/add', name: 'city_add')]
    public function add(
                        Request $request, 
                        CityRepository $cityRepository): Response
    {          
        $city = new City();
        
        $form = $this->createForm(CityType::class, $city);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            $cityRepository->save($city, true);

            return $this->redirectToRoute('city_add', [], Response::HTTP_CREATED); 
        }

        return $this->render('city/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/edit/{id}', name: 'city_edit')]
    public function edit(
                        City $city, 
                        CityRepository $cityRepository,
                        Request $request): Response
    {      
        $form = $this->createForm(CityType::class, $city);        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {  
            $cityRepository->save($city, true);

            return $this->redirectToRoute('city_edit', ['id' => $city->getId()], Response::HTTP_CREATED); 
        }

        return $this->render('city/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'city_delete')]
    public function delete(
                            City $city, 
                            CityRepository $cityRepository): Response
    {         
        if ($city) {
            $cityRepository->remove($city, true);
        } 

        return $this->redirectToRoute('city_list', [], Response::HTTP_SEE_OTHER);
    }
}