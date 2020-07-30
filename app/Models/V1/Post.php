<?php

namespace App\Models\V1;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 * @package App\Models\V1
 * @version July 29, 2020, 10:20 pm UTC
 *
 * @property integer $user_id
 * @property string $title
 * @property string $post
 */
class Post extends Model
{
    use SoftDeletes;

    public $table = 'posts';


    protected $dates = ['deleted_at'];


    protected $hidden = ['deleted_at'];


    public $fillable = [
        'user_id',
        'title',
        'post'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'title' => 'string',
        'post' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'title' => 'required|string',
        'post' => 'required|string'
    ];


}
