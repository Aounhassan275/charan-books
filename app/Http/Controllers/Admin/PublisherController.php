<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Publisher;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class PublisherController extends Controller
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
            $publishers = Publisher::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })->paginate(10);
            $query_param = ['search' => $request['search']];
        } else {
            $publishers = Publisher::paginate(10);
        }
        return view('admin-views.publisher.index', compact('publishers', 'search'));
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
            Publisher::create($request->all());
            Toastr::success('Publisher Added Successfully!');
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
     * @param  \App\Model\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publisher = Publisher::find($id);
        return view('admin-views.publisher.edit',compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $publisher = Publisher::find($id);
        $publisher->update($request->all());
        Toastr::success('Publisher Updated Successfully!');
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $publisher = Publisher::find($id);
            $publisher->delete();
            Toastr::success('Publisher Deleted Successfully!');
            return redirect()->back();
        }catch (Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }
}
