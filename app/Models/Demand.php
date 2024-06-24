<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsToMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $expected_date
 * @property string $path_image
 * @property string $description
 * @property int $status_id
 * @property string $id_user_created
 * @property string $id_user_updated
 * @property string $id_user_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Demand extends Model
{
    protected static string $table = 'demands';
    protected static array $columns = ['title', 'expected_date', 'path_image', 'description', 'status_id',
      'id_user_created', 'id_user_updated', 'id_user_deleted', 'created_at', 'updated_at', 'deleted_at'];

    public function validates(): void
    {
        Validations::notEmpty('title', $this);
        Validations::notEmpty('expected_date', $this);
        Validations::notEmpty('status_id', $this);
    }

    public function usersDemand(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'demand_user', 'demand_id', 'user_id');
    }

}
