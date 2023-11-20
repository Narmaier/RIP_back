<?php

namespace App\Normalizer;
use App\Entity\Todo;
use App\Entity\Client;
use App\Entity\Order;
use App\Entity\Auto;
use App\Entity\State;
use App\Entity\Branch;
use App\Entity\Brand;
use App\Entity\Post;
use App\Entity\StaffMember;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class TodoNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        if ($object instanceof Client){
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'surname' => $object->getSurname(),
                'middle_name' => $object->getMiddleName(),
                'phone_number' => $object->getPhoneNumber(),
            ];
        }
        elseif($object instanceof Order){
            return [
                'id' => $object->getId(),
                'client' => $object->getClient()->getId(),
                'seller' => $object->getSeller()->getId(),
                'order_date' => $object->getOrderDate(),
                'buyout_date' => $object->getBuyoutDate(),
                'price' => $object->getPrice(),
                'auto' => $object->getAuto()->getId(),
            ];
        }
        elseif($object instanceof Post){
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
            ];
        }
        elseif($object instanceof StaffMember){
            return [
                'id' => $object->getId(),
                'post' => $object->getPost()->getId(),
                'name' => $object->getName(),
                'surname' => $object->getSurname(),
                'middle_name' => $object->getMiddleName(),
                'branch' => $object->getBranch()->getId(),
            ];
        }
        elseif($object instanceof State){
            return [
                'id' => $object->getId(),
                'name' => $object->getName(),
                'relations' => $object->getBranches(),
            ];
        }
        elseif($object instanceof Auto){
            return [
                'id' => $object->getId(),
                'brand' => $object->getBrand()->getId(),
                'colour' => $object->getColour(),
                'price' => $object->getPrice(),
                'year' => $object->getYear(),
                'location' => $object->getLocation()->getId(),
            ];
        }
        elseif($object instanceof Branch){
            return [
                'id' => $object->getId(),
                'state' => $object->getState()->getId(),
                'city' => $object->getCity(),
                'address' => $object->getAddress(),
                'phone_number' => $object->getPhoneNumber(),

            ];
        }
        elseif($object instanceof Brand){
            return[
                'id' => $object->getId(),
                'name' => $object->getName(),
            ];
        }
        throw new \InvalidArgumentException('The object must be an instance of Todo.');
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Auto || $data instanceof Branch || $data instanceof Brand || $data instanceof Client || $data instanceof Order || $data instanceof Post || $data instanceof StaffMember || $data instanceof State;
    }
}