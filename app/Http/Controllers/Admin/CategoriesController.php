<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function __construct(Category $model)
    {
        $this->middleware('permission:categories_view', ['only' => ['index', 'getDatatable']]);
        $this->middleware('permission:categories_add', ['only' => ['create', 'store']]);
        $this->middleware('permission:categories_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categories_delete', ['only' => ['destroy']]);

        $this->moduleName = "Category";
        $this->moduleRoute = url(config('settings.ADMIN_PREFIX') . 'category');
        $this->moduleView = "categories";
        $this->model = $model;

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDatatable(Request $request)
    {
        if ($request->ajax()) {
            $category = Category::select([
                'id', 'image', 'category_name', 'category_slug',
                DB::raw("image AS image_thumb_url")
            ]);

            return Datatables::of($category)->addIndexColumn()
                ->make(true);
        }
    }
    public function index()
    {
        return view("admin.$this->moduleView.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.$this->moduleView.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => ['required', 'string', 'max:255'],
            'category_slug' => ['required', 'string', 'max:255'],
            'image'=>['required','mimes:png,jpeg,gif,jpg']
        ]);

        $input = $request->only(['category_name', 'category_slug','image']);
        try {
            $category = new Category();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename=$image->getClientOriginalName();
                $image->move(public_path().'/categories/', $filename);
                $category->image = $filename;
            }
            $category->category_name = $input['category_name'];
            $category->category_slug = $input['category_slug'];
            $category->save();
            if ($category->save()) {
                return redirect($this->moduleRoute)->with("success", $this->moduleName . " Created Successfully");
            }
            return redirect($this->moduleRoute)->with("error", "Sorry, Something went wrong please try again");
        } catch (\Exception $e) {
            return redirect($this->moduleRoute)->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['result'] = $this->model->where('id', $id)->first();
        return view("admin.$this->moduleView.edit", $data);
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
        $this->validate($request, [
            'category_name' => ['required', 'string', 'max:255'],
            'category_slug' => ['required', 'string', 'max:255', 'unique:categories,id,' . $id],
            'image'=>['required','mimes:png,jpeg,gif,jpg']
        ]);

        $input = $request->only(['category_name', 'category_slug','image']);
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->category_slug = $request->category_slug;
        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename=$image->getClientOriginalName();
                $image->move(public_path().'/categories/', $filename);
                $category->image = $filename;
            }
            if ($category) {
                $category->update();
                if ($category->update()) {
                    return redirect($this->moduleRoute)->with("success", $this->moduleName . " Updated Successfully");
                }
            }
            return redirect($this->moduleRoute)->with("error", "Sorry, Something went wrong please try again");
        } catch (\Exception $e) {
            return redirect($this->moduleRoute)->with('error', $e->getMessage());
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
        //
    }
}
