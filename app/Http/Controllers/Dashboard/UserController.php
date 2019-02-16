<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function editProfile()
    {
        $user = Auth('user')->user();
        return view('dashboard.user.profile',[
          'user' => $user,
        ]);
    }

    public function index(){
        $users = User::all();
        return view('dashboard.user.index',[
          'users' => $users,
        ]);
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'surnames' => $request->surnames,
            'email' => $request->email,
            'actived' => true,
            'password' => bcrypt($request->password),
        ]);
        return response()->json($user);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->surnames = $request->surnames;
        $user->email = $request->email;
        $user->actived = $request->actived;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return response()->json($user);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();
        return response()->json($user);
    }

    public function updateProfile(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->surnames = $request->surnames;
        $user->email = $request->email;

        $user->save();
        return response()->json($user);
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!(Hash::check($request->get('current_password'), Auth('user')->user()->password))) {
            // The passwords matches
            return response()->json(['current_password' => 'Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.'],422);
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return response()->json(['new_password'=>'La nueva contraseña no puede ser igual a su contraseña actual. Por favor, elija una contraseña diferente.'],422);
        }

        //Change Password
        $user = Auth('user')->user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json(['success' => 'Contraseña cambiada con éxito!']);

    }
}
