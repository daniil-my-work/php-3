<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show()
    {
        $user = Auth::user();
        return $this->success(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        return response()->json([]);
    }
}
