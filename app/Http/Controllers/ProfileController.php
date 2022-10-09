<?php

namespace App\Http\Controllers;

use App\Models\ProfileModel;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = new ProfileModel;
        return response()->json($profiles->get());
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

        $profiles = [];
        foreach($inserts as $profile){
            $profiles[] = ProfileModel::create($profile);
        }

        return response()->json($profiles);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfileModel $profile)
    {
        $request->validate([
            'name' => 'max:100',
            'link' => 'required|max:255',
        ]);

        $profile->update([
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
    public function destroy(ProfileModel $profile)
    {
        $profile->delete();

        return response()->json(['msg' => 'deleted success'], 200);
    }
}
