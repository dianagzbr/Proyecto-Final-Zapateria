<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Producto $producto)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Producto $producto)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Producto $producto)
    {
        return $user->role === 'admin';
    }
}
