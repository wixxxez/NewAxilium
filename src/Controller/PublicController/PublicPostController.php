<?php
namespace App\Controller\PublicController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepositoryInterface;
use App\Service\PostService;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use App\Service\CommentService;

class PublicPostController extends PublicController  {

    private $PostRepostitory;
    private $PostService;
    private $CommentService;
    public function __construct(PostRepositoryInterface $pri, PostService $ps,CommentService $com)
    {
        $this->PostRepostitory=$pri;
        $this->PostService= $ps;
        $this->CommentService=$com;
    }
    /**
     * @Route("/post/{id}", name="post")
     * @param int $id
     * @param Request $request
     */
    public function index(Request $request, int $id, UserRepositoryInterface $uri){
        $post = $this->PostRepostitory->getOne($id);
        $user  = $this->getUser();
        $filename = $this->CommentService->getFile($id);
        $commentForm=null;
        if($user != null){
            
            $commentForm = $this->createForm(CommentType::class);
            $commentForm->handleRequest($request);
            if($commentForm->isSubmitted() && $commentForm->isValid()){
                $u = $uri->getOne($this->getUser()->getId());
                $text = $commentForm->get('text')->getData();
                $this->CommentService->addComment($u,$this->CommentService->getFileName($id),$text);
                return $this->redirectToRoute('post',['id'=>$id]);
            }
            $commentForm = $commentForm->createView();
        }
        
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>'',
                'post'=>$post,
                'amount'=>$this->PostService->getAmount($post),
                'comments'=>$filename,
                'comForm'=>$commentForm
                
               
            ];
            if($form == null ){
                return $this->redirectToRoute('post',['id'=>$id]);
            }
        return $this->render('public/post.html.twig',$data);
    }
}