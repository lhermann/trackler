<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model {

    // assumes table with name `hits`
    // assumes PK with name `id`
    // assumes timestamps `created_at` and `updated_at`

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the event that owns this hit.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public static function register($domain_id, $event_name) {

        $event = Event::firstOrCreate(
            ['domain_id' => $domain_id, 'name' => $event_name]
        );

        $hit = self::whereDate( 'created_at', '>=', date('Y-m-d', strtotime('-1 minutes')) )
            ->whereTime( 'created_at', '>=', date('H:i:s', strtotime('-1 minutes')) )
            ->firstOrNew([
                'event_id' => $event->id,
                'timeframe' => 'minute'
            ]);

        if(!$hit->exists) {
            $hit->count = 1;
            $hit->timeframe = 'minute';
        } else {
            $hit->count = $hit->count + 1;
        }

        $hit->save();

        return $hit;
    }

    public static function aggregateByEventAndTimeframe($domain_id, $event, $amount, $timeframe) {

        // get event ids
        if( $event ) {
            $event = Domain::find($domain_id)->events()->where('name', $event)->first();
            $event_ids = [$event->id];
        } else {
            $events = Domain::find($domain_id)->events;
            $event_ids = $events->map(function($event){ return $event->id;});
        }

        // whitelist timeframe keywords
        if( !in_array($timeframe, [
            'year', 'years',
            'month', 'months',
            'week', 'weeks',
            'day', 'days',
            'hour', 'hours',
            'minute', 'minutes'
        ])) abort(404, "Unrecognized timeframe '$timeframe'");

        // perform query
        $hits = app('db')->select( sprintf(
            'SELECT
                date,
                coalesce(SUM(hits.count), 0) AS count
            FROM GENERATE_SERIES(
                    date_trunc(\'%3$s\', \'%1$s\'::TIMESTAMP) - interval \'%2$d %3$s\',
                    date_trunc(\'%3$s\', \'%1$s\'::TIMESTAMP),
                    \'1 %3$s\'::INTERVAL
                ) date
            LEFT JOIN hits
                ON date_trunc(\'%3$s\', hits.created_at) = date
                AND hits.event_id IN (%4$s)
            GROUP BY date
            ORDER BY date;',
            date('Y-m-d H:i:s'),
            (int) $amount,
            e($timeframe),
            implode(',', $event_ids)
        ));

        return $hits;

        // SELECT *
        // FROM GENERATE_SERIES(
        //         '2018-05-09 12:53:00'::TIMESTAMP - interval '6 hours',
        //         '2018-05-09 12:53:00'::TIMESTAMP,
        //         '1 hour'::INTERVAL
        //     ) p_date
        // JOIN hits
        // ON date_trunc('hour', hits.created_at) = p_date;

        // SELECT
        //     p_date,
        //     coalesce(SUM(count), 0) AS count
        // FROM GENERATE_SERIES(
        //         '2018-05-09 14:00:00'::TIMESTAMP - interval '6 hours',
        //         '2018-05-09 14:00:00'::TIMESTAMP,
        //         '1 hour'::INTERVAL
        //     ) p_date
        // LEFT JOIN hits
        // ON date_trunc('hour', hits.created_at) = p_date
        // GROUP BY p_date
        // ORDER BY p_date;
    }
}
