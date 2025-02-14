<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ComplaintExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    /**
     * Constructor to receive start and end dates.
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Retrieve complaints and pricing data using separate queries.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Retrieve complaints within the date range
        $complaints = DB::table('complaints')
            ->whereDate('complaints.created_at', '>=', $this->startDate)
            ->whereDate('complaints.created_at', '<=', $this->endDate)
            ->get();
        //dd($complaints);
        // Retrieve pricing data (assuming pricing is related by complaint_id)
        $pricing = DB::table('pricing')->get();
        // Combine complaints with corresponding pricing data
        $combined = $complaints->map(function ($complaint) use ($pricing) {
            // Find related pricing
            $pricingData = $pricing->firstWhere('complaint_id', $complaint->id);
            // Retrieve complaint logs for the current complaint
            $logsData = DB::table('complaint_logs')
                ->where('complaint_id', $complaint->id)
                ->get();

            // Extract messages from logs
            $messages = $logsData->pluck('message')->toArray(); // Extract message column
            $messagesString = implode(', ', $messages); // Convert to a single string (optional)
            return (object)[
                'complaint_uuid' => $complaint->complaint_uuid,
                'customer_name' => $complaint->customer_name,
                'customer_mobile' => $complaint->customer_mobile,
                'waybill_no' => $complaint->waybill_no,
                'case_type_name' => $complaint->case_type_name,
                'customer_message' => $complaint->customer_message,
                'customer_recommendation' => $complaint->customer_recommendation,
                'issue_date' => $complaint->issue_date,
                'source_branch' => $complaint->source_branch,
                'handle_by' => $complaint->handle_by,
                'branch_name' => $complaint->branch_name,
                'employee_id' => $complaint->employee_id,
                'employee_name' => $complaint->employee_name,
                'status_name' => $complaint->status_name,
                'complaint_review' => $complaint->complaint_review,
                'stars_rated' => $complaint->stars_rated,
                'refund_amount' => $complaint->refund_amount,
                'company_remark' => $complaint->company_remark,
                'source_platform' => $complaint->source_platform,
                'ygn_refund' => $pricingData ? $pricingData->ygn_refund : null,
                'rop_refund' => $pricingData ? $pricingData->rop_refund : null,
                'other_refund' => $pricingData ? $pricingData->other_refund : null,
                'ygn_branch' => $pricingData ? $pricingData->ygn_branch : null,
                'rop_branch' => $pricingData ? $pricingData->rop_branch : null,
                'other_branch' => $pricingData ? $pricingData->other_branch : null,
                'default_value' => $pricingData ? $pricingData->default_value : null,
                'negotiable_price' => $pricingData ? $pricingData->negotiable_price : null,
                'messages' => $messagesString, // Store all log messages as a string
                'created_at' => $complaint->created_at,
            ];
        });

        return $combined;
    }

    /**
     * Map data to each row in the export file.
     *
     * @param $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->complaint_uuid,
            $row->customer_name,
            $row->customer_mobile,
            $row->waybill_no,
            $row->case_type_name,
            $row->customer_message,
            $row->customer_recommendation,
            $row->issue_date,
            $row->source_branch,
            $row->handle_by,
            $row->branch_name,
            $row->employee_id,
            $row->employee_name,
            $row->status_name,
            $row->complaint_review,
            $row->stars_rated,
            $row->refund_amount,
            $row->company_remark,
            $row->source_platform,
            $row->ygn_refund,
            $row->rop_refund,
            $row->other_refund,
            $row->ygn_branch,
            $row->rop_branch,
            $row->other_branch,
            $row->default_value,
            $row->negotiable_price,
            $row->messages,
            $row->created_at,
        ];
    }

    /**
     * Set the headings for the Excel columns.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Complaint UUID',
            'Customer Name',
            'Customer Mobile',
            'Waybill No',
            'Case Type Name',
            'Customer Message',
            'Customer Recommendation',
            'Issue Date',
            'Source Branch',
            'Follow Up Person',
            'Responsible Office',
            'Employee ID',
            'Inform Person',
            'Status Name',
            'Complaint Review',
            'Stars Rated',
            'Refund Amount',
            'Resolution',
            'Source Platform',
            'YGN Refund',
            'ROP Refund',
            'Other Refund',
            'YGN Branch',
            'ROP Branch',
            'Other Branch',
            'Default Value',
            'Negotiable Price',
            'Complaints Logs',
            'Date Created',
        ];
    }
}
