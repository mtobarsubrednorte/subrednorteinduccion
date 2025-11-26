<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = ['modulo_id', 'text', 'icon', 'type', 'file', 'tips'];

    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'modulo_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'step_user')
            ->withPivot('completed_at')
            ->withTimestamps();
    }

}
