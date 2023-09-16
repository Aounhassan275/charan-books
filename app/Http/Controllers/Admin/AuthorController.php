<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Author;
use Exception;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $authors = Author::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })->paginate(10);
            $query_param = ['search' => $request['search']];
        } else {
            $authors = Author::paginate(10);
        }
        return view('admin-views.author.index', compact('authors', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name' => 'required'
            ]);
            Author::create($request->all());
            Toastr::success('Author Added Successfully!');
            return redirect()->back();
        }catch (Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $author = Author::find($id);
        return view('admin-views.author.edit',compact('author'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $author = Author::find($id);
        $author->update($request->all());
        Toastr::success('Author Updated Successfully!');
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $author = Author::find($id);
            $author->delete();
            Toastr::success(translate('Author Deleted Successfully!'));
            return redirect()->back();
        }catch (Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }
}
