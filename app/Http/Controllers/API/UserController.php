<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ApiFormatter;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'Failed');
        }

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
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|unique:users|email:dns',
                'address' => 'required',
                'password' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'address' => $request->address,
                'password' => $request->password,
            ]);

            $data = User::where('id', $user->id)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $e) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id', $id)->get();

        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        }else{
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // $request->validate([
            //     'name' => 'required',
            //     'username' => 'required|unique:users',
            //     'email' => 'required|unique:users|email:dns',
            //     'address' => 'required',
            //     'password' => 'required',
            // ]);

            $user = [
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'address' => $request->address,
                'password' => $request->password,
            ];

            $data = User::where('id', $id)->update($user);
            $result = User::where('id', $id)->get();

            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $result);
            }else{
                return ApiFormatter::createApi(400, 'Failed');
            }

        } catch (Exception $e) {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $data = $user->destroy($id);

        if ($data) {
            return ApiFormatter::createApi(200, 'Success');
        }else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }
}
