<?php

namespace App\Services;

use App\Models\CommandeDetail;

class CAService
{
    /**
     * Get the total revenue.
     *
     * @return array
     */
    public function getTotalRevenue()
    {
        $total = CommandeDetail::sum('prix');
        return [
            'prix' => $total,
        ];
    }
}
