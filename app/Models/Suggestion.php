<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'query',
        'type',
        'response',
        'addressed',
        'access_role'
    ];

    public function dept(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function initiator(){
        return $this->belongsTo(User::class,'user_id');
    }
}
