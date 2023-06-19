<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    public function index(){

        $category = Category::select('id', 'name')->get();
        return CategoryResource::collection($category);
    }

    public function show(Category $category){
        
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request){

        $data = $request->all();
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $name = 'categoreis/' . uniqid() . ' . ' . $file->extension();
            $file -> storePubliclyAs('public', $name);
            $data['photo'] = $name;
        }
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category){
        
        $category->update($request->all());
        return new CategoryResource($category);
    }

    public function destroy(Category $category){
     
    // Delete the associated products
    $category->products()->update(['category_id' => null]);
    // Delete the category
    $category->delete();

    return response(null, Response::HTTP_NO_CONTENT);
    }
}
