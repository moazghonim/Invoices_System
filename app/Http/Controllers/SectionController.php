<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = section::all();
        return view('sections.sections', compact('sections'));
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
        $Validator = $request->validate([
            'section_name' => ['required', 'unique:sections', 'max:255'],
            'description' => 'required',
        ]);

        section::create([
            'section_name' => $request->section_name,
            'decription' => $request->description,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect()->route('sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $Validator = $request->validate([
            'section_name' => ['required', 'unique:sections', 'max:255'],
            'description' => 'required',
        ]);

        $section = section::Find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,

        ]);

        session()->flash('Edit', 'تم تعديل القسم بنجاح');
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $section = section::Find($id);
        $section->delete($request->all());

        session()->flash('delete', 'تم حذف القسم بنجاح');
        return Redirect()->route('sections.index');
    }
}