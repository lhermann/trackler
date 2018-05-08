<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller {

    public function showAll() {
        return response()->json(Event::all());
    }

    public function showOneById($id) {
        return response()->json(Event::find($id));
    }

    public function showOneByName($name) {
        return response()->json(Event::where('name', $name)->first());
    }

    public function create(Request $request, $domain_id) {
        $label = new Event;
        $label->name = $request->name;
        $label->domain_id = $domain_id;
        $label->save();

        return response()->json($label, 201);
    }

    public function update($id, Request $request) {
        $label = Event::findOrFail($id);
        $label->name = $request->name;
        $label->save();

        return response()->json($label, 200);
    }

    public function delete($id) {
        Event::findOrFail($id)->delete();
        return response()->json((object)['message' => 'Deleted Successfully'], 200);
    }
}
