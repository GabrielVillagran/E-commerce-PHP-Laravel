<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Your Cart
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Review your products before checkout.
                </p>
            </div>

            <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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

            @if(empty($items))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Your cart is empty.
                    </h3>

                    <p class="text-gray-500 mt-2">
                        Add some products to start your order.
                    </p>

                    <a
                        href="{{ route('products.index') }}"
                        class="inline-block mt-4 bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700"
                    >
                        Browse Products
                    </a>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Cart Items
                        </h3>

                        <p class="text-sm text-gray-500">
                            Total items: {{ $count }}
                        </p>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach($items as $item)
                            <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $item['name'] }}
                                    </h4>

                                    <p class="text-sm text-gray-500">
                                        Unit price: ${{ number_format($item['price'] / 100, 2) }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Subtotal: ${{ number_format($item['subtotal'] / 100, 2) }}
                                    </p>
                                </div>

                                <div class="flex flex-col md:flex-row md:items-center gap-3">
                                    <form method="POST" action="{{ route('cart.update', $item['slug']) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $item['quantity'] }}"
                                            min="0"
                                            class="w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        >

                                        <button
                                            type="submit"
                                            class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700"
                                        >
                                            Update
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('cart.destroy', $item['slug']) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-6 bg-gray-50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">
                                Cart Total
                            </p>

                            <p class="text-2xl font-bold text-gray-900">
                                ${{ number_format($total / 100, 2) }}
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100"
                                >
                                    Clear Cart
                                </button>
                            </form>

                            <button
                                type="button"
                                disabled
                                class="px-4 py-2 rounded-lg bg-gray-400 text-white cursor-not-allowed"
                            >
                                Checkout Coming Next
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>