<?php

namespace App\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LogsExtension extends AbstractExtension
{
    /**     
     *
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(private EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getClass', [$this, 'getClass']),
        ];
    }

    /**     
     *
     * @param object|null $object
     * @return string|null
     */
    public function getClass(?object $object): ?string
    {        
        return $this->entityManagerInterface->getClassMetadata($object::class)->getName();  
    }
}