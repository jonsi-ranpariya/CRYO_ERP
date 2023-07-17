<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface RequestServiceInterface
{
    /**
     * Handel Process Of Request.
     *
     * @param  Request $request
     */
    public function handle(Request $request);
}
