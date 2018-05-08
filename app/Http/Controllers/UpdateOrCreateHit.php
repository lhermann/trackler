<?php

namespace App\Http\Controllers;

use App\Event;
use App\Hit;
use Illuminate\Http\Request;

trait UpdateOrCreateHit {

    public function updateOrCreate($domain_id, Request $request) {

        $event_name = $request->input('event', 'hit');
        $identifier = $request->input('identifier', null);

        $event = Event::firstOrCreate(
            ['domain_id' => $domain_id, 'name' => $event_name]
        );

        $hit = Hit::whereRaw('created_at >= NOW() - INTERVAL 1 MINUTE')
            ->firstOrNew([
                'event_id' => $event->id,
                'identifier' => $identifier,
                'timeframe' => 'minute'
            ]);

        if(!$hit->exists) {
            $hit->count = 1;
            $hit->identifier = $identifier;
            $hit->timeframe = 'minute';
            $hit->date = date("Y-m-d");
        } else {
            $hit->count = $hit->count + 1;
        }

        $hit->save();

        return $hit;
    }

}
