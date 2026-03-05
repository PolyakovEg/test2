<?php

namespace app\Dto;

use app\Entity\StudentEntity;

class StudentDto
{
    public ?int $id;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $patronymic;
    public ?string $email;
    public ?bool $isLiveInDormitory;
    public ?int $groupId;

    /**
     * Возвращает массив студентов в виде DTO.
     *
     * @param array $students
     * @return array
     */
    public static function formDtoFromArray(array $students): array
    {
        $dto = [];

        foreach ($students as $student) {
            /* @var $student StudentEntity */

            $dto[] = self::formFromEntity($student);
        }

        return $dto;
    }

    /**
     * Создает DTO из сущности
     *
     * @param StudentEntity $student
     * @return self
     */
    public static function formFromEntity(StudentEntity $student): self
    {
        $dto = new StudentDto();

        $dto->id = $student->getId();
        $dto->firstName = $student->getFirstName();
        $dto->lastName = $student->getLastName();
        $dto->patronymic = $student->getPatronymic();
        $dto->email = $student->getEmail();
        $dto->isLiveInDormitory = $student->getIsLiveInDormitory();
        $dto->groupId = $student->getGroupId();

        return $dto;
    }

    /**
     * Возвращает проинициальзированные свойтва.
     *
     * @return array|null
     */
    public function GetSetProperties(): array|null
    {
        $properties = null;

        foreach ($this as $key => $value) {
            if (isset($value)) {
                $properties[$key] = $value;
            }
        }

        return $properties;
    }
}