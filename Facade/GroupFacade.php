<?php

namespace app\Facade;

use app\Dto\GroupDto;
use app\Dto\GroupFilterDto;
use app\Service\GroupService;
use Doctrine\ORM\Exception\ORMException;
use Exception;
use Monolog\Level;
use Monolog\Logger;

class GroupFacade
{
    public function __construct(
        private readonly GroupService   $groupService,
        private readonly Logger         $logger
    )
    {
    }

    /**
     * @param GroupFilterDto $dto
     * @return array
     * @throws Exception
     */
    function get(GroupFilterDto $dto): array
    {
        try {
            return $this->groupService->get($dto);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при получении групп.');
        }
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    function getStudents(int $id): array
    {
        try {
            return $this->groupService->getStudents($id);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при получении студентов группы.');
        }
    }

    /**
     * @param GroupDto $dto
     * @return void
     * @throws ORMException
     * @throws Exception
     */
    public function save(GroupDto $dto): void
    {
        try {
            $this->groupService->save($dto);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при сохранении группы.');
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws ORMException
     * @throws Exception
     */
    public function delete(int $id): void
    {
        try {
            $this->groupService->delete($id);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при удалении группы.');
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws ORMException
     */
    public function deleteStudents(int $id): void
    {
        try {
            $this->groupService->deleteStudents($id);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при удалении студентов группы.');
        }
    }
}