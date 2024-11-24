<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venta;

class VentaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Venta $venta)
    {
        return in_array($user->role, ['admin', 'vendedor']);
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'vendedor';
    }

    public function delete(User $user, Venta $venta)
    {
        return $user->role === 'admin' || $user->role === 'vendedor';
    }
}

