<?php

namespace App\Models;

use App\Models\Expense;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];
    //Filter
    public function scopeFilter($query, array $filters)
    {

       if($filters['search'] ?? false)
       {
            $query ->where('name','like','%'. request('search').'%'); 
       }
    }
    



     public function expenses()
     {
        return $this->hasMany(Expense::class);
     }
}
