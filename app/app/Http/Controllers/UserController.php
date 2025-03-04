<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\EditUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUser $request, User $user)
    {
        $columns = ['name', 'email'];

        foreach($columns as $column){
            $user->$column = $request->$column;
        }

        if ($request->hasFile('icon')) {
            // 古い画像を削除（存在する場合）
            if ($user->icon && file_exists(public_path($user->icon))) {
                unlink(public_path($user->icon)); // 古い画像を削除
            }
        
            // 画像を public/img/tmp に保存
            $extension = $request->file('icon')->getClientOriginalExtension(); // 拡張子
            $newIconName = uniqid('icon_') . '.' . $extension; // ランダムな新しいファイル名
            $iconPath = 'img/tmp/' . $newIconName; // 保存先のパス
        
            // 画像を public/img/tmp に移動
            $request->file('icon')->move(public_path('img/tmp'), $newIconName);
        
            // DBに保存する画像のパスを指定
            $user->icon = $iconPath;  // 画像の相対パスを保存
        }

        $user->save(); // ユーザーデータを保存
        
        // ユーザー詳細ページにリダイレクト
        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $columns = ['name', 'email', 'icon', 'role', 'del_flg'];
        $user->del_flg = 1;
        $user->save();
        Auth::logout();

        return redirect('/');
        
    }
    public function deleteconf(User $user)
    {
        return view('users.deleteconf', compact('user'));
    }
}
