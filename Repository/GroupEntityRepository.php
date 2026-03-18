<?php

namespace app\Repository;

use app\Dto\GroupFilterDto;
use app\Entity\GroupEntity;
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
    public function getGroupsByDto(GroupFilterDto $dto = null)
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
                $queryBuilder->andWhere('g.name = :name');
                $queryBuilder->setParameter('name', $dto->name);
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
}