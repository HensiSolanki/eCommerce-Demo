<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(Product $model)
    {
        $this->middleware('permission:products_view', ['only' => ['index', 'getDatatable']]);
        $this->middleware('permission:products_add', ['only' => ['create', 'store']]);
        $this->middleware('permission:products_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:products_delete', ['only' => ['destroy']]);

        $this->moduleName = "Product";
        $this->moduleRoute = url(config('settings.ADMIN_PREFIX') . 'products');
        $this->moduleView = "products";
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
            $product = Product::select([
                'id', 'product_name', 'description', 'price', 'category_id',
                DB::raw("image AS image_thumb_url")
            ]);

            return Datatables::of($product)->addIndexColumn()
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
        $categories = DB::select('SELECT * FROM categories');
        return view("admin.$this->moduleView.create", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['product_name', 'description', 'category_id', 'price', 'image']);
        try {
            $products = new Product;
            if($request->hasfile('images'))
         {
            foreach($request->file('images') as $image)
            {
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/products/', $name);
                $data[] = $name;
            }
         }
            $products->product_name = $input['product_name'];
            $products->description = $input['description'];
            $products->category_id = $input['category_id'];
            $products->price = $input['price'];
            $products->image = json_encode($data);
            $products->save();
            if ($products->save()) {
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
        $data['result'] = Product::select(
            'products.id',
            'products.image',
            'products.product_name',
            'products.description',
            'products.price',
            DB::raw("products.image AS image_thumb_url"),
            'categories.category_name'
        )->join('categories', 'categories.id', '=', 'products.category_id')->find($id);
        $data['categories'] = DB::select('SELECT * FROM categories');
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
        $products = Product::find($id);
        try {
        if($request->hasfile('images'))
        {
           foreach($request->file('images') as $image)
           {
               $name=$image->getClientOriginalName();
               $image->move(public_path().'/products/', $name);
               $data[] = $name;
           }
        }
        $products->product_name = $request->product_name;
        $products->description = $request->description;
        $products->category_id = $request->category_id;
        $products->price = $request->price;
        $products->image = json_encode($data);

        if ($products) {
                $status = $products->update();
                if ($status) {
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
        $response = [];
        $data = $this->model->where('id', $id)->first();
        if ($data) {
            $data->delete();
            $response['message'] = $this->moduleName . " Deleted.";
            $response['status'] = true;
        } else {
            $response['message'] = $this->moduleName . " not Found!";
            $response['status'] = false;
        }
        return response()->json($response);

    }
}
