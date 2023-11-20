<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TodoRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Todo;

#[Route('/api/rip')]
class RipController extends AbstractController
{   
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getList', methods: 'get')]
    public function index(TodoRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newTodo', methods: 'post')]
    public function create(Request $request, TodoRepository $repos): JsonResponse
    {   
        $todo = new Todo();
        $data = json_decode($request->getContent(), true);

        $todo->setName($data['name']);
        $todo->setDescription($data['description']);

        $repos->addToRep($todo);
        
        $jdata = $this->serializer->serialize($todo, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editTodo', methods:'put')]
    public function edit($id, Request $request, TodoRepository $repos): JsonResponse
    {   
        $todo = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $todo->setName($data['name']);
        $todo->setDescription($data['description']);

        $repos->addToRep($todo);

        $jdata = $this->serializer->serialize($todo, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteTodo', methods:'delete')]
    public function delete($id, TodoRepository $repos): JsonResponse
    {   
        $todo = $repos->find($id);
        $repos->deleteFromRep($todo);
        
        $jdata = $this->serializer->serialize($todo, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
