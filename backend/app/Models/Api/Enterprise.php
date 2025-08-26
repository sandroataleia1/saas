<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Enterprise extends Model
{
    protected $fillable = ['name', 'description'];

    protected $table = 'enterprises';

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'id' => 'integer',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function users_has_enterprise()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
