<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tags;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    public function index(Request $request) {
        return Tags::whereBetween('created_at', [$request->from, $request->to])->get();
    }

    public function store(Request $request) {
        $tag = new Tags();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return response()->json([
            'message' => 'Tag Added Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function update($id, Request $request) {
        $tag = Tags::find($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name, '-');
        $tag->save();

        return response()->json([
            'message' => 'Tag Updated Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }

    public function destroy($id) {
        $tag = Tags::find($id);
        $tag->delete();
        return response()->json([
            'message' => 'Tag Deleted Successfully.',
            'status' => 200,
            'success' => true
        ]);
    }
}
