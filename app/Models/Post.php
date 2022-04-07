<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    //Users テーブルとのリレーション（従属テーブル側）
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    //Userテーブルとの多対多のリレーション
    public function favo_user() {
        return $this->belongsToMany('App\Models\User');
    }



}
