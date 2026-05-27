<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    private const CART_KEY = 'cart';

    public function items(): array
    {
        return session()->get(self::CART_KEY, []);
    }

    public function add(Product $product, int $quantity = 1): void
    {
        if (! $product->is_active) {
            throw new \Exception('This product is not available.');
        }

        if ($product->stock <= 0) {
            throw new \Exception('This product is out of stock.');
        }

        $cart = $this->items();

        $currentQuantity = $cart[$product->id]['quantity'] ?? 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $product->stock) {
            throw new \Exception('Not enough stock available.');
        }

        $cart[$product->id] = [
            'product_id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $newQuantity,
            'subtotal' => $product->price * $newQuantity,
        ];

        session()->put(self::CART_KEY, $cart);
    }

    public function update(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->remove($product);
            return;
        }

        if ($quantity > $product->stock) {
            throw new \Exception('Not enough stock available.');
        }

        $cart = $this->items();

        if (! isset($cart[$product->id])) {
            throw new \Exception('Product is not in the cart.');
        }

        $cart[$product->id]['quantity'] = $quantity;
        $cart[$product->id]['subtotal'] = $product->price * $quantity;

        session()->put(self::CART_KEY, $cart);
    }

    public function remove(Product $product): void
    {
        $cart = $this->items();

        unset($cart[$product->id]);

        session()->put(self::CART_KEY, $cart);
    }

    public function clear(): void
    {
        session()->forget(self::CART_KEY);
    }

    public function total(): int
    {
        return collect($this->items())->sum('subtotal');
    }

    public function count(): int
    {
        return collect($this->items())->sum('quantity');
    }

    public function isEmpty(): bool
    {
        return empty($this->items());
    }
}