<?php

namespace App\Http\Controllers\Web;

use App\Repositories\PageVisitRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class VisitsController
{
    private const DEFAULT_DISPLAY_PERIOD_DAYS = 7;
    public function __construct(private PageVisitRepository $pageVisitRepository)
    {
    }

    public function index(Request $request): View
    {
        $datetimeFormat = config('visits.datetime_format');
        $request->validate([
            'start_datetime' => "nullable|date_format:{$datetimeFormat}",
            'end_datetime' => "nullable|date_format:{$datetimeFormat}|after_or_equal:start_datetime",
        ]);

        $start = $request->input('start_datetime', now()->subDays(self::DEFAULT_DISPLAY_PERIOD_DAYS)->format($datetimeFormat));
        $end = $request->input('end_datetime', now()->format($datetimeFormat));

        $sessionTimeout = config('visits.session_timeout_seconds');
        $visits = $this->pageVisitRepository->getUniqueVisits($start, $end, $sessionTimeout);

        return view('visits.index', compact('visits', 'start', 'end', 'sessionTimeout'));
    }
}
