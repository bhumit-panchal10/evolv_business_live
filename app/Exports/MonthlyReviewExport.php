<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonthlyReviewExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function headings(): array
    {
        return [
            'City Group',
            'Member Of The Month',
            'Company Name',
            'Total Points',
            'Highest Direct Business',
            'Direct Amount',
            'Group Total Direct Amount',
            'Highest Referral Business',
            'Referral Amount',
            'Group Total Referral Amount',
            'Total Business',
            'Group Total Referral Count',
            'Top One To One',
            'Total One To One',
            'Group Total One To One Count',
        ];
    }

    public function array(): array
    {
        $data = [];

        foreach ($this->reportData as $row) {

            $directAmount = $row['top_direct_business']->total_amount ?? 0;
            $referenceAmount = $row['top_reference_business']->total_amount ?? 0;

            $totalDirectBusiness = $row['totalDirectBusiness'] ?? 0;
            $totalReferenceBusiness = $row['totalReferenceBusiness'] ?? 0;

            $totalBusiness = $totalDirectBusiness + $totalReferenceBusiness;

            $data[] = [
                $row['city_group'] ?? '-',

                $row['member_of_the_month']->Contact_person ?? '-',

                $row['member_of_the_month']->companyname ?? '-',

                $row['member_of_the_month']->total_points ?? 0,

                $row['top_direct_business']->Contact_person ?? '-',

                $directAmount,

                $totalDirectBusiness,

                $row['top_reference_business']->Contact_person ?? '-',

                $referenceAmount,

                $totalReferenceBusiness,

                $totalBusiness,

                $row['totalReferralCount'] ?? 0,

                $row['top_one_to_one']->Contact_person ?? '-',

                $row['top_one_to_one']->total_meetings ?? 0,

                $row['totalOneToOne'] ?? 0,
            ];
        }

        return $data;
    }
}
