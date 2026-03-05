<?php

namespace app\Facade;

use app\Dto\GroupDto;
use app\Dto\StudentDto;
use app\Service\GroupService;
use app\Service\StudentService;
use Doctrine\DBAL\Exception;

class GroupFacade
{
    public function __construct(
        private readonly GroupService   $groupService,
        private readonly StudentService $studentService
    )
    {
    }

    function getGroups(GroupDto $dto): array|object
    {
        try {
            return $this->groupService->getGroups($dto);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    function getStudents(StudentDto $dto): array|object
    {
        try {
            return $this->studentService->getStudents($dto);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function createGroup(GroupDto $dto): void
    {
        try {
            $this->groupService->createGroup($dto);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function updateGroup(GroupDto $dto): void
    {
        try {
            $this->groupService->updateGroup($dto);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function deleteGroup(int $id): void
    {
        try {
            $this->groupService->deleteGroup($id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function deleteStudents(int $id): void
    {
        try {
            $this->studentService->deleteStudentsOfGroup($id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}