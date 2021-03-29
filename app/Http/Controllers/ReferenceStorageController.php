<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\ReferenceStorage;
use Illuminate\Http\Request;

class ReferenceStorageController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ReferenceStorage::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReferenceStorage  $referenceStorage
     * @return \Illuminate\Http\Response
     */
    public function show(ReferenceStorage $referenceStorage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReferenceStorage  $referenceStorage
     * @return \Illuminate\Http\Response
     */
    public function edit(ReferenceStorage $referenceStorage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReferenceStorage  $referenceStorage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReferenceStorage $referenceStorage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReferenceStorage  $referenceStorage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReferenceStorage $referenceStorage)
    {
        //
    }
}
