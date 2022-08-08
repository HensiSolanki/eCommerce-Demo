<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Product extends Model
{
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'product_name', 'description','price','image'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function getImageThumbUrlAttribute()
    {
        if ($this->image) {
            return url('/products/' . json_encode($this->image[0]));
        }
    }
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('/products/' . $this->image[0]);
        }
    }
}