<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function searchByStudent($query, $search)
    {
        return $query->when($search, function($q) use ($search) {
            $q->whereHas('student', function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('major', 'LIKE', '%' . $search . '%');
            });
        });
    }
}
