<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Repository\StaffMemberRepository;
use App\Repository\AutoRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Order;

#[Route('/api/order')]
class OrderController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListOrder', methods: 'get')]
    public function index(OrderRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newOrder', methods: 'post')]
    public function create(Request $request, OrderRepository $repos, StaffMemberRepository $repos_staff,AutoRepository $repos_auto,ClientRepository $repos_client): JsonResponse
    {   
        $order = new Order();
        $data = json_decode($request->getContent(), true);

        $staff = $repos_staff->find($data['seller']);
        $auto = $repos_auto->find($data['auto']);
        $client = $repos_client->find($data['client']);

        $order->setClient($client);
        $order->setSeller($staff);
        $order->setAuto($auto);
        $order->setPrice($data['price']);
        $order->setOrderDate(date_create($data['order_date']));
        $order->setBuyoutDate(date_create($data['buyout_date']));

        $staff->addSale($order);
        $auto->addOrder($order);
        $client->addOrder($order);

        $repos->addToRep($order);
        
        $jdata = $this->serializer->serialize($order, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editOrder', methods:'put')]
    public function edit($id, Request $request, OrderRepository $repos, StaffMemberRepository $repos_staff,AutoRepository $repos_auto,ClientRepository $repos_client): JsonResponse
    {   
        $order = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $staff = $repos_staff->find($data['seller']);
        $auto = $repos_auto->find($data['auto']);
        $client = $repos_client->find($data['client']);

        $staff->removeSale($order);
        $auto->removeOrder($order);
        $client->removeOrder($order);

        $order->setClient($client);
        $order->setSeller($staff);
        $order->setAuto($auto);
        $order->setPrice($data['price']);
        $order->setOrderDate(date_create($data['order_date']));
        $order->setBuyoutDate(date_create($date['buyout_date']));

        $staff->addSale($order);
        $auto->addOrder($order);
        $client->addOrder($order);

        $repos->addToRep($order);

        $jdata = $this->serializer->serialize($order, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteOrder', methods:'delete')]
    public function delete($id, OrderRepository $repos): JsonResponse
    {   
        $order = $repos->find($id);
        $jdata = $this->serializer->serialize($order, 'json');
        $order->getSeller()->removeSale($order);
        $order->getClient()->removeOrder($order);
        $order->getAuto()->removeOrder($order);
        $repos->deleteFromRep($order);
        return new JsonResponse($jdata, 200, [], true);
    }
}
