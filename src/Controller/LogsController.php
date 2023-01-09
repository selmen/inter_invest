<?php
namespace App\Controller;

use App\Entity\Logs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/logs')]
class LogsController extends AbstractController
{    
    #[Route('/list/{id}/{className}', name: 'logs_list')]
    public function list(?int $id, ?string $className, EntityManagerInterface $em): Response
    {                                    
        $logs = $em->getRepository(Logs::class)->findLogsByNameEntityAndId($className, $id);  
              
        return $this->render('logs/list.html.twig', [            
            'logs' => $logs
        ]);
    }        
}