<?php

namespace App\Service;

use App\Entity\Address;
use Doctrine\ORM\EntityManagerInterface;

class AddressService
{
     
    /**     
     *
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(private EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }

    /**     
     *
     * @return array
     */
    public function getScalarAddress(): array
    {
        $list_address = [];

        foreach ($this->entityManagerInterface->getRepository(Address::class)->findAll() as $address) {
            $list_address[$address->getId()] = $address->getNumber().' '.$address->getChannelType().' '.$address->getChannelName().' '.$address->getPostalCode().' '.$address?->getCity()?->getName();
        }

        return $list_address;
    }
}