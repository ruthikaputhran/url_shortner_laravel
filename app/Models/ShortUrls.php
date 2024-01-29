<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ShortUrls extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "user_id",
    ] ;
    protected static function boot()
    {
        parent::boot();

        // Listen for the creating event
        static::creating(function ($model) {
            // Code to be executed before the model is created
            $model->user_id = Auth::id();
        });
    }
}
