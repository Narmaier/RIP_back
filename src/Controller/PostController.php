<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;

#[Route('/api/post')]
class PostController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListPost', methods: 'get')]
    public function index(PostRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newPost', methods: 'post')]
    public function create(Request $request, PostRepository $repos): JsonResponse
    {   
        $post = new Post();
        $data = json_decode($request->getContent(), true);

        $post->setName($data['name']);

        $repos->addToRep($post);
        
        $jdata = $this->serializer->serialize($post, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editPost', methods:'put')]
    public function edit($id, Request $request, PostRepository $repos): JsonResponse
    {   
        $post = $repos->find($id);

        $data = json_decode($request->getContent(), associative:true);

        $post->setName($data['name']);

        $repos->addToRep($post);

        $jdata = $this->serializer->serialize($post, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deletePost', methods:'delete')]
    public function delete($id, PostRepository $repos): JsonResponse
    {   
        $post= $repos->find($id);
        $repos->deleteFromRep($todo);
        
        $jdata = $this->serializer->serialize($post, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
