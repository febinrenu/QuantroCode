<template>
  <div class="app-admin-wrap layout-sidebar-large clearfix" :class="{ 
    'vertical-layout': getSidebarLayout === 'vertical',
    'vertical-collapsed': getSidebarLayout === 'vertical' && getVerticalSidebarCollapsed,
    'tenant-dashboard-layout': isTenantDashboard
  }">
    <!-- Conditional Top Navigation -->
    <vertical-top-nav v-if="getSidebarLayout === 'vertical'" />
    <top-nav v-else />

    <!-- Conditional Sidebar Rendering -->
    <vertical-sidebar v-if="getSidebarLayout === 'vertical'" />
    <sidebar v-else />

    <main :class="{ 'with-vertical-sidebar': getSidebarLayout === 'vertical' }">
      <div
        :class="{ 
          'sidenav-open': getSideBarToggleProperties.isSideNavOpen && getSidebarLayout !== 'vertical',
          'with-vertical-topnav': getSidebarLayout === 'vertical'
        }"
        class="main-content-wrap d-flex flex-column flex-grow-1"
      >
        <transition name="page" mode="out-in">
          <router-view />
        </transition>

        <div class="flex-grow-1"></div>
        <appFooter />
      </div>
    </main>
  </div>
</template>

<script>
import Sidebar from "./Sidebar";
import VerticalSidebar from "./VerticalSidebar";
import TopNav from "./TopNav";
import VerticalTopNav from "./VerticalTopNav";
import appFooter from "../common/footer";
import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    Sidebar,
    VerticalSidebar,
    TopNav,
    VerticalTopNav,
    appFooter,
  },
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["getSideBarToggleProperties", "getSidebarLayout", "getVerticalSidebarCollapsed"]),
    isTenantDashboard() {
      return this.$route && this.$route.path === "/app/dashboard";
    },
  },
  watch: {
    isTenantDashboard: {
      immediate: true,
      handler(val) {
        if (typeof document === "undefined") return;
        document.body.classList.toggle("quantro-dashboard-route", !!val);
      },
    },
  },
  methods: {},
};
</script>
<style scoped>
/* Layout adjustments for vertical sidebar */
.vertical-layout main.with-vertical-sidebar {
  margin-left: 250px;
  transition: margin-left 0.3s ease;
}

.vertical-layout.vertical-collapsed main.with-vertical-sidebar {
  margin-left: 0;
}

/* Adjust content for vertical topnav */
.with-vertical-topnav {
  /* padding-top removed for flush layout */
}

/* Mobile & Tablet adjustments */
@media (max-width: 1024px) {
  .vertical-layout main.with-vertical-sidebar {
    margin-left: 0;
  }
}

/* RTL Support */
html[dir="rtl"] .vertical-layout main.with-vertical-sidebar {
  margin-left: 0;
  margin-right: 250px;
}

html[dir="rtl"] .vertical-layout.vertical-collapsed main.with-vertical-sidebar {
  margin-right: 70px;
}

.tenant-dashboard-layout main {
  margin: 0 !important;
}

.tenant-dashboard-layout .main-content-wrap,
.tenant-dashboard-layout .main-content-wrap.sidenav-open {
  width: calc(100% - 250px) !important;
  margin-left: 250px !important;
  margin-top: 0 !important;
  padding: 0 !important;
  float: none !important;
  background: #f4f7fb !important;
}

/* Desktop: the dashboard renders its own top header, so hide the global top bar */
@media (min-width: 992px) {
  .tenant-dashboard-layout.vertical-layout .vertical-top-nav {
    display: none !important;
  }
}
html[dir="rtl"] .tenant-dashboard-layout .main-content-wrap,
html[dir="rtl"] .tenant-dashboard-layout .main-content-wrap.sidenav-open {
  margin-left: 0 !important;
  margin-right: 250px !important;
}

.tenant-dashboard-layout .main-content-wrap > .flex-grow-1,
.tenant-dashboard-layout .main-content-wrap > .footer_wrap {
  display: none !important;
}

@media (max-width: 991px) {
  .tenant-dashboard-layout .main-content-wrap,
  .tenant-dashboard-layout .main-content-wrap.sidenav-open {
    width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    margin-top: 70px !important;
  }
}
</style>
