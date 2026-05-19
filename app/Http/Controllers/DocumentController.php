<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use App\Models\DocumentLog;

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
        )->latest()->get();
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
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:2048',
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

        $document = Document::create([
            'nomor_dokumen' => 'DOC-' . time(),
            'judul' => $file->getClientOriginalName(),
            'tujuan' => $request->tujuan,
            'file' => $filename,
            'status' => 'pending_manager',
            'uploaded_by' => auth()->id(),
        ]);
        DocumentLog::create([
            'document_id' => $document->id,
            'user_id' => auth()->id(),
            'activity' => 'Mengupload dokumen'
        ]);

        $managers = User::role('manager')->get();

        foreach($managers as $manager){

        Notification::create([
            'user_id' => $manager->id,
            'message' => 'Ada dokumen baru untuk manager.',
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
                'status' => 'approved_final'
            ]);
            DocumentLog::create([           //log approve manager
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Manager menyetujui dokumen'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda disetujui manager.',
            ]);

        } elseif($request->action == 'reject') {

            $document->update([
                'status' => 'rejected_final'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda ditolak manager.',
            ]);
            DocumentLog::create([           //log tolak manager 
                'document_id' => $document->id,
                'user_id' => auth()->id(),
                'activity' => 'Manager menolak dokumen'
            ]);

        } elseif($request->action == 'disposisi') {

            $document->update([
                'status' => 'pending_director'
            ]);

            // notif buat direktur
            $directors = User::role('direktur')->get();

            foreach($directors as $director){

                Notification::create([
                    'user_id' => $director->id,
                    'message' => 'Ada dokumen disposisi baru.',
                ]);
                DocumentLog::create([           //log disposisi ke direktur
                    'document_id' => $document->id,
                    'user_id' => auth()->id(),
                    'activity' => 'Mendisposisikan dokumen ke direktur'
                ]);

            }

            // notif staff
            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda didisposisikan ke direktur.',
            ]);
        }

    }

    // role direktur
    elseif(auth()->user()->hasRole('direktur')) {

        if($request->action == 'approve') {

            $document->update([
                'status' => 'approved_final'
            ]);

            Notification::create([
                'user_id' => $document->uploaded_by,
                'message' => 'Dokumen Anda disetujui direktur.',
            ]);
            DocumentLog::create([        //log approve direktur
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
            ]);
            DocumentLog::create([        //log tolak direktur
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
        //
    }

    //fungsi untuk setiap aksi --------------------
    public function approve($id)
    {
    $document = Document::findOrFail($id);
    $document->status = 'approved_manager';
    $document->save();
    notification::create([
        'user_id' => $document->uploaded_by,
        'message' => 'Dokumen Anda disetujui.',
    ]);
    return redirect()
        ->back()
        ->with(
            'success',
            'Dokumen berhasil diapprove'
        );
    }

    public function reject($id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'rejected_manager';
        $document->save();
        notification::create([
            'user_id' => $document->uploaded_by,
            'message' => 'Dokumen Anda ditolak.',
        ]);
        return redirect()
            ->back()
            ->with(
                'success',
                'Dokumen berhasil direject'
            );
    }

    public function disposisi($id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'pending_director';
        $document->save();
        notification::create([
            'user_id' => $document->uploaded_by,
            'message' => 'Dokumen Anda didisposisikan ke direktur.',
        ]);
        $direkturs = User::role('direktur')->get();

        foreach($direkturs as $direktur){

            Notification::create([
                'user_id' => $direktur->id,
                'message' => 'Ada dokumen disposisi baru.',
            ]);
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Dokumen berhasil didisposisikan ke direktur'
            );
    }

    public function finalApprove($id)
    {
        $document = Document::findOrFail($id);
        $document->status = 'approved_final';
        $document->save();
        notification::create([
            'user_id' => $document->uploaded_by,
            'message' => 'Dokumen Anda disetujui direktur.',
        ]);
        return redirect()
            ->back()
            ->with(
                'success',
                'Dokumen berhasil disetujui direktur'
            );
    }
}