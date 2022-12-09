<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    public function products() {

        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute($image)
    {
        if ($this->image != NULL) {
            return (file_exists('storage/categories/' . $this->image) ? $this->image : 'noimg.jpg');
        } else {
            return 'noimg.jpg';
        }
    }

}
