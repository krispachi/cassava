<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("users.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string",
            "nim" => "required|string|unique:users",
            "nomor_telepon" => "required|string",
            "peran" => "required|string|in:Admin,Mahasiswa,UKM",
            "email" => "required|email|unique:users",
            "password" => "required|string|confirmed|min:4"
        ]);
        $validatedData["created_at"] = date("Y-m-d H:i:s");
        $validatedData["updated_at"] = date("Y-m-d H:i:s");

        try {
            User::create($validatedData);
            return redirect()->route("users.index")->with("success", "User " . $validatedData["name"] . " berhasil ditambah.");
        } catch (Exception $exception) {
            return redirect()->route("users.create")->withInput()->with("error", $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("users.show");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("users.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function profile()
    {
        //
    }
}
