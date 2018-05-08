<?php

namespace App\Http\Controllers;

use App\Hit;
use Illuminate\Http\Request;


class HitController extends Controller {

    use UpdateOrCreateHit;

    public function hit($domain_id, Request $request) {
        self::updateOrCreate($domain_id, $request);
        return response("");
    }

    /**
     * Archives 'minute' hits older than 120 minutes into 'hour' hits
     * and 'hour' hits older than 120 hours into 'day' hits
     */
    public function archive() {
        // TODO
    }
}
