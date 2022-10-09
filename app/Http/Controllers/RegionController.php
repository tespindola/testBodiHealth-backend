<?php

namespace App\Http\Controllers;

use App\Models\RegionModel;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = new RegionModel;
        return response()->json($regions->get());
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
            'insert.*.name' => 'required|max:150'
        ]);
        $inserts = collect($request['insert'])->map(fn($v) => ['name' => $v['name']])->toArray();

        $regions = [];
        foreach($inserts as $region){
            $regions[] = RegionModel::create($region);
        }

        return response()->json($regions);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegionModel $region)
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        $region->update([
            'name' => $request['name'],
        ]);

        return response()->json(['msg' => 'updated success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegionModel $region)
    {
        $region->delete();

        return response()->json(['msg' => 'deleted success'], 200);
    }
}
