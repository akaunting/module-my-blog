<?php

namespace Modules\MyBlog\Imports;

use App\Abstracts\Import;
use Modules\MyBlog\Http\Requests\Post as Request;
use Modules\MyBlog\Models\Post as Model;

class Posts extends Import
{
    public function model(array $row)
    {
        return new Model($row);
    }

    public function map($row): array
    {
        $row = parent::map($row);

        $row['category_id'] = $this->getCategoryId($row, 'post');

        return $row;
    }

    public function rules(): array
    {
        return (new Request())->rules();
    }
}
