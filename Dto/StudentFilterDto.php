<?php

namespace app\Dto;

use app\Entity\StudentEntity;

class StudentFilterDto
{
    public ?int $id = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
    public ?string $patronymic = null;
    public ?string $email = null;
    public ?bool $isLiveInDormitory = null;
    public ?int $group = null;

    /**
     * Возвращает проинициальзированные свойства.
     *
     * @return array|null
     */
    public function getSetProperties(): array|null
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