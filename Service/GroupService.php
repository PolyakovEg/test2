<?php

namespace app\Service;


use app\Dto\GroupDto;
use app\Entity\GroupEntity;
use Doctrine\ORM\EntityManager;

class GroupService
{
    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
    }

    public function getGroups(GroupDto $dto): array
    {
        $criteria = $dto->GetSetProperties();

        $orderBy = ['name' => 'ASC'];

        if (isset($criteria)) {
            $entities = $this->entityManager->getRepository(GroupEntity::class)->findBy($criteria, $orderBy);
        } else {
            $entities = $this->entityManager->getRepository(GroupEntity::class)->findBy([], $orderBy);
        }

        return GroupDto::formFromArray($entities);
    }

    public function createGroup(GroupDto $dto): void
    {
        $entity = new GroupEntity();

        $entity->updateFromDto($dto);
        $this->entityManager->persist($entity);

        $this->entityManager->flush();
    }

    function updateGroup(GroupDto $dto): void
    {
        $student = $this->entityManager->getRepository(GroupEntity::class)->find($dto->id);
        $student->updateFromDto($dto);
        $this->entityManager->flush();
    }

    public function deleteGroup(int $id): void
    {
        $entity = $this->entityManager->getRepository(GroupEntity::class)->find($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}