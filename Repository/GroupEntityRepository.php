<?php

namespace app\Repository;

use app\Dto\GroupFilterDto;
use app\Dto\StudentDto;
use app\Entity\GroupEntity;
use app\Entity\StudentEntity;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Exception;

class GroupEntityRepository extends EntityRepository
{
    /**
     * Возвращает массив групп, отфильтрованных с помощью GroupFilterDto.
     *
     * @param GroupFilterDto|null $dto
     * @return mixed
     * @throws Exception
     */
    public function getGroupsByDto(?GroupFilterDto $dto = null): mixed
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('g')
            ->from(GroupEntity::class, 'g')
            ->orderBy('g.name', 'ASC');

        if (isset($dto)) {
            if (isset($dto->id)) {
                $queryBuilder->andWhere('g.id = :id');
                $queryBuilder->setParameter('id', $dto->id);
            }

            if (isset($dto->name)) {
                $queryBuilder->andWhere('g.name LIKE :name');
                $queryBuilder->setParameter('name', "%$dto->name%");
            }

            if (isset($dto->studyStartDate)) {
                $queryBuilder->andWhere('g.studyStartDate = :studyStartDate');
                $queryBuilder->setParameter('studyStartDate', new DateTime($dto->studyStartDate), Types::DATE_MUTABLE);
            }

            if (isset($dto->formOfEducation)) {
                $queryBuilder->andWhere('g.formOfEducation = :formOfEducation');
                $queryBuilder->setParameter('formOfEducation', $dto->formOfEducation);
            }

            if (isset($dto->specializationId)) {
                $queryBuilder->andWhere('g.specializationId = :specializationId');
                $queryBuilder->setParameter('specializationId', $dto->specializationId);
            }
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Возвращает список студентов группы.
     *
     * @param GroupEntity $entity
     * @return array
     */
    public function getStudents(GroupEntity $entity): mixed
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('s')
            ->from(StudentEntity::class, 's')
            ->where('s.group = :group')
            ->orderBy('s.lastName', 'ASC')
            ->addOrderBy('s.firstName')
            ->addOrderBy('s.patronymic');

        $queryBuilder->setParameter('group', $entity);

        return $queryBuilder->getQuery()->getResult();
    }
}