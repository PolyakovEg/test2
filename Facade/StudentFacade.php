<?php

namespace app\Facade;

use app\Dto\StudentDto;
use app\Dto\StudentFilterDto;
use app\Service\StudentService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use Monolog\Level;
use Monolog\Logger;

class StudentFacade
{
    public function __construct(
        private readonly StudentService $studentService,
        private readonly Logger         $logger
    )
    {
    }

    /**
     * @param StudentFilterDto $dto
     * @return array
     * @throws Exception
     */
    public function get(StudentFilterDto $dto): array
    {
        try {
            return $this->studentService->get($dto);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при получении студентов.');
        }

    }

    /**
     * @param StudentDto $dto
     * @return void
     * @throws Exception
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(StudentDto $dto): void
    {
        try {
            $this->studentService->save($dto);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при сохранении студента.');
        }
    }

    /**
     * @param int $id
     * @return void
     * @throws Exception
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(int $id): void
    {
        try {
            $this->studentService->delete($id);
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при удалении студента.');
        }
    }
}