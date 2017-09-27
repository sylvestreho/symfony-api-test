<?php

namespace AppBundle\Service;

use AppBundle\Entity\Group as GroupEntity;

class Group
{
    protected $em;
    protected $groupRepository;

    public function __construct($em)
    {
        $this->em = $em;
        $this->groupRepository = $this->em->getRepository('AppBundle:Group');
    }

    /**
     * Return list of groups
     *
     * @return mixed
     */
    public function getAll()
    {
        $groups = $this->groupRepository->findBy([], [ 'name' => 'ASC' ]);

        return $groups;
    }

    /**
     * Return one group
     *
     * @return Group
     */
    public function getOne($id)
    {
        $group = $this->groupRepository->find($id);

        return $group;
    }

    /**
     * Insert new group
     *
     * @param $data
     * @return Group
     * @throws \Exception
     */
    public function insert($data)
    {
        // checks whether or not group already exists
        $groupExists = $this->groupRepository->findByName($data->get('name'));
        if ($groupExists) {
            throw new \Exception('Group already exists');
        }

        $group = new GroupEntity();
        $group->setName($data->get('name'));
        $this->em->persist($group);

        $this->em->flush();

        return $group;
    }

    /**
     * Update group
     *
     * @param $data
     * @throws \Exception
     */
    public function update($id, $data)
    {
        $group = $this->groupRepository->find($id);
        if (!$group) {
            throw new \Exception('Group not found');
        }

        $group->setName($data->get('name'));
        $this->em->persist($group);
        $this->em->flush();

        return $group;
    }
}