<?php

namespace App\Controller;

use App\Model\TypesModel;

class TypesController
{
    public static function index()
    {
        $pageParam = getIntegerParam("page", 1);
        $perPageParam = getIntegerParam("perPage", 10);

        $typesModel = new TypesModel();
        return $typesModel->index($perPageParam, $pageParam);
    }
}
