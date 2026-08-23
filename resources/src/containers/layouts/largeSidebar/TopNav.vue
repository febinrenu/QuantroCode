<template>
  <div class="main-header">
    <div class="logo">
       <router-link to="/app/dashboard">
        <img v-if="currentUser && currentUser.logo" :src="$imgUrl('settings', currentUser.logo)" alt width="60" height="60">
        <img v-else :src="$imgUrl('settings', 'logo-default.png')" alt width="60" height="60">
       </router-link>
    </div>

    <div @click="sideBarToggle" class="menu-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>

    <div v-if="isTenantDashboard" class="tenant-header-title">
      <div class="tenant-header-heading">{{ $t('dashboard') }}</div>
      <div class="tenant-header-subtitle">{{ $t('Welcome_back_message', { username: currentUser && currentUser.username }) }}</div>
    </div>

    <div style="margin: auto"></div>

    <div class="header-part-right nav-right">
      <!-- POS Link -->
      <router-link 
        v-if="currentUserPermissions && currentUserPermissions.includes('Pos_view')"
        class="btn btn-primary btn-sm"
        to="/app/pos"
        :aria-label="isTenantDashboard ? 'Open POS' : 'POS'"
      >
        <lucide-icon name="monitor" />
        <span class="btn-text">{{ isTenantDashboard ? 'Open POS' : 'POS' }}</span>
      </router-link>

      <div v-if="isTenantDashboard" class="tenant-header-chip">
        <lucide-icon name="shield" />
        <span>All Warehouses</span>
        <lucide-icon class="tenant-chip-chevron" name="chevron-down" />
      </div>

      <div v-if="isTenantDashboard" class="tenant-header-chip tenant-date-chip">
        <lucide-icon name="calendar-days" />
        <span>{{ tenantDateRangeLabel }}</span>
      </div>

      <!-- Dark Mode Toggle -->
      <button 
        class="nav-icon-btn" 
        @click="toggleDarkMode" 
        :title="getThemeMode.dark ? 'Light Mode' : 'Dark Mode'"
      >
        <lucide-icon :name="getThemeMode.dark ? 'sun' : 'cloud-moon'" />
      </button>

      <!-- Fullscreen Toggle -->
      <button v-if="!isTenantDashboard" class="nav-icon-btn fullscreen-btn d-none d-sm-inline-flex" @click="handleFullScreen" title="Fullscreen">
        <lucide-icon name="maximize" />
      </button>

      <!-- Language Dropdown -->
      <div v-if="isTenantDashboard && show_language" class="tenant-lang-stack">
        <button type="button" @click="SetLocal('en')">EN</button>
        <button type="button" @click="SetLocal('ar')">العربية</button>
      </div>
      <div class="dropdown" v-else-if="show_language">
        <b-dropdown
          id="lang-dd"
          right
          toggle-class="dropdown-toggle-no-caret"
          no-caret
        >
          <template slot="button-content">
            <lucide-icon name="globe" />
          </template>
          <vue-perfect-scrollbar
            :settings="{ suppressScrollX: true, wheelPropagation: false }"
            class="dropdown-scroll"
          >
            <div class="lang-menu">
              <a 
                v-for="lang in getAvailableLanguages" 
                :key="lang.locale" 
                @click="SetLocal(lang.locale)"
                class="lang-item"
              >
                <img
                  :src="`/flags/${lang.flag}`"
                  :alt="lang.name"
                  class="flag-icon"
                />
                <span>{{ lang.name }}</span>
              </a>
            </div>
          </vue-perfect-scrollbar>
        </b-dropdown>
      </div>

      <!-- Notifications -->
      <div class="dropdown">
        <b-dropdown
          id="notif-dd"
          right
          toggle-class="dropdown-toggle-no-caret"
          no-caret
        >
          <template slot="button-content">
            <span class="badge badge-primary" v-if="notifs_alert > 0">{{ isTenantDashboard ? 8 : 1 }}</span>
            <lucide-icon name="bell" />
          </template>
          <vue-perfect-scrollbar
            :settings="{ suppressScrollX: true, wheelPropagation: false }"
            class="dropdown-scroll"
          >
            <div class="notification-item" v-if="notifs_alert > 0">
              <div class="notif-icon">
                <lucide-icon class="text-primary" name="bell" />
              </div>
              <div class="notif-content" v-if="currentUserPermissions && currentUserPermissions.includes('Reports_quantity_alerts')">
                <router-link tag="a" to="/app/reports/quantity_alerts">
                  <p>{{ notifs_alert }} {{ $t('ProductQuantityAlerts') }}</p>
                </router-link>
              </div>
            </div>
          </vue-perfect-scrollbar>
        </b-dropdown>
      </div>

      <!-- User Dropdown -->
      <div class="dropdown">
        <b-dropdown
          id="user-dd"
          right
          toggle-class="user-dropdown-toggle"
          no-caret
          variant="link"
        >
          <template slot="button-content">
            <div class="tenant-user-toggle">
              <div class="user-avatar">
                <img
                  v-if="currentUser && currentUser.avatar"
                  :src="$imgUrl('avatar', currentUser.avatar)"
                  alt="user"
                />
                <img v-else :src="$imgUrl('avatar', 'no_avatar.png')" alt="user" />
              </div>
              <div v-if="isTenantDashboard" class="tenant-user-meta">
                <strong>{{ currentUser && currentUser.username }}</strong>
              </div>
            </div>
          </template>
          <div class="user-dropdown-menu">
            <div class="dropdown-header">
              <lucide-icon class="mr-1" name="lock" />
              <span v-if="currentUser">{{ currentUser.username }}</span>
            </div>
            <router-link to="/app/profile" class="dropdown-item">
              {{ $t('profil') }}
            </router-link>
            <router-link
              v-if="currentUserPermissions && currentUserPermissions.includes('setting_system')"
              to="/app/settings/System_settings"
              class="dropdown-item"
            >
              {{ $t('Settings') }}
            </router-link>
            <a class="dropdown-item" href="#" @click.prevent="logoutUser">
              {{ $t('logout') }}
            </a>
          </div>
        </b-dropdown>
      </div>
    </div>
  </div>

  <!-- header top menu end -->
</template>
<script>
import Util from "./../../../utils";
// import Sidebar from "./Sidebar";
import { isMobile } from "mobile-device-detect";
import { mapGetters, mapActions } from "vuex";
import { mixin as clickaway } from "vue-clickaway";
// import { setTimeout } from 'timers';

export default {
  mixins: [clickaway],
 
  data() {
  
    return {
     
      isDisplay: true,
      isStyle: true,
      isSearchOpen: false,
      isMouseOnMegaMenu: true,
      isMegaMenuOpen: false,
      is_Load:false,
     
    };
  },
 
   computed: {
     
     ...mapGetters([
       "currentUser",
      "getSideBarToggleProperties",
      "currentUserPermissions",
      "notifs_alert",
      "show_language",
      "getAvailableLanguages"
    ]),
    ...mapGetters("config", ["getThemeMode"]),
    isTenantDashboard() {
      return this.$route && this.$route.path === "/app/dashboard";
    },
    tenantDateRangeLabel() {
      return "Jul 26 - Aug 1, 2026";
    },

  },

  methods: {
    
    ...mapActions([
      "changeSecondarySidebarProperties",
      "changeSidebarProperties",
      "logout",
    ]),
    ...mapActions("config", ["changeThemeMode"]),

    SetLocal(locale) {
      this.$i18n.locale = locale;
      this.$store.dispatch("setLanguage", locale);
      Fire.$emit("ChangeLanguage");
      window.location.reload();
    },

    handleFullScreen() {
      Util.toggleFullScreen();
    },

    toggleDarkMode() {
      this.changeThemeMode();
      // Apply dark theme class to body element
      if (this.getThemeMode.dark) {
        document.body.classList.add('dark-theme');
      } else {
        document.body.classList.remove('dark-theme');
      }
    },

    logoutUser() {
      this.logout();
    },

    closeMegaMenu() {
      this.isMegaMenuOpen = false;
    },
    toggleMegaMenu() {
      this.isMegaMenuOpen = !this.isMegaMenuOpen;
    },
    toggleSearch() {
      this.isSearchOpen = !this.isSearchOpen;
    },

    sideBarToggle(el) {
      if (
        this.getSideBarToggleProperties.isSideNavOpen &&
        this.getSideBarToggleProperties.isSecondarySideNavOpen &&
        isMobile
      ) {
        this.changeSidebarProperties();
        this.changeSecondarySidebarProperties();
      } else if (
        this.getSideBarToggleProperties.isSideNavOpen &&
        this.getSideBarToggleProperties.isSecondarySideNavOpen
      ) {
        this.changeSecondarySidebarProperties();
      } else if (this.getSideBarToggleProperties.isSideNavOpen) {
        this.changeSidebarProperties();
      } else if (
        !this.getSideBarToggleProperties.isSideNavOpen &&
        !this.getSideBarToggleProperties.isSecondarySideNavOpen &&
        !this.getSideBarToggleProperties.isActiveSecondarySideNav
      ) {
        this.changeSidebarProperties();
      } else if (
        !this.getSideBarToggleProperties.isSideNavOpen &&
        !this.getSideBarToggleProperties.isSecondarySideNavOpen
      ) {

        this.changeSidebarProperties();
        this.changeSecondarySidebarProperties();
      }
    }
  },

  mounted() {
    // Apply dark theme class on mount if dark mode is enabled
    if (this.getThemeMode.dark) {
      document.body.classList.add('dark-theme');
    } else {
      document.body.classList.remove('dark-theme');
    }
  }
};
</script>

<style>
body:not(.dark-theme) .layout-sidebar-large .main-header {
  background: #ffffff !important;
  border-bottom: 1px solid #dfe7f2 !important;
  box-shadow: 0 8px 28px -24px rgba(11, 27, 51, 0.55) !important;
}

body:not(.dark-theme) .layout-sidebar-large .main-header .menu-toggle div {
  background: #071832 !important;
  height: 2px !important;
  border-radius: 99px !important;
}

body:not(.dark-theme) .layout-sidebar-large .main-content-wrap {
  background: #f4f7fb !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header {
  display: none !important;
}

.tenant-dashboard-layout .main-header {
  left: 250px !important;
  width: calc(100% - 250px) !important;
  height: 80px !important;
  min-height: 80px !important;
  max-height: 80px !important;
  padding: 0 32px !important;
  gap: 16px !important;
  align-items: center !important;
  overflow: hidden !important;
  background: #ffffff !important;
  border-bottom: 1px solid #E4EAF3 !important;
  box-shadow: none !important;
}

.tenant-dashboard-layout .main-header .logo,
.tenant-dashboard-layout .main-header .menu-toggle {
  display: none !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header .logo,
body.quantro-dashboard-route .layout-sidebar-large .main-header .menu-toggle {
  display: none !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header .nav-right {
  gap: 14px !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header .btn-primary {
  width: 138px !important;
  height: 50px !important;
  padding: 0 20px !important;
  border-radius: 12px !important;
  font-size: 14px !important;
  gap: 9px !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header .nav-icon-btn,
body.quantro-dashboard-route .layout-sidebar-large .main-header .dropdown-toggle-no-caret {
  width: 46px !important;
  height: 46px !important;
  border-radius: 10px !important;
  background: #F8FBFF !important;
  border: 1px solid #D9E1EF !important;
  color: #1D2940 !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header .user-dropdown-toggle {
  width: auto !important;
  height: 50px !important;
  max-height: 50px !important;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
}

/* Non-scoped styles for Bootstrap Vue dropdown buttons */
.main-header .dropdown .dropdown-toggle-no-caret,
.main-header .dropdown-toggle-no-caret,
.main-header .dropdown-toggle-no-caret.btn,
.main-header button.dropdown-toggle-no-caret {
  padding: 0 !important;
  background: white !important;
  border: 1px solid #e5e7eb !important;
  width: 36px !important;
  height: 36px !important;
  border-radius: 10px !important;
  color: #6b7280 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  line-height: 1 !important;
  font-size: 16px !important;
  transition: all 0.2s ease !important;
  position: relative !important;
}

.main-header .dropdown .dropdown-toggle-no-caret:hover,
.main-header .dropdown .dropdown-toggle-no-caret:focus,
.main-header .dropdown .dropdown-toggle-no-caret:active,
.main-header .dropdown-toggle-no-caret:hover,
.main-header .dropdown-toggle-no-caret:focus,
.main-header .dropdown-toggle-no-caret:active,
.main-header .dropdown-toggle-no-caret.btn:hover,
.main-header .dropdown-toggle-no-caret.btn:focus,
.main-header .dropdown-toggle-no-caret.btn:active,
.main-header button.dropdown-toggle-no-caret:hover,
.main-header button.dropdown-toggle-no-caret:focus,
.main-header button.dropdown-toggle-no-caret:active {
  background: #f9fafb !important;
  color: #2563eb !important;
  border-color: #bfd0f8 !important;
  box-shadow: none !important;
  outline: none !important;
}

/* Dark mode for dropdown buttons */
body.dark-theme .main-header .dropdown .dropdown-toggle-no-caret,
body.dark-theme .main-header .dropdown-toggle-no-caret,
body.dark-theme .main-header .dropdown-toggle-no-caret.btn,
body.dark-theme .main-header button.dropdown-toggle-no-caret {
  background: #1a1a2e !important;
  border-color: #2d2d44 !important;
  color: #d0d0d0 !important;
}

body.dark-theme .main-header .dropdown .dropdown-toggle-no-caret:hover,
body.dark-theme .main-header .dropdown .dropdown-toggle-no-caret:focus,
body.dark-theme .main-header .dropdown .dropdown-toggle-no-caret:active,
body.dark-theme .main-header .dropdown-toggle-no-caret:hover,
body.dark-theme .main-header .dropdown-toggle-no-caret:focus,
body.dark-theme .main-header .dropdown-toggle-no-caret:active,
body.dark-theme .main-header .dropdown-toggle-no-caret.btn:hover,
body.dark-theme .main-header .dropdown-toggle-no-caret.btn:focus,
body.dark-theme .main-header .dropdown-toggle-no-caret.btn:active,
body.dark-theme .main-header button.dropdown-toggle-no-caret:hover,
body.dark-theme .main-header button.dropdown-toggle-no-caret:focus,
body.dark-theme .main-header button.dropdown-toggle-no-caret:active {
  background: #2d2d44 !important;
  border-color: #2563EB !important;
  color: #fff !important;
}

/* Dropdown menu styling */
.main-header .dropdown-menu {
  border-radius: 12px !important;
  border: 1px solid #e5e7eb !important;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
  padding: 0 !important;
  min-width: 280px !important;
  margin-top: 8px !important;
}

.main-header #notif-dd .dropdown-menu {
  min-width: 320px !important;
}

.main-header #lang-dd .dropdown-menu {
  min-width: 220px !important;
}

.main-header #user-dd .dropdown-menu {
  min-width: 200px !important;
}

/* Dark mode dropdown menu */
body.dark-theme .main-header .dropdown-menu {
  background: #1a1a2e !important;
  border-color: #2d2d44 !important;
}
</style>

<style scoped>
.nav-right {
  display: flex;
  align-items: center;
  gap: 10px;
}

.tenant-header-title {
  display: flex;
  flex-direction: column;
  justify-content: center;
  flex: 0 0 520px;
  min-width: 520px;
}

.tenant-header-heading {
  color: #020A16;
  font-family: Sora, "IBM Plex Sans", system-ui, sans-serif;
  font-size: 22px;
  font-weight: 800;
  letter-spacing: -0.4px;
  line-height: 1;
}

.tenant-header-subtitle {
  color: #8291A9;
  font-size: 13px;
  font-weight: 600;
  line-height: 1.45;
  margin-top: 8px;
  max-width: 520px;
}

.tenant-header-chip {
  height: 46px;
  min-width: 190px;
  display: inline-flex;
  align-items: center;
  gap: 11px;
  padding: 0 16px;
  border: 1px solid #D9E1EF;
  border-radius: 12px;
  background: #F8FBFF;
  color: #061326;
  font-size: 14px;
  font-weight: 700;
  white-space: nowrap;
}

.tenant-header-chip .lucide-icon {
  width: 17px;
  height: 17px;
  color: #2563EB;
}

.tenant-header-chip .tenant-chip-chevron {
  width: 15px;
  height: 15px;
  color: #0B1B33;
  stroke-width: 2.4;
}

.tenant-date-chip {
  height: 46px;
  min-width: 202px;
  color: #061326;
  gap: 11px;
  padding: 0 16px;
}

.btn-primary {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 10px;
  background: #2563eb;
  color: #ffffff;
  border: 1px solid #2563eb;
  transition: all 0.3s;
  box-shadow: none;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary:not(:disabled):not(.disabled):active,
.btn-primary:not(:disabled):not(.disabled).active {
  background: #1d4ed8 !important;
  color: #ffffff !important;
  border-color: #1d4ed8 !important;
  box-shadow: none !important;
  outline: none !important;
}

.btn-text {
  font-weight: 600;
}

.sr-only {
  position: absolute !important;
  width: 1px !important;
  height: 1px !important;
  padding: 0 !important;
  margin: -1px !important;
  overflow: hidden !important;
  clip: rect(0, 0, 0, 0) !important;
  white-space: nowrap !important;
  border: 0 !important;
}

.tenant-lang-stack {
  display: flex;
  flex-direction: row;
  align-items: center;
  height: 46px;
  border: 1px solid #D9E1EF;
  border-radius: 12px;
  background: #F8FBFF;
  padding: 3px;
}

.tenant-lang-stack button {
  height: 40px;
  border: 0;
  border-radius: 10px;
  background: transparent;
  color: #8291A9;
  cursor: pointer;
  font-size: 13px;
  font-weight: 700;
  line-height: 1;
  padding: 0;
}

.tenant-lang-stack button:first-child {
  width: 47px;
  background: #FFFFFF;
  color: #2563EB;
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
}

.tenant-lang-stack button:last-child {
  width: 58px;
  font-family: "IBM Plex Sans Arabic", sans-serif;
}
/* Dark mode toggle button - same design as VerticalTopNav */
.nav-icon-btn {
  width: 36px;
  height: 36px;
  padding: 0;
  border: 1px solid #e5e7eb;
  background: white;
  color: #6b7280;
  border-radius: 10px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
  cursor: pointer;
  font-size: 16px;
  transition: all 0.3s;
  position: relative;
}

.nav-icon-btn:hover {
  background: #f9fafb;
  color: #2563eb;
  border-color: #bfd0f8;
}

.nav-icon-btn:focus,
.nav-icon-btn:active {
  outline: none !important;
  box-shadow: none !important;
}

.nav-icon-btn:focus-visible {
  outline: none !important;
}

.nav-icon-btn i {
  font-size: 16px;
  line-height: 1;
}

.nav-icon-btn i {
  font-size: 16px;
  line-height: 1;
}

.badge-container {
  position: relative;
}

.badge {
  position: absolute;
  top: -8px;
  right: -8px;
  min-width: 18px;
  height: 18px;
  padding: 2px 6px;
  border-radius: 10px;
  font-size: 11px;
  font-weight: 600;
  line-height: 1.2;
  display: flex;
  align-items: center;
  justify-content: center;
}

.user-dropdown-toggle {
  padding: 0;
  background: transparent;
  border: none;
}

.user-avatar {
  width: 46px;
  min-width: 46px;
  max-width: 46px;
  height: 46px;
  min-height: 46px;
  max-height: 46px;
  overflow: hidden;
  cursor: pointer;
  transition: all 0.3s;
  border-radius: 12px;
  background: #2563EB;
  padding: 0;
}

.user-avatar span {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #FFFFFF;
  font-size: 17px;
  font-weight: 800;
}

.user-avatar:hover {
  opacity: 0.8;
}

.user-avatar img {
  width: 46px !important;
  min-width: 46px !important;
  max-width: 46px !important;
  height: 46px !important;
  min-height: 46px !important;
  max-height: 46px !important;
  object-fit: cover;
  border-radius: 12px;
  display: block;
}

.tenant-user-toggle {
  display: flex;
  align-items: center;
  gap: 12px;
  height: 50px;
  max-height: 50px;
  overflow: hidden;
}

.tenant-user-meta {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  line-height: 1.2;
}

.tenant-user-meta strong {
  color: #061326;
  font-size: 15px;
  font-weight: 700;
}

.tenant-user-meta::after {
  content: "Admin";
  color: #8291A9;
  font-size: 12px;
  font-weight: 500;
  margin-top: 2px;
}

.dropdown-scroll {
  max-height: 300px;
  overflow-y: auto;
}

.lang-menu {
  padding: 10px;
}

.lang-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 15px;
  border-radius: 6px;
  cursor: pointer;
  color: #333;
  text-decoration: none;
  transition: background 0.3s;
}

.lang-item:hover {
  background: #f5f5f5;
}

.flag-icon {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  object-fit: cover;
}

.notification-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 15px 20px;
  border-bottom: 1px solid #f0f0f0;
  transition: background 0.3s;
  cursor: pointer;
}

.notification-item:hover {
  background: #f9fafb;
}

.notification-item:last-child {
  border-bottom: none;
}

.notif-icon {
  font-size: 24px;
  line-height: 1;
  flex-shrink: 0;
}

.notif-content {
  flex: 1;
}

.notif-content p {
  margin: 0;
  font-size: 14px;
  color: #666;
  line-height: 1.5;
}

.notif-content a {
  color: #2563EB;
  text-decoration: none;
  display: block;
}

.notif-content a:hover {
  color: #1D4ED8;
}

.user-dropdown-menu {
  min-width: 200px;
}

.dropdown-header {
  padding: 15px;
  border-bottom: 1px solid #e0e0e0;
  font-weight: 600;
  color: #333;
}

.dropdown-item {
  padding: 12px 20px;
  color: #666;
  text-decoration: none;
  display: block;
  transition: all 0.3s;
}

.dropdown-item:hover {
  background: #f5f5f5;
  color: #2563EB;
}

/* Dark Mode */
body.dark-theme .nav-icon-btn,
body.dark-theme .btn-primary {
  background: #1a1a2e;
  border-color: #2d2d44;
  color: #d0d0d0;
}

body.dark-theme .nav-icon-btn:hover,
body.dark-theme .btn-primary:hover,
body.dark-theme .btn-primary:focus,
body.dark-theme .btn-primary:active {
  background: #2d2d44 !important;
  border-color: #2563EB !important;
  color: #fff !important;
  box-shadow: none !important;
}

body.dark-theme .lang-item {
  color: #e0e0e0;
}

body.dark-theme .lang-item:hover {
  background: #2d2d44;
}

body.dark-theme .notification-item {
  border-bottom-color: #2d2d44;
}

body.dark-theme .notification-item:hover {
  background: #2d2d44;
}

body.dark-theme .notif-content p {
  color: #d0d0d0;
}

body.dark-theme .notif-content a {
  color: #6EA0FF;
}

body.dark-theme .notif-content a:hover {
  color: #93C5FD;
}

body.dark-theme .dropdown-header {
  border-bottom-color: #2d2d44;
  color: #e0e0e0;
}

body.dark-theme .dropdown-item {
  color: #d0d0d0;
}

body.dark-theme .dropdown-item:hover {
  background: #2d2d44;
  color: #fff;
}

/* Mobile adjustments */
@media (max-width: 768px) {
  /* Hide fullscreen button on mobile */
  .fullscreen-btn {
    display: none !important;
  }

  .btn-text {
    display: none;
  }

  .btn-primary {
    padding: 8px 12px;
    font-size: 13px;
  }

  /* Make POS button look like icon buttons on mobile */
  .nav-right .btn.btn-primary {
    width: 36px;
    height: 36px;
    padding: 0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: #fff;
    color: #2563EB;
    border: 1px solid #e5e7eb;
  }

  .nav-right .btn.btn-primary:hover,
  .nav-right .btn.btn-primary:focus,
  .nav-right .btn.btn-primary:active {
    background: #f9fafb;
    color: #2563EB;
    border-color: #2563EB;
    box-shadow: none;
  }

  .nav-right .btn.btn-primary i {
    font-size: 16px;
    color: inherit;
    line-height: 1;
  }
}

/* Remove outline from header icons when clicked */
.header-icon:focus,
.header-icon:active {
  outline: none !important;
  box-shadow: none !important;
}

.header-icon:focus-visible {
  outline: none !important;
}

/* =========================================================
   Quantro Design System — header accents → blue #2563EB
   Matches "Quantro Tenant Dashboard.dc.html"
   ========================================================= */
.nav-right .btn.btn-primary {
  background: #2563EB !important;
  color: #FFFFFF !important;
  border: 1px solid #2563EB !important;
  font-weight: 600;
  box-shadow: 0 8px 18px -6px rgba(37, 99, 235, 0.45) !important;
}
.nav-right .btn.btn-primary:hover,
.nav-right .btn.btn-primary:focus,
.nav-right .btn.btn-primary:active {
  background: #1D53D0 !important;
  color: #FFFFFF !important;
  border-color: #1D53D0 !important;
}
.nav-right .btn.btn-primary i { color: #FFFFFF !important; }

.nav-icon-btn:hover {
  color: #2563EB !important;
  border-color: #2563EB !important;
}
.nav-right .badge.badge-primary {
  background: #2563EB !important;
  color: #FFFFFF !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header .nav-right .btn.btn-primary {
  box-shadow: none !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header #notif-dd .dropdown-toggle-no-caret {
  border: 1px solid #D9E1EF !important;
  background: #F8FBFF !important;
  color: #1D2940 !important;
  width: 46px !important;
  height: 46px !important;
  align-items: center !important;
  padding-top: 0 !important;
}

body.quantro-dashboard-route .layout-sidebar-large .main-header #notif-dd .badge {
  top: -8px !important;
  right: -4px !important;
  min-width: 20px !important;
  height: 20px !important;
  padding: 0 6px !important;
  border-radius: 999px !important;
  background: #2563EB !important;
  color: #FFFFFF !important;
  font-size: 12px !important;
  font-weight: 800 !important;
}
</style>
