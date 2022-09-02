<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{

    public function index()
    {
        $sections = sections::all();


        return view('sections.sections', compact('sections'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $input = $request->all();


        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections',
            'description' => 'required',
        ], [

            'section_name.required' => 'يرجى ادخال اسم لاقسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجى ادخال الوصف',
        ]);

        sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح');
        return redirect('/sections');
    }


    public function show(sections $sections)
    {
        //
    }


    public function edit(sections $sections)
    {
        //
    }


    public function update(Request $request, sections $sections)
    {
        $id = $request->id;

        $this->validate($request, [

            //becouse of the section name is unique this $id check if the requested name is the same name in db $id then accepted
            'section_name' => 'required|unique:sections,section_name,' . $id,
            'description' => 'required',
        ], [

            'section_name.required' => 'يرجى ادخال اسم لاقسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجى ادخال الوصف',
        ]);

        $sections = sections::find($id);
        $sections->update([

            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);

        session()->flash('Edit', 'تم تحديث القسم بنجاح');
        return redirect('/sections');
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        sections::find($id)->delete();

        session()->flash('Delete', 'تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
