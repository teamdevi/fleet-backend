<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return response()->json(['success' => true, 'data' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {

            $success = User::create($request->getAttributes());

            list($status,$data) = $success ? [ true , $success ] : [ false , ''] ;

            return ['success' => $status, 'data' => $data];

        }  catch (Exception $e) {

            return response()->json($e->errorInfo[2] ?? 'unknown error');

        }



    }


    public function admins()
    {
        $data = User::where('master', 1)->where('id', '!=', 1)->get();
        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::find($id);
        return $user ? ['success' => true, 'data' => $user] : ['success' => false, 'data' => ''];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request, $id)
    {
        $arr=$request->getAttributes();
         $updated = User::where('id', $id)->update($arr);
         list($status, $data) = $updated ? [true, User::find($id)] : [false, ''];
        return ['success' => $status, 'data' => $data];

    }

    public function change_password(Request $request,$id)
    {
    $validator = Validator::make($request->all(), [
    'password' => 'required',
    'confirm_password' => 'required|same:password',
    ]);
    if ($validator->fails()) {
        return response()->json([ 'success' => false, 'errors' => $validator->errors() ]);
    }
    $response = false;
    $update = User::where('id', $id)->update(['password' => Hash::make($request->password)]);

    $response = ($update) ?  [true ,'Password has been changed']: [false, 'Password cannot changed'];
    return response()->json(['success' => $response] );
    }


    public function destroy($id)
    {
        return User::find($id)->delete()
        ? [ 'response_status' => true, 'message' => ' User has been deleted' ]
        : [ 'response_status' => false, 'message' => 'User cannot delete' ];
    }
}

