@php
  $elFooterCategories = $categories ?? collect();
  $elFooterSubcats = optional($elFooterCategories->first())->subcategories ?? collect();
  $elFooterSubcatId = fn ($name) => optional($elFooterSubcats->firstWhere('name', $name))->id;
  $elSocial = $s->social_links ?? [];
  if (is_string($elSocial)) { $d = json_decode($elSocial, true); if (json_last_error() === JSON_ERROR_NONE) $elSocial = $d; }
  if (!is_array($elSocial)) { $elSocial = []; }
  $elIsAssoc = !empty($elSocial) && array_keys($elSocial) !== range(0, count($elSocial) - 1);
  if ($elIsAssoc) { $elSocial = collect($elSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-el-black text-white/70">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-5 gap-8">
    <div class="col-span-2">
      <span class="font-serif font-bold text-xl tracking-wide text-white uppercase">{{ $s->store_name ?? 'Élégance' }}</span>
      <span class="block eyebrow text-[9px] text-white/40 mt-0.5">{{ 'Timeless Fashion' }}</span>
      <p class="text-sm text-white/50 mt-3 max-w-xs">{{ $s->footer_text ?? 'Elegance is not about being noticed, it\'s about being remembered.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($elSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 hover:bg-el-gold hover:text-el-black inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','pinterest','youtube','tiktok'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-el-gold hover:text-el-black inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ __('messages.Shop') }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.shop', ['sort' => 'latest']) }}" class="hover:text-white">{{ 'New In' }}</a></li>
        @foreach(['Women', 'Men', 'Dresses', 'Shoes', 'Bags', 'Accessories'] as $elSubName)
          @if($elFooterSubcatId($elSubName))
            <li><a href="{{ route('store.shop', ['sub_category' => $elFooterSubcatId($elSubName)]) }}" class="hover:text-white">{{ $elSubName }}</a></li>
          @endif
        @endforeach
        <li><a href="{{ route('store.shop', ['sort' => 'price_asc']) }}" class="hover:text-white">{{ 'Sale' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'Customer Care' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-white">{{ 'Track Your Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Returns & Exchanges' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Shipping Info' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'FAQs' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Size Guide' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Contact Us' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'About Us' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Our Story' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Sustainability' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Press' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-white">{{ 'Affiliates' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-6 border-t border-white/10">
    <h6 class="text-xs font-bold eyebrow text-white/40 mb-3">{{ 'We Accept' }}</h6>
    <div class="flex flex-wrap items-center gap-2">
      @foreach(['VISA','Mastercard','AMEX','PayPal','Apple Pay','G Pay','Shop Pay'] as $method)
        <span class="h-8 px-3 inline-flex items-center rounded bg-white/10 text-[11px] font-bold text-white">{{ $method }}</span>
      @endforeach
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-white/40">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'Élégance' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span class="flex items-center gap-4">
      <a href="#" class="hover:text-white">{{ 'Privacy Policy' }}</a>
      <a href="#" class="hover:text-white">{{ 'Terms & Conditions' }}</a>
      <a href="#" class="hover:text-white">{{ 'Accessibility' }}</a>
    </span>
  </div>
</footer>
