<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object'; // Bisa 'array' atau 'object'
    protected $useTimestamps    = true; // Otomatis mengisi created_at, updated_at

    // Ini adalah 'fillable' di Laravel
    protected $allowedFields    = ['name', 'email', 'password', 'role'];

    // ... (logic untuk hash password bisa ditambah di sini)
}