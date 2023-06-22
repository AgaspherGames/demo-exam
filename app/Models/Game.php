<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'thumbnail',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function($parent){
            $versions = $parent->versions;
            foreach ($versions as $version) {
                $version->delete();
            }
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function versions(){
        return $this->hasMany(Version::class);
    }

    public function lastVersion(){
        return $this->hasOne(Version::class)->latestOfMany();
    }

    public function scores(){
        return $this->through('versions')->has('scores');
    }

}
