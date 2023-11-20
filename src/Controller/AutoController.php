<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AutoRepository;
use App\Repository\BranchRepository;
use App\Repository\BrandRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Auto;

#[Route('/api/auto')]
class AutoController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListAuto', methods: 'get')]
    public function index(AutoRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newAuto', methods: 'post')]
    public function create(Request $request, AutoRepository $repos, BranchRepository $repos_branch, BrandRepository $repos_brand): JsonResponse
    {   
        $auto = new Auto();
        $data = json_decode($request->getContent(), true);

        $branch = $repos_branch->find($data['branch']);
        $brand = $repos_brand->find($data['brand']);

        $auto->setBrand($brand);
        $auto->setColour($data['colour']);
        $auto->setPrice($data['price']);
        $auto->setYear(date_create($data['year']));
        $auto->setLocation($branch);

        $branch->addAuto($auto);
        $brand->addAuto($auto);

        $repos->addToRep($auto);
        
        $jdata = $this->serializer->serialize($auto, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editAuto', methods:'put')]
    public function edit($id, Request $request, AutoRepository $repos, BranchRepository $repos_branch, BrandRepository $repos_brand): JsonResponse
    {   
        $auto = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $branch = $repos_branch->find($data['branch']);
        $brand = $repos_brand->find($data['brand']);
        $branch->removeAuto($auto);
        $brand->removeAuto($auto);

        $auto->setBrand($brand);
        $auto->setColour($data['colour']);
        $auto->setPrice($data['price']);
        $auto->setYear(date_create($data['year']));
        $auto->setLocation($branch);

        $branch->addAuto($auto);
        $brand->addAuto($auto);
        $repos->addToRep($auto);

        $jdata = $this->serializer->serialize($auto, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteAuto', methods:'delete')]
    public function delete($id, AutoRepository $repos): JsonResponse
    {   
        $auto = $repos->find($id);
        $auto-getBrand()->removeAuto($auto);
        $auto-getBranch()->removeAuto($auto);
        $repos->deleteFromRep($auto);
        
        $jdata = $this->serializer->serialize($auto, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
