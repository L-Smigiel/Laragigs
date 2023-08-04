<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'company', 'email',  'location', 'website', 'description', 'tags'];

    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }
    
        if ($filters['search'] ?? false) {
            $searchTerm = $filters['search'];
            $query->where(function ($query) use ($searchTerm) {
                $query->where('tags', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%');
            });
        }
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
