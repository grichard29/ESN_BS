<?php

namespace BSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        $name = ($user == null) ? '' : $user->getUsername();
        $roles = ($user == null) ? []: $user->getRoles();
        $isAuthorized = false;
        foreach($roles as $role){
            if($role == 'ROLE_ADMIN'){
                $isAuthorized = $isAuthorized || true;
            }
        }
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $noUsers = (count($users)>0) ? false : true;
        return $this->render('BSBundle:Default:index.html.twig',['name' => $name,'isAuthorized' => $isAuthorized, 'noUsers' => $noUsers]);
    }

    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setPlainPassword('admin');
        $user->setEmail('admin@test.com');
        $user->setRoles(['ROLE_ADMIN']);
        $userManager->updateUser($user);
        for($i=1;$i<6;$i++) {
            $user = $userManager->createUser();
            $user->setUsername('test'.$i);
            $user->setPlainPassword('test'.$i);
            $user->setEmail('test'.$i.'@test.com');
            $user->setRoles(['ROLE_USER']);
            $userManager->updateUser($user);
        }
        for($i=1;$i<6;$i++) {
            $user = $userManager->createUser();
            $user->setUsername('local'.$i);
            $user->setPlainPassword('local'.$i);
            $user->setEmail('local'.$i.'@test.com');
            $user->setRoles(['ROLE_LOCAL']);
            $userManager->updateUser($user);
        }
        for($i=1;$i<6;$i++) {
            $user = $userManager->createUser();
            $user->setUsername('is'.$i);
            $user->setPlainPassword('is'.$i);
            $user->setEmail('is'.$i.'@test.com');
            $user->setRoles(['ROLE_IS']);
            $userManager->updateUser($user);
        }
        for($i=1;$i<6;$i++) {
            $user = $userManager->createUser();
            $user->setUsername('bc'.$i);
            $user->setPlainPassword('bc'.$i);
            $user->setEmail('bc'.$i.'@test.com');
            $user->setRoles(['ROLE_BC']);
            $userManager->updateUser($user);
        }
        return $this->redirectToRoute('home');
    }
}
