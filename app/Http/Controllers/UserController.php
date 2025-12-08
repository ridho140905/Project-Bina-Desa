<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
       // Inisialisasi query
        $query = User::query();

        // Search functionality (nama dan email)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter functionality dengan dropdown huruf saja
        if ($request->filled('filter_user')) {
            if ($request->filter_user == 'a') {
                // User dengan nama A-M
                $query->whereRaw('LOWER(SUBSTRING(name, 1, 1)) BETWEEN "a" AND "m"');
            } elseif ($request->filter_user == 'n') {
                // User dengan nama N-Z
                $query->whereRaw('LOWER(SUBSTRING(name, 1, 1)) BETWEEN "n" AND "z"');
            }
        }

        // Default order by name
        $query->orderBy('name', 'asc');

        $data['dataUser'] = $query->paginate(10);

        // Untuk menjaga filter di pagination
        $data['dataUser']->appends($request->query());


        return view('pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $data['name'] = $request->name;
        $data['email']  = $request->email;
        $data['password']   = Hash::make($request->password);
        $data['role'] = $request->role;

        User::create($data);

        return redirect()->route('user.index')->with('success', 'Penambahan Data Berhasil!');
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
          $data['dataUser'] = User::findOrFail($id);
        return view('pages.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = $id;
        $user    = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
