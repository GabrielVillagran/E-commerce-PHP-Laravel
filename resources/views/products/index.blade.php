<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mini Shop
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Browse our products and start building your cart.
                </p>
            </div>

            @auth
                <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                    My Profile
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                    Login
                </a>
            @endauth
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="mb-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Categories
                </h3>

                <div class="flex flex-wrap gap-2">
                    <a
                        href="{{ route('products.index') }}"
                        class="px-4 py-2 rounded-full text-sm border {{ empty($selectedCategory) ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}"
                    >
                        All
                    </a>

                    @foreach($categories as $category)
                        <a
                            href="{{ route('products.index', ['category' => $category->slug]) }}"
                            class="px-4 py-2 rounded-full text-sm border {{ $selectedCategory === $category->slug ? 'bg-gray-900 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}"
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if($products->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-gray-600">
                        No products found for this category.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col">
                            <div class="h-40 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                                <span class="text-gray-400 text-sm">
                                    Product Image
                                </span>
                            </div>

                            <p class="text-sm text-indigo-600 font-medium">
                                {{ $product->category->name }}
                            </p>

                            <h3 class="text-lg font-semibold text-gray-900 mt-1">
                                {{ $product->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-2">
                                {{ $product->description }}
                            </p>

                            <div class="mt-4">
                                <p class="text-xl font-bold text-gray-900">
                                    {{ $product->formattedPrice() }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Stock: {{ $product->stock }}
                                </p>
                            </div>

                            <div class="mt-auto pt-4 space-y-2">
                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="block text-center bg-white text-gray-900 px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100"
                                >
                                    View Details
                                </a>

                                @if($product->stock > 0)
                                    <form method="POST" action="{{ route('cart.store', $product) }}">
                                        @csrf

                                        <input type="hidden" name="quantity" value="1">

                                        <button
                                            type="submit"
                                            class="w-full bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700"
                                        >
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button
                                        type="button"
                                        disabled
                                        class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed"
                                    >
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>