<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BranchRepository;
use App\Repository\StateRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Branch;

#[Route('/api/branch')]
class BranchController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListBranch', methods: 'get')]
    public function index(BranchRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newBranch', methods: 'post')]
    public function create(Request $request, BranchRepository $repos, StateRepository $repos_state): JsonResponse
    {   
        $branch = new Branch();
        $data = json_decode($request->getContent(), true);

        $state = $repos_state->find($data['state']);

        $branch->setState($state);
        $branch->setCity($data['city']);
        $branch->setAddress($data['address']);
        $branch->setPhoneNumber($data['phone_number']);

        $state->addBranch($branch);

        $repos->addToRep($branch);
        
        $jdata = $this->serializer->serialize($branch, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editBranch', methods:'put')]
    public function edit($id, Request $request, BranchRepository $repos,  StateRepository $repos_state): JsonResponse
    {   
        $branch = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $state = $repos_state->find($data['state']);
        $state->removeBranch($branch);

        $branch->setState($state);
        $branch->setCity($data['city']);
        $branch->setAddress($data['address']);
        $branch->setPhoneNumber($data['phone_number']);

        $state->addBranch($branch);

        $repos->addToRep($branch);
        
        $jdata = $this->serializer->serialize($branch, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteBranch', methods:'delete')]
    public function delete($id, BranchRepository $repos): JsonResponse
    {   
        $branch = $repos->find($id);
        $branch->getState()->removeBranch($branch);

        $repos->deleteFromRep($auto);
        
        $jdata = $this->serializer->serialize($branch, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
