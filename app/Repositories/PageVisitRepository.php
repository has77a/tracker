<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

final class PageVisitRepository
{
    public function getUniqueVisits($startDate, $endDate, $sessionTimeoutSeconds): array
    {
        $query = <<<SQL
SELECT
    page,
    COUNT(DISTINCT CONCAT(fingerprint, '_', FLOOR(UNIX_TIMESTAMP(client_timestamp) / ?))) AS unique_visits
FROM page_visits
WHERE client_timestamp BETWEEN ? AND ?
GROUP BY page
ORDER BY unique_visits DESC;
SQL;

        return DB::select($query, [$sessionTimeoutSeconds, $startDate, $endDate]);
    }

}
