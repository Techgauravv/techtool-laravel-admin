<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use File;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store', 'updateStatus']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['delete']]);
    }

    /**
     * List User
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {
        $users = User::wherenot('id', Auth::user()->id)->with('roles')->paginate(10);
        return view('users.index', ['users' => $users]);
    }

    /**
     * Create User
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function create()
    {
        $this->user['formType'] = 'Add User';
        $this->user['user'] = [];
        $this->user['heading'] = 'Add Users';
        $this->user['sub_heading'] = 'Add New User';

        $roles = Role::orderby('name')->pluck('name', 'id');

        return view('users.add', ['roles' => $roles], $this->user);
    }

    /**
     * Store User
     * @param Request $request
     * @return View Users
     * @author Shani Singh
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([
            'name'    => 'required',
            'email'         => 'required|unique:users,email',
            // 'image' => 'mimes:jpeg,png|max:5014',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
            'status'       =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {
            // Store Data
            $user = new User;
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->password      = bcrypt($request->password);
            if ($request->image) {
                $file_name = $request->image;
                $image_name = $file_name->getClientOriginalName();
                $image = \Storage::disk('public')->put('user_image', $file_name);
                $image_url = 'storage/' . $image;
                $user->image = $image_url;
            } else {
                $user->image = 'assets/admin/img/user_placeholder.jpg';
            }
            $user->mobile_number = $request->mobile_number;
            $user->role_id = $request->role_id;
            $user->status = $request->status;
            $user->save();

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Created Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     * @author Shani Singh
     */
    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required|exists:users,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('users.index')->with('error', $validate->errors()->first());
        }
        try {
            DB::beginTransaction();

            // Update Status
            User::whereId($user_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    /**
     * Edit User
     * @param Integer $user
     * @return Collection $user
     * @author Shani Singh
     */
    public function edit(User $user)
    {
        // if (isset($id)) {

        $this->user['formType'] = 'edit';
        $this->user['user'] = User::find($user->id);
        $this->user['heading'] = 'Update Users';
        $this->user['sub_heading'] = 'Update User';
        // $user = $this->user;

        $roles = Role::orderby('name')->pluck('name', 'id');
        return view('users.add', $this->user)->with([
            'roles' => $roles,
            'user'  => $user
        ]);
        // }
        // } else {

        //     $this->user['formType'] = 'Add User';
        //     $this->user['user'] = [];
        //     $this->user['heading'] = 'Add Users';
        //     $this->user['sub_heading'] = 'Add New User';

        //     $roles = Role::orderby('name')->pluck('name', 'id');

        //     return view('users.add', ['roles' => $roles], $this->user);
        // }
    }
    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     * @author Shani Singh
     */
    public function update(Request $request, User $user)
    {
        // Validations
        $request->validate([
            'name'    => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'mimes:jpeg,png|max:5014',
            'mobile_number' => 'required|numeric|digits:10',
            'role_id'       =>  'required|exists:roles,id',
            'status'       =>  'required|numeric|in:0,1',
        ]);

        DB::beginTransaction();
        try {
            // Store Data
            $user = User::find($user->id);
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->password      = bcrypt($request->password);
            if ($request->image) {
                $file_name = $request->image;
                $image_name = $file_name->getClientOriginalName();
                $image = \Storage::disk('public')->put('user_image', $file_name);
                $image_url = 'storage/' . $image;
                $user->image = $image_url;
            }
            $user->mobile_number = $request->mobile_number;
            $user->role_id = $request->role_id;
            $user->status  = $request->status;
            $user->save();

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function storeOrUpdate(Request $request)
    {

        // Check if an object with the given ID exists
        if ($request->id) {

            // Validations
            $request->validate([
                'name'    => 'required',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'image' => 'mimes:jpeg,png|max:5014',
                'mobile_number' => 'required|numeric|digits:10',
                'role_id'       =>  'required|exists:roles,id',
                'status'       =>  'required|numeric|in:0,1',
            ]);
            // Store Data
            $user = User::find($request->id);
        } else {

            // Validations
            $request->validate([
                'name'    => 'required',
                'email' => 'required|email|unique:users,email,',
                'image' => 'mimes:jpeg,png|max:5014',
                'mobile_number' => 'required|numeric|digits:10',
                'role_id'       =>  'required|exists:roles,id',
                'status'       =>  'required|numeric|in:0,1',
            ]);
            // Store Data
            $user = new User;
        }
        DB::beginTransaction();
        try {
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->password      = bcrypt($request->password);
            if ($request->image) {
                $file_name = $request->image;
                $image_name = $file_name->getClientOriginalName();
                $image = \Storage::disk('public')->put('user_image', $file_name);
                $image_url = 'storage/' . $image;
                $user->image = $image_url;
            } else {
                $user->image = 'assets/admin/img/user_placeholder.jpg';
            }
            $user->mobile_number = $request->mobile_number;
            $user->role_id = $request->role_id;
            $user->status = $request->status;
            $user->save();

            // Delete Any Existing Role
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();

            // Assign Role To User
            $user->assignRole($user->role_id);

            // Commit And Redirected To Listing
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Created Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return Index Users
     * @author Shani Singh
     */
    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            User::whereId($user->id)->delete();
            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Deleted Successfully!.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    /*
     * Import Users
     * @param Null
     * @return View File
     */
    public function importUsers()
    {
        return view('users.import');
    }

    public function uploadUsers(Request $request)
    {
        Excel::import(new UsersImport, $request->file);

        return redirect()->route('users.index')->with('success', 'User Imported Successfully');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    

}
