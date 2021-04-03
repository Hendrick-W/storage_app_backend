<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\ReferenceStorage;
use App\Http\Resources\ReferencesCollection;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferenceStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(["message" => 'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(["message" => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(["message" => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(["message" => 'token_absent'], $e->getStatusCode());

        }
        if($user->role_id > 1){
            return response()->json(["status" => true,"data"=> ReferencesCollection::collection(ReferenceStorage::all())]);
        }
        return response()->json(["status" => true,"data"=> ReferenceStorage::all()]);
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
        // Check token and the user that associated with it
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(["message" => 'user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(["message" => 'token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(["message" => 'token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(["message" => 'token_absent'], $e->getStatusCode());

        }

        // Check the user role_id (if the user is other than admin or dept head)
        if($user->role_id > 1){
            return response()->json(["message" => 'Forbidden'], 403);
        }

        //Validator for the data
        $validator = Validator::make($request->all(), [
            "nama_barang" => "required|string",
            "kode_barang" => "required|string",
            "kategori" => "required|string"
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        //Eloquent model
        try {
            $ref_storage = new ReferenceStorage();
            $ref_storage->nama_barang = $request->nama_barang;
            $ref_storage->kode_barang = $request->kode_barang;
            $ref_storage->kategori = $request->kategori;
            $ref_storage->created_by = $user->nama;
            $ref_storage->user_id = $user->id;
            $ref_storage->user_role = $user->role_id;
            $ref_storage->save();

            return response()->json([
                "status" => true,
                "message"=>'New reference item has been created',
                "user" => $ref_storage
            ]);
            
        } catch (JWTException $exception) {
            return response()->json([
                "status" => false,
                "message" => "Ops, New reference item cannot be created"
            ]);
        }
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
