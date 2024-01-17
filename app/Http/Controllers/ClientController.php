<?php

namespace App\Http\Controllers;

use App\DataTables\ClientDataTable;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\ClientDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ClientDataTable $dataTable)
    {
        return $dataTable->render('clients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $user = User::create(array_merge($data, [
            'role_id' => 3, 
            'name' => $request->firstname . ' ' . $request->lastname,
            'email_verified_at' => $request->has('is_verify') ? now() : null
        ]));

        ClientDetail::create(array_merge($data, ['user_id' => $user->id]));

        if(!$request->has('is_verify')) {
            event(new Registered($user));
        }

        return redirect()->route('clients.index')->withSuccess('Client Added Successfully');
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
        $client = ClientDetail::where('id', $id)->with("user")->firstOrFail();
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {   
        $data = $request->validated();
        
        $client = ClientDetail::where('id', $id)->firstOrFail();

        $client->update($data);
        $client->user->update($data);

        return back()->withSuccess('Client Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
