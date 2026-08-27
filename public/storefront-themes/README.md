# Storefront Theme Packs

This folder holds 10 self-contained storefront theme packs. Each one is a
plain folder of static assets — **no PHP, no Blade, no database access** —
so the exact same folder can be copied into any other platform (a different
SaaS, a static site, a headless storefront) that implements the same tiny
CSS-variable contract described below.

Each pack's palette, type pairing, and shape language is adapted from a
real per-industry storefront design mockup, then translated into this
project's CSS-variable contract:

| Theme slug | Industry | Design source |
|---|---|---|
| `jewelry-luxe` | Jewelry, Watches & Luxury Goods | Voguelane |
| `fashion-edit` | Fashion, Apparel & Footwear | Urbana |
| `beauty-glow` | Cosmetics, Skincare & Beauty | Veloura |
| `electronics-tech` | Electronics, Gadgets & Tech | Novatech |
| `grocery-fresh` | Grocery, Supermarket & Fresh Produce | Naturia |
| `fitness-power` | Fitness, Gym & Supplements | Trailpeak |
| `bookstore-classic` | Books, Stationery & Media | Paperloom |
| `restaurant-fresh` | Restaurant, Cafe & Food Delivery | Terra & Co. |
| `marketplace-mega` | Marketplace & Multi-Category Retail | ShopIQ |
| `pawluxe-pets` | Pet Supplies & Accessories | PawLuxe |

## Folder layout

```
storefront-themes/
  <slug>/
    theme.json    # metadata + default design tokens + which tokens tenants may customize
    theme.css     # the actual visual override stylesheet
    preview.svg   # gallery thumbnail
```

## `theme.json` schema

```jsonc
{
  "slug": "jewelry-luxe",
  "name": "Jewelry & Watches — Luxe",
  "industry": "Jewelry, Watches & Luxury Goods",
  "version": "1.0.0",
  "description": "...",
  "layout": "spacious-dark",
  "googleFontsUrl": "https://fonts.googleapis.com/css2?...",
  "tokens": {                 // default design tokens, see contract below
    "color-accent-500": "#C9A227",
    "font-heading": "'Cormorant Garamond', serif",
    ...
  },
  "customizable": [           // which of the tokens above an admin may override
    "color-accent-500", "font-heading", "font-body"
  ]
}
```

## The CSS-variable contract

Every theme only ever needs to define this same set of CSS custom
properties, scoped to a `[data-theme="<slug>"]` selector on the root
element. Any platform's storefront markup can consume them the exact same
way — via `rgb(var(--color-accent-500) / <alpha>)` for colors, and directly
for the rest:

| Variable | Format | Purpose |
|---|---|---|
| `--color-bg-base` / `-surface` / `-elevated` / `-muted` | `"R G B"` triplet | Page background layers |
| `--color-border-subtle` / `-strong` | `"R G B"` triplet | Borders |
| `--color-fg-primary` / `-secondary` / `-muted` | `"R G B"` triplet | Text colors |
| `--color-accent-400` / `-500` / `-600` | `"R G B"` triplet | Brand accent (buttons, links, highlights) |
| `--color-accent-glow` | `rgba(...)` | Focus ring / glow effects |
| `--store-font-heading` / `--store-font-body` | CSS font-family value | Typography |
| `--store-radius-sm` / `-md` / `-lg` | CSS length | Corner rounding |
| `--store-card-aspect` | CSS aspect-ratio value | Product image shape |
| `--store-grid-cols` | integer | Desktop catalogue grid density |

Any host page can also opt into structural theming by giving its DOM the
following semantic hook classes (already wired up in this project's
storefront: `resources/views/layouts/store.blade.php`,
`resources/views/store/index.blade.php`,
`resources/views/store/partials/shop-product-grid.blade.php`):

- `.store-hero`, `.store-hero-grid` — the homepage hero section
- `.store-product-grid` — the product catalogue grid
- `.product-card`, `.product-media`, `.product-body`, `.product-title` — a single product card

A theme pack only has to author `theme.css` rules against these classes; it
never has to know anything about Laravel, Vue, or the backend serving the
page.

## Reusing a pack on another platform / multi-tenant site

1. Copy the theme's folder as-is.
2. Make sure your storefront markup defines the same CSS variables (with
   sane defaults) and, ideally, the same hook classes above.
3. Set `data-theme="<slug>"` on your root/html element and link the pack's
   `theme.css` **after** your base stylesheet.
4. Optionally read `theme.json`'s `customizable` list to let your own admin
   UI expose only the tokens the theme author intended to be tenant-editable.

That's the entire integration surface — nothing here is specific to this
codebase.
