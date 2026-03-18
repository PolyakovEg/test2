<?php

namespace app\Dto;

use app\Entity\GroupEntity;
use DateTime;
use Exception;

class GroupDto
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $studyStartDate = null;
    public ?int $specializationId = null;
    public ?string $formOfEducation = null;
    public ?array $students = null;

    /**
     * Создает массив DTO из массива групп.
     *
     * @param array $groups
     * @return array
     * @throws Exception
     */
    public static function formFromArray(array $groups): array
    {
        $dto = [];

        foreach ($groups as $group) {
            /* @var $group GroupEntity */
            $dto[] = self::formFromEntity($group);
        }

        return $dto;
    }

    /**
     * Создает DTO из сущности
     *
     * @param GroupEntity $group
     * @return self
     */
    public static function formFromEntity(GroupEntity $group): self
    {
        $dto = new GroupDto();
        $dto->id = $group->getId();
        $dto->name = $group->getName();
        $dto->studyStartDate = date_format($group->getStudyStartDate(), 'd.m.Y') ?: null;
        $dto->specializationId = $group->getSpecializationId();
        $dto->formOfEducation = $group->getFormOfEducation();
        $dto->students = $group->getStudentsArray();

        return $dto;
    }
}