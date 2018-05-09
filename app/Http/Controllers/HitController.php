<?php

namespace App\Http\Controllers;

use App\Hit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HitController extends Controller {

    public function hit($first, $domain, $event_name = 'hit') {
        $hit = Hit::register($domain, $event_name);
        return response()->json($hit);
    }

    public function silentHit($first, $domain, $event_name = 'hit') {
        self::hit($first, $domain, $event_name);
        return response("");
    }

    public function showByTimeframe($domain_id, $amount, $timeframe) {
        $hits = Hit::aggregateByEventAndTimeframe($domain_id, null, $amount, $timeframe);
        return response()->json($hits);
    }

    public function showByEventAndTimeframe($domain_id, $event, $amount, $timeframe) {
        $hits = Hit::aggregateByEventAndTimeframe($domain_id, $event, $amount, $timeframe);
        return response()->json($hits);
    }

    /**
     * Archives 'minute' hits older than 120 minutes into 'hour' hits
     * and 'hour' hits older than 120 hours into 'day' hits
     */
    public function archive() {
        // TODO
    }
}
