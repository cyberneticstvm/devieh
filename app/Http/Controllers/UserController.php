<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\PaymentMode;
use App\Models\User;
use App\Models\UserBranch;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $branches;

    public function __construct()
    {
        $this->branches = Branch::all();

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        try {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                if (Str::contains($request->userAgent(), ['iPhone', 'Android', 'Linux', 'Macintosh']) && !Auth::user()->mobile_login) :
                    Auth::logout();
                    return redirect()->route('login')->with("error", "Mobile access has been restricted for this login");
                endif;
                return redirect()->intended('/admin/dashboard')
                    ->withSuccess('User logged in successfully');
            }
            return redirect()->back()->with("error", "Invalid Credentials")->withInput($request->all());
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
    }

    public function dashboard()
    {
        $branches = Branch::whereIn('id', UserBranch::where('user_id', Auth::id())->pluck('branch_id'))->pluck('name', 'id');
        $appointments = [];
        if (Session::get('branch')) :
            $appointments = Appointment::where('branch_id', Session::get('branch'))->whereNull('mrn_id')->withTrashed()->latest()->get();
        endif;
        $doctors = Doctor::all();
        return view('admin.dashboard', compact('branches', 'appointments', 'doctors', 'branches'));
    }

    public function updateBranch(Request $request)
    {
        Session::put('branch', $request->branch);
        if (Session::has('branch')) :
            return redirect()->route('dashboard')
                ->withSuccess('User branch updated successfully!');
        else :
            return redirect()->route('dashboard')
                ->withError('Please update branch!');
        endif;
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with("success", "User logged out successfully");
    }

    public function index()
    {
        $users = User::withTrashed()->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = $this->branches;
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.user.create', compact('branches', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roles' => 'required',
            'branches' => 'required',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        $data = [];
        foreach ($request->branches as $key => $br) :
            $data[] = [
                'user_id' => $user->id,
                'branch_id' => $br,
            ];
        endforeach;
        UserBranch::insert($data);
        return redirect()->route('user')
            ->with('success', 'User has been created successfully');
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
        $user = User::findOrFail(decrypt($id));
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $branches = $this->branches;
        return view('admin.user.edit', compact('user', 'roles', 'userRole', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
            'branches' => 'required',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::findOrFail($id);
        $user->update($input);
        $data = [];
        foreach ($request->branches as $key => $br) :
            $data[] = [
                'user_id' => $user->id,
                'branch_id' => $br,
            ];
        endforeach;
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        UserBranch::where('user_id', $id)->delete();
        UserBranch::insert($data);
        $user->assignRole($request->input('roles'));

        return redirect()->route('user')
            ->with('success', 'User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail(decrypt($id))->delete();
        return redirect()->route('user')
            ->with('success', 'User deleted successfully');
    }
}
