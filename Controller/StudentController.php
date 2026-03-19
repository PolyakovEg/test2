<?php

namespace app\Controller;

use app\Dto\StudentDto;
use app\Dto\StudentFilterDto;
use app\Facade\StudentFacade;
use app\Utils\DtoBuilder;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

class StudentController
{
    public function __construct(
        private readonly StudentFacade $facade
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
        $dto = DtoBuilder::formFromRequest(StudentFilterDto::class, $params);
        return $this->facade->get($dto);
    }

    /**
     * @param array $params
     * @return void
     * @throws Exception
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(array $params): void
    {
        $dto = DtoBuilder::formFromRequest(StudentDto::class, $params);
        $this->facade->save($dto);
    }

    /**
     * @param array $params
     * @return void
     * @throws Exception
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(array $params): void
    {
        $this->facade->delete($params['id']);
    }
}