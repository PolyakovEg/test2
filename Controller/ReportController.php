<?php

namespace app\Controller;

use app\Facade\ReportFacade;
use Exception;

class ReportController
{
    public function __construct(
        private readonly ReportFacade $facade
    )
    {
    }

    /**
     * Метод для получения отчета.
     *
     * @param array $params
     * @return void
     * @throws Exception
     */
    function download(array $params): void
    {
        $this->facade->download($params['reportType']);
    }
}