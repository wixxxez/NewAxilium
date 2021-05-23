<?php
namespace App\Controller\PublicController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepositoryInterface;
use App\Service\PostService;
use App\Entity\Post;
class PublicPostController extends PublicController  {

    private $PostRepostitory;
    private $PostService;
    public function __construct(PostRepositoryInterface $pri, PostService $ps)
    {
        $this->PostRepostitory=$pri;
        $this->PostService= $ps;
    }
    /**
     * @Route("/post/{id}", name="post")
     * @param int $id
     * @param Request $request
     */
    public function index(Request $request, int $id){
        $post = $this->PostRepostitory->getOne($id);
        $userName = $post->getNickname()->getName();
       
            $form = parent::getRegForm($request);
            $data  = [
                'Regform' =>$form,
                'last_username'=>'',
                'error'=>'',
                'post'=>$post,
                'amount'=>$this->PostService->getAmount($post),
                'nickname'=>$userName
               
            ];
            if($form == null ){
                return $this->redirectToRoute('post',['id'=>$id]);
            }
        return $this->render('public/post.html.twig',$data);
    }
}