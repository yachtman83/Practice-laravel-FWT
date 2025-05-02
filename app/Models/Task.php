<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    protected $fillable = [
        'title',
        'status',
        'user_id',
    ];
    protected $casts = [
        'status' => Status::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabel(): string
    {
        return Status::from($this->status)->label();
    }
}
