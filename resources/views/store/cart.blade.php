@extends('layouts.store')

@section('content')
<div class="container py-8 max-w-3xl">
  <h1 class="section-title mb-6 flex items-center gap-2">
    <x-store.icon name="cart" class="w-6 h-6" />
    {{ __('messages.YourCart') }}
  </h1>

  <div x-data="miniCart()">
    <template x-if="!items.length">
      <div class="empty-state py-16 text-center bg-bg-elevated rounded-lg border border-line-subtle">
        <x-store.icon name="bag" class="w-12 h-12 opacity-40 mx-auto" />
        <p class="mt-4 text-fg-muted">{{ __('messages.YourCartEmpty') }}</p>
        <a href="{{ route('store.shop') }}" class="btn btn-primary mt-4 inline-flex">{{ __('messages.AllProducts') }}</a>
      </div>
    </template>

    <div class="bg-bg-elevated rounded-lg border border-line-subtle divide-y divide-line-subtle">
      <template x-for="it in items" :key="it.id">
        <div class="flex items-center gap-4 p-4">
          <img :src="it.image || '{{ global_asset(upload_path('products').'/no-image.png') }}'" class="w-16 h-16 rounded-md object-cover border border-line-subtle">
          <div class="flex-1 min-w-0">
            <div class="text-sm font-semibold truncate" x-text="it.name"></div>
            <div class="text-sm font-mono text-accent-500" x-text="hidePrices ? '' : money(it.price)"></div>
          </div>
          <div class="flex items-center border border-line-subtle rounded-md h-9">
            <button type="button" class="w-8 h-full" @click="dec(it)"><x-store.icon name="minus" class="w-3 h-3 mx-auto" /></button>
            <input type="number" class="w-10 text-center h-full bg-transparent" :value="it.qty" min="1" @change="setQty(it, $event.target.value)">
            <button type="button" class="w-8 h-full" @click="inc(it)"><x-store.icon name="plus" class="w-3 h-3 mx-auto" /></button>
          </div>
          <div class="w-20 text-right font-mono font-semibold" x-text="lineTotal(it)"></div>
          <button type="button" class="p-1 rounded hover:bg-bg-muted" @click="remove(it)" aria-label="{{ __('messages.Remove') }}">
            <x-store.icon name="trash" class="w-4 h-4 text-danger" />
          </button>
        </div>
      </template>
    </div>

    <div class="bg-bg-elevated rounded-lg border border-line-subtle p-5 mt-4" x-show="items.length">
      <div class="flex justify-between text-sm text-fg-secondary"><span>{{ __('messages.Subtotal') }}</span><strong class="font-mono text-fg-primary" x-text="money(subtotal)"></strong></div>
      <div class="flex justify-between mt-2"><span class="font-semibold">{{ __('messages.GrandTotal') }}</span><strong class="font-mono text-lg text-fg-primary" x-text="money(grand)"></strong></div>
      <div class="flex gap-2 mt-4">
        <button type="button" class="btn btn-secondary flex-1" @click="clear">{{ __('messages.Clear') }}</button>
        <button type="button" class="btn btn-primary flex-1" @click="checkout('{{ route('checkout') }}')">
          {{ __('messages.Checkout') }}
          <x-store.icon name="arrow-right" class="w-4 h-4" />
        </button>
      </div>
    </div>
  </div>

  <a href="{{ route('store.shop') }}" class="inline-flex items-center gap-1.5 mt-6 text-sm font-semibold text-accent-500">
    <x-store.icon name="arrow-left" class="w-4 h-4" />
    {{ __('messages.ContinueShopping') ?? __('messages.AllProducts') }}
  </a>
</div>
@endsection
