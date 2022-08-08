<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'category_name', 'category_slug'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function getImageThumbUrlAttribute()
    {
        if ($this->image) {
            return url('categories/' . $this->image);
        }
    }
}
