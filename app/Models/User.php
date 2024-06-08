<?php

namespace App\Models;

use App\Services\ProfileAvatar;
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
 * @property Problem[] $problems
 * @property Problem[] $reinforced_problems
 */
class User extends Model
{
    protected static string $table = 'users';
    protected static array $columns = ['name', 'email', 'encrypted_password',
      'profile_id', 'created_at', 'updated_at', 'deleted_at'];

    protected ?string $password = null;
    protected ?string $password_confirmation = null;

    public function problems(): HasMany
    {
        return $this->hasMany(Problem::class, 'user_id');
    }

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

    public function avatar(): ProfileAvatar
    {
        return new ProfileAvatar($this);
    }

    public function reinforcedProblems(): BelongsToMany
    {
        return $this->belongsToMany(Problem::class, 'problem_user_reinforce', 'user_id', 'problem_id');
    }
}
