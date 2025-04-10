<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    protected $fillable = ['material_id', 'course_name', 'semester'];

    public function material() {
        return $this->belongsTo(Material::class);
    }
}
