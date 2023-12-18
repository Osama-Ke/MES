<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Traits\APIResponseTrait;
use Throwable;

class CategoryController extends Controller
{
    use APIResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $categories = Category::all();
            if (!$categories)
                return $this->errorResponse('there is no data ', ' no categories yet  ');
            return $this->successResponse( ['categories' => CategoryResource::collection($categories)] ,
                ' categories returned successfully '
            );
        } catch (Throwable $th) {
            return $this->errorResponse($th->getMessage(),);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $validate = $request->validated();
            $category = Category::create([
                'name' => $request->name,
            ]);

            return $this->createdResponse(['category' => new CategoryResource($category)], 'category ');
        } catch (Throwable $th) {

            return $this->errorResponse($th->getMessage(),);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try {
            return $this->successResponse(['category' => new CategoryResource($category)], 'category returned successfully ');
        } catch (Throwable $th) {
            return $this->errorResponse($th->getMessage(),);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->update([
                'name' => $request->name ?? $category->name,
            ]);
            return $this->successResponse(['category' => new CategoryResource($category)], 'category updated successfully ');
        } catch (Throwable $th) {
            return $this->errorResponse($th->getMessage(),);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            if ($category->delete())
                return $this->okResponse(['category' => new CategoryResource($category)], 'Category deleted successfully');
             else
                return $this->errorResponse('Unknown error', 'The category has not been deleted');

        } catch (Throwable $th) {
            return $this->errorResponse($th->getMessage(),);
        }
    }
}
