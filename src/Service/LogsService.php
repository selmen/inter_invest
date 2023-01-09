<?php

namespace App\Service;

use App\Entity\Logs;
use Doctrine\ORM\EntityManagerInterface;

class LogsService
{
     
    /**     
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param SerializerService $serializerService
     */
    public function __construct(
                                private EntityManagerInterface $entityManagerInterface,
                                private SerializerService $serializerService)
    {
        $this->entityManagerInterface = $entityManagerInterface;        
    }

    /**     
     *
     * @param object|null $object
     * @param string|null $status
     * @return void
     */
    public function create(?object $object, ?array $groups, ?string $status = Logs::STATUS_CREATE): void
    {
        if ($object) {            
            $nameClass = $this->getClass($object);                                   
            $data = $this->serializerService->normalize($object, $groups);                                  
            $logs = (new Logs())->setCreateById($object->getId())->setAction($status)->setNameEntity($nameClass)->setContents($data);
            $this->entityManagerInterface->persist($logs);
            $this->entityManagerInterface->flush();
        }
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