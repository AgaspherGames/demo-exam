<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'version',
        'path',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($parent){
            $scores = $parent->scores;
            foreach ($scores as $score) {
                $score->delete();
            }
        });
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function scores(){
        return $this->hasMany(Score::class);
    }

}
