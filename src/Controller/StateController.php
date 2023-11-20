<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StateRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\State;

#[Route('/api/state')]
class StateController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListState', methods: 'get')]
    public function index(StateRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newState', methods: 'post')]
    public function create(Request $request, StateRepository $repos): JsonResponse
    {   
        $state = new State();
        $data = json_decode($request->getContent(), true);

        $state->setName($data['name']);

        $repos->addToRep($state);
        
        $jdata = $this->serializer->serialize($state, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editState', methods:'put')]
    public function edit($id, Request $request, StateRepository $repos): JsonResponse
    {   
        $state = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $state->setName($data['name']);

        $repos->addToRep($state);

        $jdata = $this->serializer->serialize($state, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteState', methods:'delete')]
    public function delete($id, StateRepository $repos): JsonResponse
    {   
        $state = $repos->find($id);
        $repos->deleteFromRep($state);
        
        $jdata = $this->serializer->serialize($state, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
