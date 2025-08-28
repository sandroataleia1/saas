<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name','cpf_cnpj','slug','address', 'city', 'state', 'zip', 'country', 'phone'];

    protected $table = 'companies';

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'id' => 'integer',
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
