<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

class SerializerService
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
     * @param object|null $object
     * @return string|null
     */
    public function serialize(?object $object): ?string
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders); 
        
        return $serializer->serialize($object, 'json');        
    }

    /**     
     *
     * @param object|null $object
     * @return array|null
     */
    public function normalize(?object $object, ?array $groups): ?array
    {         
        // $normalizer = new ObjectNormalizer(null, null, null, new ReflectionExtractor());
        // $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);
    
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new PropertyNormalizer($classMetadataFactory);
        $serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);

        return $serializer->normalize($object, null, ['groups' => $groups]);
    }
}