<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; //この行を上に追加
use App\Models\User;//この行を上に追加
use Auth;//この行を上に追加
use Validator;//この行を上に追加

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //全ての投稿を取得(追記)
        $posts = Post::get();
        
        //{}を追記
        if( Auth::check() ){
            
            //ログインユーザーのお気に入り投稿を取得
            $favo_posts = Auth::user()->favo_posts()->get();
            
             return view('posts',[
            'posts'=>$posts,
            'favo_posts'=>$favo_posts
            ]);
            
        }else{
            
             return view('posts',[
            'posts'=>$posts
            ]);
        
        }
        
        //お気に入り処理の段階で移設
        // return view('posts',[
        //     'posts'=>$posts
        //     ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //バリデーション
        $validator = Validator::make($request->all(),[
            
            'post_title' => 'required | max:255',
            'post_desc' => 'required | max:255'
            
        ]);
        
        //バリデーションがエラーだったら
        if( $validator->fails() ){
            return redirect('/')
              ->withInput()  //フォームに入力したやつを持って帰るよ
              ->withErrors($validator);
        }
        
        //以下に登録処理を記述
        $posts = new Post;
        $posts ->post_title = $request->post_title;
        $posts ->post_desc = $request->post_desc;
        $posts ->user_id = Auth::id(); //ここでログインしているユーザーのIDを登録しています
        $posts ->save();
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    
    //お気に入り処理 ここは追記！
    public function favo($post_id){
        
        //ログイン中のユーザーを取得
        $user = Auth::user();
        
        //お気に入りする記事（投稿）を取得
        $post = Post::find($post_id);
        
        //リレーションの登録
        $post->favo_user()->attach($user);
        
        return redirect('/'); //トップページに返す
    }
}
