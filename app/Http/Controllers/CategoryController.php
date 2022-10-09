<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new CategoryModel;
        return response()->json($categories->get());
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

        $categories = [];
        foreach($inserts as $category){
            $categories[] = CategoryModel::create($category);
        }

        return response()->json($categories);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryModel $category)
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        $category->update([
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
    public function destroy(CategoryModel $category)
    {
        $category->delete();

        return response()->json(['msg' => 'deleted success'], 200);
    }
}
