<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsObject;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportData extends Controller
{
    public function universalExport(Request $request, $objectName, $format)
    {
        $fullObjectUrl = "\\App\\Models\\" . $objectName;

        if (!class_exists($fullObjectUrl)) {
            abort(404, 'Nie znaleziono modelu eksportu');
        }

        $modelObject = new $fullObjectUrl();

        if (!($modelObject instanceof CmsObject)) {
            abort(404, 'Nieprawidłowy obiekt CMS');
        }

        if (!($modelObject->allowExport ?? false)) {
            abort(403, 'Eksport dla tego obiektu jest wyłączony');
        }

        if (!$modelObject->exportFormatAvailable($format)) {
            abort(404, 'Nieobsługiwany format eksportu');
        }

        switch (mb_strtolower($format)) {
            case 'csv':
                return $this->exportCsv($modelObject, $request);
        }

        abort(404);
    }

    protected function exportCsv(CmsObject $modelObject, Request $request): StreamedResponse
    {
        $fileName = $modelObject->getExportFileName() . '-' . now()->format('Y-m-d-H-i-s') . '.csv';
        $exportHeaders = $modelObject->getExportHeaders();
        $exportFields = $modelObject->getExportFields();
        $rows = $modelObject->getExportRows($request);

        return response()->streamDownload(function () use ($exportHeaders, $exportFields, $rows) {
            $output = fopen('php://output', 'w');

            // UTF-8 BOM dla Excela
            fwrite($output, "\xEF\xBB\xBF");

            fputcsv($output, $exportHeaders, ';');

            foreach ($rows as $row) {
                $line = [];

                foreach ($exportFields as $fieldConfig) {
                    $field = $fieldConfig['field'];
                    $value = $row[$field] ?? '';

                    if (is_bool($value)) {
                        $value = $value ? 1 : 0;
                    }

                    if (is_array($value)) {
                        $value = implode(', ', $value);
                    }

                    $line[] = $value;
                }

                fputcsv($output, $line, ';');
            }

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
            'Expires' => '0',
        ]);
    }
}
