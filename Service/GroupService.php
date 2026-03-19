<?php

namespace app\Service;


use app\Dto\GroupDto;
use app\Dto\GroupFilterDto;
use app\Dto\StudentDto;
use app\Entity\GroupEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class GroupService
{
    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
    }

    /**
     * Получает массив групп из БД по фильтрам.
     *
     * @param GroupFilterDto|null $dto
     * @return array
     * @throws Exception
     */
    public function get(GroupFilterDto $dto = null): array
    {
        $entities = $this->entityManager->getRepository(GroupEntity::class)->getGroupsByDto($dto);
        $groupDto = GroupDto::formFromArray($entities);

        foreach ($groupDto as $group) {
            $group->students = StudentDto::formFromArray($group->students);
        }

        return $groupDto;
    }

    /**
     * Сохраняет группу в БД.
     *
     * @param GroupDto $dto
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    function save(GroupDto $dto): void
    {
        if (isset($dto->id)) {
            $entity = $this->entityManager->getRepository(GroupEntity::class)->find($dto->id);
            $entity->updateFromDto($dto);
        } else {
            $entity = new GroupEntity();
            $entity->updateFromDto($dto);
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();
    }

    /**
     * Удаляет группу из БД по id.
     *
     * @param int $id
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(int $id): void
    {
        $entity = $this->entityManager->getRepository(GroupEntity::class)->find($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Возвращает массив студентов группы по id группы.
     *
     * @param int $id
     * @return array
     */
    public function getStudents(int $id): array
    {
        $repository = $this->entityManager->getRepository(GroupEntity::class);
        $entity = $repository->find($id);
        return StudentDto::formFromArray($repository->getStudents($entity));
    }

    /**
     * Удаляет всех студентов группы по id группы.
     *
     * @param int $id
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteStudents(int $id)
    {
        $entity = $this->entityManager->getRepository(GroupEntity::class)->find($id);

        foreach ($entity->getStudents() as $student) {
            $this->entityManager->remove($student);
        }

        $this->entityManager->flush();
    }
}