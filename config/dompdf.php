<?php

return [
    'showPdf' => env('SHOW_PDF', false),
    'orientation' => env('DOMPDF_PAPER_ORIENTATION', 'portrait'),
    'paper' => env('DOMPDF_PAPER', 'a4'),
    'defaultFont' => 'DejaVu Sans',
];
