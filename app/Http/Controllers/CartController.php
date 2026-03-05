<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function addItem(Request $request)
    {
        try {
            // $userId = auth()->id();
            $userId = 1;
            $productId = $request->product_id;
            $quantity = (int) $request->quantity ?? 1;

            $cart = $this->cartService->addItem($userId, $productId, $quantity);

            return response()->json([
                'status' => true,
                'message' => 'Item Added Successfully!',
                'data' => $cart
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong',
                'data' => $error->getMessage(),
            ], 500);
        }
    }

    public function updateQuantity(Request $request, int $cartItemId)
    {
        try {
            // $userId = auth()->id();
            $userId = 1;
            $cartItemId = $cartItemId; // valuenya dari url
            $quantity = (int) ($request->quantity ?? 1);

            $cart = $this->cartService->updateQuantity($userId, $cartItemId, $quantity);

            return response()->json([
                'status' => true,
                'message' => 'Quantity Updated Successfully!',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Quantity Update Failed',
                'data' => $error->getMessage()
            ]);
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
                'message' => 'Item Remove Failed',
                'data' => $error->getMessage()
            ]);
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
                'message' => 'Cart Data Retrieved Successfully!',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Cart Data Retrieved Failed',
                'data' => $error->getMessage()
            ]);
        }
    }
}
