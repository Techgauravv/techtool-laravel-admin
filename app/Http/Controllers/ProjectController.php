<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        // $users = User::with('roles')->paginate(10);
        return view('projects.index');
    }
    public function create()
    {
        // $roles = Role::all();
        $clients = Client::all();

        return view('projects.create')->with(['clients' => $clients]);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'project_name' => 'required',
                'details' => 'required',
            ]);
            $projects = new Project;
            $projects->project_name = $request->project_name;
            $projects->client_id = $request->client_id;
            $projects->detail = $request->detail;
            $projects->start_datetime = $request->start_datetime;
            $projects->end_datetime = $request->end_datetime;
            $projects->created_by = Auth::user()->id;
            $projects->status = $request->status;
            $projects->project_status = $request->project_status;
            $projects->save();

            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('projects.create')->with('error', $th->getMessage());
        }
    }
    public function update()
    {

    }
}
