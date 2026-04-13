<?php

namespace App\Services;

use App\Models\ExamTest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ExamPdfExportService
{
    protected function configurePdf($pdf)
    {
        return $pdf->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'defaultFont' => 'DejaVu Sans',
            ]);
    }

    public function generateExamPdf(ExamTest $examTest, bool $includeAnswers = false): Response
    {
        $questions = $examTest->questions()->get();

        $pdf = Pdf::loadView('pdf.exam-test', [
            'examTest' => $examTest,
            'questions' => $questions,
            'includeAnswers' => $includeAnswers,
        ]);

        $this->configurePdf($pdf);

        $filename = 'exam-'.$examTest->id.'-'.now()->format('Y-m-d-His').'.pdf';

        return $pdf->download($filename);
    }

    public function generateAnswerKeyPdf(ExamTest $examTest): Response
    {
        return $this->generateExamPdf($examTest, includeAnswers: true);
    }

    public function streamExamPdf(ExamTest $examTest, bool $includeAnswers = false)
    {
        $questions = $examTest->questions()->get();

        $pdf = Pdf::loadView('pdf.exam-test', [
            'examTest' => $examTest,
            'questions' => $questions,
            'includeAnswers' => $includeAnswers,
        ]);

        $this->configurePdf($pdf);

        return $pdf->stream();
    }
}
