<template>
  <div class="main-content">
    <!-- Loading -->
    <div v-if="loading" class="loading_page spinner spinner-primary mr-3"></div>

    <!-- Dashboard -->
    <div
      v-else-if="!loading && currentUserPermissions && currentUserPermissions.includes('dashboard')"
      ref="dashboardRoot"
      class="dashboard-static dashboard-page-root quantro-dashboard"
      :class="{ 'dashboard-static--mobile-app': isMobileViewport }"
      :style="dashboardFontStyle"
      data-screen-label="Main Dashboard"
    >
      <!-- ========================================================= -->
      <!-- HEADER                                                    -->
      <!-- ========================================================= -->
      <header class="quantro-header">
        <div class="quantro-header-left">
          <h2>{{ isArabic ? 'لوحة التحكم' : 'Dashboard' }}</h2>
          <p class="quantro-welcome-text">
            {{ isArabic ? `أهلاً بعودتك، ${currentUserName} — إليك ملخص اليوم.` : `Welcome back, ${currentUserName} — here's today at a glance.` }}
          </p>
        </div>

        <div class="quantro-header-right">
          <!-- POS -->
          <router-link
            v-if="currentUserPermissions && currentUserPermissions.includes('Pos_view')"
            to="/app/pos"
            class="quantro-pos-btn"
          >
            <lucide-icon name="monitor" />
            <span>{{ isArabic ? 'نقطة البيع' : 'Open POS' }}</span>
          </router-link>

          <!-- Warehouse -->
          <div class="quantro-warehouse-chip">
            <lucide-icon name="shield" />
            <span>{{ selectedWarehouseLabel }}</span>
            <lucide-icon class="quantro-chip-chevron" name="chevron-down" />
          </div>

          <!-- Date Range -->
          <div class="quantro-date-chip" @click="openDatePicker">
            <lucide-icon name="calendar-days" />
            <span>{{ dashboardDateRangeLabel }}</span>
          </div>

          <!-- Language Toggle -->
          <div class="quantro-lang-toggle">
            <button 
              type="button" 
              class="quantro-lang-btn" 
              :class="{ active: !isArabic }" 
              @click="setLocale('en')"
            >EN</button>
            <button 
              type="button" 
              class="quantro-lang-btn quantro-lang-btn--ar" 
              :class="{ active: isArabic }" 
              @click="setLocale('ar')"
            >العربية</button>
          </div>

          <!-- Theme Toggle -->
          <button type="button" class="quantro-icon-btn" @click="toggleDarkMode" :title="isDark ? 'Light Mode' : 'Dark Mode'">
            <lucide-icon :name="isDark ? 'sun' : 'cloud-moon'" />
          </button>

          <!-- Notifications -->
          <router-link
            v-if="currentUserPermissions && currentUserPermissions.includes('Reports_quantity_alerts')"
            to="/app/reports/quantity_alerts"
            class="quantro-icon-btn quantro-bell"
          >
            <lucide-icon name="bell" />
            <span v-if="notificationCount" class="quantro-bell-badge">{{ notificationCount }}</span>
          </router-link>

          <!-- User Profile -->
          <router-link to="/app/profile" class="quantro-user">
            <span class="quantro-user-avatar">
              <img
                v-if="currentUser && currentUser.avatar"
                :src="$imgUrl('avatar', currentUser.avatar)"
                alt="user"
              />
              <template v-else>
                {{ (currentUser && currentUser.username) ? currentUser.username.charAt(0).toUpperCase() : 'U' }}
              </template>
            </span>
            <span class="quantro-user-meta">
              <strong>{{ currentUser && currentUser.username }}</strong>
              <span>{{ isArabic ? 'مدير' : 'Admin' }}</span>
            </span>
          </router-link>
        </div>
      </header>

      <!-- ========================================================= -->
      <!-- CONTENT                                                   -->
      <!-- ========================================================= -->
      <div class="quantro-content">
        <!-- KPI Cards -->
        <div class="quantro-kpi-grid">
          <!-- Revenue -->
          <router-link to="/app/sales/list" class="quantro-kpi-card">
            <div class="quantro-kpi-top">
              <span class="quantro-kpi-icon" style="background: rgba(37, 99, 235, .1); color: #2563EB;">
                <lucide-icon name="dollar-sign" />
              </span>
              <span class="quantro-kpi-label">{{ isArabic ? 'إجمالي الإيرادات' : 'Gross Revenue' }}</span>
            </div>
            <div class="quantro-kpi-value">{{ formatPriceWithSymbol(currentUser && currentUser.currency, report_today.today_sales || 0, 2) }}</div>
            <div class="quantro-kpi-footer">
              <span class="quantro-kpi-trend up">↑ 18.6%</span>
              <span>{{ isArabic ? 'مقارنة بيونيو' : 'vs June' }}</span>
            </div>
            <svg viewBox="0 0 120 26" width="100%" height="26" style="margin-top: 8px;">
              <path d="M2,20 18,16 34,18 50,12 66,14 82,8 98,10 118,4" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round"></path>
            </svg>
          </router-link>

          <!-- Profit -->
          <router-link to="/app/reports/profit_and_loss" class="quantro-kpi-card">
            <div class="quantro-kpi-top">
              <span class="quantro-kpi-icon" style="background: rgba(0, 196, 154, .12); color: #00A882;">
                <lucide-icon name="trending-up" />
              </span>
              <span class="quantro-kpi-label">{{ isArabic ? 'صافي الربح' : 'Net Profit' }}</span>
            </div>
            <div class="quantro-kpi-value">{{ formatPriceWithSymbol(currentUser && currentUser.currency, report_today.today_profit || 0, 2) }}</div>
            <div class="quantro-kpi-footer">
              <span class="quantro-kpi-trend up">↑ 22.4%</span>
              <span>{{ isArabic ? 'مقارنة بيونيو' : 'vs June' }}</span>
            </div>
            <svg viewBox="0 0 120 26" width="100%" height="26" style="margin-top: 8px;">
              <path d="M2,22 18,18 34,20 50,15 66,16 82,10 98,12 118,5" fill="none" stroke="#00C49A" stroke-width="2" stroke-linecap="round"></path>
            </svg>
          </router-link>

          <!-- Orders -->
          <router-link to="/app/sales/list" class="quantro-kpi-card">
            <div class="quantro-kpi-top">
              <span class="quantro-kpi-icon" style="background: rgba(139, 92, 246, .12); color: #8B5CF6;">
                <lucide-icon name="shopping-bag" />
              </span>
              <span class="quantro-kpi-label">{{ isArabic ? 'الطلبات' : 'Orders' }}</span>
            </div>
            <div class="quantro-kpi-value">{{ report_today.today_invoices ? report_today.today_invoices : 0 }}</div>
            <div class="quantro-kpi-footer">
              <span class="quantro-kpi-trend up">↑ 15.3%</span>
              <span>{{ isArabic ? 'مقارنة بيونيو' : 'vs June' }}</span>
            </div>
            <svg viewBox="0 0 120 26" width="100%" height="26" style="margin-top: 8px;">
              <path d="M2,18 18,20 34,14 50,16 66,10 82,13 98,8 118,6" fill="none" stroke="#8B5CF6" stroke-width="2" stroke-linecap="round"></path>
            </svg>
          </router-link>

          <!-- Inventory -->
          <router-link to="/app/reports/stock_report" class="quantro-kpi-card">
            <div class="quantro-kpi-top">
              <span class="quantro-kpi-icon" style="background: rgba(255, 159, 28, .14); color: #E88A00;">
                <lucide-icon name="package" />
              </span>
              <span class="quantro-kpi-label">{{ isArabic ? 'قيمة المخزون' : 'Inventory Value' }}</span>
            </div>
            <div class="quantro-kpi-value">{{ formatPriceWithSymbol(currentUser && currentUser.currency, stock_value.by_cost || 0, 2) }}</div>
            <div class="quantro-kpi-footer">
              <span class="quantro-kpi-trend up">↑ 3.6%</span>
              <span>{{ isArabic ? '٤ مستودعات' : '4 warehouses' }}</span>
            </div>
            <svg viewBox="0 0 120 26" width="100%" height="26" style="margin-top: 8px;">
              <path d="M2,14 18,15 34,12 50,14 66,11 82,12 98,9 118,8" fill="none" stroke="#E88A00" stroke-width="2" stroke-linecap="round"></path>
            </svg>
          </router-link>

          <!-- Stock Alerts -->
          <router-link to="/app/reports/quantity_alerts" class="quantro-kpi-card">
            <div class="quantro-kpi-top">
              <span class="quantro-kpi-icon" style="background: rgba(225, 72, 72, .1); color: #E14848;">
                <lucide-icon name="alert-triangle" />
              </span>
              <span class="quantro-kpi-label">{{ isArabic ? 'تنبيهات المخزون' : 'Stock Alerts' }}</span>
            </div>
            <div class="quantro-kpi-value">{{ stockAlertRows.length }} <span style="font-size: 12px; font-weight: 600; color: var(--q-ink3, #8291A9);">{{ isArabic ? 'عنصر' : 'items' }}</span></div>
            <div class="quantro-kpi-footer">
              <span class="quantro-kpi-trend down">{{ totalStockAlertQuantity }}</span>
              <span>{{ isArabic ? 'غير متوفر' : 'out of stock' }}</span>
            </div>
            <div style="display: flex; gap: 3px; margin-top: 12px;">
              <div style="flex: 24; height: 5px; border-radius: 3px; background: #E14848;"></div>
              <div style="flex: 13; height: 5px; border-radius: 3px; background: #E88A00;"></div>
              <div style="flex: 20; height: 5px; border-radius: 3px; background: var(--q-bd, #E4EAF3);"></div>
            </div>
          </router-link>
        </div>

        <!-- Charts Row -->
        <div class="quantro-main-grid">
          <!-- Sales & Profit Chart -->
          <div class="quantro-chart-card">
            <div class="quantro-chart-header">
              <div>
                <h4>{{ isArabic ? 'اتجاهات المبيعات والأرباح' : 'Sales & Profit Trends' }}</h4>
                <p>{{ isArabic ? 'الأداء اليومي عبر جميع الفروع' : 'Daily performance across all branches' }}</p>
              </div>
              <div class="quantro-chart-actions">
                <span class="quantro-legend-item">
                  <span class="quantro-legend-dot" style="background: #2563EB;"></span>
                  {{ isArabic ? 'المبيعات' : 'Sales' }}
                </span>
                <span class="quantro-legend-item">
                  <span class="quantro-legend-dot" style="background: #00C49A;"></span>
                  {{ isArabic ? 'الربح' : 'Profit' }}
                </span>
                <div class="quantro-chart-tabs">
                  <button class="active">{{ isArabic ? 'يوم' : 'Day' }}</button>
                  <button>{{ isArabic ? 'أسبوع' : 'Week' }}</button>
                  <button>{{ isArabic ? 'شهر' : 'Month' }}</button>
                </div>
              </div>
            </div>
            <div class="quantro-chart-body">
              <apexchart v-if="!loading" type="bar" :height="200" :options="chartSalesOptions" :series="chartSalesSeries"></apexchart>
            </div>
          </div>

          <!-- Top Selling Categories -->
          <div class="quantro-chart-card">
            <div class="quantro-chart-header">
              <h4>{{ isArabic ? 'أعلى الفئات مبيعاً' : 'Top Selling Categories' }}</h4>
            </div>
            <div class="quantro-top-categories">
              <div class="quantro-donut">
                <apexchart v-if="!loading" type="donut" height="150" :options="chartProductOptions" :series="chartProductSeries"></apexchart>
              </div>
              <div class="quantro-category-list">
                <div v-for="(cat, index) in topCategoryRows" :key="'cat-' + index" class="quantro-category-row">
                  <span class="quantro-category-dot" :style="{ background: cat.color }"></span>
                  <span>{{ cat.name }}</span>
                  <strong>{{ cat.percent }}%</strong>
                </div>
              </div>
            </div>
            <div class="quantro-chart-footer">
              <lucide-icon name="trending-up" style="color: #00A882;" />
              <span>{{ isArabic ? 'الإلكترونيات ترتفع ٨٫٢٪ هذا الشهر' : 'Electronics up 8.2% this month' }}</span>
            </div>
          </div>
        </div>

        <!-- Bottom Grid -->
        <div class="quantro-bottom-grid">
          <!-- Recent Transactions -->
          <div class="quantro-table-card">
            <div class="quantro-table-header">
              <h4>{{ isArabic ? 'أحدث المعاملات' : 'Recent Transactions' }}</h4>
              <router-link to="/app/sales/list">{{ isArabic ? 'عرض الكل ←' : 'View all →' }}</router-link>
            </div>
            <div class="quantro-table-scroll">
              <table>
                <thead>
                  <tr>
                    <th>{{ isArabic ? 'الفاتورة' : 'Invoice' }}</th>
                    <th>{{ isArabic ? 'العميل' : 'Customer' }}</th>
                    <th>{{ isArabic ? 'المستودع' : 'Warehouse' }}</th>
                    <th>{{ isArabic ? 'الحالة' : 'Status' }}</th>
                    <th>{{ isArabic ? 'الإجمالي' : 'Total' }}</th>
                    <th>{{ isArabic ? 'التاريخ' : 'Date' }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(sale, index) in recentSaleRows" :key="'rs-' + index">
                    <td><router-link :to="'/app/sales/detail/' + (sale.id || '')">{{ sale.Ref }}</router-link></td>
                    <td>
                      <span class="quantro-avatar-sm" :style="{ background: sale.avatarColor || '#2563EB' }">
                        {{ (sale.client_name || 'U').charAt(0).toUpperCase() }}
                      </span>
                      {{ sale.client_name }}
                    </td>
                    <td>{{ sale.warehouse_name || sale.warehouse || '-' }}</td>
                    <td>
                      <span class="quantro-status-pill" :class="'quantro-status-pill--' + sale.statusTone">
                        {{ sale.payment_status || sale.statut || '-' }}
                      </span>
                    </td>
                    <td><strong>{{ formatPriceWithSymbol(currentUser && currentUser.currency, sale.GrandTotal || 0, 2) }}</strong></td>
                    <td>{{ sale.date || sale.created_at || '-' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Right Column -->
          <div class="quantro-right-column">
            <!-- Quick Actions -->
            <div class="quantro-action-card">
              <h4>{{ isArabic ? 'إجراءات سريعة' : 'Quick Actions' }}</h4>
              <div class="quantro-action-grid">
                <router-link to="/app/pos" class="quantro-action-btn primary">
                  <lucide-icon name="plus" /> {{ isArabic ? 'بيع جديد' : 'New Sale' }}
                </router-link>
                <router-link to="/app/products/store" class="quantro-action-btn">
                  <lucide-icon name="package" /> {{ isArabic ? 'إضافة منتج' : 'Add Product' }}
                </router-link>
                <router-link to="/app/purchases/store" class="quantro-action-btn">
                  <lucide-icon name="receipt-text" /> {{ isArabic ? 'أمر شراء' : 'Purchase Order' }}
                </router-link>
                <router-link to="/app/reports/sales_report" class="quantro-action-btn">
                  <lucide-icon name="bar-chart-2" /> {{ isArabic ? 'تشغيل تقرير' : 'Run Report' }}
                </router-link>
              </div>
            </div>

            <!-- Stock Alerts -->
            <div class="quantro-alert-card">
              <div class="quantro-alert-header">
                <h4>{{ isArabic ? 'تنبيهات المخزون' : 'Stock Alerts' }}</h4>
                <router-link to="/app/reports/quantity_alerts">{{ isArabic ? 'عرض الكل ←' : 'View all →' }}</router-link>
              </div>
              <div v-for="(item, index) in stockAlertRows" :key="'qa-' + index" class="quantro-alert-row">
                <div class="quantro-alert-icon" :style="{ background: item.tileBg || 'rgba(225, 72, 72, .1)', color: item.tileC || '#E14848' }">
                  {{ item.code }}
                </div>
                <div class="quantro-alert-info">
                  <strong>{{ item.name }}</strong>
                  <div class="quantro-alert-bar">
                    <div class="quantro-alert-progress" :style="{ width: item.percent || '0%', background: item.barC || '#E14848' }"></div>
                  </div>
                </div>
                <button class="quantro-alert-reorder">{{ isArabic ? 'إعادة طلب' : 'Reorder' }}</button>
              </div>
            </div>

            <!-- Sales by Branch -->
            <div class="quantro-branch-card">
              <h4>{{ isArabic ? 'المبيعات حسب الفرع' : 'Sales by Branch' }}</h4>
              <div v-for="(branch, index) in branchSales" :key="'br-' + index" class="quantro-branch-row">
                <div class="quantro-branch-label">
                  <span>{{ branch.name }}</span>
                  <strong>{{ formatPriceWithSymbol(currentUser && currentUser.currency, branch.amount || 0, 2) }}</strong>
                </div>
                <div class="quantro-branch-bar">
                  <div class="quantro-branch-progress" :style="{ width: branch.percent + '%' }"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No Permission -->
    <div v-else>
      <div class="welcome-card">
        <div class="welcome-icon">
          <lucide-icon name="home" />
        </div>
        <h3>{{ $t('Welcome_to_your_Dashboard') }}</h3>
        <p class="text-muted">{{ $t('No_dashboard_permission') }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import VueApexCharts from "vue-apexcharts";
import moment from "moment";
import { formatPriceDisplay as formatPriceDisplayHelper, getPriceFormatSetting, getPriceDecimals } from "../../../utils/priceFormat";

export default {
  components: { apexchart: VueApexCharts },
  metaInfo: { title: "Dashboard" },
  data() {
    const end = moment().endOf("day");
    const start = end.clone().subtract(6, "days").startOf("day");
    return {
      dateRange: { startDate: start.toDate(), endDate: end.toDate() },
      startDate: start.format("YYYY-MM-DD"),
      endDate: end.format("YYYY-MM-DD"),
      defaultDateRange: "week",
      today_mode: true,
      sales: [],
      warehouses: [],
      warehouse_id: "",
      stock_alerts: [],
      report_today: {
        today_sales: 0,
        sales_due: 0,
        return_sales: 0,
        today_purchases: 0,
        purchase_due: 0,
        return_purchases: 0,
        today_profit: 0,
        today_invoices: 0,
      },
      products: [],
      customers_top: [],
      loading: true,
      price_format_key: null,
      dashboardSectionOrder: [],
      dashboardFontSize: "",
      dashboardFontFamily: "",
      stock_value: { by_cost: 0, by_retail: 0, by_wholesale: 0 },
      chartSalesSeries: [],
      chartProductSeries: [],
      chartSalesOptions: {},
      chartProductOptions: {},
    };
  },
  computed: {
    ...mapGetters(["currentUserPermissions", "currentUser", "notifs_alert", "show_language"]),
    ...mapGetters("config", ["getThemeMode"]),
    isDark() { return this.getThemeMode && this.getThemeMode.dark; },
    isArabic() { return this.$i18n && this.$i18n.locale === 'ar'; },
    currentUserName() {
      return (this.currentUser && (this.currentUser.username || this.currentUser.name)) || "User";
    },
    dashboardDateRangeLabel() {
      const start = this.startDate ? moment(this.startDate) : null;
      const end = this.endDate ? moment(this.endDate) : null;
      if (!start || !end || !start.isValid() || !end.isValid()) return "";
      return this.isArabic 
        ? `${start.format('D')} – ${end.format('D')} ${end.format('M')} ${end.format('YYYY')}`
        : `${start.format("MMM D, YYYY")} - ${end.format("MMM D, YYYY")}`;
    },
    selectedWarehouseLabel() {
      if (!this.warehouse_id) return this.$t("All_Warehouses") || "All Warehouses";
      const warehouse = (this.warehouses || []).find(item => String(item.id) === String(this.warehouse_id));
      return (warehouse && (warehouse.name || warehouse.label)) || this.$t("warehouse") || "Warehouse";
    },
    notificationCount() {
      const alertCount = Array.isArray(this.notifs_alert) ? this.notifs_alert.length : Number(this.notifs_alert || 0);
      if (alertCount) return alertCount;
      return Array.isArray(this.stock_alerts) ? this.stock_alerts.length : 0;
    },
    totalStockAlertQuantity() {
      return (this.stockAlertRows || []).reduce((sum, item) => sum + Number(item.quantity || 0), 0);
    },
    priceDecimals() { return getPriceDecimals({ store: this.$store }); },
    dashboardFontStyle() {
      const s = {};
      if (this.dashboardFontSize) s.fontSize = this.dashboardFontSize + "px";
      if (this.dashboardFontFamily) s.fontFamily = this.dashboardFontFamily;
      return s;
    },
    topCategoryRows() {
      const colors = ["#2563EB", "#00C49A", "#8B5CF6", "#FF9F1C", "#D4DEEC"];
      const rows = (this.products || []).slice(0, 5);
      const total = rows.reduce((sum, item) => sum + Number(item.total_sales || item.value || 0), 0) || 1;
      return rows.map((item, index) => ({
        name: item.name || item.product_name || "-",
        percent: Math.round((Number(item.total_sales || item.value || 0) / total) * 100),
        color: colors[index] || colors[colors.length - 1],
      }));
    },
    branchSales() {
      return [
        { name: this.isArabic ? 'المستودع الرئيسي' : 'Main Warehouse', amount: 98245, percent: 80 },
        { name: this.isArabic ? 'فرع وسط المدينة' : 'Downtown Branch', amount: 67812, percent: 55 },
        { name: this.isArabic ? 'فرع المطار' : 'Airport Branch', amount: 45760, percent: 37 },
        { name: this.isArabic ? 'المنطقة الصناعية' : 'Industrial Area', amount: 21936, percent: 18 },
      ];
    },
    stockAlertRows() {
      return (this.stock_alerts || []).slice(0, 4).map((item) => {
        const quantity = Number(item.quantity || item.qte || item.qty || 0);
        const alert = Number(item.stock_alert || item.alert_quantity || item.alert || 0);
        const ratio = alert ? quantity / alert : 1;
        const percent = Math.max(0, Math.min(100, Math.round((quantity / alert) * 100))) + '%';
        const barC = ratio <= 0.5 ? '#E14848' : ratio <= 0.85 ? '#E88A00' : '#00C49A';
        const tileBg = ratio <= 0.5 ? 'rgba(225, 72, 72, .1)' : 'rgba(255, 159, 28, .13)';
        const tileC = ratio <= 0.5 ? '#E14848' : '#C77700';
        return {
          code: item.code || item.product_code || "-",
          name: item.name || item.product_name || "-",
          quantity,
          stock_alert: alert,
          percent,
          barC,
          tileBg,
          tileC,
        };
      });
    },
    recentSaleRows() {
      const avatarColors = ['#2563EB', '#00A882', '#8B5CF6', '#E8618C', '#FF9F1C', '#64748B'];
      return (this.sales || []).slice(0, 6).map((item, idx) => {
        const status = String(item.payment_status || item.statut || "").toLowerCase();
        const statusTone = status.includes("paid") && !status.includes("unpaid") ? "paid"
          : status.includes("partial") ? "partial"
          : status.includes("refund") ? "refunded"
          : "unpaid";
        return {
          ...item,
          GrandTotal: Number(item.GrandTotal || item.total || 0),
          statusTone,
          avatarColor: avatarColors[idx % avatarColors.length],
        };
      });
    },
  },
  methods: {
    ...mapActions("config", ["changeThemeMode"]),
    toggleDarkMode() {
      this.changeThemeMode();
      this.applyTheme();
    },
    applyTheme() {
      if (this.getThemeMode && this.getThemeMode.dark) {
        document.body.classList.add("dark-theme");
      } else {
        document.body.classList.remove("dark-theme");
      }
      this.updateCSSVariables();
    },
    updateCSSVariables() {
      const el = this.$refs.dashboardRoot;
      if (!el) return;
      const d = this.isDark;
      const L = {
        '--q-bg': '#F4F7FB',
        '--q-card': '#FFFFFF',
        '--q-card2': '#F6F9FC',
        '--q-ink': '#0B1B33',
        '--q-ink2': '#47586F',
        '--q-ink3': '#8291A9',
        '--q-bd': '#E4EAF3',
        '--q-sh': '0 1px 2px rgba(11,27,51,.04), 0 10px 30px -14px rgba(11,27,51,.10)',
      };
      const D = {
        '--q-bg': '#060D1A',
        '--q-card': '#0C1728',
        '--q-card2': '#111F35',
        '--q-ink': '#EAF1FA',
        '--q-ink2': '#B4C4D9',
        '--q-ink3': '#71839E',
        '--q-bd': '#1C2B45',
        '--q-sh': '0 1px 2px rgba(0,0,0,.35), 0 14px 34px -14px rgba(0,0,0,.5)',
      };
      const vars = d ? D : L;
      for (const k in vars) {
        el.style.setProperty(k, vars[k]);
      }
    },
    setLocale(locale) {
      if (this.$i18n.locale === locale) return;
      this.$i18n.locale = locale;
      this.$store.dispatch("setLanguage", locale);
      if (window.Fire) Fire.$emit("ChangeLanguage");
      window.location.reload();
    },
    formatPriceDisplay(number, dec) {
      try {
        const decimals = this.priceDecimals;
        const n = Number(number || 0);
        const key = this.price_format_key || getPriceFormatSetting({ store: this.$store });
        if (key) this.price_format_key = key;
        return formatPriceDisplayHelper(n, decimals, key || null);
      } catch (e) {
        const n = Number(number || 0);
        return n.toLocaleString(undefined, { maximumFractionDigits: dec || 2 });
      }
    },
    formatPriceWithSymbol(symbol, number, dec) {
      try {
        const safeSymbol = symbol || (this.currentUser && this.currentUser.currency) || "";
        const value = this.formatPriceDisplay(number, dec);
        return safeSymbol ? `${safeSymbol} ${value}` : value;
      } catch (e) {
        const safeSymbol = symbol || "";
        const value = this.formatPriceDisplay(number, dec);
        return safeSymbol ? `${safeSymbol} ${value}` : value;
      }
    },
    all_dashboard_data() {
      this.loading = true;
      this.get_data_loaded();
      axios
        .get(`/dashboard_data?warehouse_id=${this.warehouse_id}&to=${this.endDate}&from=${this.startDate}`)
        .then(response => {
          this.today_mode = false;
          const responseData = response.data;
          const reportData = response.data.report_dashboard.original.report;
          this.report_today = {
            today_sales: Number(reportData.today_sales) || 0,
            sales_due: Number(reportData.sales_due) || 0,
            return_sales: Number(reportData.return_sales) || 0,
            today_purchases: Number(reportData.today_purchases) || 0,
            purchase_due: Number(reportData.purchase_due) || 0,
            return_purchases: Number(reportData.return_purchases) || 0,
            today_profit: Number(reportData.today_profit) || 0,
            today_invoices: Number(reportData.today_invoices) || 0,
          };
          this.warehouses = response.data.warehouses;
          this.stock_alerts = response.data.report_dashboard.original.stock_alert;
          this.products = response.data.report_dashboard.original.products;
          this.sales = response.data.report_dashboard.original.last_sales;

          if (response.data.stock_value) {
            this.stock_value = {
              by_cost: Number(response.data.stock_value.by_cost) || 0,
              by_retail: Number(response.data.stock_value.by_retail) || 0,
              by_wholesale: Number(response.data.stock_value.by_wholesale) || 0,
            };
          }

          // Sales & Purchases Chart
          this.chartSalesSeries = [
            { name: this.$t('Sales'), data: responseData.sales.original.data },
            { name: this.$t('Purchases'), data: responseData.purchases.original.data },
          ];
          this.chartSalesOptions = {
            chart: { type: "bar", toolbar: { show: false }, fontFamily: "inherit" },
            colors: ["#2563EB", "#00C49A"],
            plotOptions: { bar: { horizontal: false, columnWidth: "38%", borderRadius: 8 } },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ["transparent"] },
            xaxis: { categories: responseData.sales.original.days },
            yaxis: {
              title: { text: "" },
              labels: { formatter: (value) => this.formatPriceDisplay(value, 2) },
            },
            fill: { opacity: 1 },
            tooltip: { y: { formatter: (val) => this.formatPriceDisplay(val, 2) } },
            legend: { position: "top", horizontalAlign: "right", fontSize: "13px" },
            grid: { borderColor: "#e0e6ed" },
          };

          // Top Products Chart
          const productData = responseData.product_report.original;
          this.chartProductSeries = productData.map(item => item.value);
          this.chartProductOptions = {
            chart: { type: "donut", fontFamily: "inherit" },
            labels: productData.map(item => item.name),
            colors: ["#2563EB", "#00C49A", "#8B5CF6", "#FF9F1C", "#D4DEEC"],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
              pie: {
                donut: {
                  size: "62%",
                  labels: {
                    show: true,
                    value: { show: true, fontSize: "16px", fontWeight: 800, color: "#071832" },
                    total: { show: true, label: "TOTAL", fontSize: "8px", fontWeight: 600, color: "#8291A9" },
                  },
                },
              },
            },
            tooltip: { y: { formatter: (val) => Math.floor(val) + " " + this.$t('Sales') } },
          };

          this.loading = false;
        })
        .catch(() => {
          this.today_mode = false;
          this.loading = false;
        });
    },
    get_data_loaded() {
      if (this.today_mode) {
        const end = moment().endOf("day");
        let start = end.clone();
        const range = this.defaultDateRange || "week";
        if (range === "today") start = end.clone().startOf("day");
        else if (range === "week") start = end.clone().subtract(6, "days").startOf("day");
        else if (range === "month") start = moment().startOf("month");
        else start = end.clone().subtract(6, "days").startOf("day");
        this.startDate = start.format("YYYY-MM-DD");
        this.endDate = end.format("YYYY-MM-DD");
        this.dateRange = { startDate: start.toDate(), endDate: end.toDate() };
      }
    },
    openDatePicker() {
      // Trigger date picker modal or dropdown
      // You can implement this with vue2-daterange-picker or any other date picker
    },
    loadDefaultDateRangeSetting() {
      return axios
        .get("get_Settings_data")
        .then(response => {
          const settings = (response.data && response.data.settings) || {};
          const value = settings.default_dashboard_date_range;
          if (value === "today" || value === "week" || value === "month") {
            this.defaultDateRange = value;
          } else {
            this.defaultDateRange = "week";
          }
          const raw = settings.dashboard_section_order;
          let order = [];
          try {
            if (raw && typeof raw === "string") order = JSON.parse(raw);
            else if (Array.isArray(raw)) order = raw;
          } catch (e) {}
          this.dashboardSectionOrder = order;
          this.dashboardFontSize = settings.dashboard_font_size || "";
          this.dashboardFontFamily = settings.dashboard_font_family || "";
          return this.defaultDateRange;
        })
        .catch(() => {
          this.defaultDateRange = "week";
          return "week";
        });
    },
  },
  async mounted() {
    if (typeof document !== "undefined") {
      document.body.classList.add("quantro-dashboard-route");
    }
    const range = await this.loadDefaultDateRangeSetting();
    this.defaultDateRange = range;
    await this.all_dashboard_data();
    this.applyTheme();
  },
  beforeDestroy() {
    if (typeof document !== "undefined") {
      document.body.classList.remove("quantro-dashboard-route");
      document.body.classList.remove("dark-theme");
    }
  },
};
</script>

<style>
/* ================================================================
   QUANTRO DASHBOARD — COMPLETE STYLES (No Sidebar)
   ================================================================ */

/* Base styles */
.quantro-dashboard {
  background: var(--q-bg, #F4F7FB) !important;
  color: var(--q-ink, #0B1B33) !important;
  font-family: 'IBM Plex Sans', system-ui, sans-serif !important;
  font-size: 13px !important;
  padding: 0 0 28px !important;
  min-height: 100vh;
}

/* ================================================================
   HEADER
   ================================================================ */
.quantro-header {
  display: flex;
  align-items: center;
  gap: 14px;
  min-height: 82px;
  padding: 0 32px;
  background: var(--q-card, #FFFFFF);
  border-bottom: 1px solid var(--q-bd, #E4EAF3);
  margin-bottom: 0;
  flex-wrap: nowrap;
  position: sticky;
  top: 0;
  z-index: 5;
  box-sizing: border-box;
}

.quantro-header-left {
  flex: 1 1 360px;
  min-width: 280px;
}

.quantro-header-left h2 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 17px;
  letter-spacing: -0.3px;
  margin: 0;
  color: var(--q-ink, #0B1B33);
}

.quantro-welcome-text {
  color: var(--q-ink3, #8291A9);
  font-size: 11px;
  margin-top: 1px;
}

.quantro-header-right {
  display: flex;
  align-items: center;
  gap: 8px;
  flex: 1;
  justify-content: flex-end;
  flex-wrap: nowrap;
  min-width: 0;
}

.quantro-pos-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  height: 44px;
  min-width: 138px;
  padding: 0 20px;
  border-radius: 12px;
  background: #2563EB;
  color: #FFFFFF;
  border: 1px solid #2563EB;
  box-shadow: 0 12px 22px -12px rgba(37, 99, 235, 0.75);
  font-size: 13px;
  font-weight: 700;
  line-height: 1;
  text-decoration: none;
  white-space: nowrap;
  box-sizing: border-box;
}

.quantro-pos-btn:hover {
  background: #1D53D0;
  border-color: #1D53D0;
  color: #FFFFFF;
  text-decoration: none;
}

.quantro-pos-btn svg {
  width: 16px;
  height: 16px;
}

.quantro-warehouse-chip {
  display: flex;
  align-items: center;
  gap: 9px;
  background: var(--q-card2, #F6F9FC);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 10px;
  padding: 0 14px;
  color: var(--q-ink, #0B1B33);
  font-size: 12px;
  font-weight: 700;
  min-width: 190px;
  height: 44px;
  box-sizing: border-box;
  white-space: nowrap;
}

.quantro-warehouse-chip svg {
  width: 16px;
  height: 16px;
  color: #2563EB;
}

.quantro-warehouse-chip .quantro-chip-chevron {
  width: 14px;
  height: 14px;
  margin-inline-start: auto;
  color: var(--q-ink, #0B1B33);
}

.quantro-date-chip {
  display: flex;
  align-items: center;
  gap: 8px;
  background: var(--q-card2, #F6F9FC);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 10px;
  padding: 8px 14px;
  font-weight: 600;
  font-size: 12px;
  color: var(--q-ink, #0B1B33);
  cursor: pointer;
  height: 44px;
  white-space: nowrap;
  box-sizing: border-box;
}

.quantro-date-chip svg {
  color: #2563EB;
}

.quantro-lang-toggle {
  display: flex;
  background: var(--q-card2, #F6F9FC);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 10px;
  padding: 3px;
  gap: 2px;
  height: 44px;
  box-sizing: border-box;
  flex: 0 0 auto;
}

.quantro-lang-btn {
  border: none;
  cursor: pointer;
  font-family: inherit;
  font-weight: 600;
  font-size: 11.5px;
  padding: 6px 11px;
  border-radius: 8px;
  background: transparent;
  color: var(--q-ink3, #8291A9);
  transition: all 0.2s;
}

.quantro-lang-btn.active {
  background: #FFFFFF;
  color: #2563EB;
  box-shadow: 0 1px 4px rgba(11, 27, 51, .12);
}

body.dark-theme .quantro-lang-btn.active {
  background: #1B3050;
  color: #6EA0FF;
}

.quantro-lang-btn--ar {
  font-family: 'IBM Plex Sans Arabic', sans-serif;
}

.quantro-icon-btn {
  border: 1px solid var(--q-bd, #E4EAF3);
  background: var(--q-card2, #F6F9FC);
  border-radius: 10px;
  padding: 8px 10px;
  cursor: pointer;
  color: var(--q-ink2, #47586F);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  transition: all 0.2s;
  width: 44px;
  height: 44px;
  padding: 0;
  flex: 0 0 44px;
}

.quantro-icon-btn:hover {
  border-color: #2563EB;
  color: #2563EB;
}

.quantro-bell-badge {
  position: absolute;
  top: -4px;
  inset-inline-end: -4px;
  background: #2563EB;
  color: #fff;
  font-size: 9px;
  font-weight: 700;
  border-radius: 8px;
  padding: 1px 5px;
  min-width: 18px;
  text-align: center;
}

.quantro-user {
  display: flex;
  align-items: center;
  gap: 9px;
  cursor: pointer;
  color: var(--q-ink, #0B1B33);
  text-decoration: none;
  min-width: 154px;
  max-width: 178px;
  height: 44px;
  overflow: hidden;
  flex: 0 0 auto;
}

.quantro-user-avatar {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  background: #2563EB;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 13px;
  overflow: hidden;
  flex-shrink: 0;
}

.quantro-user-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.quantro-user-meta strong {
  font-weight: 600;
  font-size: 12px;
  display: block;
  color: var(--q-ink, #0B1B33);
  max-width: 112px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.quantro-user-meta span {
  color: var(--q-ink3, #8291A9);
  font-size: 10px;
}

/* ================================================================
   CONTENT
   ================================================================ */
.quantro-content {
  display: flex;
  flex-direction: column;
  gap: 18px;
  padding: 28px 32px 0;
}

/* ================================================================
   KPI CARDS
   ================================================================ */
.quantro-kpi-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 14px;
}

.quantro-kpi-card {
  background: var(--q-card, #fff);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 16px;
  padding: 16px 17px;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11, 27, 51, .04));
  text-decoration: none;
  color: var(--q-ink, #0B1B33);
  transition: all 0.2s;
  display: flex;
  flex-direction: column;
}

.quantro-kpi-card:hover {
  transform: translateY(-2px);
  border-color: #2563EB;
  box-shadow: 0 8px 24px -12px rgba(37, 99, 235, 0.3);
}

.quantro-kpi-top {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
}

.quantro-kpi-icon {
  width: 26px;
  height: 26px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.quantro-kpi-icon svg {
  width: 13px;
  height: 13px;
}

.quantro-kpi-label {
  color: var(--q-ink3, #8291A9);
  font-size: 11px;
  font-weight: 500;
}

.quantro-kpi-value {
  font-family: 'Sora', sans-serif;
  font-weight: 800;
  font-size: 22px;
  letter-spacing: -0.5px;
  margin: 4px 0 6px;
  color: var(--q-ink, #0B1B33);
}

.quantro-kpi-footer {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: var(--q-ink3, #8291A9);
  margin-top: auto;
}

.quantro-kpi-trend {
  font-weight: 700;
}

.quantro-kpi-trend.up {
  color: #0BA47E;
}

.quantro-kpi-trend.down {
  color: #E14848;
}

/* ================================================================
   MAIN GRID
   ================================================================ */
.quantro-main-grid {
  display: grid;
  grid-template-columns: 1.9fr 1fr;
  gap: 16px;
}

.quantro-chart-card {
  background: var(--q-card, #fff);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 16px;
  padding: 19px 20px;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11, 27, 51, .04));
}

.quantro-chart-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  flex-wrap: wrap;
  margin-bottom: 12px;
}

.quantro-chart-header h4 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 14px;
  margin: 0;
  color: var(--q-ink, #0B1B33);
}

.quantro-chart-header p {
  color: var(--q-ink3, #8291A9);
  font-size: 11px;
  margin: 1px 0 0;
}

.quantro-chart-actions {
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
}

.quantro-legend-item {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 11px;
  color: var(--q-ink2, #47586F);
}

.quantro-legend-dot {
  width: 9px;
  height: 9px;
  border-radius: 3px;
}

.quantro-chart-tabs {
  display: flex;
  background: var(--q-card2, #F6F9FC);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 9px;
  padding: 2px;
  gap: 2px;
  font-size: 11px;
  font-weight: 600;
}

.quantro-chart-tabs button {
  border: none;
  background: transparent;
  padding: 5px 12px;
  border-radius: 7px;
  cursor: pointer;
  color: var(--q-ink3, #8291A9);
  font-weight: 600;
  font-size: 11px;
  transition: all 0.2s;
}

.quantro-chart-tabs button.active {
  background: #2563EB;
  color: #fff;
}

.quantro-chart-body {
  min-height: 200px;
}

/* Top Categories */
.quantro-top-categories {
  display: flex;
  align-items: center;
  gap: 18px;
  margin-top: 6px;
}

.quantro-donut {
  flex-shrink: 0;
  width: 120px;
  height: 120px;
}

.quantro-category-list {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 9px;
  font-size: 11.5px;
}

.quantro-category-row {
  display: flex;
  align-items: center;
  gap: 7px;
  color: var(--q-ink2, #47586F);
}

.quantro-category-dot {
  width: 8px;
  height: 8px;
  border-radius: 3px;
  flex-shrink: 0;
}

.quantro-category-row strong {
  margin-inline-start: auto;
  font-weight: 700;
  color: var(--q-ink, #0B1B33);
}

.quantro-chart-footer {
  margin-top: 14px;
  padding-top: 13px;
  border-top: 1px solid var(--q-bd, #E4EAF3);
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 11px;
  color: var(--q-ink2, #47586F);
}

/* ================================================================
   BOTTOM GRID
   ================================================================ */
.quantro-bottom-grid {
  display: grid;
  grid-template-columns: 1.9fr 1fr;
  gap: 16px;
  align-items: start;
}

/* Table Card */
.quantro-table-card {
  background: var(--q-card, #fff);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 16px;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11, 27, 51, .04));
  overflow: hidden;
}

.quantro-table-header {
  display: flex;
  align-items: center;
  padding: 17px 20px 13px;
  border-bottom: 1px solid var(--q-bd, #E4EAF3);
}

.quantro-table-header h4 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 14px;
  margin: 0;
  color: var(--q-ink, #0B1B33);
}

.quantro-table-header a {
  margin-inline-start: auto;
  font-size: 11.5px;
  font-weight: 600;
  color: #2563EB;
  text-decoration: none;
}

.quantro-table-scroll {
  overflow-x: auto;
  padding: 0 20px;
}

.quantro-table-scroll table {
  width: 100%;
  border-collapse: collapse;
  font-size: 12px;
}

.quantro-table-scroll th {
  text-align: left;
  padding: 10px 0 8px;
  color: var(--q-ink3, #8291A9);
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  border-bottom: 1px solid var(--q-bd, #E4EAF3);
}

.quantro-table-scroll td {
  padding: 11px 0;
  border-bottom: 1px solid var(--q-bd, #E4EAF3);
  color: var(--q-ink, #0B1B33);
  vertical-align: middle;
}

.quantro-table-scroll tr:last-child td {
  border-bottom: none;
}

.quantro-table-scroll a {
  color: #2563EB;
  font-weight: 600;
  text-decoration: none;
}

.quantro-avatar-sm {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  height: 24px;
  border-radius: 8px;
  color: #fff;
  font-weight: 700;
  font-size: 10px;
  margin-inline-end: 8px;
}

.quantro-status-pill {
  display: inline-block;
  padding: 3px 9px;
  border-radius: 20px;
  font-size: 10.5px;
  font-weight: 600;
}

.quantro-status-pill--paid {
  background: rgba(0, 196, 154, .13);
  color: #0BA47E;
}

.quantro-status-pill--partial {
  background: rgba(37, 99, 235, .12);
  color: #2563EB;
}

.quantro-status-pill--unpaid {
  background: rgba(225, 72, 72, .1);
  color: #E14848;
}

.quantro-status-pill--refunded {
  background: rgba(225, 72, 72, .1);
  color: #E14848;
}

/* Right Column */
.quantro-right-column {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

/* Quick Actions */
.quantro-action-card {
  background: var(--q-card, #fff);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 16px;
  padding: 17px 18px;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11, 27, 51, .04));
}

.quantro-action-card h4 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 14px;
  margin: 0 0 12px;
  color: var(--q-ink, #0B1B33);
}

.quantro-action-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 9px;
}

.quantro-action-btn {
  display: flex;
  align-items: center;
  gap: 9px;
  padding: 12px 13px;
  border-radius: 11px;
  background: var(--q-card2, #F6F9FC);
  border: 1px solid var(--q-bd, #E4EAF3);
  color: var(--q-ink, #0B1B33);
  font-weight: 600;
  font-size: 12px;
  text-decoration: none;
  transition: all 0.2s;
  cursor: pointer;
}

.quantro-action-btn:hover {
  border-color: #2563EB;
  color: #2563EB;
}

.quantro-action-btn.primary {
  background: #2563EB;
  border-color: #2563EB;
  color: #fff;
  box-shadow: 0 8px 18px -6px rgba(37, 99, 235, .45);
}

.quantro-action-btn.primary:hover {
  background: #1D53D0;
  border-color: #1D53D0;
}

/* Stock Alerts */
.quantro-alert-card {
  background: var(--q-card, #fff);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 16px;
  padding: 17px 18px;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11, 27, 51, .04));
}

.quantro-alert-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}

.quantro-alert-header h4 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 14px;
  margin: 0;
  color: var(--q-ink, #0B1B33);
}

.quantro-alert-header a {
  font-size: 11.5px;
  font-weight: 600;
  color: #2563EB;
  text-decoration: none;
}

.quantro-alert-row {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 11px 0;
  border-bottom: 1px solid var(--q-bd, #E4EAF3);
}

.quantro-alert-row:last-child {
  border-bottom: none;
}

.quantro-alert-icon {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 11px;
  flex-shrink: 0;
}

.quantro-alert-info {
  flex: 1;
  min-width: 0;
}

.quantro-alert-info strong {
  font-size: 12px;
  color: var(--q-ink, #0B1B33);
  display: block;
}

.quantro-alert-bar {
  width: 100%;
  height: 5px;
  border-radius: 3px;
  background: var(--q-bd, #E4EAF3);
  margin-top: 5px;
  overflow: hidden;
}

.quantro-alert-progress {
  height: 100%;
  border-radius: 3px;
  transition: width 0.3s;
}

.quantro-alert-reorder {
  border: 1px solid #2563EB;
  color: #2563EB;
  background: transparent;
  padding: 6px 11px;
  border-radius: 8px;
  font-size: 10.5px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  flex-shrink: 0;
}

.quantro-alert-reorder:hover {
  background: #2563EB;
  color: #fff;
}

/* Sales by Branch */
.quantro-branch-card {
  background: var(--q-card, #fff);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 16px;
  padding: 17px 18px;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11, 27, 51, .04));
}

.quantro-branch-card h4 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 14px;
  margin: 0 0 13px;
  color: var(--q-ink, #0B1B33);
}

.quantro-branch-row {
  margin-bottom: 11px;
}

.quantro-branch-row:last-child {
  margin-bottom: 0;
}

.quantro-branch-label {
  display: flex;
  justify-content: space-between;
  font-size: 11.5px;
  color: var(--q-ink2, #47586F);
  margin-bottom: 5px;
}

.quantro-branch-label strong {
  color: var(--q-ink, #0B1B33);
  font-weight: 700;
}

.quantro-branch-bar {
  height: 6px;
  border-radius: 3px;
  background: var(--q-bd, #E4EAF3);
  overflow: hidden;
}

.quantro-branch-progress {
  height: 100%;
  border-radius: 3px;
  background: #2563EB;
}

/* ================================================================
   DARK THEME OVERRIDES
   ================================================================ */
body.dark-theme .quantro-dashboard {
  background: #060D1A !important;
}

body.dark-theme .quantro-search,
body.dark-theme .quantro-warehouse-chip,
body.dark-theme .quantro-date-chip,
body.dark-theme .quantro-lang-toggle,
body.dark-theme .quantro-icon-btn {
  border-color: #1C2B45;
}

body.dark-theme .quantro-chart-tabs button.active {
  background: #2563EB;
}

body.dark-theme .quantro-kpi-card,
body.dark-theme .quantro-chart-card,
body.dark-theme .quantro-table-card,
body.dark-theme .quantro-action-card,
body.dark-theme .quantro-alert-card,
body.dark-theme .quantro-branch-card {
  background: #0C1728;
  border-color: #1C2B45;
}

body.dark-theme .quantro-kpi-value,
body.dark-theme .quantro-chart-header h4,
body.dark-theme .quantro-table-header h4,
body.dark-theme .quantro-action-card h4,
body.dark-theme .quantro-alert-header h4,
body.dark-theme .quantro-branch-card h4,
body.dark-theme .quantro-category-row strong,
body.dark-theme .quantro-branch-label strong {
  color: #EAF1FA;
}

body.dark-theme .quantro-kpi-label,
body.dark-theme .quantro-welcome-text,
body.dark-theme .quantro-chart-header p,
body.dark-theme .quantro-kpi-footer {
  color: #71839E;
}

body.dark-theme .quantro-user-meta strong {
  color: #EAF1FA;
}

body.dark-theme .quantro-user-meta span {
  color: #71839E;
}

body.dark-theme .quantro-search-shortcut {
  background: #111F35;
  border-color: #1C2B45;
}

/* ================================================================
   RESPONSIVE
   ================================================================ */
@media (max-width: 1399px) {
  .quantro-kpi-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 1199px) {
  .quantro-main-grid,
  .quantro-bottom-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 767px) {
  .quantro-header {
    flex-direction: column;
    align-items: stretch;
    gap: 10px;
  }

  .quantro-header-right {
    flex-wrap: wrap;
    justify-content: stretch;
  }

  .quantro-search {
    flex: 1;
    min-width: 0;
  }

  .quantro-date-chip {
    flex: 1;
    min-width: 0;
  }

  .quantro-dashboard {
    padding: 0 14px 28px !important;
  }

  .quantro-kpi-grid {
    grid-template-columns: 1fr 1fr;
  }

  .quantro-top-categories {
    flex-direction: column;
    align-items: stretch;
  }

  .quantro-donut {
    margin: 0 auto;
  }

  .quantro-action-grid {
    grid-template-columns: 1fr 1fr;
  }

  .quantro-table-scroll {
    padding: 0 14px;
  }

  .quantro-table-scroll table {
    font-size: 11px;
  }

  .quantro-table-scroll th,
  .quantro-table-scroll td {
    padding: 8px 4px;
  }

  .quantro-avatar-sm {
    width: 20px;
    height: 20px;
    font-size: 8px;
    margin-inline-end: 4px;
  }

  .quantro-user-meta {
    display: none;
  }
}

@media (max-width: 480px) {
  .quantro-kpi-grid {
    grid-template-columns: 1fr;
  }

  .quantro-action-grid {
    grid-template-columns: 1fr;
  }
}

/* ================================================================
   ABSOLUTE LAST OVERRIDE
   ================================================================ */
body.quantro-dashboard-route .quantro-dashboard {
  background: var(--q-bg, #F4F7FB) !important;
  padding: 0 26px 28px !important;
  min-height: 100vh !important;
}

body.quantro-dashboard-route .quantro-kpi-grid {
  display: grid !important;
  grid-template-columns: repeat(5, 1fr) !important;
  gap: 14px !important;
}

body.quantro-dashboard-route .quantro-main-grid {
  display: grid !important;
  grid-template-columns: 1.9fr 1fr !important;
  gap: 16px !important;
}

body.quantro-dashboard-route .quantro-bottom-grid {
  display: grid !important;
  grid-template-columns: 1.9fr 1fr !important;
  gap: 16px !important;
  align-items: start !important;
}

@media (max-width: 1399px) {
  body.quantro-dashboard-route .quantro-kpi-grid {
    grid-template-columns: repeat(3, 1fr) !important;
  }
}

@media (max-width: 1199px) {
  body.quantro-dashboard-route .quantro-main-grid,
  body.quantro-dashboard-route .quantro-bottom-grid {
    grid-template-columns: 1fr !important;
  }
}

@media (max-width: 767px) {
  body.quantro-dashboard-route .quantro-dashboard {
    padding: 0 14px 28px !important;
  }
  body.quantro-dashboard-route .quantro-kpi-grid {
    grid-template-columns: 1fr 1fr !important;
  }
}

@media (max-width: 480px) {
  body.quantro-dashboard-route .quantro-kpi-grid {
    grid-template-columns: 1fr !important;
  }
}
</style>
