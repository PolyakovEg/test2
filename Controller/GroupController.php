<?php

namespace app\Controller;

use app\Dto\GroupDto;
use app\Dto\GroupFilterDto;
use app\Facade\GroupFacade;
use app\Utils\DtoBuilder;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class GroupController
{
    public function __construct(
        private readonly GroupFacade $facade
    )
    {
    }

    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function get(array $params): array
    {
        $dto = DtoBuilder::formFromRequest(GroupFilterDto::class, $params);

        return $this->facade->get($dto);
    }

    /**
     * @param array $params
     * @return void
     * @throws ORMException
     */
    public function save(array $params): void
    {
        $dto = DtoBuilder::formFromRequest(GroupDto::class, $params);
        $this->facade->save($dto);
    }

    /**
     * @param array $params
     * @return void
     * @throws ORMException
     */
    public function delete(array $params): void
    {
        $this->facade->delete($params['id']);
    }

    /**
     * @param array $params
     * @return void
     * @throws ORMException
     */
    public function deleteStudents(array $params): void
    {
        $this->facade->deleteStudents($params['id']);
    }

    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function getStudents(array $params): array
    {
        return $this->facade->getStudents($params['id']);
    }
}