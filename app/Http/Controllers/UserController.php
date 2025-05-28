<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
			$users = User::select(["id", "name", "nim", "email", "nomor_telepon", "peran", "created_at"]);
			return DataTables::of($users)
				->addIndexColumn()
				->addColumn("aksi", function ($user) {
					return '<span style="white-space: nowrap">
                                <a href="' . route("users.edit", $user->id) . '" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>Ubah
                                </a>
								<button type="submit" class="btn btn-danger btn-sm text-light button-delete" data-id="' . $user->id . '" data-name="' . $user->name . '">
									<i class="fa-solid fa-trash me-2"></i>Hapus
								</button>
                            </span>';
				})
                ->addColumn("created_at", function($user) {
                    return $user->created_at->format("d F Y H:i:s");
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at, '%d %M %Y %H:%i:%s') LIKE ?", ["%$keyword%"]);
                })
                ->orderColumn("created_at", function($query, $order) {
                    $query->orderBy("created_at", $order);
                })
				->rawColumns(["aksi", "created_at"])
                ->makeHidden(["id"])
				->make(true);
		}

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
    public function destroy(Request $request, User $user)
    {
        try {
            $userId = $user->id;
            $user->delete();

            if($userId == auth()->user()->id ?? -1) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                $request->session()->flash("success", "User berhasil dihapus.");
                return response()->json(["redirect" => route("login")]);
            }
            
            return response()->json(["success" => "User berhasil dihapus."]);
        } catch (Exception $exception) {
            return response()->json(["error" => $exception->getMessage()]);
        }
    }

    public function profile(int $userId = null)
    {
        if(empty($user)) {
            $userId = auth()->user()->id;
        }
    }
}
