<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemRequest;
use App\Http\Requests\UpdateQuantityRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function cartPage(): View
    {
        try {
            $userId = auth()->id();
            $cart = $this->cartService->getCart($userId);
            return view('cart.index', compact('cart'));
        } catch (\Exception $error) {
            $cart = null;
            return view('cart.index', compact('cart'));
        }
    }

    public function getCart(): JsonResponse
    {
        try {
            $userId = auth()->id();
            $cart = $this->cartService->getCart($userId);

            return response()->json([
                'status' => true,
                'message' => 'Cart Retrieved Successfully!',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Cart Retrieve Failed',
                'data' => null
            ], 500);
        }
    }

    public function addItem(AddItemRequest $request): JsonResponse
    {
        try {
            $userId = auth()->id();
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

    public function updateQuantity(UpdateQuantityRequest $request, int $cartItemId): JsonResponse
    {
        try {
            $userId = auth()->id();
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

    public function removeItem(int $cartItemId): JsonResponse
    {
        try {
            $userId = auth()->id();
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

    public function clearCart(): JsonResponse
    {
        try {
            $cart = $this->cartService->clearCart(auth()->id());

            if (!$cart) {
                return response()->json([
                    'status' => false,
                    'message' => 'Cart Not Found',
                    'data' => null
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Cart Cleared!',
                'data' => $cart
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Failed To Clear Cart',
                'data' => null
            ], 500);
        }
    }
}
