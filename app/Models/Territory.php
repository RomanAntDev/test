<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Territory extends Model
{
    /**
     * @var string
     */
    protected $table = 't_koatuu_tree';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRegions(): \Illuminate\Support\Collection
    {
        return self::all()->where('ter_type_id', 0);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCities(): \Illuminate\Support\Collection
    {
        return self::all()->where('ter_level', 2)->where('ter_type_id','<=', 2);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getDistricts(): \Illuminate\Support\Collection
    {
        return self::all()->where('ter_level', '>','2');
    }
    
    /**
     * @return Territory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getException()
    {
        return self::all()->where('ter_level',2);
    }
}
