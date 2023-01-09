<?php
namespace App\Controller;

use App\Entity\Company;
use App\Entity\Logs;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Service\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company')]
class CompanyController extends AbstractController
{    
    #[Route('/list', name: 'company_list')]
    public function list(CompanyRepository $companyRepository): Response
    {                                       
        return $this->render('company/list.html.twig', [
            'companies' => $companyRepository->findAll()
        ]);
    } 
    
    #[Route('/add', name: 'company_add')]
    public function add(
                        Request $request,
                        CompanyService $companyService): Response
    {    
        $company = new Company();
        
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $companyService->create($company, $request->request->all(), ['list_company'], Logs::STATUS_CREATE);           
            return $this->redirectToRoute('company_add', [], Response::HTTP_CREATED);
        }

        return $this->render('company/add.html.twig', [
            'form' => $form->createView()
        ]);
    } 

    #[Route('/edit/{id}', name: 'company_edit')]
    public function edit(
                        Company $company,                        
                        Request $request,
                        CompanyService $companyService): Response
    {                    
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $companyService->create($company, $request->request->all(), ['list_company'], Logs::STATUS_UPDATE);
            return $this->redirectToRoute('company_edit', ['id' => $company->getId()], Response::HTTP_CREATED);
        }

        return $this->render('company/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/delete/{id}', name: 'company_delete')]
    public function delete(
                            Company $company, 
                            CompanyRepository $companyRepository): Response
    {         
        if ($company) {
            $companyRepository->remove($company, true);
        } 

        return $this->redirectToRoute('company_list', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/{id}/address/list', name: 'company_list_address')]
    public function listAddress(Company $company): Response
    {           
        return $this->render('address/list.html.twig', [
            'list_address' => $company->getAddress(),
            'company' => $company 
        ]);        
    }
}