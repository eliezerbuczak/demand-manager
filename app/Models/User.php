<?php

namespace App\Models;

use Core\Database\ActiveRecord\BelongsTo;
use Core\Database\ActiveRecord\BelongsToMany;
use Core\Database\ActiveRecord\HasMany;
use Lib\Validations;
use Core\Database\ActiveRecord\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $encrypted_password
 * @property int $profile_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends Model
{
    protected static string $table = 'users';
    protected static array $columns = ['name', 'email', 'encrypted_password',
      'profile_id', 'created_at', 'updated_at', 'deleted_at'];

    protected ?string $password = null;
    protected ?string $password_confirmation = null;

    public function validates(): void
    {
        Validations::notEmpty('name', $this);
        Validations::notEmpty('email', $this);

        Validations::uniqueness('email', $this);

        if ($this->newRecord()) {
            Validations::passwordConfirmation($this);
        }
    }

    public function authenticate(string $password): bool
    {
        if ($this->encrypted_password == null) {
            return false;
        }

        return password_verify($password, $this->encrypted_password);
    }

    public static function findByEmail(string $email): User | null
    {
        return User::findBy(['email' => $email]);
    }

    public function __set(string $property, mixed $value): void
    {
        parent::__set($property, $value);

        if (
            $property === 'password' &&
            $this->newRecord() &&
            $value !== null && $value !== ''
        ) {
            $this->encrypted_password = password_hash($value, PASSWORD_DEFAULT);
        }
    }

    public static function availableUsers(): array
    {
        $users = User::all();
        foreach ($users as $user) {
            $profile = Profile::findById($user->profile_id);
            if (!$profile->create_demand) {
                $usersForDemand[] = $user;
            }
        }
        if (isset($usersForDemand)) {
            return $usersForDemand;
        }
        return [];

    }

    public function permissions(): Profile
    {
      return Profile::findById($this->profile_id);
    }
    public function demands(): array
    {
      $demands = $this->belongsToMany(Demand::class, 'demand_user', 'user_id', 'demand_id')->get();

      foreach ($demands as $demand) {
        $demand_user = DemandUser::where(['demand_id' => $demand->id, 'user_id' => $this->id])[0];
        $demand->status_id = Status::findById($demand_user->status_id)->id;
      }

      return $demands;
    }

}
