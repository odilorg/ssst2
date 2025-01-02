<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/test-pdf', function () {
    // Example data for the PDF
    $data = [
        'title' => 'Invoice',
        'date' => date('m/d/Y'),
        'invoice_number' => 'INV-12345',
        'items' => [
            ['description' => 'Item 1', 'quantity' => 2, 'price' => 50],
            ['description' => 'Item 2', 'quantity' => 1, 'price' => 30],
        ],
    ];

    // Load the view and generate the PDF
    $pdf = Pdf::loadView('pdf.invoice', $data);

    // Return the PDF as a download
    return $pdf->download('invoice.pdf');
});

