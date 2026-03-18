<?php

namespace app\Dto;

use DateTime;
use Exception;

class GroupFilterDto
{
    public ?int $id = null;
    public ?string $name = null;
    public ?string $studyStartDate = null;
    public ?int $specializationId = null;
    public ?string $formOfEducation = null;

    /**
     * Возвращает проинициальзированные свойства.
     *
     * @return array|null
     * @throws Exception
     */
    public function getSetProperties(): array|null
    {
        $properties = null;

        foreach ($this as $key => $value) {
            if (isset($value)) {
                $properties[$key] = $value;
            }
        }

        if (isset($properties['studyStartDate'])) {
            $properties['studyStartDate'] = $properties['studyStartDate'] ? new DateTime($properties['studyStartDate']) : null;
        }

        return $properties;
    }
}