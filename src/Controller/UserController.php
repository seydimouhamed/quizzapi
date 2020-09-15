<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $em;
    private $validator;
    private $serializer;
    private $encoder;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder)
    {
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->encoder=$encoder;
    }

    /**
     * @Route(
     *     name="get",
     *     path="/api/users/{username}",
     *     methods={"GET"}
     *  )
     */
    public function getUserByUsername(string $username)
    {
        $user = $this->em->getRepository(User::class)->findByUsername($username);

        return $this->json($user[0],200);
    }
    /**
     * @Route(
     *     name="postUser",
     *     path="/api/register",
     *     methods={"POST"}
     *  )
     */
    public function addUser(Request $req)
    {
        //$user = $this->em->getRepository(User::class)->findByUsername($username);

        $dataUser=$req->request->all();;
      // dd($dataUser);
        $user=$this->serializer->denormalize($dataUser,User::class,true);
      // return $this->json(json_decode($req->getContent(),true),200);
      //  dd($user);


        $img=$req->files->get('avatar');
        if($img)
        {
            $avatar=\fopen($img->getRealPath(),'rb');
            $user->setAvatar($avatar);
           // \fclose($img);
        }

        $errors = $this->validator->validate($user);
        if(count($errors))
        {
            $errors = $this->serializer->serialize($errors,'json');
            return new JsonResponse($errors,400,[],true);
        }

        $password=$user->getPassword();
      //  dd($password);
        $user->setPassword($this->encoder->encodePassword($user,'fgghgh'));
    // dd($user);
        $this->em->persist($user);
        $this->em->flush();

        return $this->json(true,200);
    }

}
