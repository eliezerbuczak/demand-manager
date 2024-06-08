<?php

namespace Database\Populate;

use App\Models\Profile;

class ProfilePopulate
{
  public static function populate()
  {
    $admin = [
      'name' => 'Administrador',
      'create_demand' => 1,
      'edit_demand' => 1,
      'delete_demand' => 1,
      'show_all_demands' => 1,
      'id_user_created' => 1,
    ];
    $user = [
      'name' => 'Usuário',
      'create_demand' => 0,
      'edit_demand' => 0,
      'delete_demand' => 0,
      'show_all_demands' => 0,
      'id_user_created' => 1,
    ];
    $user = new Profile($user);
    $user->save();
    $admin = new Profile($admin);
    $admin->save();

    UsersPopulate::update();

    echo "Profiles populated with 2 registers\n";
  }
}
