<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = ['name', 'barcode', 'cost', 'price', 'stock', 'alert', 'status', 'image', 'category_id'];

    public function category() {

        return $this->belongsTo(Category::class);

    }

    public function purchase() {

        return $this->belongsTo(Purchase::class);

    }

    public function getImagenAttribute($image)
    {
        if ($this->image != NULL) {
            return (file_exists('storage/products/' . $this->image) ? $this->image : 'noimg.jpg');
        } else {
            return 'noimg.jpg';
        }
    }

}
