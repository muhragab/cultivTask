<?php

namespace App\Repositories\V1;

use App\Models\V1\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories\V1
 * @version July 29, 2020, 6:07 pm UTC
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'email',
        'password'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
