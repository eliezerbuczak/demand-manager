<?php

namespace App\Models;

use Core\Database\ActiveRecord\Model;
use Lib\Validations;

class Profile extends Model
{
    /**
      * @param $user
      * @property int $id
      * @property string $name
      * @property bool $create_demand
      * @property bool $edit_demand
      * @property bool $delete_demand
      * @property bool $show_all_demands
      * @property int $id_user_created
     * @property int $id_user_updated
     * @property int $id_user_deleted
      * @property string $created_at
      * @property string $updated_at
      * @property string $deleted_at
     */

    protected static string $table = 'profiles';
    protected static array $columns = [
        'name', 'create_demand', 'edit_demand', 'delete_demand', 'show_all_demands', 'id_user_created', 'id_user_updated', 'id_user_deleted',
        'created_at', 'updated_at', 'deleted_at'];

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::uniqueness('name', $this);
        Validations::notEmpty('create_demand', $this);
        Validations::notEmpty('edit_demand', $this);
        Validations::notEmpty('delete_demand', $this);
        Validations::notEmpty('show_all_demands', $this);
    }
}
