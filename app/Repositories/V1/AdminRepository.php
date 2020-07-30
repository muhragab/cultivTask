<?php

namespace App\Repositories\V1;

use App\Models\V1\Admin;
use App\Repositories\BaseRepository;

/**
 * Class AdminRepository
 * @package App\Repositories\V1
 * @version July 29, 2020, 3:42 pm UTC
*/

class AdminRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'username',
        'email',
        'avatar',
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
        return Admin::class;
    }
}
