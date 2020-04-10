<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::latest()->get();
            return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('status', function($user) {
                            if($user->is_admin == true) {
                                $btn = '<span class="badge bg-danger">Admin</span>';
                            } else {
                                $btn = '<span class="badge bg-success">User</span>';
                            }    
                            return $btn;
                    })
                    ->addColumn('action', function($user) {
                        return "<a href=".route('users.show', $user->id)."><i class='nav-icon fas fa-edit'></i></a>";
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
        }
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

}
