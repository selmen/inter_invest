<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

class CompanyService
{
     
    /**     
     *
     * @param EntityManagerInterface $entityManagerInterface
     * @param CompanyRepository $companyRepository
     * @param LogsService $logsService
     */
    public function __construct(
                                private EntityManagerInterface $entityManagerInterface,
                                private CompanyRepository $companyRepository,
                                private LogsService $logsService)
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->companyRepository = $companyRepository;
        $this->logsService = $logsService;
    }

    /**     
     *
     * @param Company $company
     * @param array $data
     * @return void
     */
    public function create(Company $company, array $data, ?array $groups, ?string $status): void
    {
        $this->companyRepository->save($company, true);

        if (array_key_exists('company', $data) && array_key_exists('address', $data['company'])) {
            
            $list_address = $data['company']['address'];            
            
            foreach ($list_address as $id) {
                
                $address = $this->entityManagerInterface->getRepository(Address::class)->find($id); 
                $company->addAddress($address); 
                
                $this->entityManagerInterface->persist($company);
                $this->entityManagerInterface->flush();                 
            }        
        }

        $this->logsService->create($company, $groups, $status);
    }

    public function getAccessorValue(?array $data, ?string $keys)
    {        
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->getValue($data, '['.$keys.']'); 
    }
}