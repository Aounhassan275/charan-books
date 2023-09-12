<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\SubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
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
            $categories = SubCategory::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })->paginate(10);
            $query_param = ['search' => $request['search']];
        } else {
            $categories = SubCategory::paginate(10);
        }
        return view('admin-views.sub-category.index', compact('categories', 'search'));
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
                'name' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
            ]);
            SubCategory::create($request->all());
            Toastr::success(translate('Sub Category Added Successfully!'));
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
     * @param  \App\Model\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subCategory = SubCategory::find($id);
        return view('admin-views.sub-category.edit',compact('subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $subCategory = SubCategory::find($id);
        $subCategory->update($request->all());
        Toastr::success('Sub Category Updated Successfully!');
        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $subCategory = SubCategory::find($id);
            $subCategory->delete();
            Toastr::success(translate('Sub Category Deleted Successfully!'));
            return redirect()->back();
        }catch (Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }
    public function getSubCategories(Request $request)
    {
        
        $categories = Category::where('parent_id',$request->id)->get();
        return response()->json([
            'categories' => $categories
        ]);
    }
}
