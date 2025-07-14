<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;

class ResultPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Result $result): bool
    {
        return $user->isAdmin() || $user->id === $result->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Result $result): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Result $result): bool
    {
        return $user->isAdmin();
    }
}