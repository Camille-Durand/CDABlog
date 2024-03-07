<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UtilisateurService{
    private UserRepository $userRepository;

    private EntityManagerInterface $em;

    public function __contruct(UserRepository $userRepository, EntityManagerInterface $em){
        $this->userRepository = $userRepository;

        $this->em = $em;
    }

    public function create(?User $user): bool{
        if($user){
            if(!$this->userRepository->findByOne(['mail' => $user->getMail()])){
                $this->em->persist($user);
                $this->em->flush();
                return true;
            }
            return false;
        }
        return false;
    }
}