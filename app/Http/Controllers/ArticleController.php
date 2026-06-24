<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('category')->get();
        $categories = Category::all();
        return view('articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photo' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $request->photo,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('article.index')->with('success', 'Article di tambahkan!');
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Article::with('category')->find($id);
        $categories = Category::all();
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('articles.getEditFormB', compact('data', 'categories'))->render()
        ), 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);
        $data->title = $request->title;
        $data->content = $request->content;
        $data->photo = $request->photo;
        $data->category_id = $request->category_id;
        $data->save();

        $categoryName = Category::find($request->category_id)->category_name;

        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Article data is up-to-date!',
            'category_name' => $categoryName
        ), 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);
        $data->delete();
        return response()->json(array(
            'status' => 'oke',
            'msg' => 'Article data is removed !'
        ), 200);
    }
}
