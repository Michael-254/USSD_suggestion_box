<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AfricasTalking\SDK\AfricasTalking;
use App\Imports\UsersImport;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ResponseController extends Controller
{

    public function messages()
    {
        $messages = Suggestion::query()
            ->where('addressed', 'open')
            ->when(request()->input('term'), function ($query, $term) {
                $query->Where('query', 'like', "%{$term}%");
                $query->orWhere('response', 'like', "%{$term}%");
                $query->orWhereHas('initiator', function ($query) use ($term) {
                    $query->where('name', 'like', "%{$term}%");
                    $query->orWhere('phone_number', 'like', "%{$term}%");
                    $query->orWhere('site', 'like', "%{$term}%");
                    $query->orWhere('dept', 'like', "%{$term}%");
                    $query->orWhere('supervisor_email', 'like', "%{$term}%");
                });
            })
            ->when(request()->input('site'), function ($query, $site) {
                $query->WhereHas('initiator', function ($query) use ($site) {
                    $query->Where('site', 'like', "%{$site}%");
                });
            })
            ->when(request()->input('dept'), function ($query, $dept) {
                $query->WhereHas('initiator', function ($query) use ($dept) {
                    $query->Where('dept', 'like', "%{$dept}%");
                });
                $query->orWhereHas('dept', function ($query) use ($dept) {
                    $query->Where('department', 'like', "%{$dept}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($sugg) => [
                'id' => $sugg->id,
                'user' => $sugg->initiator,
                'department' => $sugg->dept,
                'query' => Str::limit($sugg->query, 20),
                'type' => $sugg->type,
                'addressed' => $sugg->addressed,
                'response' => Str::limit($sugg->response, 20),
                'canSee' => [
                    $my_roles = \Arr::flatten(auth()->user()->roles->toArray()),
                    'HR' => in_array($sugg->access_role, $my_roles),
                    'CM' => in_array($sugg->access_role, $my_roles),
                ]
            ]);

        return Inertia::render('Admin/Message', [
            'Messages' => $messages,
            'filters' => request()->all('dept', 'site', 'term'),
        ]);
    }

    public function viewMsg($id)
    {
        $my_roles = \Arr::flatten(auth()->user()->roles->toArray());
        $message = Suggestion::findOrFail($id);
        if (!in_array($message->access_role, $my_roles)) {
            abort(403, 'Unauthorised access');
        }
        $message->load('initiator', 'dept');

        return Inertia::render('Admin/Respond', [
            'Message' => $message,
        ]);
    }

    public function closeMessage($id)
    {
        $message = Suggestion::findOrFail($id)->update(['addressed' => 'closed']);
        return back()->withFlash('message marked as addressed');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(['response' => 'required']);
        $message = Suggestion::findorFail($id);
        $message->update($data);
        $username = 'sandbox';
        $apiKey   = '0b1d14f33ed4b882b2b3d307e16af000d6ac61967bdd3debc61197629892809f';
        $AT       = new AfricasTalking($username, $apiKey);

        $sms      = $AT->sms();

        $result   = $sms->send([
            'to'      => $message->initiator->phone_number,
            'message' => 'Response given to your query is ' . $request->response,
        ]);

        Log::info($result);
        return back()->withFlash('Respose updated');
    }

    public function UploadUsers()
    {
        return Inertia::render('Admin/Upload');
    }

    public function storeUsers(Request $request)
    {
        \Excel::import(new UsersImport(), $request->file('users'));
        return redirect('users')->withFlash('Users Uploaaaaded');
    }
}
