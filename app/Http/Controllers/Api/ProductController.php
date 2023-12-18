<?php



namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\APIResponseTrait;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProductController extends Controller
{
    use APIResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            // Retrieve products with associated category
            $products = Product::with('category')->get();

            // Check if there are no products
            if ($products->isEmpty()) {
                return $this->errorResponse('No data', 'No products available.');
            }

            // Return success response with product data
            return $this->successResponse(['products' => ProductResource::collection($products)], 'Products returned successfully');
        } catch (Throwable $th) {
            // Handle unexpected errors
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
//            return
            // Validate the incoming request data
            $validatedData = $request->validated();
            // Create a new product using the validated data
            $product = Product::create($validatedData);

            // Return success response with the created product
            return $this->createdResponse(['product' => new ProductResource($product)], 'Product created successfully');
        } catch (Throwable $th) {
            // Handle unexpected errors
            return $this->generalFailureResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        try {
            // Return success response with the requested product
            return $this->successResponse(['product' => new ProductResource($product)], 'Product returned successfully.');
        } catch (Throwable $th) {
            // Handle unexpected errors
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validated();

            // Define fields to update
            $fieldsToUpdate = [
                'name', 'price', 'description', 'note',  'amount', 'category_id'
            ];

            // Update each specified field based on the request or keep the existing value
            foreach ($fieldsToUpdate as $field) {
                $product->$field = $request->$field ?? $product->$field;
            }

            // Save the updated product
            $product->save();

            // Return success response with the updated product
            return $this->successResponse(['product' => new ProductResource($product)], 'Product updated successfully');
        } catch (Throwable $th) {
            // Handle unexpected errors
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            // Attempt to delete the product
            if ($product->delete())
                // Return success response with the deleted product
                return $this->okResponse(['product' => new ProductResource($product)], 'Product deleted successfully');
             else
                // Return error response if deletion fails
                return $this->errorResponse('Unknown error', 'The product has not been deleted');

        } catch (Throwable $th) {
            // Handle unexpected errors
            return $this->errorResponse($th->getMessage());
        }
    }
}
