<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\LinkModel;
use App\Models\NewsModel;
use App\Models\ProfileModel;
use App\Models\RegionModel;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $news = new NewsModel;
        $news = $news->with(['links', 'categories', 'profiles', 'regions']);
        if($request['search']){
            $news->where('title', 'like', "%{$request['search']}%")->orWhere('content', 'like', "%{$request['search']}%");
        }
        
        return $news->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['links'] = LinkModel::get();
        $data['categories'] = CategoryModel::get();
        $data['profiles'] = ProfileModel::get();
        $data['regions'] = RegionModel::get();

        return response()->json($data);
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
            'title' => 'required|max:150',
            'content' => 'required',
            'labels' => 'array',
            'category_id' => 'required|array|min:1|exists:categories,id',
            'link_id' => 'array|exists:links,id',
            'profile_id' => 'array|exists:profiles,id',
            'region_id' => 'array|exists:regions,id'
        ]);

        $news = NewsModel::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'published' => date('Y-m-d H:i:s'),
            'labels' => $request['labels']
        ]);

        $news->categories()->attach($request['category_id']);
        if($request['link_id']) $news->links()->attach($request['link_id']);
        if($request['profile_id']) $news->profiles()->attach($request['profile_id']);
        if($request['region_id']) $news->regions()->attach($request['region_id']);

        return response()->json($news);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = NewsModel::with(['links', 'categories', 'profiles', 'regions'])->find($id);

        return response()->json($news);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['links'] = LinkModel::get();
        $data['categories'] = CategoryModel::get();
        $data['profiles'] = ProfileModel::get();
        $data['regions'] = RegionModel::get();
        $data['news'] = NewsModel::find($id);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsModel $news)
    {
        $request->validate([
            'title' => 'required|max:100',
            'content' => 'required|max:255',
            'labels' => 'array'
        ]);

        $news->update([
            'title' => $request['title'],
            'content' => $request['content'],
            'labels' => $request['labels']
        ]);

        return response()->json(['msg' => 'updated success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsModel $news)
    {
        $news->categories()->detach(collect($news->categories)->map(fn($item) => $item['id'])->toArray());
        $news->links()->detach(collect($news->links)->map(fn($item) => $item['id'])->toArray());
        $news->profiles()->detach(collect($news->profiles)->map(fn($item) => $item['id'])->toArray());
        $news->regions()->detach(collect($news->regions)->map(fn($item) => $item['id'])->toArray());
        $news->delete();

        return response()->json(['msg' => 'deleted success'], 200);
    }
}
