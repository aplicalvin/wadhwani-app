<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true; // Mengaktifkan soft delete (butuh 'deleted_at')
    protected $allowedFields    = ['category_id', 'name', 'description', 'price_per_kg', 'image'];
}