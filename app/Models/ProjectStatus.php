<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectStatus extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function projects()
    {
        return $this->hasMany(Project::class, 'status_id');
    }
}
