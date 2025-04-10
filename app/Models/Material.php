<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model {
    use SoftDeletes;
    protected $fillable = ['user_id', 'title', 'description', 'file_path', 'approved'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function courses() {
        return $this->hasMany(Course::class);
    }
}
