<?php

namespace App\Http\Controllers\Api;

use App\Models\PageVisit;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

final class TrackerController
{
    private const UNKNOWN_VALUE_PLACEHOLDER = 'unknown';

    public function collect(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'required|string|max:512',
            'timestamp' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $ip = $request->ip();
        $userAgent = $request->userAgent();
        if ($ip === null && $userAgent === null) {
            return response()->json([], 204);
        }

        $ipForFingerprint = $ip ?? self::UNKNOWN_VALUE_PLACEHOLDER;
        $uaForFingerprint = $userAgent ?? self::UNKNOWN_VALUE_PLACEHOLDER;
        $fingerprintRaw = "{$ipForFingerprint}|{$uaForFingerprint}";
        $fingerprint = hash('sha256', $fingerprintRaw);

        PageVisit::create([
            'page' => $request->query('page'),
            'client_timestamp' => Carbon::createFromTimestampMs((int)$request->query('timestamp')),
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'fingerprint' => $fingerprint,
        ]);

        return response()->json([], 204);
    }
}
