<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('staff')){
        $documents = Document::where(
            'uploaded_by',
            auth()->id()
        )->whereIn('status', [

            'pending_manager',
            'pending_director'

        ])->latest()->get();
    }

    elseif(auth()->user()->hasRole('manager')){

        $documents = Document::where(
            'status',
            'pending_manager'
        )->latest()->get();
    }

    elseif(auth()->user()->hasRole('direktur')){

        $documents = Document::where(
            'status',
            'pending_director'
        )->get();
    }

    else{
        $documents = Document::latest()->get();
    }

    return view('documents.index', compact('documents'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
            'tujuan' => 'required|string|max:255',
        ], [
            'file.required' =>
                'Harap isi terlebih dahulu upload dokumen dan tujuan singkat',
            'tujuan.required' =>
                'Harap isi terlebih dahulu upload dokumen dan tujuan singkat',
        ]);

        $file = $request->file('file');

        $filename = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('documents', $filename, 'public');

        $status = 'pending_manager';

        if(auth()->user()->hasRole('manager')){
            $status = 'pending_director';
        }

        $document = Document::create([
            'nomor_dokumen' => 'DOC-' . time(),
            'judul' => $file->getClientOriginalName(),
            'tujuan' => $request->tujuan,
            'file' => $filename,
            'status' => $status,
            'uploaded_by' => auth()->id(),
        ]);
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'activity' => 'Mengupload dokumen'
        ]);

        if(auth()->user()->hasRole('manager')){
            $receivers = User::role('direktur')->get();

        } else {
            $receivers = User::role('manager')->get();
        }

        $message = 'Ada dokumen baru untuk manager.';

        if(auth()->user()->hasRole('manager')){

        $message = 'Ada dokumen baru untuk direktur.';
        }

        foreach($receivers as $receiver){

        Notification::create([
            'user_id' => $receiver->id,
            'message' => $message,
            'link' => route('documents.index'),
        ]);
        }   

        return redirect()->route('documents.index')
        ->with('success', 'Dokumen berhasil diupload');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
    if(auth()->user()->hasRole('manager')) {

        if($request->action == 'approve') {

            $document->update([
                'status' => 'approved_manager'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda disetujui manager.',
                'link' => route('documents.index'),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Manager menyetujui dokumen'
            ]);

        } elseif($request->action == 'reject') {

            $document->update([
                'status' => 'rejected_manager'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda ditolak manager.',
                'link' => route('documents.index'),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Manager menolak dokumen'
            ]);

        } elseif($request->action == 'disposisi') {

            $document->update([
                'status' => 'pending_director'
            ]);

            $directors = User::role('direktur')->get();

            foreach($directors as $director){

                Notification::create([
                    'user_id' => $director->id,
                    'message' => 'Ada dokumen disposisi baru.',
                    'link' => route('documents.index'),
                ]);
            }

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda didisposisikan ke direktur.',
                'link' => route('documents.index'),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Manager mendisposisikan dokumen ke direktur'
            ]);
        }

    } elseif(auth()->user()->hasRole('direktur')) {

        if($request->action == 'approve') {

            $document->update([
                'status' => 'approved_final'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda disetujui direktur.',
                'link' => route('documents.index'),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Direktur menyetujui dokumen'
            ]);

        } elseif($request->action == 'reject') {

            $document->update([
                'status' => 'rejected_final'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda ditolak direktur.',
                'link' => route('documents.index'),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Direktur menolak dokumen'
            ]);
        }
    }

    return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $document = Document::findOrFail($id);
        Storage::disk('public')->delete('documents/' . $document->file);
        DocumentLog::where('document_id', $id)->delete();
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Dokumen berhasil dihapus');
    }

// fungsi untuk dokumen approved dan rejected ------------
    public function approved()
{

    if(auth()->user()->hasRole('staff')){

        $documents = Document::where(
            'uploaded_by',
            auth()->id()
        )->whereIn('status', [

            'approved_manager',
            'approved_final'

        ])->latest()->get();

    } elseif(auth()->user()->hasRole('manager')){
        $documents = Document::whereIn(
            'status',
        [
            'approved_manager',
            'approved_final'
        ]
        )->latest()->get();

    } elseif(auth()->user()->hasRole('direktur')){

        $documents = Document::where(
            'status',
            'approved_final'
        )->latest()->get();

    }

    return view(
        'documents.approved',
        compact('documents')
    );
}

    public function rejected()
{

    if(auth()->user()->hasRole('staff')){

        $documents = Document::where(
            'uploaded_by',
            auth()->id()
        )->whereIn('status', [

            'rejected_manager',
            'rejected_final'

        ])->latest()->get();

    } elseif(auth()->user()->hasRole('manager')){

        $documents = Document::whereIn(
            'status',
            [
                'rejected_manager',
                'rejected_final'
            ]
        )->latest()->get();

    } elseif(auth()->user()->hasRole('direktur')){

        $documents = Document::where(
            'status',
            'rejected_final'
        )->latest()->get();

    }

    return view(
        'documents.rejected',
        compact('documents')
    );
}

}