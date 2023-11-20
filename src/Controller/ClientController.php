<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;

#[Route('/api/client')]
class ClientController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListClient', methods: 'get')]
    public function index(ClientRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newClient', methods: 'post')]
    public function create(Request $request, ClientRepository $repos): JsonResponse
    {   
        $client = new Client();
        $data = json_decode($request->getContent(), true);

        $client->setName($data['name']);
        $client->setSurname($data['surname']);
        $client->setMiddleName($data['middle_name']);
        $client->setPhoneNumber($data['phone_number']);

        $repos->addToRep($client);
        
        $jdata = $this->serializer->serialize($client, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editClient', methods:'put')]
    public function edit($id, Request $request, ClientRepository $repos): JsonResponse
    {   
        $client = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $client->setName($data['name']);
        $client->setSurname($data['surname']);
        $client->setMiddleName($data['middle_name']);
        $client->setPhoneNumber($data['phone_number']);

        $repos->addToRep($client);

        $jdata = $this->serializer->serialize($client, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteClient', methods:'delete')]
    public function delete($id, ClientRepository $repos): JsonResponse
    {   
        $client = $repos->find($id);
        $repos->deleteFromRep($client);
        
        $jdata = $this->serializer->serialize($client, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
