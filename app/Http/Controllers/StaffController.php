<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $staffs = User::where('role', 'staffs');

    if ($request->has('data')) {
        $data = $request->data;
        $staffs->where(function ($query) use ($data) {
            $query->where('name', 'like', "%$data%")
                  ->orWhere('email', 'like', "%$data%")
                  ->orWhere('role', 'like', "%$data%");
        });
    }

    $staffs = $staffs->get();

    return view('staff.index', compact('staffs'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email|min:3',
            'role' => 'required'
        ]);

        $email = strstr($request['email'], '@', true);
        $password = mb_substr($email, 0, 3) . mb_substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($password),
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambahkan Data Pengguna !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staffs = User::find($id);

        return view('staff.edit', compact('staffs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|min:3',
            'role' => 'required'
        ]);

        if ($request->password) {
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        } else {
            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }

        return redirect()->route('staff.home')->with('success', 'Proses Berhasil Dijalankan !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();

        return redirect()->back()->with('deleted', 'Data Berhasil Dihapus !');
    }
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);
        if (Auth::attempt($user)) {
            return redirect()->route('home.page');//->with('success', 'login berhasil');
        }else {
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }
    }