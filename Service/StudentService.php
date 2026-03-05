<?php
//запросы к бд (бизнес-логика)
namespace app\Service;

use app\Dto\StudentDto;
use app\Entity\StudentEntity;
use Doctrine\ORM\EntityManager;

class StudentService
{
    public function __construct(
        private readonly EntityManager $entityManager
    )
    {
    }

    public function getStudents(StudentDto $dto): array
    {
        $criteria = $dto->GetSetProperties();

        $orderBy = ['lastName' => 'ASC', 'firstName' => 'ASC', 'patronymic' => 'ASC'];

        if (isset($criteria)) {
            $entities = $this->entityManager->getRepository(StudentEntity::class)->findBy($criteria, $orderBy);
        } else {
            $entities = $this->entityManager->getRepository(StudentEntity::class)->findBy([], $orderBy);
        }

        return StudentDto::formDtoFromArray($entities);
    }

    public function createStudent(StudentDto $dto): void
    {
        $entity = new StudentEntity();
        $entity->updateFromDto($dto);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    function updateStudent(StudentDto $dto): void
    {
        $entity = $this->entityManager->getRepository(StudentEntity::class)->find($dto->id);
        $entity->updateFromDto($dto);
        $this->entityManager->flush();
    }

    public function deleteStudent(int $id): void
    {
        $entity = $this->entityManager->getRepository(StudentEntity::class)->find($id);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    public function deleteStudentsOfGroup(int $groupId): void
    {
        $entities = $this->entityManager->getRepository(StudentEntity::class)->findBy(['groupId' => $groupId]);

        foreach ($entities as $entity) {
            $this->entityManager->remove($entity);
        }

        $this->entityManager->flush();
    }
}