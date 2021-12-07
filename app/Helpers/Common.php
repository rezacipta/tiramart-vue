<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Common
{
    public static function idr($expression)
    {
        $expression = number_format($expression, 0, ',', '.');

        return 'Rp ' . $expression;
    }

    public static function excel($head, $data, $filename)
    {
        function int2letter($num)
        {
            $numeric = $num % 26;
            $letter = chr(65 + $numeric);
            $num2 = intval($num / 26);
            if ($num2 > 0)
                return $this->int2letter($num2 - 1) . $letter;
            else
                return $letter;
        }

        $spreadsheet = new Spreadsheet();
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ];
        $color = 'ebf5e9';
        $cols = 0;
        foreach ($head as $k => $v) {
            $spreadsheet->getActiveSheet()->setCellValue(int2letter($cols) . '1', $v);
            $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setIndent(1);
            $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . '1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . '1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
            $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . '1')->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getColumnDimension(int2letter($cols))->setAutoSize(true);
            $cols++;
        }

        $rows = 2;
        foreach ($data as $v) {
            $cols = 0;
            foreach ($v as $vv) {
                $spreadsheet->getActiveSheet()->setCellValue(int2letter($cols) . $rows, $vv);
                $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . $rows)->getAlignment()->setIndent(1);
                $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . $rows)->applyFromArray($styleArray);
                if ($rows % 2 == 1)
                    $spreadsheet->getActiveSheet()->getStyle(int2letter($cols) . $rows)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($color);
                $cols++;
            }
            $rows++;
        }

        $path = 'media/download/excel/' . $filename . '.xls';
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save($path);

        return $path;
    }
}
