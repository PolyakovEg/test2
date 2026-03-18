<?php

namespace app\Service;

use app\Dto\GroupDto;
use app\Dto\StudentDto;
use app\Thesaurus\ReportTypeThesaurus;
use avadim\FastExcelWriter\Excel;
use Knp\Snappy\Pdf;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Environment;

class ReportService
{
    public function __construct(
        private readonly Pdf         $knpSnappyPdf,
        private readonly Environment $twig
    )
    {
    }

    /**
     * Отправляет отчет на фронт.
     *
     * @param array $groups
     * @param ReportTypeThesaurus $type
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function download(array $groups, ReportTypeThesaurus $type): void
    {
        switch ($type) {
            case ReportTypeThesaurus::pdf:
                $context = ['groups' => $groups];
                $html = $this->twig->render('table.html.twig', $context);

                header('Content-Type: application/pdf');
                echo $this->knpSnappyPdf->getOutputFromHtml($html);
                break;
            case ReportTypeThesaurus::excel:
                $excel = Excel::create(['ReportSheet']);
                $sheet = $excel->sheet();

                $head = ['Группа', 'Номер по списку', 'ФИО', 'Почта ', 'Общежитие'];
                $headStyle = [
                    'font' => [
                        'style' => 'bold'
                    ],
                    'text-align' => 'center',
                    'vertical-align' => 'center',
                    'border' => 'thin',
                    'height' => 24,
                ];

                $dataStyle = [
                    'text-align' => 'center',
                    'vertical-align' => 'center',
                    'border' => 'thin',
                    'height' => 15,
                ];

                $sheet->setColWidths([
                    'A' => 8,
                    'B' => 15.6,
                    'C' => 35.7,
                    'D' => 20,
                    'E' => 11.5
                ]);

                $sheet->writeHeader($head, $headStyle);

                $y = 2;

                foreach ($groups as $group) {
                    /* @var $group  GroupDto */

                    $studentsCount = count($group->students);

                    if ($studentsCount == 0) {
                        continue;
                    }

                    $sheet->mergeCells("A$y:A" . ($y + $studentsCount - 1), -1);
                    $sheet->writeTo("A$y", $group->name, $dataStyle);

                    $i = 1;

                    $sheet->setTopLeftCell("B$y");

                    foreach ($group->students as $student) {
                        /* @var $student  StudentDto */

                        $sheet->writeRow([
                            $i,
                            $student->getFullName(),
                            $student->email,
                            $student->isLiveInDormitory ? 'Да' : 'Нет'
                        ], $dataStyle);

                        $i++;
                    }

                    $y += $studentsCount;
                }

                $excel->download('report.xlsx');
                break;
        }
    }
}