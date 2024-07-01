<?php

namespace Database\Populate;

use App\Models\Status;
use App\Models\User;

class StatusPopulate
{
  public static function populate()
  {
    $data = [
      'name' => 'Aberto',
    ];

    $status = new Status($data);
    $status->save();

    $data = [
      'name' => 'Em andamento',
    ];

    $status = new Status($data);
    $status->save();

    $data = [
      'name' => 'Finalizada',
    ];

    $status = new Status($data);
    $status->save();
    echo "Status populated with 3 registers\n";
  }

}
