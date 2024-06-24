<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property int $demand_id
 * @property int $user_id
 * @property int $status_id
 * @property string $id_user_created
 * @property string $id_user_updated
 * @property string $id_user_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class DemandUser extends Model
{
    protected static string $table = 'demand_user';
    protected static array $columns = ['demand_id', 'user_id', 'status_id',
      'id_user_created', 'id_user_updated', 'id_user_deleted', 'created_at', 'updated_at', 'deleted_at'];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demands(): BelongsTo
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }

    public function validates(): void
    {
        Validations::notEmpty('demand_id', $this);
        Validations::notEmpty('user_id', $this);
        Validations::notEmpty('status_id', $this);
    }
}
