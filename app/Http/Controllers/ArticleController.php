<?php

namespace App\Http\Controllers;
use App\Article;

use http\Env\Response;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ArticleController extends Controller
{
    public function index()
    {
        return response()-> json(['data'=>Article::all(), 'message'=>'thanh cong', 'status'=>1], 200);
    }

    public function show($id)
    {
        if($this->checkid($id)){
            return response()->json(['data'=>Article::find($id), 'message'=>'thanh cong', 'status'=>1], 200);
        }
        else{
            return response()->json(['message'=>'khong thanh cong', 'status'=>0], 404);
        }
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        $body = $request->input('body');
        if($title != null && $body != null){
            try{
                $article = Article::create($request->all());
                return response()->json(['data'=>$article, 'message'=>'them thanh cong', 'status'=>1], 200);
            }catch (\Exception $exception){
                return response()->json(['message'=>$exception->getMessage(), 'status'=>0], 404);
            }

        }
        else{
            return response()->json(['message'=>'khong thanh cong! xin nhap day du thong tin', 'status'=>0], 404);
        }

    }

    public function update(Request $request , $id )
    {
        $article = Article::find($id);
        if($article != null){
            try{
                $article -> update($request -> all());
                return response()->json(['data'=>$article, 'message'=>'update thanh cong', 'status'=>1], 200);
            }catch (Exception $exception){
                return response()->json(['message'=>$exception->getMessage(), 'status'=>0], 404);
            }

        }
        else{
            return response()->json(['message'=>'khong tim thay id', 'status'=>0], 404);
        }
    }

    public function delete($id)
    {
        if($this->checkid($id)){
            try{
                $article = Article::find($id);
                $article->delete();
                return response()->json(['message'=>'xoa thanh cong', 'status'=>1], 200);
            }catch (\Exception $exception){
                return response()->json(['message'=>$exception->getMessage(), 'status'=>0], 404);
            }

        }
        else {
            return response()->json(['message'=>'khong tim thay id', 'status'=>0], 404);
        }

    }
    public function checkid($id){
        $article = Article::find($id);
        if($article){
            return true;
        }
        else {
            return false;
        }
    }
}
