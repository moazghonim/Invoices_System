<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoice_attachments;
use App\Models\invoice_details;
use Illuminate\Support\Facades\Storage;
use File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoice::where('id', '=', $id)->first();
        $details = invoice_details::where('id_Invoice', '=', $id)->get();
        $attachments = invoice_attachments::where('invoice_id', '=', $id)->get();
        return view('invoices.details_invoice', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($invoice_number, $file_name)
    {
        $path = "Attachments";
        $pathToFile = public_path($path . '/' . $invoice_number . '/' . $file_name);
        return response()->download($pathToFile);
    }

    public function open_file($invoice_number, $file_name)
    {
        $path = "Attachments";
        $pathToFile = public_path($path . '/' . $invoice_number . '/' . $file_name);
        return response()->file($pathToFile);
    }
}
