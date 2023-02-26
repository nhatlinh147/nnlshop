<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PostModel;
use Illuminate\Support\Facades\Auth;

class PostViewModel extends Model
{


    protected $table = 'tbl_post_view';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function createViewLog($post)
    {
        $postView = new PostViewModel();
        $postView->id_post = $post->id;
        $postView->titleslug  = $post->titleslug;
        $postView->url = request()->url();
        $postView->session_id = request()->getSession()->getId();
        $postView->user_id = Auth::check() ? Auth::user()->id : null;
        $postView->ip = request()->ip();
        $postView->save();
    }
    public function postView()
    {
        return $this->belongsTo(PostModel::class);
    }
}