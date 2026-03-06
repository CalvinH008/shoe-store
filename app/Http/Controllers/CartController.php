<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemRequest;
use App\Http\Requests\UpdateQuantityRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function addItem(AddItemRequest $request)
    {
        try {
            // $userId = auth()->id();
            $userId = 1;

            $cart = $this->cartService->addItem(
                $userId,
                $request->validated('product_id'),
                $request->validated('quantity')
            );

            return response()->json([
                'status' => true,
                'message' => 'Item Added To Cart!',
                'data' => $cart
            ], 200);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong',
                'data' => null,
            ], 500);
        }
    }

    public function updateQuantity(UpdateQuantityRequest $request, int $cartItemId)
    {
        try {
            // $userId = auth()->id();
            $userId = 1;
            $cart = $this->cartService->updateQuantity(
                $userId,
                $cartItemId,
                $request->validated('quantity')
            );

            return response()->json([
                'status' => true,
                'message' => 'Quantity Updated.',
                'data' => $cart
            ]);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $error) {

            return response()->json([
                'status' => false,
                'message' => 'Failed To Update Quantity',
                'data' => null
            ], 500);
        }
    }

    public function removeItem(Request $request, int $cartItemId)
    {
        try {
            // $userId = auth()->id();
            $userId = 1;
            $cartItemId = $cartItemId; // valuenya dari url

            $cart = $this->cartService->removeItem($userId, $cartItemId);
            return response()->json([
                'status' => true,
                'message' => 'Item Removed Successfully!',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Failed To Remove Item ',
                'data' => null
            ], 500);
        }
    }

    public function getCart()
    {
        try {
            // $userId = auth()->id();
            $userId = 1;
            $cart = $this->cartService->getCart($userId);

            return response()->json([
                'status' => true,
                'message' => 'Cart Retrieved Successfully!',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Cart Retrieved Failed',
                'data' => $error->getMessage()
            ], 500);
        }
    }
}
