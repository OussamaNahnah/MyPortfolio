<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfNetController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth:api',[
            'except'=>['edit','create','show','index','getProductByCategory'],
        
        ]);
    }

    public function store(Request $request)
    {


        $validator=Validator::make($request->all(),[
            'name'=>'required|string|unique:products', 
            'link'=>'required|string',
            'icon' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
            'user_id'=>'required|exists:App\Models\User,id',

        ]);
        
       /*
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
          
        if(!$request->hasFile('image'))
        {
            return response()->json(
                [
                 'message'=>'No image !',
                ],400);
            }
        
            $destination_path='public/images/';
            $image=$request->file('image');
            $image_name=  rand().'.'.$image->getClientOriginalExtension();
            Storage::disk('uploadproduct')->put($image_name, file_get_contents($image));
            $img = Image::make($image);
            $img->resize(400, 400, function ($c) {
            $c->aspectRatio();
            $c->upsize();
            });
            $img->save('uploads/product/thumb/thumb_'.$image_name);

        






        $product =Product::create([
            'name'=>$request->input('name'),
            'path_org'=>'/uploads/product/org/'.$image_name,
            'path_thumb'=>'/uploads/product/thumb/thumb_'.$image_name,
            'category_id'=>$request->input('category_id'),
        ]);*/
        return response()->json(
            [
             'message'=>'Product successfully created',
             'product'=>$product,
            ],201);



    }


/*




  public function index()
    {
      $products=  Product::all();
        return response()->json(
            [
             'message'=>'Product successfully created',
             'product'=>$products,
            ],200);
    }



    public function store(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required|string|unique:products', 
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
            'category_id'=>'required|numeric|exists:App\Models\Category,id',
         
           // 'user_id'=>'required|exists:App\Models\User,id',

        ]);
        
       
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
          
        if(!$request->hasFile('image'))
        {
            return response()->json(
                [
                 'message'=>'No image !',
                ],400);
            }
        
            $destination_path='public/images/';
            $image=$request->file('image');
            $image_name=  rand().'.'.$image->getClientOriginalExtension();
            Storage::disk('uploadproduct')->put($image_name, file_get_contents($image));
            $img = Image::make($image);
            $img->resize(400, 400, function ($c) {
            $c->aspectRatio();
            $c->upsize();
            });
            $img->save('uploads/product/thumb/thumb_'.$image_name);

        






        $product =Product::create([
            'name'=>$request->input('name'),
            'path_org'=>'/uploads/product/org/'.$image_name,
            'path_thumb'=>'/uploads/product/thumb/thumb_'.$image_name,
            'category_id'=>$request->input('category_id'),
        ]);
        return response()->json(
            [
             'message'=>'Product successfully created',
             'product'=>$product,
            ],201);



    }

    public function show($id)
    {
        $data = [
            'id' => $id
        ];
    
        $validator = Validator::make($data, [
            'id'=>'required|numeric|exists:App\Models\Product,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $product = Product::find($id);
        $descriptions = Description::where('product_id', $id)->with('savedimages')->get();
        $box = Box::where('product_id', $id)->with('savedimages','lastpromotion')->get();
        return response()->json(
            [
             'message'=>'Get Produst '.$id.'successfully',
             'product'=>$product,
             'descriptions'=>$descriptions,
             'box'=>$box,
            ],201);
    }

   
    public function update(Request $request, $id)
    {
        $request->merge(['id' =>$id]);  
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|unique:products',
            'category_id'=>'required|numeric|exists:App\Models\Category,id', 
            'id'=>'required|numeric|exists:App\Models\Product,id',

        ]);
        
       
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $product =Product::find($id);
        $product->name=$request->input('name');
        $product->category_id=$request->input('category_id');
        $product->save();
        return response()->json(
            [
             'message'=>'Product successfully modified',
             'product'=>$product,
            ],200);
    }

   
    public function destroy($id)
    { 
       
        $data = [
            'id' => $id
        ];

        $validator = Validator::make($data, [
            'id'=>'required|numeric|exists:App\Models\Product,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        
        $product = Product::find($id);
        $product->delete();
        return response()->json(
            [
             'message'=>$id.' Deleted successfully',
            ],200);
    }

    public function getProductByCategory($id_category)
    { 
       
        $data = [
            'id' => $id_category
        ];
    
        $validator = Validator::make($data, [
            'id'=>'required|numeric|exists:App\Models\Category,id',
        ]);

         if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }
        $products = Product::where('category_id', $id_category)->get();
        return response()->json(
            [
             'message'=>'Get Produsts By Category '.$id_category.'successfully',
             'products'=>$products,
            // 'images'=>$product->savedimages
            ],200);
    }
    public function updateImg(Request $request, $id)
    {
        $request->merge(['id' =>$id]);
        $validator=Validator::make($request->all(),[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg',
            'id'=>'required|numeric|exists:App\Models\Product,id',

        ]);
        
        if($validator->fails()){
            return response()->json(
                $validator->errors()->toJson(),400);

        }

        if(!$request->hasFile('image'))
        {
            return response()->json(
                [
                 'message'=>'No image !',
                ],400);
            }
        
            $destination_path='public/images/';
            $image=$request->file('image');
            $image_name=  rand().'.'.$image->getClientOriginalExtension();
            Storage::disk('uploadcategory')->put($image_name, file_get_contents($image));
            $img = Image::make($image);
            $img->resize(400, 400, function ($c) {
            $c->aspectRatio();
            $c->upsize();
            });
            $img->save('uploads/category/thumb/thumb_'.$image_name);

            
        $product = Product::find($id);
        $product->path_org='/uploads/category/org/'.$image_name;
        $product->path_thumb='/uploads/category/thumb/thumb_'.$image_name;
        
        $product->save();
        return response()->json(
            [
             'message'=>'product successfully modified',
             'product'=>$product,
            ],200);
    }*/



}
