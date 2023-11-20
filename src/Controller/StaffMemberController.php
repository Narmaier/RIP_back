<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StaffMemberRepository;
use App\Repository\BranchRepository;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\StaffMember;

#[Route('/api/staff')]
class StaffMemberController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/', name: 'getListStaff', methods: 'get')]
    public function index(StaffMemberRepository $repos): JsonResponse
    {   
        $list = $repos->findAll();
        $jdata = $this->serializer->serialize($list, 'json');
        return new JsonResponse($jdata, 200, [], true);
    } 

    #[Route('/', name: 'newStaff', methods: 'post')]
    public function create(Request $request, StaffMemberRepository $repos, PostRepository $post_repos, BranchRepository $branch_repos): JsonResponse
    {   
        $staff = new StaffMember();
        $data = json_decode($request->getContent(), true);

        $branch = $branch_repos->find($data['branch']);
        $post = $post_repos->find($data['post']);

        $staff->setName($data['name']);
        $staff->setSurname($data['surname']);
        $staff->setMiddleName($data['middle_name']);
        $staff->setPost($post);
        $staff->setBranch($branch);

        $branch->addStaff($staff);
        $post->addStaffMember($staff);

        $repos->addToRep($staff);
        
        $jdata = $this->serializer->serialize($staff, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'editStaff', methods:'put')]
    public function edit($id, Request $request, StaffMemberRepository $repos, PostRepository $post_repos, BranchRepository $branch_repos): JsonResponse
    {   
        $staff = $repos->find($id);

        $branch = $branch_repos->find($data['branch']);
        $post = $post_repos->find($data['post']);
        
        $branch->removeStaff($staff);
        $post->removeStaffMember($staff);

        $staff->setName($data['name']);
        $staff->setSurname($data['surname']);
        $staff->setMiddleName($data['middle_name']);
        $staff->setPost($post);
        $staff->setBranch($branch);

        $branch->addStaff($staff);
        $post->addStaffMember($staff);

        $repos->addToRep($staff);

        $jdata = $this->serializer->serialize($staff, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }

    #[Route ('/{id}', name: 'deleteStaff', methods:'delete')]
    public function delete($id, StaffMemberRepository $repos): JsonResponse
    {   
        $staff = $repos->find($id);
        $staff->getPost()->removeStaffMember($staff);
        $staff->getBranch()->removeStaff($staff);
        $repos->deleteFromRep($staff);
        
        $jdata = $this->serializer->serialize($staff, 'json');
        return new JsonResponse($jdata, 200, [], true);
    }
}
