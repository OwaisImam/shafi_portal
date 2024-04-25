<?php

namespace App\Repositories\Report;

use App\Models\Client;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ReportRepository extends BaseRepository
{
    public function model(): string
    {
        return Client::class;
    }

    public function generateFollowupReportData($date = null)
    {
        $query = $this->model->query();

        if (isset($date)) {
            $date = explode(' to ', $date);
            $query->whereBetween('follow_up_date', $date);
        }

        return $query->get();
    }

    public function exportFollowupCSV($date = null)
    {
        $clients = $this->generateFollowupReportData($date);
        $csvFileName = 'followup-report.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'Name',
            'City',
            'State',
            'Country',
            'Website',
            'Email',
            'Second Email',
            'Phone',
            'Emailed?',
            'Called?',
            'Follow up call',
            'Follow up date',
            'Remarks',
            'Created By',
        ]);

        foreach ($clients as $client) {
            fputcsv($handle, [
                $client->name,
                $client->city->name,
                $client->state->name,
                $client->country->name,
                $client->website,
                $client->second_email,
                $client->phone,
                $client->is_emailed == 1 ? 'true' : 'false',
                $client->is_called == 1 ? 'true' : 'false',
                $client->follow_up_call == 1 ? 'true' : 'false',
                $client->follow_up_date,
                $client->remarks,
                $client->creator->name,
        ]); // Add more fields as needed
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }

    public function generateClientDetailsReportData($date = null)
    {
        $query = $this->model->query();

        if (isset($date)) {

            switch ($date) {
                case 'daily':
                    $query->where('created_at', Carbon::today());
                    break;
                case 'monthly':
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    break;
                case 'yearly':
                    $query->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                    break;
                default:
                    break;
            }
        }

        return $query->get();
    }

    public function exportClientDetailsCSV($date = null)
    {
        $clients = $this->generateClientDetailsReportData($date);
        $csvFileName = 'clientdetails-report.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'Name',
            'City',
            'State',
            'Country',
            'Website',
            'Email',
            'Second Email',
            'Phone',
            'Emailed?',
            'Called?',
            'Follow up call',
            'Follow up date',
            'Remarks',
            'Created By',
            'Created At',
        ]);

        foreach ($clients as $client) {
            fputcsv($handle, [
                $client->name,
                $client->city->name,
                $client->state->name,
                $client->country->name,
                $client->website,
                $client->second_email,
                $client->phone,
                $client->is_emailed == 1 ? 'true' : 'false',
                $client->is_called == 1 ? 'true' : 'false',
                $client->follow_up_call == 1 ? 'true' : 'false',
                $client->follow_up_date,
                $client->remarks,
                $client->creator->name,
                Carbon::parse($client->created_at)->format('d-m-Y'),
        ]); // Add more fields as needed
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }

    public function generateSummaryReportData($date = null)
    {
        $query = $this->model->query();

        if (isset($date)) {
            $date = explode(' to ', $date);
            $query->whereBetween('created_at', $date);
        }

        return $query->get();
    }

    public function exportSummaryCSV($date = null)
    {
        $clients = $this->generateSummaryReportData($date);
        $csvFileName = 'summary-report.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'Total Calls Reported',
            'Total Email Count',
            'Total Followup',
        ]);

        foreach ($clients as $client) {
            fputcsv($handle, [
                $client->where('is_emailed')->count(),
                $client->where('is_called', 1)->count(),
                $client->where('follow_up_call', 1)->count(),
            ]); // Add more fields as needed
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
}
