<?php

namespace app\Dto;

use app\Entity\GroupEntity;
use app\Entity\StudentEntity;

class StudentDto
{
    public ?int $id = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $patronymic = null;
    public ?string $email = null;
    public ?bool $isLiveInDormitory = null;
    public ?int $groupId = null;
    public ?GroupEntity $group = null;

    /**
     * Возвращает массив студентов в виде DTO.
     *
     * @param array $students
     * @return array
     */
    public static function formFromArray(array $students): array
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
        $dto->groupId = $student->getGroup()->getId();

        return $dto;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return "$this->lastName $this->firstName $this->patronymic";
    }
}