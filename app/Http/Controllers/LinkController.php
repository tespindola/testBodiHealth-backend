<?php

namespace App\Http\Controllers;

use App\Models\LinkModel;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = new LinkModel;
        return response()->json($links->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'insert' => 'required|array|min:1',
            'insert.*.link' => 'required|max:200'
        ]);
        $inserts = collect($request['insert'])->map(fn($v) => ['link' => $v['link']])->toArray();

        $links = [];
        foreach($inserts as $link){
            $links[] = LinkModel::create($link);
        }

        return response()->json($links);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LinkModel $link)
    {
        $request->validate([
            'name' => 'required|max:100',
            'link' => 'required|max:255'
        ]);

        $link->update([
            'name' => $request['name'],
            'link' => $request['link'],
        ]);

        return response()->json(['msg' => 'updated success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LinkModel $link)
    {
        $link->delete();

        return response()->json(['msg' => 'deleted success'], 200);
    }
}
