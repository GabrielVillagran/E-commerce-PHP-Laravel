<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function index(): View
    {
        return view('cart.index', [
            'items' => $this->cartService->items(),
            'total' => $this->cartService->total(),
            'count' => $this->cartService->count(),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->cartService->add($product, $validated['quantity']);

            return redirect()
                ->route('cart.index')
                ->with('success', 'Product added to cart.');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        try {
            $this->cartService->update($product, $validated['quantity']);

            return back()->with('success', 'Cart updated.');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->cartService->remove($product);

        return back()->with('success', 'Product removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        $this->cartService->clear();

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart cleared.');
    }
}