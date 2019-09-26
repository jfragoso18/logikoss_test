<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Traits\UploadImage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => 'OK',
            'msg' => 'Working',
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'email' => 'email',
            'password' => 'string',
            'username' => 'string',

        ]);
        // 'avatar'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = $request->password;

        $user->save();

        // TODO: I KNOW: HASH PASSWORDS

        return response()->json([
            'data' => $user,
            'status' => 'ok',
            'msg' => 'Saved'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateProfile(Request $request, $id)
    {
        // Form validation
        $request->validate([
            'avatar'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);


        if ($request->has('avatar')){
            $image  = $request->file('avatar');
        }

        $user = User::findOrFail($id);

        // Check if a profile image has been uploaded
        if ($request->has('avatar')) {

            $image = $request->file('avatar');
            $name = '__'.time();
            $folder = '/images/';
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            $this->uploadOne($image, $folder, 'public', $name);
            $user->avatar = $filePath;
        }

        // Persist user record to database
        $user->save();

        // Return user back and show a flash message
        return response()->json([
            'status' => 'OK',
            'msg' => "Uploaded",
            'id' => $id,
            'image' => $image
            ]);
    }
}
