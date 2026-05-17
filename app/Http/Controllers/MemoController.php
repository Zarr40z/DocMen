<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\User;
use App\Models\Notification;

class MemoController extends Controller
{
    public function index()
    {
        $memos = Memo::latest()->get();

        return view(
            'memos.index',
            compact('memos')
        );
    }

    public function create()
    {
        $roles = [];

        if(auth()->user()->hasRole('manager')) {

            $roles = ['staff', 'admin'];

        } elseif(auth()->user()->hasRole('direktur')) {

            $roles = [
                'manager',
                'staff',
                'admin'
            ];
        }

        $users = User::all();

        return view(
            'memos.create',
            compact('roles', 'users')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:2048',
            'tujuan' => 'required|string|max:255',
            'target_role' => 'required|string|in:' . implode(',', $roles)
        ], [
            'file.required' =>
                'Harap isi terlebih dahulu file, tujuan dan role',
            'tujuan.required' =>
                'Harap isi terlebih dahulu file, tujuan dan role',
            'target_role.required' =>
                'Harap isi terlebih dahulu file, tujuan dan role',
        ]);

        $file = $request->file('file');

        $filename = time() . '_' .
            $file->getClientOriginalName();

        $file->storeAs(
            'memos',
            $filename,
            'public'
        );

        $receivers = User::role(
            $request->target_role
        )->get();

        foreach($receivers as $receiver){

            Memo::create([

                'sender_id' => auth()->id(),
                'receiver_id' => $receiver->id,
                'target_role' =>
                    $request->target_role,
                'send_to_all' => true,
                'title' =>
                    $file->getClientOriginalName(),
                'message' =>
                    $request->tujuan,
                'file' =>
                    $filename,
            ]);

            Notification::create([
                'user_id' => $receiver->id,
                'message' => 'Ada memo baru'
            ]);
        }

    return redirect()
        ->route('memos.index');
    }
}