<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletes;



class ExcludeBannedUsersScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereHas('user', function ($query) {
            $query->where('ban_reason', NULL);
        });
    }
}


class Score extends Model
{
    use HasFactory, SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ExcludeBannedUsersScope());
    }


    protected $fillable = [
        'user_id',
        'version_id',
        'score',
    ];

    public function scopeAll(Builder $query)
    {
        return $query->whereHas('user', function ($query) {
            $query->where('ban_reason', NULL);
        });
    }


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function version(){
        return $this->belongsTo(Version::class);
    }

}
