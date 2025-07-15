<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

final class PageVisitRepository
{
    public function getUniqueVisits($startDate, $endDate, $sessionTimeoutSeconds): array
    {
        $query = "
        WITH ordered_visits AS (
            SELECT
                *,
                UNIX_TIMESTAMP(client_timestamp) AS ts,
                LAG(UNIX_TIMESTAMP(client_timestamp)) OVER (PARTITION BY fingerprint, page ORDER BY client_timestamp) AS prev_ts
            FROM page_visits
            WHERE client_timestamp BETWEEN ? AND ?
        ),
        sessions AS (
            SELECT
                *,
                CASE WHEN ts - COALESCE(prev_ts, 0) > ? THEN 1 ELSE 0 END AS new_session_flag
            FROM ordered_visits
        ),
        session_groups AS (
            SELECT
                *,
                SUM(new_session_flag) OVER (PARTITION BY fingerprint, page ORDER BY client_timestamp ROWS UNBOUNDED PRECEDING) AS session_id
            FROM sessions
        )
        SELECT
            page,
            COUNT(DISTINCT CONCAT(fingerprint, '_', session_id)) AS unique_visits
        FROM session_groups
        GROUP BY page
        ORDER BY unique_visits DESC;
        ";

        return DB::select($query, [$startDate, $endDate, $sessionTimeoutSeconds]);
    }
}
