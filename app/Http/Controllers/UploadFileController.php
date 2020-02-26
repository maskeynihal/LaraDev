<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    //blade file
    public function index()
    {
        return view('upload-file');
    }

    public function store(Request $request)
    {
        $request->validate([

            'file' => 'required|mimes:pdf,xlx,csv|max:2048',

        ]);



        $fileName = time() . '.' . $request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);

        return back()

            ->with('success', 'You have successfully upload file.')

            ->with('file', $fileName);
        dd($request->toArray());
    }
}
