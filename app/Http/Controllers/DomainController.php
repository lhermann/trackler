<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller {

    public function showAll() {
        return response()->json(Domain::all());
    }

    public function showOne($id) {
        return response()->json(Domain::find($id));
    }

    public function showEvents($id) {
        return response()->json(Domain::find($id)->events);
    }

    public function create(Request $request) {
        $domain = Domain::create($request->all());

        return response()->json($domain, 201);
    }

    public function update($id, Request $request) {
        $domain = Domain::findOrFail($id);
        $domain->update($request->all());

        return response()->json($domain, 200);
    }

    public function delete($id) {
        Domain::findOrFail($id)->delete();
        return response()->json((object)['message' => 'Deleted Successfully'], 200);
    }
}
