<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()
            ->when(request()->input('term'), function ($query, $term) {
                $query->where('name', 'like', "%{$term}%");
            })
            ->when(request()->input('site'), function ($query, $site) {
                $query->where('site', 'like', "%{$site}%");
            })
            ->when(request()->input('dept'), function ($query, $dept) {
                $query->where('dept', 'like', "%{$dept}%");
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'site' => $user->site,
                'dept' => $user->dept
            ]);

        return Inertia::render('Users/Index', [
            'Users' => $users,
            'filters' => request()->all('dept', 'site', 'term'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findorFail($id, ['name', 'email', 'id', 'phone_number', 'site', 'dept', 'supervisor_email']);
        return Inertia::render('Users/Edit', [
            'User' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required'],
            'phone_number' => ['required', 'unique:users,phone_number,' . $id],
            'email' => ['required', 'unique:users,email,' . $id],
            'site' => ['required'],
            'dept' => ['required'],
            'supervisor_email' => ['required', 'email'],
        ]);
        User::findorFail($id)->update($data);
        return redirect('users')->withFlash('User Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findorFail($id)->delete();
        return back()->withFlash('User deleted');
    }
}
