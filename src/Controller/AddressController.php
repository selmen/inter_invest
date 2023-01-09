<?php
namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/address')]
class AddressController extends AbstractController
{    
    #[Route('/list', name: 'address_list')]
    public function list(AddressRepository $addressRepository): Response
    {                                       
        return $this->render('address/list.html.twig', [
            'list_address' => $addressRepository->findAll()
        ]);
    } 
    
    #[Route('/add', name: 'address_add')]
    public function add(
                        Request $request, 
                        AddressRepository $addressRepository): Response
    {          
        $address = new Address();
        
        $form = $this->createForm(AddressType::class, $address);        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {  
            $addressRepository->save($address, true);

            return $this->redirectToRoute('address_add', [], Response::HTTP_CREATED); 
        }

        return $this->render('address/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/edit/{id}', name: 'address_edit')]
    public function edit(
                        Address $address, 
                        AddressRepository $addressRepository,
                        Request $request): Response
    {      
        $form = $this->createForm(AddressType::class, $address);        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {  
            $addressRepository->save($address, true);

            return $this->redirectToRoute('address_edit', ['id' => $address->getId()], Response::HTTP_CREATED); 
        }

        return $this->render('address/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'address_delete')]
    public function delete(
                            Address $address, 
                            AddressRepository $addressRepository): Response
    {         
        if ($address) {
            $addressRepository->remove($address, true);
        } 

        return $this->redirectToRoute('address_list', [], Response::HTTP_SEE_OTHER);
    }
}