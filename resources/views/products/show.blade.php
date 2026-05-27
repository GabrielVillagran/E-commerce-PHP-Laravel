<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $product->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $product->category->name }}
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                Back to products
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="h-80 bg-gray-100 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400">
                            Product Image
                        </span>
                    </div>

                    <div>
                        <p class="text-sm text-indigo-600 font-medium">
                            {{ $product->category->name }}
                        </p>

                        <h1 class="text-3xl font-bold text-gray-900 mt-2">
                            {{ $product->name }}
                        </h1>

                        <p class="text-2xl font-bold text-gray-900 mt-4">
                            {{ $product->formattedPrice() }}
                        </p>

                        <p class="text-gray-600 mt-6">
                            {{ $product->description }}
                        </p>

                        <div class="mt-6">
                            @if($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                In stock: {{ $product->stock }}
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-800">
                                Out of stock
                            </span>
                            @endif
                        </div>

                        <div class="mt-8">
                            @if(session('success'))
                            <div class="mb-6 bg-green-100 text-green-800 px-4 py-3 rounded-lg">
                                {{ session('success') }}
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="mb-6 bg-red-100 text-red-800 px-4 py-3 rounded-lg">
                                {{ session('error') }}
                            </div>
                            @endif

                            @if($product->stock > 0)
                            <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-8">
                                @csrf

                                <div class="mb-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">
                                        Quantity
                                    </label>

                                    <input
                                        id="quantity"
                                        type="number"
                                        name="quantity"
                                        value="1"
                                        min="1"
                                        max="{{ $product->stock }}"
                                        class="mt-1 w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                    @error('quantity')
                                    <p class="text-sm text-red-600 mt-2">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="w-full md:w-auto bg-gray-900 text-white px-6 py-3 rounded-lg hover:bg-gray-700">
                                    Add to Cart
                                </button>
                            </form>
                            @else
                            <div class="mt-8">
                                <button
                                    type="button"
                                    disabled
                                    class="w-full md:w-auto bg-gray-400 text-white px-6 py-3 rounded-lg cursor-not-allowed">
                                    Out of Stock
                                </button>
                            </div>
                            @endif

                            <p class="text-sm text-gray-500 mt-3">
                                We will implement the cart in the next phase.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">
                    ← Continue shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>