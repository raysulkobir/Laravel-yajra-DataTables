<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::query();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="View" class="me-1 btn btn-info btn-sm showProduct"><i class="fa-regular fa-eye"></i> View</a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('products');
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
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::updateOrCreate(
            [
                'id' => $request->product_id
            ],
            [
                'name' => $request->name,
                'detail' => $request->detail
            ]
        );

        return response()->json(['success' => 'Product saved successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success' => 'Product delete successfully.']);
    }
}
