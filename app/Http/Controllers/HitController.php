<?php

namespace App\Http\Controllers;

use App\Event;
use App\Hit;
use Illuminate\Http\Request;

class HitController extends Controller {

    public function updateOrCreate($domain_id, $label, Request $request) {

        $label = Event::firstOrCreate(
            ['domain_id' => $domain_id, 'name' => $label]
        );

        $hit = Hit::whereRaw('created_at >= NOW() - INTERVAL 1 MINUTE')
            ->firstOrNew(['label_id' => $label->id, 'timeframe' => 'minute']);


        if(!$hit->exists) {
            $hit->count = 1;
            $hit->timeframe = 'minute';
            $hit->date = date("Y-m-d");
        } else {
            $hit->count = $hit->count + 1;
        }

        $hit->save();

        return response()->json($hit);
    }

    /**
     * Archives 'minute' hits older than 120 minutes into 'hour' hits
     * and 'hour' hits older than 120 hours into 'day' hits
     */
    public function archive() {
        // TODO
    }
}
