<?php

namespace app\Controller;

use app\Dto\StudentDto;
use app\Facade\StudentFacade;
use app\Utils\DtoBuilder;

class StudentController
{
    public function __construct(
        private readonly StudentFacade $facade
    )
    {
    }

    public function getStudents(array $params): array|object
    {
        $dto = DtoBuilder::formFromRequest(StudentDto::class, $params);

        return $this->facade->getStudents($dto);
    }

    public function createStudent(array $params): void
    {
        $dto = DtoBuilder::formFromRequest(StudentDto::class, $params);

        $this->facade->createStudent($dto);
    }

    public function updateStudent(array $params): void
    {
        $dto = DtoBuilder::formFromRequest(StudentDto::class, $params);

        $this->facade->updateStudent($dto);
    }

    public function deleteStudent(array $params): void
    {
        $this->facade->deleteStudent($params['id']);
    }
}