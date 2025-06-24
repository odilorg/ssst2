<?php
namespace App\Jobs;

use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateVoucherTemplatePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // grab your operator company
        $company = Company::whereNotNull('is_operator')->first();

        // number of blanks per page
        $count = 6;

        $pdf = PDF::loadView('vouchers.entrance_ticket_sheet', compact('company','count'))
                  ->setPaper('a4','portrait');

        // overwrite the single template file
        Storage::put('vouchers/entrance_ticket_template.pdf', $pdf->output());
    }
}
