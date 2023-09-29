<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $client;
    public function index()
    {
        $clients = Client::get();
        return view('clients.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->client['formType'] = 'Add Client';
        $this->client['client'] = [];
        $this->client['heading'] = 'Clients';
        $this->client['sub_heading'] = 'Add New Client';
        return view('clients.create', $this->client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clients = new Client;
        $clients->client_name = $request->client_name;
        $clients->status = $request->status;
        $clients->client_created_by = Auth::user()->id;
        $clients->save();
        return redirect()->route('clients.index')->with('client added successfully');
    }

    public function edit(Client $client)
    {
        $this->client['formType'] = 'edit';
        $this->client['client'] = client::find($client->id);
        $this->client['heading'] = 'Update Clients';
        $this->client['sub_heading'] = 'Update Client';
        return view('clients.create', $this->client)->with([
            'client'  => $client
        ]);
    }

    public function updateStatus($client_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'client_id'   => $client_id,
            'status'    => $status
        ], [
            'client_id'   =>  'required|exists:clients,id',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if ($validate->fails()) {
            return redirect()->route('clients.index')->with('error', $validate->errors()->first());
        }
        try {
            DB::beginTransaction();
            // Update Status
            Client::whereId($client_id)->update(['status' => $status]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('clients.index')->with('success', 'client Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function storeUpdate(Request $request)
    {
        // Validations
        $request->validate([
            'client_name'    => 'required',
            'status'       =>  'required|numeric|in:0,1',
        ]);
        $client = Client::find($request->input('id'));

        if ($client) {
            // Update the client
            $client->client_name = $request->input('client_name');
            $client->client_created_by = Auth::user()->id;
            $client->status = $request->input('status');
            $client->save();
        } else {
            // Create a new client
            $clients = new Client;
            $clients->client_name = $request->client_name;
            $clients->client_created_by = Auth::user()->id;
            $clients->status = $request->status;
            $clients->save();
        }
        return redirect()->route('clients.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */

    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */

    public function destroy(Client $client)
    {
        //
    }
}
