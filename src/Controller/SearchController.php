<?php
namespace App\Controller;

use App\Form\SearchType;
use App\Repository\CompanyRepository;
use App\Service\CompanyService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search')]
class SearchController extends AbstractController
{    
    #[Route('/index', name: 'search_index')]
    public function index(
                           Request $request, 
                           CompanyRepository $companyRepository,
                           CompanyService $companyService): Response
    {    
        $form = $this->createForm(SearchType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
                      
            $registrationDate = $companyService->getAccessorValue($request->request->all()['search'], 'registrationDate');            
            $companies = $companyRepository->findBy(['registrationDate' => new DateTime($registrationDate)]);
            
            return $this->render('company/list.html.twig', [
                'companies' => $companies,
                'page_search' => true
            ]);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView()            
        ]);
    }        
}