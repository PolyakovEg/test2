<?php

namespace app\Service;

use app\Dto\StudentDto;
use app\Dto\StudentFilterDto;
use app\Entity\GroupEntity;
use app\Entity\StudentEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class StudentService
{
    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
    }

    /**
     * Получает массив студентов из БД по фильтрам.
     *
     * @param StudentFilterDto $dto
     * @return array
     */
    public function get(StudentFilterDto $dto): array
    {
        $criteria = $dto->getSetProperties();

        $orderBy = ['lastName' => 'ASC', 'firstName' => 'ASC', 'patronymic' => 'ASC'];

        if (isset($criteria)) {
            $entities = $this->entityManager->getRepository(StudentEntity::class)->findBy($criteria, $orderBy);
        } else {
            $entities = $this->entityManager->getRepository(StudentEntity::class)->findBy([], $orderBy);
        }

        return StudentDto::formFromArray($entities);
    }

    /**
     * Сохраняет студента в БД.
     *
     * @param StudentDto $dto
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    function save(StudentDto $dto): void
    {
        if (isset($dto->id)) {
            $entity = $this->entityManager->getRepository(StudentEntity::class)->find($dto->id);
        } else {
            $entity = new StudentEntity();
            $this->entityManager->persist($entity);
        }

        $entity
            ->setFirstName($dto->firstName)
            ->setLastName($dto->lastName)
            ->setPatronymic($dto->patronymic)
            ->setEmail($dto->email)
            ->setGroup($this->entityManager->getRepository(GroupEntity::class)->find($dto->groupId))
            ->setIsLiveInDormitory($dto->isLiveInDormitory);

        $this->entityManager->flush();
    }

    /**
     * Удаляет студента из БД по id.
     *
     * @param int $id
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(int $id): void
    {
        $entity = $this->entityManager->getRepository(StudentEntity::class)->find($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}