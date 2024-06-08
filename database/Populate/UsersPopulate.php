<?php

namespace Database\Populate;

use App\Models\User;

class UsersPopulate
{
  public static function populate()
  {
    $data = [
      'name' => 'Eliezer Boeira',
      'email' => 'admin@example.com',
      'password' => 'admin',
      'password_confirmation' => 'admin'
    ];

    $user = new User($data);
    $user->save();

    $data = [
      'name' => 'João Silva',
      'email' => 'user@example.com',
      'password' => 'user',
      'password_confirmation' => 'user'
    ];

    $user = new User($data);
    $user->save();
    echo "Users populated with 2 registers\n";
  }

  public static function update()
  {

    $user = User::findById(1);
    $user->update([
      'profile_id' => 1,
      'updated_at' => date('Y-m-d H:i:s')
    ]);
    $user = User::findById(2);
    $user->update([
      'profile_id' => 2,
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }
}
