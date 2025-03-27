<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(Request $request)
    {

        // return response()->json([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request)
    {
        return response()->json([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function similar(Request $request, string $id)
    {
        return response()->json([]);
    }
}
