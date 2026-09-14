<template> 
  <div class="main-content">
    <breadcumb :page="$t('Settings')" :folder="$t('Store')" />

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <div v-else class="wrapper">
      <b-form @submit.prevent="save">
        <!-- ===== Store Basics ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Store_Basics') }}</div>
            <b-badge pill variant="light">#1</b-badge>
          </div>
          <div class="card-body">
            <div class="row">

              <!-- Enable / Disable Online Store URL -->
              <div class="col-md-4">
                <b-form-group label="Online Store URL">
                  <b-form-checkbox v-model="form.enabled" switch>
                    {{ form.enabled ? 'Enabled' : 'Disabled' }}
                  </b-form-checkbox>
                  <small class="text-muted d-block mt-1">
                    When disabled, the /online_store pages will be inaccessible.
                  </small>
                </b-form-group>
              </div>

              <div class="col-md-4">
                <b-form-group :label="$t('Store_Name')">
                  <b-form-input v-model="form.store_name"/>
                </b-form-group>
              </div>

             <b-col lg="4" md="4" sm="12">
              <b-form-group :label="$t('Currency')">
                <v-select
                  v-model="form.default_currency_id"
                  :reduce="label => label.value"
                  :options="currencies.map(currencies => ({
                    label: currencies.name + ' (' + currencies.symbol + ')',
                    value: currencies.id
                  }))"
                  :placeholder="$t('Choose_Currency')"
                  :clearable="false"
                />
                <small  class="text-warning d-block mt-1">
                  ⚠️ Changing currency will affect both system and online store
                </small>
              </b-form-group>
            </b-col>


              <!-- Default Warehouse -->
              <b-col lg="4" md="4" sm="12">
                <b-form-group :label="$t('DefaultWarehouse')">
                  <v-select
                    v-model="form.default_warehouse_id"
                    :options="warehouseOptions"
                    :reduce="opt => opt.value"
                    :placeholder="$t('Choose_Warehouse')"
                    :clearable="false"
                  />
                </b-form-group>
              </b-col>

              <div class="col-md-4">
                <b-form-group :label="$t('Primary_Color')">
                  <b-form-input type="color" v-model="form.primary_color"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Secondary_Color')">
                  <b-form-input type="color" v-model="form.secondary_color"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Font_Family')">
                  <b-form-input v-model="form.font_family"/>
                </b-form-group>
              </div>

              <!-- Registration Access Control -->
              <div class="col-md-12 mt-2">
                <h6 class="text-muted border-bottom pb-2 mb-3"><lucide-icon class="mr-1" name="lock" /> {{ $t('Registration_Access_Control') }}</h6>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Public_Registration')">
                  <b-form-checkbox v-model="form.registration_enabled" switch>
                    {{ form.registration_enabled ? $t('Enabled') : $t('Disabled') }}
                  </b-form-checkbox>
                  <small class="text-muted d-block mt-1">
                    {{ $t('Public_Registration_Help') }}
                  </small>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Require_Invite_Code')">
                  <b-form-checkbox v-model="form.require_invite_code" switch>
                    {{ form.require_invite_code ? $t('Yes') : $t('No') }}
                  </b-form-checkbox>
                  <small class="text-muted d-block mt-1">
                    {{ $t('Require_Invite_Code_Help') }}
                  </small>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Require_Admin_Approval')">
                  <b-form-checkbox v-model="form.require_admin_approval" switch>
                    {{ form.require_admin_approval ? $t('Yes') : $t('No') }}
                  </b-form-checkbox>
                  <small class="text-muted d-block mt-1">
                    {{ $t('Require_Admin_Approval_Help') }}
                  </small>
                </b-form-group>
              </div>
              <div class="col-md-12" v-if="pendingCustomersCount > 0">
                <div class="alert alert-warning d-flex align-items-center justify-content-between py-2 mb-3">
                  <div>
                    <lucide-icon class="mr-1" name="clock" />
                    <strong>{{ pendingCustomersCount }}</strong> {{ $t('Pending_Customers_Awaiting_Approval') }}
                  </div>
                  <router-link :to="{name: 'StorePendingCustomers'}" class="btn btn-sm btn-outline-warning">
                    {{ $t('Review') }}
                  </router-link>
                </div>
              </div>
              <div class="col-md-12" v-if="form.require_invite_code">
                <div class="d-flex align-items-center justify-content-between bg-light rounded p-2 mb-3">
                  <div class="small text-muted">
                    <lucide-icon class="mr-1" name="ticket" /> {{ $t('Manage_invite_codes_from_dedicated_page') }}
                  </div>
                  <router-link :to="{name: 'StoreInviteCodes'}" class="btn btn-sm btn-outline-primary">
                    {{ $t('Manage_Invite_Codes') }}
                  </router-link>
                </div>
              </div>

              <!-- Allow overselling -->
              <div class="col-md-12">
                <b-form-group :label="$t('Stock_behavior')">
                  <b-form-checkbox v-model="form.allow_overselling" switch>
                    {{ form.allow_overselling ? $t('Allow_overselling') : $t('Prevent_overselling') }}
                  </b-form-checkbox>
                  <small class="text-muted d-block mt-1">
                    {{ $t('Allow_overselling_help') }}
                  </small>
                </b-form-group>
                <div class="col-md-12">
                  <b-form-group :label="$t('Hide_out_of_stock')">
                    <b-form-checkbox v-model="form.hide_out_of_stock" switch>
                      {{ form.hide_out_of_stock ? $t('Yes') : $t('No') }}
                    </b-form-checkbox>
                    <small class="text-muted d-block mt-1">
                      {{ $t('Hide_out_of_stock_help') }}
                    </small>
                  </b-form-group>
                </div>
                <div class="col-md-12">
                  <b-form-group :label="$t('Hide_prices_for_guests')">
                    <b-form-checkbox v-model="form.hide_prices_for_guests" switch>
                      {{ form.hide_prices_for_guests ? $t('Yes') : $t('No') }}
                    </b-form-checkbox>
                    <small class="text-muted d-block mt-1">
                      {{ $t('Hide_prices_for_guests_help') }}
                    </small>
                  </b-form-group>
                </div>
                <div class="col-md-12">
                  <b-form-group :label="$t('Show_stock')">
                    <b-form-checkbox v-model="form.show_stock" switch>
                      {{ form.show_stock ? $t('Yes') : $t('No') }}
                    </b-form-checkbox>
                    <small class="text-muted d-block mt-1">
                      {{ $t('Show_stock_help') }}
                    </small>
                  </b-form-group>
                </div>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== Storefront Theme Gallery ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Storefront_Theme_Gallery') }}</div>
            <b-badge pill variant="light">
              <lucide-icon class="mr-1" name="palette" style="width:12px;height:12px" />{{ $t('Theme') }}
            </b-badge>
          </div>
          <div class="card-body">
            <small class="text-muted d-block mb-3">
              {{ $t('Storefront_Theme_Gallery_Help') }}
            </small>

            <!-- Category-Specific Themes Section -->
            <div class="mb-4" v-if="categorySpecificThemes.length">
              <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <div class="d-flex align-items-center">
                  <h6 class="text-dark font-weight-bold mb-0">
                    Category-Specific Themes
                  </h6>
                </div>
                <small class="text-muted">Tailored for specific retail verticals and industries</small>
              </div>

              <div class="theme-gallery">
                <div
                  v-for="t in categorySpecificThemes"
                  :key="t.slug"
                  class="theme-gallery-card"
                  :class="{ active: form.theme === t.slug }"
                  @click="selectTheme(t)"
                >
                  <div class="theme-gallery-thumb" :style="themeThumbStyle(t)">
                    <span v-if="form.theme === t.slug" class="theme-gallery-check">
                      <lucide-icon name="check" style="width:14px;height:14px" />
                    </span>
                    <div class="theme-gallery-swatches">
                      <span v-for="(c, i) in (t.paletteSwatches || [])" :key="i" class="theme-gallery-swatch" :style="{ background: c }"></span>
                    </div>
                  </div>
                  <div class="theme-gallery-meta">
                    <div class="theme-gallery-name">{{ t.name }}</div>
                    <div class="theme-gallery-industry text-muted text-truncate" :title="t.tagline || t.description || t.layout_persona">
                      {{ t.tagline || t.description || t.layout_persona }}
                    </div>
                    <div v-if="t.categoryLabel" class="theme-gallery-category">{{ t.categoryLabel }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- General Storefront Themes Section -->
            <div class="mb-3" v-if="generalThemes.length">
              <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <div class="d-flex align-items-center">
                  <h6 class="text-dark font-weight-bold mb-0">
                    General Storefront Themes
                  </h6>
                </div>
                <small class="text-muted">Multi-purpose layouts for general retail catalogs</small>
              </div>

              <div class="theme-gallery">
                <div
                  v-for="t in generalThemes"
                  :key="t.slug"
                  class="theme-gallery-card"
                  :class="{ active: form.theme === t.slug }"
                  @click="selectTheme(t)"
                >
                  <div class="theme-gallery-thumb" :style="themeThumbStyle(t)">
                    <span v-if="form.theme === t.slug" class="theme-gallery-check">
                      <lucide-icon name="check" style="width:14px;height:14px" />
                    </span>
                    <div class="theme-gallery-swatches">
                      <span v-for="(c, i) in (t.paletteSwatches || [])" :key="i" class="theme-gallery-swatch" :style="{ background: c }"></span>
                    </div>
                  </div>
                  <div class="theme-gallery-meta">
                    <div class="theme-gallery-name">{{ t.name }}</div>
                    <div class="theme-gallery-industry text-muted text-truncate" :title="t.tagline || t.description || t.layout_persona">
                      {{ t.tagline || t.description || t.layout_persona }}
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Per-theme token customizer -->
            <div v-if="selectedTheme && selectedTheme.customizable && selectedTheme.customizable.length" class="mt-4 p-3 bg-white rounded border theme-customizer-panel">
              <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-3">
                <h6 class="text-dark font-weight-bold mb-0">
                  <lucide-icon class="mr-1 text-primary" name="sliders" style="width:16px;height:16px" />
                  {{ $t('Customize') }} — {{ selectedTheme.name }}
                </h6>
                <button type="button" class="btn btn-outline-secondary btn-sm" @click="resetThemeTokens">
                  <lucide-icon name="rotate-ccw" class="mr-1" style="width:13px;height:13px" />
                  {{ $t('Reset_To_Theme_Defaults') || 'Reset To Theme Defaults' }}
                </button>
              </div>

              <!-- 1) Four Independently Configurable Accent Colors -->
              <div class="row mb-2">
                <div class="col-md-3 col-sm-6" v-for="colorKey in ['color-accent-500', 'color-accent-600', 'color-accent-700', 'color-accent-800']" :key="colorKey">
                  <b-form-group :label="tokenLabel(colorKey)">
                    <div class="d-flex align-items-center">
                      <b-form-input
                        type="color"
                        style="width: 44px; height: 36px; padding: 2px;"
                        :value="getTokenValue(colorKey)"
                        @input="v => setToken(colorKey, v)"
                      />
                      <b-form-input
                        type="text"
                        class="ml-2 font-monospace text-uppercase"
                        :value="getTokenValue(colorKey)"
                        @input="v => setToken(colorKey, v)"
                      />
                    </div>
                  </b-form-group>
                </div>
              </div>

              <!-- 2) Typography (Heading & Body Font Families) -->
              <div class="row mb-2">
                <div class="col-md-6">
                  <b-form-group :label="$t('Font_Heading') || 'Font: Heading'">
                    <b-form-input
                      type="text"
                      :placeholder="selectedTheme.tokens && selectedTheme.tokens['font-heading']"
                      :value="getTokenValue('font-heading')"
                      @input="v => setToken('font-heading', v)"
                    />
                  </b-form-group>
                </div>
                <div class="col-md-6">
                  <b-form-group :label="$t('Font_Body') || 'Font: Body'">
                    <b-form-input
                      type="text"
                      :placeholder="selectedTheme.tokens && selectedTheme.tokens['font-body']"
                      :value="getTokenValue('font-body')"
                      @input="v => setToken('font-body', v)"
                    />
                  </b-form-group>
                </div>
              </div>

              <!-- 3) Font Sizes (Heading & Body Sizes) -->
              <div class="row">
                <div class="col-md-6">
                  <b-form-group :label="'Heading font size: ' + getFontSizePx('font-size-heading', 32) + 'px'">
                    <div class="d-flex align-items-center">
                      <b-form-input
                        type="range"
                        min="20"
                        max="64"
                        step="1"
                        class="custom-range flex-grow-1"
                        :value="getFontSizePx('font-size-heading', 32)"
                        @input="v => setToken('font-size-heading', v + 'px')"
                      />
                      <b-form-input
                        type="number"
                        min="20"
                        max="64"
                        class="ml-2 text-center"
                        style="width: 80px;"
                        :value="getFontSizePx('font-size-heading', 32)"
                        @input="v => setToken('font-size-heading', (v || 32) + 'px')"
                      />
                    </div>
                  </b-form-group>
                </div>
                <div class="col-md-6">
                  <b-form-group :label="'Body font size: ' + getFontSizePx('font-size-body', 15) + 'px'">
                    <div class="d-flex align-items-center">
                      <b-form-input
                        type="range"
                        min="12"
                        max="24"
                        step="1"
                        class="custom-range flex-grow-1"
                        :value="getFontSizePx('font-size-body', 15)"
                        @input="v => setToken('font-size-body', v + 'px')"
                      />
                      <b-form-input
                        type="number"
                        min="12"
                        max="24"
                        class="ml-2 text-center"
                        style="width: 80px;"
                        :value="getFontSizePx('font-size-body', 15)"
                        @input="v => setToken('font-size-body', (v || 15) + 'px')"
                      />
                    </div>
                  </b-form-group>
                </div>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== Contact ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Contact') }}</div>
            <b-badge pill variant="light">#2</b-badge>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <b-form-group :label="$t('Contact_Email')">
                  <b-form-input v-model="form.contact_email"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Contact_Phone')">
                  <b-form-input v-model="form.contact_phone"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Contact_Address')">
                  <b-form-input v-model="form.contact_address"/>
                </b-form-group>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== Branding (Logo / Favicon) ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Branding') }}</div>
            <b-badge pill variant="light">#3</b-badge>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <b-form-group :label="$t('Logo')">
                  <b-form-file accept="image/*" @change="pick('logo',$event)"/>
                  <img v-if="settings.logo_path" :src="asset(settings.logo_path)" height="40" class="mt-2 rounded shadow-sm"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Favicon')">
                  <b-form-file accept="image/*" @change="pick('favicon',$event)"/>
                  <img v-if="settings.favicon_path" :src="asset(settings.favicon_path)" height="24" class="mt-2 rounded shadow-sm"/>
                </b-form-group>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== Hero Slides ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Hero_Header') }}</div>
            <div class="d-flex align-items-center" style="gap:.5rem;">
              <small class="text-muted">{{ $t('Hero_Slides_Help') }}</small>
              <b-badge pill variant="light">#4</b-badge>
            </div>
          </div>
          <div class="card-body">
            <div v-if="!form.hero_slides.length" class="empty-state my-2">
              <div class="emoji">🖼️</div>
              <div class="title">{{ $t('No_items') }}</div>
            </div>

            <transition-group name="fade" tag="div">
              <div v-for="(slide, idx) in form.hero_slides" :key="'hero-slide-'+idx" class="hero-slide-card mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <strong class="text-dark">{{ $t('Slide') }} {{ idx + 1 }}</strong>
                  <div class="d-flex align-items-center" style="gap:.4rem;">
                    <div class="btn-group">
                      <b-button size="sm" variant="light" @click="moveHeroSlide(idx,-1)" :disabled="idx===0">↑</b-button>
                      <b-button size="sm" variant="light" @click="moveHeroSlide(idx,1)" :disabled="idx===form.hero_slides.length-1">↓</b-button>
                    </div>
                    <b-button size="sm" variant="outline-danger" @click="removeHeroSlide(idx)">
                      <lucide-icon name="x" /> {{ $t('Remove') }}
                    </b-button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <b-form-group :label="$t('Hero_Title')">
                      <b-form-input v-model="slide.title"/>
                    </b-form-group>
                  </div>
                  <div class="col-md-6">
                    <b-form-group :label="$t('Hero_Subtitle')">
                      <b-form-input v-model="slide.subtitle"/>
                    </b-form-group>
                  </div>
                  <div class="col-md-4">
                    <b-form-group :label="$t('Hero_CTA_Text')">
                      <b-form-input v-model="slide.cta_text" placeholder="Start shopping"/>
                    </b-form-group>
                  </div>
                  <div class="col-md-4">
                    <b-form-group :label="$t('Hero_CTA_Link')">
                      <b-form-input v-model="slide.cta_link" placeholder="/shop"/>
                    </b-form-group>
                  </div>
                  <div class="col-md-4">
                    <b-form-group :label="$t('Hero_Image')">
                      <b-form-file accept="image/*" @change="pickHeroSlideImage(idx,$event)"/>
                      <div v-if="slide.image && !slide._clearImage" class="mt-2 d-flex align-items-center" style="gap:.5rem;">
                        <img :src="asset(slide.image)" height="48" class="rounded shadow-sm"/>
                        <b-button size="sm" variant="outline-danger" @click="clearHeroSlideImage(idx)">{{ $t('Remove') }}</b-button>
                      </div>
                    </b-form-group>
                  </div>
                </div>
              </div>
            </transition-group>

            <b-button size="sm" variant="outline-success" @click="addHeroSlide">
              <lucide-icon name="plus" /> {{ $t('Add_Slide') }}
            </b-button>
          </div>
        </b-card>

        <!-- ===== Offers & Promotions ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Offers_and_Promotions') }}</div>
            <b-badge pill variant="light">#5</b-badge>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 mb-2">
                <small class="text-muted d-block">
                  {{ $t('Offers_Help') }}
                </small>
              </div>

              <div class="col-md-4">
                <b-form-group :label="$t('Offer_Badge_Text')">
                  <b-form-input v-model="form.offer.badge_text" placeholder="Limited time"/>
                </b-form-group>
              </div>
              <div class="col-md-8">
                <b-form-group :label="$t('Offer_Headline')">
                  <b-form-input v-model="form.offer.title" placeholder="Today's Deals — Up to 50% Off"/>
                </b-form-group>
              </div>
              <div class="col-md-12">
                <b-form-group :label="$t('Offer_Subtext')">
                  <b-form-textarea rows="2" v-model="form.offer.subtitle"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Offer_Discount_Text')">
                  <b-form-input v-model="form.offer.discount_text" placeholder="50% OFF"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Offer_Button_Text')">
                  <b-form-input v-model="form.offer.button_text" placeholder="Shop the Deals"/>
                </b-form-group>
              </div>
              <div class="col-md-4">
                <b-form-group :label="$t('Offer_Link')">
                  <b-form-input v-model="form.offer.link" placeholder="/shop?sort=price_asc"/>
                </b-form-group>
              </div>

              <div class="col-md-6">
                <b-form-group :label="$t('Offer_Image')">
                  <b-form-file accept="image/*" @change="pick('offer_image',$event)"/>
                  <div v-if="offerImagePath && !form.offer_image_clear" class="mt-2 d-flex align-items-center" style="gap:.5rem;">
                    <img :src="asset(offerImagePath)" height="48" class="rounded shadow-sm"/>
                    <b-button size="sm" variant="outline-danger" @click="clearOfferImage">{{ $t('Remove') }}</b-button>
                  </div>
                </b-form-group>
              </div>
              <div class="col-md-3">
                <b-form-group :label="$t('Offer_Starts_At')">
                  <b-form-input type="datetime-local" v-model="form.offer.starts_at"/>
                </b-form-group>
              </div>
              <div class="col-md-3">
                <b-form-group :label="$t('Offer_Ends_At')">
                  <b-form-input type="datetime-local" v-model="form.offer.ends_at"/>
                </b-form-group>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== SEO ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">SEO</div>
            <b-badge pill variant="light">#6</b-badge>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <b-form-group :label="$t('SEO_Title')">
                  <b-form-input v-model="form.seo_meta_title"/>
                </b-form-group>
              </div>
              <div class="col-md-12">
                <b-form-group :label="$t('SEO_Description')">
                  <b-form-textarea rows="2" v-model="form.seo_meta_description"/>
                </b-form-group>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== Topbar & Footer ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Topbar_and_Footer') }}</div>
            <b-badge pill variant="light">#7</b-badge>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <b-form-group :label="$t('Topbar_Text_Left')">
                  <b-form-input v-model="form.topbar_text_left"/>
                </b-form-group>
              </div>
              <div class="col-md-6">
                <b-form-group :label="$t('Topbar_Text_Right')">
                  <b-form-input v-model="form.topbar_text_right"/>
                </b-form-group>
              </div>

              <div class="col-md-12">
                <b-form-group :label="$t('Footer_Text')">
                  <b-form-textarea rows="2" v-model="form.footer_text"/>
                </b-form-group>
              </div>
            </div>
          </div>
        </b-card>

        <!-- ===== Social Links ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Social_Links') }}</div>
            <b-button size="sm" variant="outline-success" @click="form.social_links.push({platform:'',url:''})">
              + {{ $t('Add_Link') }}
            </b-button>
          </div>
          <div class="card-body">
            <div v-if="!form.social_links.length" class="text-muted small mb-2">{{ $t('No_items') }}</div>
            <div v-for="(link, i) in form.social_links" :key="'soc-'+i" class="d-flex mb-2 align-items-center section-row">
              <span class="pill-type mr-2">🔗</span>
              <b-form-input v-model="link.platform" placeholder="Platform (e.g. facebook)" class="mr-2"/>
              <b-form-input v-model="link.url" placeholder="URL (https://…)" class="mr-2"/>
              <b-button size="sm" variant="danger" @click="form.social_links.splice(i,1)">×</b-button>
            </div>
          </div>
        </b-card>

        <!-- ===== Homepage Blocks (Hero + Collections + Offer + Banners + Newsletter) ===== -->
        <b-card class="settings-card shadow-sm mb-3" no-body>
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="h6 mb-0">{{ $t('Homepage_Blocks') }}</div>
            <small class="text-muted">{{ $t('Toggle_to_show_on_home_and_use_arrows_to_reorder') }}</small>
          </div>
          <div class="card-body">
            <div v-if="!homeRows.length" class="empty-state my-2">
              <div class="emoji">🧩</div>
              <div class="title">{{ $t('No_items') }}</div>
            </div>

            <transition-group name="fade" tag="div">
              <div v-for="(row, idx) in homeRows" :key="row.key" class="simple-row">
                <div class="left">
                  <div class="d-flex align-items-center" style="gap:.4rem;">
                    <strong class="text-dark text-truncate" :title="row.title">{{ row.title }}</strong>
                    <b-badge pill :variant="badgeVariant(row.kind)">{{ labelFor(row.kind) }}</b-badge>
                    <b-badge v-if="row.kind==='collection' && row.products_count!=null" variant="light" pill>
                      {{ $t('Products') }}: {{ row.products_count }}
                    </b-badge>
                    <b-badge v-if="row.kind!=='collection' && row.warning" variant="warning" pill>⚠︎ {{ $t('Incomplete') }}</b-badge>
                  </div>
                 
                </div>

                <div class="right">
                  <b-form-checkbox v-model="row.active" switch class="mr-2">
                    {{ row.active ? $t('Active') : $t('Inactive') }}
                  </b-form-checkbox>

                  <div class="btn-group">
                    <b-button size="sm" variant="light" @click="move(idx,-1)" :disabled="idx===0">↑</b-button>
                    <b-button size="sm" variant="light" @click="move(idx,1)" :disabled="idx===homeRows.length-1">↓</b-button>
                  </div>
                </div>
              </div>
            </transition-group>
          </div>
        </b-card>

        <!-- Sticky Save Bar -->
        <div class="savebar shadow-sm">
          <div class="d-flex align-items-center justify-content-between">
            <small class="text-muted">{{ $t('Unsaved_changes_may_be_lost') }}</small>
            <b-button :disabled="saving" type="submit" variant="btn btn-primary">
              <span v-if="saving" class="spinner-border spinner-border-sm mr-2"/>
              <lucide-icon name="check" /> {{ $t('Save') }}
            </b-button>
          </div>
        </div>
      </b-form>
    </div>
  </div>
</template>

<script>

export default {
  metaInfo: {
    title: "Store Settings"
  },
  data() {
    return {
      isLoading: true,
      saving: false,
      settings: {},
      offerImagePath: '',

      // Authoritative collections from backend
      collections: [],
      // Unified UI list: hero + all collections + newsletter
      homeRows: [],
      warehouses: [],
      currencies: [],
      themes: [],

      pendingCustomersCount: 0,

      form: {
        enabled: true,
        registration_enabled: true,
        require_invite_code: false,
        require_admin_approval: false,
        store_name: '',
        theme: 'monochra',
        primary_color: '#6c5ce7',
        secondary_color: '#00c2ff',
        font_family: 'Arial, sans-serif',
        language: 'en',
        default_warehouse_id: '',
        default_currency_id: '',
        contact_email: '',
        contact_phone: '',
        contact_address: '',
        hero_title: '',
        hero_subtitle: '',
        hero_slides: [],
        offer: {
          badge_text: '',
          title: '',
          subtitle: '',
          discount_text: '',
          button_text: '',
          link: '',
          starts_at: '',
          ends_at: '',
        },
        offer_image_clear: false,
        seo_meta_title: '',
        seo_meta_description: '',
        topbar_text_left: '',
        topbar_text_right: '',
        footer_text: '',
        // Single source of truth for homepage order/visibility
        homepage_lineup: [],
        homepage_layout: 'default',
        allow_overselling: true,
        hide_out_of_stock: false,
        hide_prices_for_guests: false,
        show_stock: true,
        menus: { header: [], footer_shop: [], footer_support: [] },
        social_links: [],
        custom_css: '',
        custom_js: '',
        store_slug: 'online_store',
        theme_tokens: {},
      },
      files: {},
      langs: [
        { value: 'en', text: 'English' },
        { value: 'fr', text: 'Français' },
        { value: 'ar', text: 'العربية' }
      ],
    }
  },
   computed: {
    // For vue-select
    warehouseOptions () {
      var arr = Array.isArray(this.warehouses) ? this.warehouses : []
      return arr.map(function (w) {
        return { label: w.name, value: Number(w.id) }
      })
    },
    // For b-form-select
    warehouseOptionsBV () {
      var arr = Array.isArray(this.warehouses) ? this.warehouses : []
      return arr.map(function (w) {
        return { text: w.name, value: Number(w.id) }
      })
    },
    selectedTheme () {
      var arr = Array.isArray(this.themes) ? this.themes : []
      var found = arr.find(function (t) { return t.slug === this.form.theme }.bind(this))
      return found || null
    },
    categorySpecificThemes () {
      var arr = Array.isArray(this.themes) ? this.themes : []
      return arr.filter(function (t) {
        return t.themeGroup === 'category-specific' || t.theme_type === 'category-specific' || t.category === 'Category-Specific Themes'
      })
    },
    generalThemes () {
      var arr = Array.isArray(this.themes) ? this.themes : []
      return arr.filter(function (t) {
        return !(t.themeGroup === 'category-specific' || t.theme_type === 'category-specific' || t.category === 'Category-Specific Themes')
      })
    }
  },
  mounted(){ this.fetch() },
  methods:{
    makeToast(variant,msg,title){
      this.$root.$bvToast?.toast(msg,{title,variant,solid:true})
    },
    asset(p){
      if (!p) return ''
      if (p.startsWith('images/')) return `/${p}`
      if (p.startsWith('/')) return p
      return `/storage/${p}`
    },
    pick(key,e){
      this.files[key] = e.target.files[0]
      if (key === 'offer_image') this.form.offer_image_clear = false
    },

    // --------- UI helpers ----------
    badgeVariant(kind){
      if (kind === 'collection') return 'info'
      if (kind === 'hero') return 'primary'
      if (kind === 'newsletter') return 'success'
      if (kind === 'offer') return 'warning'
      if (kind === 'banner_grid') return 'secondary'
      return 'light'
    },
    labelFor(kind){
      if (kind === 'collection') return this.$t('Collection')
      if (kind === 'hero') return this.$t('Hero')
      if (kind === 'newsletter') return this.$t('Newsletter')
      if (kind === 'offer') return this.$t('Offer')
      if (kind === 'banner_grid') return this.$t('Banners')
      return kind
    },
    clearOfferImage(){
      this.offerImagePath = ''
      this.form.offer_image_clear = true
      delete this.files.offer_image
    },

    // --------- Hero slides ----------
    addHeroSlide(){
      this.form.hero_slides.push({ title:'', subtitle:'', cta_text:'', cta_link:'', image:'', _clearImage:false })
    },
    removeHeroSlide(idx){
      this.form.hero_slides.splice(idx,1)
      // Re-index any pending per-slide file picks so they still line up
      // with their slide after the array shifts.
      this.reindexHeroSlideFiles()
    },
    moveHeroSlide(idx,dir){
      const j = idx + dir
      if (j < 0 || j >= this.form.hero_slides.length) return
      const a = this.form.hero_slides
      const [item] = a.splice(idx,1)
      a.splice(j,0,item)
      this.reindexHeroSlideFiles()
    },
    reindexHeroSlideFiles(){
      // Pending uploads are keyed by index (files['hero_slide_image_N']); after
      // an add/remove/reorder, rebuild that map from each slide's own file
      // reference so nothing gets attached to the wrong slide.
      const rebuilt = {}
      for (const k in this.files) {
        if (k.indexOf('hero_slide_image_') !== 0) rebuilt[k] = this.files[k]
      }
      this.form.hero_slides.forEach((slide, i) => {
        if (slide._pendingFile) rebuilt['hero_slide_image_' + i] = slide._pendingFile
      })
      this.files = rebuilt
    },
    pickHeroSlideImage(idx, e){
      const file = e.target.files[0]
      if (!file) return
      this.$set(this.form.hero_slides[idx], '_pendingFile', file)
      this.$set(this.form.hero_slides[idx], '_clearImage', false)
      this.files['hero_slide_image_' + idx] = file
    },
    clearHeroSlideImage(idx){
      const slide = this.form.hero_slides[idx]
      this.$set(slide, 'image', '')
      this.$set(slide, '_clearImage', true)
      delete slide._pendingFile
      delete this.files['hero_slide_image_' + idx]
    },
    move(idx,dir){
      const j = idx + dir
      if (j < 0 || j >= this.homeRows.length) return
      const a = this.homeRows
      const [item] = a.splice(idx,1)
      a.splice(j,0,item)
    },
    collectionUrl(slug){
      return `/${this.form.store_slug ? this.form.store_slug + '/' : ''}collections/${slug}`
    },

    // --------- Theme gallery ----------
    selectTheme(t){
      if (this.form.theme === t.slug) return
      this.form.theme = t.slug
      this.form.theme_tokens = {}
    },
    themeThumbStyle(t){
      const colors = (t.paletteSwatches && t.paletteSwatches.length) ? t.paletteSwatches : ['#3B82F6', '#22D3EE']
      const stops = colors.map((c, i) => `${c} ${Math.round((i / colors.length) * 100)}%, ${c} ${Math.round(((i + 1) / colors.length) * 100)}%`).join(', ')
      return { background: `linear-gradient(135deg, ${stops})` }
    },
    setToken(key, value){
      if (!this.form.theme_tokens || typeof this.form.theme_tokens !== 'object') {
        this.$set(this.form, 'theme_tokens', {})
      }
      this.$set(this.form.theme_tokens, key, value)
    },
    resetThemeTokens(){
      this.$set(this.form, 'theme_tokens', {})
    },
    getTokenValue(key) {
      if (this.form.theme_tokens && typeof this.form.theme_tokens[key] !== 'undefined' && this.form.theme_tokens[key] !== '') {
        return this.form.theme_tokens[key]
      }
      if (this.selectedTheme && this.selectedTheme.tokens && typeof this.selectedTheme.tokens[key] !== 'undefined') {
        return this.selectedTheme.tokens[key]
      }
      if (key.indexOf('color') === 0) return '#000000'
      if (key === 'font-size-heading') return '32px'
      if (key === 'font-size-body') return '15px'
      return ''
    },
    getFontSizePx(key, fallbackDefault) {
      var val = this.getTokenValue(key)
      if (typeof val === 'number') return val
      if (typeof val === 'string') {
        var num = parseInt(val, 10)
        if (!isNaN(num)) return num
      }
      return fallbackDefault || 16
    },
    tokenLabel(key){
      if (key === 'color-accent-500') return 'Accent 500'
      if (key === 'color-accent-600') return 'Accent 600'
      if (key === 'color-accent-700') return 'Accent 700'
      if (key === 'color-accent-800') return 'Accent 800'
      return String(key).replace(/^color-/, '').replace(/^font-/, 'Font: ').replace(/-/g, ' ')
    },

    // --------- Normalizers ----------
    tryParseJson(v){ if (!v || typeof v!=='string') return null; try{ return JSON.parse(v) }catch{ return null } },
    normalizeBool(v){
      if (typeof v === 'boolean') return v
      return v === 1 || v === '1' || v === 'true' || v === 'on'
    },
    normalizeMenus(v) {
      const x = (typeof v==='string') ? this.tryParseJson(v) : v
      if (!x || typeof x !== 'object' || Array.isArray(x)) {
        return { header: [], footer_shop: [], footer_support: [] }
      }
      return {
        header: Array.isArray(x.header) ? x.header : [],
        footer_shop: Array.isArray(x.footer_shop) ? x.footer_shop : [],
        footer_support: Array.isArray(x.footer_support) ? x.footer_support : [],
      }
    },
    normalizeSocialLinks(v) {
      const x = (typeof v==='string') ? this.tryParseJson(v) : v
      if (!x) return []
      if (Array.isArray(x)) return x.map(o => ({ platform: o.platform || '', url: o.url || '' }))
      if (typeof x === 'object') return Object.entries(x).map(([platform, url]) => ({ platform, url }))
      return []
    },
    // Your API shape (slug, is_active, sort_order, limit, products_count)
    normalizeCollectionsArray(cols){
      return (cols || []).map(c=>({
        id: c.id ?? null,
        key: `collection:${String(c.slug || c.handle || '').trim()}`,
        kind: 'collection',
        slug: String(c.slug || c.handle || '').trim(),
        title: c.title || c.slug || this.$t('Untitled'),
        products_count: c.products_count ?? null,
        limit: Number(c.limit ?? 8),
        is_active: this.normalizeBool(c.is_active ?? false),
        sort_order: Number(c.sort_order ?? 9999),
      })).filter(c=>!!c.slug)
    },

    // --------- Build the unified Home list ----------
    buildHomeRows(){
      const rows = []
      const lineup = Array.isArray(this.form.homepage_lineup) ? this.form.homepage_lineup : []

      // Prepare the three “sources”
      const heroConfigured = !!(this.form.hero_title || this.settings.hero_image_path)
      const heroRow = {
        key: 'hero',
        kind: 'hero',
        title: this.form.hero_title || this.$t('Hero'),
        active: false,
        warning: !heroConfigured
      }

      const newsletterRow = {
        key: 'newsletter',
        kind: 'newsletter',
        title: this.$t('Newsletter'),
        active: false,
        warning: false
      }

      // Offer + banner grid default to active:true when absent from a saved
      // lineup -- that mirrors how the storefront actually renders them (a
      // theme's promo/banner section always shows unless explicitly turned
      // off), so the toggle here never lies about the live state.
      const offerConfigured = !!(this.form.offer.title || this.form.offer.badge_text || this.offerImagePath)
      const offerRow = {
        key: 'offer',
        kind: 'offer',
        title: this.form.offer.title || this.$t('Offer'),
        active: true,
        warning: !offerConfigured
      }

      const bannerGridRow = {
        key: 'banner_grid',
        kind: 'banner_grid',
        title: this.$t('Banners'),
        active: true,
        warning: false
      }

      const collectionBySlug = new Map(this.collections.map(c => [c.slug, c]))
      const used = new Set()

      if (lineup.length) {
        // 1) Place items exactly as saved
        lineup.forEach(item => {
          if (!item || !item.type) return
          if (item.type === 'hero') { rows.push({ ...heroRow, active: true }); used.add('hero') }
          else if (item.type === 'newsletter') { rows.push({ ...newsletterRow, active: true }); used.add('newsletter') }
          else if (item.type === 'promo_banner') { rows.push({ ...offerRow, active: this.normalizeBool(item.enabled ?? true) }); used.add('offer') }
          else if (item.type === 'banner_grid') { rows.push({ ...bannerGridRow, active: this.normalizeBool(item.enabled ?? true) }); used.add('banner_grid') }
          else if (item.type === 'collection' && item.slug) {
            const c = collectionBySlug.get(String(item.slug))
            if (c) { rows.push({ ...c, key: `collection:${c.slug}`, kind:'collection', active: true }); used.add(`collection:${c.slug}`) }
          }
        })
        // 2) Append the rest (not in lineup)
        if (!used.has('hero')) rows.push(heroRow)
        if (!used.has('offer')) rows.push(offerRow)
        if (!used.has('banner_grid')) rows.push(bannerGridRow)
        if (!used.has('newsletter')) rows.push(newsletterRow)
        this.collections
          .filter(c => !used.has(`collection:${c.slug}`))
          .sort((a,b)=> (a.sort_order - b.sort_order) || a.title.localeCompare(b.title))
          .forEach(c => rows.push({ ...c, key:`collection:${c.slug}`, kind:'collection', active: this.normalizeBool(c.is_active) }))
      } else {
        // No saved lineup yet → default order
        rows.push({ ...heroRow, active: false })
        rows.push(offerRow)
        rows.push(bannerGridRow)
        this.collections
          .slice()
          .sort((a,b)=> (a.sort_order - b.sort_order) || a.title.localeCompare(b.title))
          .forEach(c => rows.push({ ...c, key:`collection:${c.slug}`, kind:'collection', active: this.normalizeBool(c.is_active) }))
        rows.push({ ...newsletterRow, active: false })
      }

      this.homeRows = rows
    },

    // --------- IO ----------
    async fetch () {
      try {
        this.isLoading = true

        const resp = await axios.get('/admin/store/settings')
        const payload = (resp && resp.data) ? resp.data : {}

        // read new shape (fallback to old for compatibility)
        const settings = (payload && payload.settings) ? payload.settings : payload
        const warehouses = Array.isArray(payload && payload.warehouses) ? payload.warehouses : []
        const currencies = Array.isArray(payload && payload.currencies) ? payload.currencies : []
        const themes = Array.isArray(payload && payload.themes) ? payload.themes : []

        this.settings = settings || {}
        this.warehouses = warehouses
        this.currencies = currencies
        this.themes = themes
        this.pendingCustomersCount = (payload && payload.pending_customers_count) || 0

        // build form (no spread / optional chaining)
        var merged = Object.assign({}, this.form, settings)

        merged.enabled        = this.normalizeBool(settings && settings.enabled)
        merged.registration_enabled = this.normalizeBool(settings && (settings.registration_enabled ?? true))
        merged.require_invite_code = this.normalizeBool(settings && (settings.require_invite_code ?? false))
        merged.require_admin_approval = this.normalizeBool(settings && (settings.require_admin_approval ?? false))
        merged.menus          = this.normalizeMenus(settings && settings.menus)
        merged.social_links   = this.normalizeSocialLinks(settings && settings.social_links)
        merged.store_slug     = (settings && settings.store_slug) ? settings.store_slug : this.form.store_slug
        merged.theme          = (settings && settings.theme) ? settings.theme : 'default'
        var tokensRaw = settings && settings.theme_tokens
        merged.theme_tokens = (tokensRaw && typeof tokensRaw === 'object' && !Array.isArray(tokensRaw))
          ? tokensRaw
          : (this.tryParseJson(tokensRaw) || {})

        var lineupRaw = settings && settings.homepage_lineup
        merged.homepage_lineup = Array.isArray(lineupRaw)
          ? lineupRaw
          : (this.tryParseJson(lineupRaw) || [])

        // Pull the promo_banner item's fields into the dedicated Offers form.
        var offerItem = merged.homepage_lineup.find(function (it) { return it && it.type === 'promo_banner' })
        merged.offer = {
          badge_text: (offerItem && offerItem.badge_text) || '',
          title: (offerItem && offerItem.title) || '',
          subtitle: (offerItem && offerItem.subtitle) || '',
          discount_text: (offerItem && offerItem.discount_text) || '',
          button_text: (offerItem && offerItem.button_text) || '',
          link: (offerItem && offerItem.link) || '',
          starts_at: (offerItem && offerItem.starts_at) || '',
          ends_at: (offerItem && offerItem.ends_at) || '',
        }
        merged.offer_image_clear = false
        this.offerImagePath = (offerItem && offerItem.image) || ''

        // Hero slides: use whatever's saved, or seed one slide from the
        // legacy single hero_title/hero_subtitle/hero_image_path fields so a
        // merchant's existing hero isn't lost the first time they open this
        // (now-multi-slide) form.
        var slidesRaw = settings && settings.hero_slides
        var existingSlides = Array.isArray(slidesRaw) ? slidesRaw : (this.tryParseJson(slidesRaw) || [])
        merged.hero_slides = existingSlides.length
          ? existingSlides.map(function (sl) {
              return {
                title: (sl && sl.title) || '',
                subtitle: (sl && sl.subtitle) || '',
                cta_text: (sl && sl.cta_text) || '',
                cta_link: (sl && sl.cta_link) || '',
                image: (sl && sl.image) || '',
              }
            })
          : ((settings && (settings.hero_title || settings.hero_subtitle || settings.hero_image_path))
              ? [{
                  title: (settings && settings.hero_title) || '',
                  subtitle: (settings && settings.hero_subtitle) || '',
                  cta_text: '',
                  cta_link: '',
                  image: (settings && settings.hero_image_path) || '',
                }]
              : [])

        merged.homepage_layout = 'default'
        merged.allow_overselling = this.normalizeBool(settings && settings.allow_overselling)
        merged.hide_out_of_stock = this.normalizeBool(settings && settings.hide_out_of_stock)
        merged.hide_prices_for_guests = this.normalizeBool(settings && settings.hide_prices_for_guests)
        merged.show_stock = this.normalizeBool(settings && (settings.show_stock ?? true))

        // Ensure default_warehouse_id is a Number; pick first if empty
        if (merged.default_warehouse_id != null) {
          merged.default_warehouse_id = Number(merged.default_warehouse_id)
        } else if (this.warehouses.length) {
          merged.default_warehouse_id = Number(this.warehouses[0].id)
        } else {
          merged.default_warehouse_id = null
        }

         // Ensure default_currency_id is a Number; pick first if empty
        if (merged.default_currency_id != null) {
          merged.default_currency_id = Number(merged.default_currency_id)
        } else if (this.currencies.length) {
          merged.default_currency_id = Number(this.currencies[0].id)
        } else {
          merged.default_currency_id = null
        }

        this.form = merged

        // Collections: from settings or endpoint fallback (unchanged)
        var cols = []
        var dataCollections = settings && settings.collections
        if (Array.isArray(dataCollections) && dataCollections.length) {
          cols = dataCollections
        } else {
          try {
            const res = await axios.get('/admin/store/collections?include_counts=1')
            cols = Array.isArray(res && res.data) ? res.data : []
          } catch (e) { cols = [] }
        }
        this.collections = this.normalizeCollectionsArray(cols)

        this.buildHomeRows()
      } catch (e) {
        this.makeToast('danger', this.$t('InvalidData'), this.$t('Failed'))
      } finally {
        this.isLoading = false
      }
    },

    async save () {
      this.saving = true
      try {
        // 1) Build homepage_lineup from active rows (keep order)
        var lineup = []
        for (var i = 0; i < this.homeRows.length; i++) {
          var r = this.homeRows[i]
          if (!r) continue
          // Offer / banner grid always get an explicit entry (enabled reflects
          // the toggle) since their visibility is truly gated by this value —
          // unlike hero/newsletter/collection, omitting them would NOT hide
          // them (the storefront defaults an absent entry to "on").
          if (r.kind === 'offer') {
            lineup.push({
              type: 'promo_banner',
              enabled: !!r.active,
              badge_text: this.form.offer.badge_text || '',
              title: this.form.offer.title || '',
              subtitle: this.form.offer.subtitle || '',
              discount_text: this.form.offer.discount_text || '',
              button_text: this.form.offer.button_text || '',
              link: this.form.offer.link || '',
              image: this.offerImagePath || '',
              starts_at: this.form.offer.starts_at || '',
              ends_at: this.form.offer.ends_at || '',
            })
            continue
          }
          if (r.kind === 'banner_grid') {
            lineup.push({ type: 'banner_grid', enabled: !!r.active })
            continue
          }
          if (!r.active) continue
          if (r.kind === 'hero') {
            lineup.push({ type: 'hero' })
          } else if (r.kind === 'newsletter') {
            lineup.push({ type: 'newsletter' })
          } else if (r.kind === 'collection') {
            lineup.push({
              type: 'collection',
              slug: r.slug,
              limit: r.limit ? Number(r.limit) : 8,
              layout: 'grid',
              title_override: ''
            })
          }
        }
        this.form.homepage_lineup = lineup

        // 1b) Clean hero_slides for the wire (strip UI-only helper fields;
        // clearing a slide's image blanks it here, the actual clear flag is
        // appended to FormData below since it's not part of this.form).
        var heroSlidesClean = this.form.hero_slides.map(function (sl) {
          return {
            title: sl.title || '',
            subtitle: sl.subtitle || '',
            cta_text: sl.cta_text || '',
            cta_link: sl.cta_link || '',
            image: sl._clearImage ? '' : (sl.image || ''),
          }
        })
        var heroSlideClearFlags = this.form.hero_slides.map(function (sl) { return !!sl._clearImage })
        this.form.hero_slides = heroSlidesClean

        // 2) Ensure numeric fields are numbers (esp. default_warehouse_id)
        if (this.form.default_warehouse_id != null && this.form.default_warehouse_id !== '') {
          this.form.default_warehouse_id = Number(this.form.default_warehouse_id)
        } else {
          this.form.default_warehouse_id = null
        }

        if (this.form.default_currency_id != null && this.form.default_currency_id !== '') {
          this.form.default_currency_id = Number(this.form.default_currency_id)
        } else {
          this.form.default_currency_id = null
        }

        // 3) Build FormData (Vue 2 compatible)
        var fd = new FormData()
        var jsonFields = ['menus', 'social_links', 'homepage_lineup', 'theme_tokens', 'hero_slides']
        // Staging-only field: its contents already travel inside the
        // promo_banner entry of homepage_lineup, built above.
        var skipFields = ['offer']

        for (var k in this.form) {
          if (!Object.prototype.hasOwnProperty.call(this.form, k)) continue
          if (skipFields.indexOf(k) !== -1) continue
          var v = this.form[k]

          // Booleans as 1/0 for Laravel convenience
          if (typeof v === 'boolean') {
            fd.append(k, v ? 1 : 0)
            continue
          }

          // JSON fields (arrays/objects) → stringify
          if (jsonFields.indexOf(k) !== -1) {
            try {
              fd.append(k, JSON.stringify(v || []))
            } catch (e) {
              fd.append(k, '[]')
            }
            continue
          }

          // Null/undefined → empty string
          if (v === null || typeof v === 'undefined') {
            fd.append(k, '')
            continue
          }

          // Everything else (numbers/strings) as-is
          fd.append(k, v)
        }

        // 4) Attach files (if any)
        for (var fk in this.files) {
          if (!Object.prototype.hasOwnProperty.call(this.files, fk)) continue
          var f = this.files[fk]
          if (f) fd.append(fk, f)
        }

        // 4b) Per-slide "remove image" flags (not part of this.form, so not
        // covered by the generic loop above)
        heroSlideClearFlags.forEach(function (clear, i) {
          if (clear) fd.append('hero_slide_image_clear_' + i, 1)
        })

        // 5) POST (multipart) — Laravel will read request->all()/files normally
        await axios.post('/admin/store/settings', fd, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })

        this.makeToast('success', this.$t('Successfully_Updated'), this.$t('Success'))
        await this.fetch()   // reload latest (also refreshes warehouses/default if backend changed)
        this.files = {}
      } catch (e) {
        this.makeToast('danger', this.$t('InvalidData'), this.$t('Failed'))
      } finally {
        this.saving = false
      }
    }

  }
}
</script>

<style scoped>
/* Cards */
.settings-card .card-header{
  background: #f8fafc;
  border-bottom: 1px solid #e5e7eb;
}
.settings-card .card-body{
  background: #fff;
}

/* Social links row */
.section-row {
  background: #f8fafc;
  border: 1px dashed #e2e8f0;
  border-radius: .5rem;
  padding: .5rem;
}
.pill-type {
  background: #fff;
  border: 1px solid #e5e7eb;
  border-radius: 999px;
  padding: .15rem .5rem;
  font-size: .85rem;
}

/* Homepage blocks list */
.empty-state {
  border: 2px dashed #e2e8f0;
  border-radius: 1rem;
  padding: 1.25rem;
  text-align: center;
  background: #fafafa;
  color: #6b7280;
}
.empty-state .emoji { font-size: 1.6rem; }
.empty-state .title { font-weight: 700; margin-top: .2rem; }

.simple-row{
  display:flex; align-items:center; justify-content:space-between;
  padding:.75rem .8rem; background:#fff; border:1px solid #e5e7eb;
  border-radius:.9rem; margin-bottom:.6rem;
}

.hero-slide-card {
  padding: .9rem 1rem;
  background: #fafafa;
  border: 1px solid #e5e7eb;
  border-radius: .9rem;
}
.simple-row .left{ min-width:0; }
.muted-row { color:#6b7280; font-size:.85rem; }
.a-muted { color:#6b7280; }
.a-muted:hover { color:#111827; text-decoration:none; }

.fade-enter-active, .fade-leave-active { transition: all .15s ease; }
.fade-enter, .fade-leave-to { opacity:0; transform: translateY(-4px); }

/* Storefront theme gallery */
.theme-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 1rem;
}
.theme-gallery-card {
  cursor: pointer;
  border: 2px solid transparent;
  border-radius: .6rem;
  overflow: hidden;
  background: #f8f9fb;
  transition: border-color .15s ease, transform .15s ease;
}
.theme-gallery-card:hover { transform: translateY(-2px); }
.theme-gallery-card.active { border-color: #6c5ce7; }
.theme-gallery-thumb { position: relative; aspect-ratio: 400 / 260; background: #fff; }
.theme-gallery-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.theme-gallery-check {
  position: absolute; top: 6px; right: 6px;
  width: 22px; height: 22px; border-radius: 50%;
  background: #6c5ce7; color: #fff;
  display: flex; align-items: center; justify-content: center;
}
.theme-gallery-meta { padding: .5rem .6rem; }
.theme-gallery-name { font-size: .8rem; font-weight: 600; line-height: 1.2; }
.theme-gallery-industry { font-size: .7rem; }
.theme-gallery-category {
  font-size: .65rem; font-weight: 600; margin-top: .2rem;
  display: inline-block; padding: .1rem .45rem; border-radius: 999px;
  background: #f1eefe; color: #6c5ce7;
}
.theme-gallery-swatches {
  position: absolute; bottom: 6px; left: 6px;
  display: flex; gap: 4px;
}
.theme-gallery-swatch {
  width: 14px; height: 14px; border-radius: 50%;
  border: 2px solid rgba(255,255,255,.85);
  box-shadow: 0 1px 2px rgba(0,0,0,.25);
}

/* Sticky Save Bar */
.savebar{
  position: sticky;
  bottom: 0;
  background: linear-gradient(180deg, rgba(255,255,255,.0), rgba(255,255,255,.95) 20%);
  padding: .75rem 1rem;
  border-top: 1px solid #e5e7eb;
  border-radius: .75rem;
}

/* Theme customizer panel */
.theme-customizer-panel {
  background: #ffffff !important;
  border: 1px solid #e5e7eb !important;
  box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
</style>
