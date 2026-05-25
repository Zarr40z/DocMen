<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;

class MemoController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('admin')){

            $memos = Memo::latest()->get();
        }

        elseif(auth()->user()->hasRole('staff')){

            $memos = Memo::where(
                'target_role',
                'staff'
            )->latest()->get();
        }

        elseif(auth()->user()->hasRole('manager')){

            $memos = Memo::where('target_role', 'manager')

                ->orWhere('sender_id', auth()->id())

                ->latest()
                ->get();
        }

        elseif(auth()->user()->hasRole('direktur')){

            $memos = Memo::where('target_role', 'direktur')

                ->orWhere('sender_id', auth()->id())

                ->latest()
                ->get();
        }

        return view('memos.index', compact('memos'));
    }

    public function create()
    {
        return view('memos.create');
    }

    public function store(Request $request)
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

        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
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

            Memo::create([

                'sender_id' => auth()->id(),
                'target_role' => $request->target_role,
                'send_to_all' => true,
                'title' => $file->getClientOriginalName(),
                'message' => $request->tujuan,
                'file' => $filename,
            ]);

            foreach($receivers as $receiver) {

                Notification::create([
                    'user_id' => $receiver->id,
                    'message' => 'Memo baru: ' . $request->title,
                    'link' => route('memos.index'),
                ]);
            }

            return redirect()
                ->route('memos.index');
            }

        public function destroy(string $id)
        {
            $memo = Memo::findOrFail($id);
            Storage::disk('public')->delete('memos/' . $memo->file);
            $memo->delete();
    
            return redirect()->route('memos.index')
                ->with('success', 'Memo berhasil dihapus');
        }
}