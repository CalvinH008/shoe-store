<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddItemRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\CartService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function getCart(): JsonResponse
    {
        try {
            $cart = $this->cartService->getCart(auth()->id());
            return response()->json([
                'status' => true,
                'message' => 'Cart Retrieved Successfully',
                'data' => $cart
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to retrieve cart.',
                'data'    => null,
            ], 500);
        }
    }

    public function addItem(AddItemRequest $request): JsonResponse
    {
        try {
            $cart = $this->cartService->addItem(
                auth()->id(),
                $request->validated('product_id'),
                $request->validated('quantity'),
            );

            return response()->json([
                'status' => true,
                'message' => 'Item Added To Cart',
                'data' => $cart
            ]);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong',
                'data' => null,
            ], 500);
        }
    }

    public function updateQuantity(UpdateProductRequest $request, int $cartItemId): JsonResponse
    {
        try {
            $cart = $this->cartService->updateQuantity(auth()->id(), $cartItemId, $request->validated('quantity'));
            return response()->json([
                'status' => true,
                'message' => 'Quantity Updated',
                'data' => $cart
            ]);
        } catch (\InvalidArgumentException $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 422);
        } catch (\Exception) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update quantity.',
                'data' => null
            ], 500);
        }
    }

    public function removeItem(int $cartItemId): JsonResponse
    {
        try {
            $cart = $this->cartService->removeItem(auth()->id(), $cartItemId);
            return response()->json([
                'status' => true,
                'message' => 'Item Removed.',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function clearCart(): JsonResponse
    {
        try {
            $cart = $this->cartService->clearCart(auth()->id());
            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart Not Found',
                    'data' => $cart
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Cart Cleared Successfully',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => $error->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
