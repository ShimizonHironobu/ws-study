<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $fillable = ['message'];

    public function getMessage() {
        $selectList = [
            "msg.id", "u.name as user_name", "u.id as user_id", "msg.message", "msg.created_at"
        ];
        $query = DB::table("messages as msg")->select($selectList);
        $query->leftjoin("users as u", "msg.users_id", "=", "u.id");
        $query->limit(20);
        $query->orderBy("msg.created_at", "desc");
        return $query->get();

    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}