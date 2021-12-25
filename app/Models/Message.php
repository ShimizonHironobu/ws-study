<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['users_id', 'message'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function getAllMessage() {

        $selectList = [
            "msg.id", "u.id", "u.name", "msg.message", "msg.created_at"
        ];

        $query = DB::table("messages as msg");
        $query->select($selectList);
        $query->leftJoin("users as u", "msg.users_id", "=", "u.id");
        $query->where("msg.deleted_at", null);
        return $query->get();
    }

}