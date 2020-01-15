<?php

namespace ConfrariaWeb\Task\Policies;

use App\User;
use ConfrariaWeb\Task\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {

        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any tasks.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @param  \MeridienClube\Meridien\Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        return true;
        return $user->isAdmin() ||
            $task->responsibles->pluck('id')->search($user->id) !== false ||
            $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @param  \MeridienClube\Meridien\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $user->isAdmin() ||
            $task->responsibles->pluck('id')->search($user->id) !== false ||
            $user->id === $task->user_id;
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @param  \MeridienClube\Meridien\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @param  \MeridienClube\Meridien\Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param  \MeridienClube\Meridien\User  $user
     * @param  \MeridienClube\Meridien\Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        return false;
    }

}
