@php
  $msSocial = $s->social_links ?? [];
  if (is_string($msSocial)) { $d = json_decode($msSocial, true); if (json_last_error() === JSON_ERROR_NONE) $msSocial = $d; }
  if (!is_array($msSocial)) { $msSocial = []; }
  $msIsAssoc = !empty($msSocial) && array_keys($msSocial) !== range(0, count($msSocial) - 1);
  if ($msIsAssoc) { $msSocial = collect($msSocial)->map(fn($u,$p)=>['platform'=>$p,'url'=>$u])->values()->all(); }
@endphp
<footer class="mt-16 bg-white border-t border-ms-teal/10">
  <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-6 gap-8">
    <div class="col-span-2">
      <span class="flex items-center gap-2">
        <svg class="w-8 h-8 text-ms-teal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="4"/><path d="M12 8v8M8 12h8"/></svg>
        <span class="block font-heading font-extrabold text-lg text-ms-ink">{{ $s->store_name ?? 'MediSphere' }}</span>
      </span>
      <p class="text-sm text-ms-inkSoft mt-3 max-w-xs">{{ $s->footer_text ?? 'Your trusted partner in health and wellness. Genuine medicines, right at your doorstep.' }}</p>
      <div class="flex items-center gap-2 mt-4">
        @forelse($msSocial as $item)
          @php $url = is_array($item) ? ($item['url'] ?? '#') : '#'; @endphp
          <a href="{{ $url }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-ms-tealLight hover:bg-ms-teal hover:text-white inline-flex items-center justify-center">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
          </a>
        @empty
          @foreach(['facebook','instagram','youtube','linkedin'] as $icon)
            <a href="#" class="w-8 h-8 rounded-full bg-ms-tealLight hover:bg-ms-teal hover:text-white inline-flex items-center justify-center">
              <x-store.icon name="{{ $icon }}" class="w-3.5 h-3.5" />
            </a>
          @endforeach
        @endforelse
      </div>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-ms-inkSoft mb-3">{{ 'Customer Care' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Help Center' }}</a></li>
        <li><a href="{{ url('/online_store/account/orders') }}" class="hover:text-ms-teal">{{ 'Track Order' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Returns & Refunds' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Shipping Policy' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-ms-inkSoft mb-3">{{ 'Pharmacy Services' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Upload Prescription' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Medicine Reminder' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Symptoms A-Z' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Lab Test Bookings' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-ms-inkSoft mb-3">{{ 'Health Resources' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Health Blog' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Medicine Guide' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Symptoms & Tips' }}</a></li>
      </ul>
    </div>
    <div>
      <h6 class="text-xs font-bold uppercase tracking-wider text-ms-inkSoft mb-3">{{ 'About MediSphere' }}</h6>
      <ul class="space-y-2 text-sm">
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'About Us' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Careers' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Privacy Policy' }}</a></li>
        <li><a href="{{ route('store.contact') }}" class="hover:text-ms-teal">{{ 'Terms & Conditions' }}</a></li>
      </ul>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 py-5 border-t border-ms-teal/10 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-ms-inkSoft">
    <span>&copy; {{ date('Y') }} {{ $s->store_name ?? 'MediSphere Pharmacy Pvt. Ltd.' }}. {{ __('messages.AllRightsReserved') ?? 'All Rights Reserved.' }}</span>
    <span>{{ 'Information provided is for awareness only and not a substitute for professional medical advice.' }}</span>
  </div>
</footer>
