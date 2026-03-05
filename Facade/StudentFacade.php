<?php

namespace app\Facade;

use app\Dto\StudentDto;
use app\Service\StudentService;
use Doctrine\DBAL\Exception;
use Monolog\Level;
use Monolog\Logger;

class StudentFacade
{
    public function __construct( //todo отфармотировать конструкторы
        private readonly StudentService $studentService
    )
    {
    }

    public function getStudents(StudentDto $dto): array|object
    {
        try {
            return $this->studentService->getStudents($dto);
        } catch (Exception $exception) {
            throw $exception;
        }

    }

    public function createStudent(StudentDto $dto): void
    {
        try {
            $this->studentService->createStudent($dto);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function updateStudent(StudentDto $dto): void
    {
        try {
            $this->studentService->updateStudent($dto);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function deleteStudent(int $id): void
    {
        try {
            $this->studentService->deleteStudent($id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}