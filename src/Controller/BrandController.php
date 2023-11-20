<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Brand;

#[Route('/api/brand')]
class BrandController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListBrand', methods: 'get')]
    public function index(BrandRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newBrand', methods: 'post')]
    public function create(Request $request, BrandRepository $repos): JsonResponse
    {   
        $brand = new Brand();
        $data = json_decode($request->getContent(), true);

        $brand->setName($data['name']);

        $repos->addToRep($brand);
        
        $jdata = $this->serializer->serialize($brand, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editBrand', methods:'put')]
    public function edit($id, Request $request, BrandRepository $repos): JsonResponse
    {   
        $brand = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $brand->setName($data['name']);

        $repos->addToRep($brand);

        $jdata = $this->serializer->serialize($brand, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteBrand', methods:'delete')]
    public function delete($id, BrandRepository $repos): JsonResponse
    {   
        $brand = $repos->find($id);
        $repos->deleteFromRep($brand);
        
        $jdata = $this->serializer->serialize($brand, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
