<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDivisions extends Model
{
    use HasFactory;
    protected $guard = ['id'];
    protected $fillable =['division_id','name',"div","role"];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
