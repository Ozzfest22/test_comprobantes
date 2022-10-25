<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        'id',
        'cod_prod',
        'name',
        'description',
        'price'
    ];

    public function vouchers(){
        return $this->belongsToMany(Voucher::class, 'voucher_detail', 'id_prod', 'id_voucher')
            ->withPivot('quantity','price');
    }
}
