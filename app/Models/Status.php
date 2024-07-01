<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsToMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $id_user_created
 * @property string $id_user_updated
 * @property string $id_user_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Status extends Model
{
    protected static string $table = 'statuses';
    protected static array $columns = ['name',
      'id_user_created', 'id_user_updated', 'id_user_deleted', 'created_at', 'updated_at', 'deleted_at'];

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
    }

}
