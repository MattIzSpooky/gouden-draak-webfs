<?php

namespace App\Console\Commands;

use App\DailySummary;
use App\Exports\DailyOrdersExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportDailySummaryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports the daily summary in a excel document and saves it to the storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today = now()->toDateString();
        $fileName = 'summary-' . $today . '.xlsx';
        $filePath = 'summaries/' . $fileName;

        $isSaved = Excel::store(new DailyOrdersExport($today), $filePath);

        if ($isSaved) {
            DailySummary::updateOrCreate([
                'file' => $fileName,
                'date' => $today
            ], [
                'file' => $fileName,
                'date' => $today
            ]);
        }
    }
}
