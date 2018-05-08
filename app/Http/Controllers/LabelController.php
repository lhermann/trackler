<?php

namespace App\Http\Controllers;

use App\Label;
use Illuminate\Http\Request;

class LabelController extends Controller {

    public function showAll() {
        return response()->json(Label::all());
    }

    public function showOneById($id) {
        return response()->json(Label::find($id));
    }

    public function showOneByName($name) {
        return response()->json(Label::where('name', $name)->first());
    }

    public function create(Request $request, $domain_id) {
        $label = new Label;
        $label->name = $request->name;
        $label->domain_id = $domain_id;
        $label->save();

        return response()->json($label, 201);
    }

    public function update($id, Request $request) {
        $label = Label::findOrFail($id);
        $label->name = $request->name;
        $label->save();

        return response()->json($label, 200);
    }

    public function delete($id) {
        Label::findOrFail($id)->delete();
        return response()->json((object)['message' => 'Deleted Successfully'], 200);
    }
}
