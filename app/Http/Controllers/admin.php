<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class admin extends AdminAuthController
{
    /**
     * Alias de store vers register pour compatibilité
     */
    public function store(Request $request)
    {
        return $this->register($request);
    }
}
