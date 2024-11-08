<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\University;
use Auth;

class UniversityController extends Controller
{
    public function index()
    {    
        $universities = University::orderBy('id', 'desc')->get();
        return view('backend.university.index',compact('universities'));
    }


    public function create()
    {   
        return view('backend.university.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'university_name'=> 'required',
        ]);

        $data = $request->all();

        if(University::create($data)){
           return redirect(route('university.index'))->with('message','Successfully University Added');
        }else{
            return redirect()->back()->with('error','Error !! Added Failed');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $university = University::find($id);
        return view('backend.university.edit' , compact('university'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'university_name'=> 'required',
        ]);

        $data = $request->all();

        $university = University::find($id);

        if($university->update($data)){
            return redirect(route('university.index'))->with('message','Successfully University Updated');
        }else{
            return redirect()->back()->with('error','Error !! Update Failed');;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $university = University::find($id);

        if($university->delete()){
            return redirect(route('university.index'))->with('message','Successfully University Deleted');
        }else{
            return redirect()->back()->with('error','Error !! Delete Failed');
        }

    }
}
