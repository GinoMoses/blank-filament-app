<?php

namespace App\Services;

use App\Models\ExamTest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ExamPdfExportService
{
    /**
     * Generate PDF for an exam test
     */
    public function generateExamPdf(ExamTest $examTest, bool $includeAnswers = false): Response
    {
        $questions = $examTest->questions()->get();

        $pdf = Pdf::loadView('pdf.exam-test', [
            'examTest' => $examTest,
            'questions' => $questions,
            'includeAnswers' => $includeAnswers,
        ]);

        $filename = 'exam-'.$examTest->id.'-'.now()->format('Y-m-d-His').'.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate PDF with answer key
     */
    public function generateAnswerKeyPdf(ExamTest $examTest): Response
    {
        return $this->generateExamPdf($examTest, includeAnswers: true);
    }

    /**
     * Stream PDF directly without downloading
     */
    public function streamExamPdf(ExamTest $examTest, bool $includeAnswers = false)
    {
        $questions = $examTest->questions()->get();

        $pdf = Pdf::loadView('pdf.exam-test', [
            'examTest' => $examTest,
            'questions' => $questions,
            'includeAnswers' => $includeAnswers,
        ]);

        return $pdf->stream();
    }
}
