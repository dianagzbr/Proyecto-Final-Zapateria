<?php

namespace App\Policies;

use App\Models\Compra;
use App\Models\User;

class CompraPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Compra $compra)
    {
        return in_array($user->role, ['admin', 'comprador']);
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'comprador';
    }

    public function delete(User $user, Compra $compra)
    {
        return $user->role === 'admin' || $user->role === 'comprador';
    }
}
