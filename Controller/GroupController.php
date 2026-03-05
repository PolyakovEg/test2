<?php

namespace app\Controller;

use app\Dto\GroupDto;
use app\Dto\StudentDto;
use app\Facade\GroupFacade;
use app\Utils\DtoBuilder;

class GroupController
{
    public function __construct(
        private readonly GroupFacade $facade
    )
    {
    }

    public function getGroups(array $params): array|object
    {
        $dto = DtoBuilder::formFromRequest(GroupDto::class, $params);

        return $this->facade->getGroups($dto);
    }

    public function createGroup(array $params): void
    {
        $dto = DtoBuilder::formFromRequest(GroupDto::class, $params);

        $this->facade->createGroup($dto);
    }

    public function updateGroup(array $params): void
    {
        $dto = DtoBuilder::formFromRequest(GroupDto::class, $params);

        $this->facade->updateGroup($dto);
    }

    public function deleteGroup(array $params): void
    {
        $this->facade->deleteGroup($params['id']);
    }

    public function deleteStudents(array $params): void
    {
        $this->facade->deleteStudents($params['id']);
    }

    public function getStudents(array $params): array|object
    {
        $dto = DtoBuilder::formFromRequest(StudentDto::class, $params);

        $dto->groupId = $dto->id;
        unset($dto->id);

        return $this->facade->getStudents($dto);
    }
}