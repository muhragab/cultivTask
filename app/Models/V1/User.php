<?php

namespace App\Models\V1;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models\V1
 * @version July 29, 2020, 6:07 pm UTC
 *
 * @property string $username
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

    public $table = 'users';


    protected $dates = ['deleted_at'];


    protected $hidden = ['deleted_at', 'password'];


    public $fillable = [
        'username',
        'email',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'username' => 'required|string',
        'email' => 'required|email|unique:users,email|unique:admins,email|',
        'password' => 'required|confirmed'
    ];

    /**
     * hash password
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * delete all posts when delete user
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($user) {
            $user->posts()->delete();
        });
    }

}
