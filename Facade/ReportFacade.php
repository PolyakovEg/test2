<?php

namespace app\Facade;

use app\Service\GroupService;
use app\Service\ReportService;
use app\Thesaurus\ReportTypeThesaurus;
use Exception;
use Monolog\Level;
use Monolog\Logger;

class ReportFacade
{
    public function __construct(
        private readonly Logger        $logger,
        private readonly ReportService $reportService,
        private readonly GroupService  $groupService
    )
    {
    }

    /**
     * Метод для получения отчета.
     *
     * @param int $type
     * @return void
     * @throws Exception
     */
    public function download(int $type): void
    {
        try {
            $groups = $this->groupService->get();
            $this->reportService->download($groups, ReportTypeThesaurus::from($type));
        } catch (Exception $exception) {
            $this->logger->log(Level::Error, $exception->getMessage());
            throw new Exception('Ошибка при получении отчета.');
        }
    }
}