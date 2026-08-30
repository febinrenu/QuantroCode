{{--
  Shared storefront language switcher — reused by all 20 themes.
  Drop into a theme's header with: @include('store.partials.language-switcher')
  Optional: pass ['variant' => 'mobile'] for a full-width list version (no
  dropdown chrome) suited to a mobile menu panel, e.g.:
    @include('store.partials.language-switcher', ['variant' => 'mobile'])

  Uses the SAME data source and flag/label set as the main system's language
  switcher (App\Models\Central\CentralLanguage + the central admin layout's
  flag SVGs), and the existing `lang.switch` route + Alpine `dropdown()`
  component already shipped in storefront.min.js — no external API needed.
--}}
@php
  $lsVariant = $variant ?? 'dropdown';
  $lsCurrent = app()->getLocale();
  $lsFlags = [
    'en' => '<svg viewBox="0 0 60 30"><clipPath id="s"><path d="M0,0 v30 h60 v-30 z"/></clipPath><clipPath id="t"><path d="M30,15 h30 v15 z v15 h-30 z h-30 v-15 z v-15 h30 z"/></clipPath><g clip-path="url(#s)"><path d="M0,0 v30 h60 v-30 z" fill="#012169"/><path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6"/><path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4"/><path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10"/><path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6"/></g></svg>',
    'fr' => '<svg viewBox="0 0 3 2"><rect width="3" height="2" fill="#ED2939"/><rect width="2" height="2" fill="#fff"/><rect width="1" height="2" fill="#002395"/></svg>',
    'ar' => '<svg viewBox="0 0 12 8"><rect width="12" height="8" fill="#006C35"/><rect y="0" width="12" height="2.67" fill="#006C35"/><rect y="2.67" width="12" height="2.67" fill="#fff"/><rect y="5.33" width="12" height="2.67" fill="#000"/></svg>',
    'es' => '<svg viewBox="0 0 3 2"><rect width="3" height="2" fill="#c60b1e"/><rect y=".5" width="3" height="1" fill="#ffc400"/></svg>',
    'hi' => '<svg viewBox="0 0 900 600"><rect width="900" height="200" fill="#FF9933"/><rect y="200" width="900" height="200" fill="#fff"/><rect y="400" width="900" height="200" fill="#138808"/><circle cx="450" cy="300" r="60" fill="#000080"/><circle cx="450" cy="300" r="54" fill="#fff"/><circle cx="450" cy="300" r="18" fill="#000080"/></svg>',
    'bn' => '<svg viewBox="0 0 5 3"><rect width="5" height="3" fill="#006a4e"/><circle cx="2.25" cy="1.5" r="0.9" fill="#f42a41"/></svg>',
    'tr' => '<svg viewBox="0 0 12 8"><rect width="12" height="8" fill="#E30A17"/><circle cx="4.4" cy="4" r="2" fill="#fff"/><circle cx="4.9" cy="4" r="1.6" fill="#E30A17"/><polygon points="5.8,4 6.6,3.2 5.9,3.8 6.8,3.8 6,3.2" fill="#fff" transform="rotate(18 6.2 4)"/></svg>',
    'de' => '<svg viewBox="0 0 5 3"><rect width="5" height="3" fill="#FFCE00"/><rect width="5" height="2" fill="#DD0000"/><rect width="5" height="1" fill="#000"/></svg>',
    'pt' => '<svg viewBox="0 0 6 4"><rect width="6" height="4" fill="#FF0000"/><rect width="2.4" height="4" fill="#006600"/><circle cx="2.4" cy="2" r="0.8" fill="#FFCC00"/></svg>',
  ];
  $lsLabels = [
    'en' => 'English', 'fr' => 'Français', 'ar' => 'العربية', 'es' => 'Español',
    'hi' => 'हिन्दी', 'bn' => 'বাংলা', 'tr' => 'Türkçe', 'de' => 'Deutsch', 'pt' => 'Português',
  ];

  // Central\CentralLanguage is the same admin-managed source of truth the
  // main system's own switcher reads from (active/inactive, default, sort
  // order) — falls back to the full shipped language pack list if that
  // table isn't reachable for any reason (e.g. central DB not migrated yet).
  try {
    $lsLanguages = \App\Models\Central\CentralLanguage::active();
  } catch (\Throwable $e) {
    $lsLanguages = collect(array_map(
      fn ($code, $i) => (object) ['locale' => $code, 'name' => $lsLabels[$code] ?? strtoupper($code), 'sort_order' => $i],
      array_keys($lsLabels), array_keys($lsLabels)
    ));
  }
@endphp

@if($lsVariant === 'mobile')
  {{-- currentColor-relative styling on purpose: this partial is shared across
       20 themes with both light and dark mobile menus, so it can't assume a
       light background/dark text pairing like the desktop dropdown (which
       renders in its own floating white panel) can. --}}
  <div class="grid grid-cols-2 gap-1.5 text-current">
    @foreach($lsLanguages as $lang)
      @php $code = $lang->locale; @endphp
      <a href="{{ route('lang.switch', $code) }}"
         class="flex items-center gap-2 px-2.5 py-2 rounded-lg border text-sm {{ $lsCurrent === $code ? 'border-current bg-current/10 font-semibold' : 'border-current/15 opacity-70 hover:opacity-100' }}">
        <span class="w-4 h-4 rounded-full overflow-hidden shrink-0 inline-flex">{!! $lsFlags[$code] ?? '' !!}</span>
        <span class="truncate">{{ $lsLabels[$code] ?? $lang->name }}</span>
      </a>
    @endforeach
  </div>
@else
  <div class="relative" x-data="dropdown()" @click.outside="close">
    <button type="button"
            class="h-10 px-2.5 inline-flex items-center gap-1.5 rounded-lg text-sm font-medium text-current opacity-70 hover:opacity-100 hover:bg-current/10"
            @click="toggle"
            aria-label="{{ __('messages.Language') ?? 'Language' }}">
      <span class="w-4 h-4 rounded-full overflow-hidden shrink-0 inline-flex">{!! $lsFlags[$lsCurrent] ?? '' !!}</span>
      <span class="hidden sm:inline">{{ strtoupper($lsCurrent) }}</span>
      <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/></svg>
    </button>
    <div x-show="open" x-cloak x-transition
         class="absolute end-0 mt-1 w-44 bg-white border border-slate-200 rounded-lg shadow-lg py-1 z-50 max-h-80 overflow-y-auto">
      @foreach($lsLanguages as $lang)
        @php $code = $lang->locale; @endphp
        <a href="{{ route('lang.switch', $code) }}"
           class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-slate-50 {{ $lsCurrent === $code ? 'text-slate-900 font-semibold' : 'text-slate-600' }}">
          <span class="w-4 h-4 rounded-full overflow-hidden shrink-0 inline-flex">{!! $lsFlags[$code] ?? '' !!}</span>
          <span class="truncate">{{ $lsLabels[$code] ?? $lang->name }}</span>
          @if($lsCurrent === $code)
            <svg class="w-3.5 h-3.5 ms-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6 9 17l-5-5"/></svg>
          @endif
        </a>
      @endforeach
    </div>
  </div>
@endif
