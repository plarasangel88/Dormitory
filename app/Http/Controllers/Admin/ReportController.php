<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dates = $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $from = $dates['from'] ?? now()->startOfMonth()->toDateString();
        $to = $dates['to'] ?? now()->toDateString();

        return view('admin.reports', compact('from', 'to'));
    }

    public function export(Request $request, string $type): StreamedResponse
    {
        abort_unless(in_array($type, ['payments', 'maintenance', 'payment-audit'], true), 404);

        $dates = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        [$filename, $headers, $rows] = match ($type) {
            'payments' => $this->payments($dates['from'], $dates['to']),
            'maintenance' => $this->maintenance($dates['from'], $dates['to']),
            'payment-audit' => $this->paymentAudit($dates['from'], $dates['to']),
        };

        return response()->streamDownload(function () use ($headers, $rows): void {
            $output = fopen('php://output', 'wb');
            fputcsv($output, $headers);

            foreach ($rows->cursor() as $row) {
                fputcsv($output, array_map(fn ($value) => $this->safeCsvValue($value), (array) $row));
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** @return array{string, array<int, string>, Builder} */
    private function payments(string $from, string $to): array
    {
        $rows = DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->leftJoin('bills', 'bills.id', '=', 'payments.bill_id')
            ->whereBetween('payments.created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->orderBy('payments.id')
            ->select([
                'payments.reference_number', 'users.name as student', 'users.email',
                'bills.billing_month', 'payments.applies_to', 'payments.amount', 'payments.method',
                'payments.status', 'payments.provider_reference', 'payments.payment_date', 'payments.created_at',
            ]);

        return ['payments-'.$from.'-to-'.$to.'.csv', ['Reference', 'Student', 'Email', 'Billing Month', 'Charge', 'Amount', 'Method', 'Status', 'Provider Reference', 'Paid Date', 'Submitted At'], $rows];
    }

    /** @return array{string, array<int, string>, Builder} */
    private function maintenance(string $from, string $to): array
    {
        $rows = DB::table('maintenance_requests')
            ->join('users', 'users.id', '=', 'maintenance_requests.user_id')
            ->leftJoin('rooms', 'rooms.id', '=', 'maintenance_requests.room_id')
            ->leftJoin('users as assignees', 'assignees.id', '=', 'maintenance_requests.assigned_to')
            ->whereBetween('maintenance_requests.created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->orderBy('maintenance_requests.id')
            ->select([
                'maintenance_requests.id', 'users.name as student', 'rooms.room_number',
                'maintenance_requests.title as category', 'maintenance_requests.priority',
                'maintenance_requests.status', 'assignees.name as assigned_to',
                'maintenance_requests.due_at', 'maintenance_requests.resolved_at', 'maintenance_requests.created_at',
            ]);

        return ['maintenance-'.$from.'-to-'.$to.'.csv', ['Request ID', 'Student', 'Room', 'Category', 'Priority', 'Status', 'Assigned Admin', 'Due At', 'Resolved At', 'Submitted At'], $rows];
    }

    /** @return array{string, array<int, string>, Builder} */
    private function paymentAudit(string $from, string $to): array
    {
        $rows = DB::table('payment_audits')
            ->leftJoin('users as actors', 'actors.id', '=', 'payment_audits.actor_id')
            ->leftJoin('users as students', 'students.id', '=', 'payment_audits.student_id')
            ->whereBetween('payment_audits.created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->orderBy('payment_audits.id')
            ->select([
                'payment_audits.reference_number', 'students.name as student', 'actors.name as changed_by',
                'payment_audits.action', 'payment_audits.previous_status', 'payment_audits.new_status',
                'payment_audits.amount', 'payment_audits.created_at',
            ]);

        return ['payment-audit-'.$from.'-to-'.$to.'.csv', ['Reference', 'Student', 'Changed By', 'Action', 'Previous Status', 'New Status', 'Amount', 'Changed At'], $rows];
    }

    private function safeCsvValue(mixed $value): mixed
    {
        if (! is_string($value) || $value === '') {
            return $value;
        }

        return preg_match('/^[\s]*[=+\-@]/u', $value) === 1 ? "'".$value : $value;
    }
}
