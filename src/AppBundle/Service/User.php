<?php

namespace AppBundle\Service;

use AppBundle\Entity\User as UserEntity;

class User
{
    protected $em;
    protected $userRepository;

    public function __construct($em)
    {
        $this->em = $em;
        $this->userRepository = $this->em->getRepository('AppBundle:User');
    }

    /**
     * Return list of users
     *
     * @return mixed
     */
    public function getAll()
    {
        $groups = $this->userRepository->findBy([], [ 'firstname' => 'ASC' ]);

        return $groups;
    }

    /**
     * Return one user
     *
     * @return User
     */
    public function getOne($id)
    {
        $user = $this->userRepository->find($id);

        return $user;
    }

    /**
     * Insert new user
     *
     * @param $data
     * @return User
     * @throws \Exception
     */
    public function insert($data)
    {
        // checks whether or not user already exists
        $userExists = $this->userRepository->findByEmail($data->get('email'));
        if ($userExists) {
            throw new \Exception('User already exists');
        }

        $user = new UserEntity();
        $this->magicSetter($user, $data);
        $user->setUsername($data->get('email'));
        $user->setCreationDate(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();

        $user->setPassword(''); // hide password

        return $user;
    }

    /**
     * Update user
     *
     * @param $data
     * @throws \Exception
     * @return User
     */
    public function update($id, $data)
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new \Exception('Group not found');
        }

        $this->magicSetter($user, $data);
        $this->em->persist($user);
        $this->em->flush();

        $user->setPassword(''); // hide password

        return $user;
    }

    /**
     * Dynamically set data
     * @todo put this method in a utility class
     *
     * @param $user
     * @param $data
     */
    protected function magicSetter($user, $data)
    {
        foreach ($data as $k => $v) {
            $setter = 'set' . ucfirst($k);
            if (method_exists($user, $setter)) {
                $user->$setter($v);
            }
        }
    }
}