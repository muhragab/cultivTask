<?php

namespace App\Repositories\V1;

use App\Models\V1\Post;
use App\Repositories\BaseRepository;

/**
 * Class PostRepository
 * @package App\Repositories\V1
 * @version July 29, 2020, 10:20 pm UTC
*/

class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'title',
        'post'
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
        return Post::class;
    }
}
