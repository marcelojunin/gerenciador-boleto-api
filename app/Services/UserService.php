<?php

namespace App\Services;

use App\Client;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService {

    public function list(): LengthAwarePaginator {
        return Client::paginate(15);
    }

    public function save(array $array): void {
        DB::transaction(function () use($array) {
        $user = new User($array);
        $user->password = bcrypt($user->password);
        $user->save();

        $client =  new Client($array['client']);
        $client->user()->associate($user);
        $client->save();
        });
    }

    public function findOne(int $id): User {
        return User::with('client')->find($id);
    }
}