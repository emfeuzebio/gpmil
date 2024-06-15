<?php

namespace App\Policies;

use App\Models\User;

class ApresentacaoPolicy
{
    public function __construct()
    {
        //
    }

    public function before() {

    }

    public function isAdmin(User $user) {

        $user = User::with('pessoa')->find($user->id);
        // dd($user->id);
        // dd($user->pessoa->nivelacesso_id);

        return $user->pessoa->nivelacesso_id == 1;
    }

    // aqui podemos usar nome para a operações, pois depois vamos testar com CAN() ou CANNOT()
    public function PodeInserirApresentacao(User $user) {

        $user = User::with('pessoa')->find($user->id);
        return in_array($user->pessoa->nivelacesso_id,[1,3,5,6]);
    }

    public function show() {
        
    }
}
