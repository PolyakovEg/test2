<?php

namespace app\Dto;

use app\Entity\GroupEntity;
use Exception;

class GroupDto
{
    public ?int $id;
    public ?string $name;
    public ?string $studyStartDate;
    public ?int $specializationId;
    public ?string $formOfEducation;

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

        return $dto;
    }

    /**
     * Возвращает проинициальзированные свойтва.
     *
     * @return array|null
     * @throws Exception
     */
    public function GetSetProperties(): array|null
    {
        $properties = null;

        foreach ($this as $key => $value) {
            if (isset($value)) {
                $properties[$key] = $value;
            }
        }

        if(isset($properties['studyStartDate'])) {
            $properties['studyStartDate'] = $properties['studyStartDate'] ? new \DateTime($properties['studyStartDate']) : null;
        }

        return $properties;
    }
}