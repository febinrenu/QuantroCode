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
      <header
        class="quantro-header"
        style="height: auto !important; min-height: 0 !important; max-height: none !important; padding: 14px 26px !important; gap: 12px !important;"
      >
        <div
          class="quantro-header-left"
          style="flex: 0 1 520px !important; min-width: 260px !important; max-width: 520px !important; overflow: hidden !important;"
        >
          <h2>{{ isArabic ? 'لوحة التحكم' : 'Dashboard' }}</h2>
          <p
            class="quantro-welcome-text"
            style="overflow: hidden !important; text-overflow: ellipsis !important; white-space: nowrap !important;"
          >
            {{ isArabic ? `أهلاً بعودتك، ${currentUserName} — إليك ملخص اليوم.` : `Welcome back, ${currentUserName} — here's today at a glance.` }}
          </p>
        </div>

        <div
          class="quantro-header-right"
          style="display: flex !important; align-items: center !important; justify-content: flex-end !important; flex: 0 0 auto !important; margin-left: auto !important; gap: 12px !important; flex-wrap: nowrap !important; min-width: max-content !important;"
        >
          <!-- POS -->
          <router-link
            v-if="currentUserPermissions && currentUserPermissions.includes('Pos_view')"
            to="/app/pos"
            class="quantro-pos-btn"
            style="display: inline-flex !important; align-items: center !important; justify-content: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; padding: 9px 16px !important; border-radius: 10px !important; gap: 8px !important; font-size: 12px !important; font-weight: 600 !important; white-space: nowrap !important;"
          >
            <lucide-icon name="monitor" />
            <span>{{ isArabic ? 'نقطة البيع' : 'Open POS' }}</span>
          </router-link>

          <!-- Warehouse -->
          <v-select
            v-model="warehouse_id"
            :reduce="option => option.value"
            :options="warehouseOptions"
            :clearable="false"
            :searchable="false"
            class="quantro-warehouse-select"
            style="display: inline-flex !important; align-items: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; padding: 8px 12px !important; border-radius: 10px !important; gap: 7px !important; font-size: 12px !important; font-weight: 600 !important; white-space: nowrap !important;"
            @input="onWarehouseChange"
          >
            <template v-slot:selected-option="option">
              <lucide-icon name="shield" />
              <span>{{ option ? option.label : selectedWarehouseLabel }}</span>
            </template>
            <template v-slot:option="option">
              <span>{{ option.label }}</span>
            </template>
          </v-select>

          <!-- Date Range -->
          <date-range-picker
            v-model="dateRange"
            :autoApply="true"
            :showDropdowns="true"
            :opens="'left'"
            class="quantro-date-picker"
            @update="onDateRangeUpdate"
          >
            <template v-slot:input>
              <button
                type="button"
                class="quantro-date-chip"
                style="display: inline-flex !important; align-items: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; padding: 8px 12px !important; border-radius: 10px !important; gap: 7px !important; font-size: 12px !important; font-weight: 600 !important; white-space: nowrap !important;"
              >
                <lucide-icon name="calendar-days" />
                <span>{{ dashboardDateRangeLabel }}</span>
              </button>
            </template>
          </date-range-picker>

          <!-- Language Toggle -->
          <div
            class="quantro-lang-toggle"
            style="display: inline-flex !important; align-items: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; padding: 3px !important; border-radius: 10px !important; gap: 2px !important; white-space: nowrap !important;"
          >
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
          <button
            type="button"
            class="quantro-icon-btn"
            style="display: inline-flex !important; align-items: center !important; justify-content: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; padding: 8px 10px !important; border-radius: 10px !important;"
            @click="toggleDarkMode"
            :title="isDark ? 'Light Mode' : 'Dark Mode'"
          >
            <lucide-icon :name="isDark ? 'sun' : 'cloud-moon'" />
          </button>

          <!-- Notifications -->
          <router-link
            v-if="currentUserPermissions && currentUserPermissions.includes('Reports_quantity_alerts')"
            to="/app/reports/quantity_alerts"
            class="quantro-icon-btn quantro-bell"
            style="display: inline-flex !important; align-items: center !important; justify-content: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; padding: 8px 10px !important; border-radius: 10px !important;"
          >
            <lucide-icon name="bell" />
            <span v-if="notificationCount" class="quantro-bell-badge">{{ notificationCount }}</span>
          </router-link>

          <!-- User Profile -->
          <router-link
            to="/app/profile"
            class="quantro-user"
            style="display: inline-flex !important; align-items: center !important; flex: 0 0 auto !important; width: auto !important; min-width: 0 !important; max-width: none !important; height: auto !important; min-height: 0 !important; max-height: none !important; gap: 9px !important; white-space: nowrap !important;"
          >
            <span
              class="quantro-user-avatar"
              style="width: 34px !important; min-width: 34px !important; max-width: 34px !important; height: 34px !important; min-height: 34px !important; max-height: 34px !important; border-radius: 10px !important; background: var(--primary-color, #2563eb) !important;"
            >
              {{ (currentUser && currentUser.username) ? currentUser.username.charAt(0).toUpperCase() : 'U' }}
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
        <div class="quantro-kpi-grid quantro-kpi-grid--reference">
          <router-link v-for="card in referenceKpis" :key="card.key" :to="card.to" class="quantro-kpi-card quantro-kpi-card--reference">
            <div class="quantro-kpi-top">
              <span class="quantro-kpi-icon" :style="{ background: card.bg, color: card.color }">
                <lucide-icon :name="card.icon" />
              </span>
              <span class="quantro-kpi-label">{{ card.label }}</span>
              <span class="quantro-kpi-trend" :class="card.trendTone">{{ card.trend }}</span>
            </div>
            <div class="quantro-kpi-value">{{ card.value }}</div>
            <div class="quantro-kpi-footer quantro-kpi-footer--split">
              <span>{{ card.footerLabel }}</span>
              <strong :style="{ color: card.footerColor }">{{ card.footerValue }}</strong>
            </div>
          </router-link>
        </div>

        <div class="quantro-main-grid quantro-main-grid--reference">
          <div class="quantro-chart-card quantro-chart-card--sales">
            <div class="quantro-chart-header">
              <div>
                <h4>{{ isArabic ? 'المبيعات والمشتريات' : 'Sales & Purchases' }}</h4>
                <p>{{ isArabic ? 'آخر ٧ أيام' : 'Last 7 days' }}</p>
              </div>
              <div class="quantro-chart-actions">
                <span class="quantro-legend-item"><span class="quantro-legend-dot" style="background:#2563EB"></span>{{ isArabic ? 'المبيعات' : 'Sales' }}</span>
                <span class="quantro-legend-item"><span class="quantro-legend-dot" style="background:#00C49A"></span>{{ isArabic ? 'المشتريات' : 'Purchases' }}</span>
              </div>
            </div>
            <div class="quantro-chart-body quantro-chart-body--large">
              <apexchart v-if="!loading" type="bar" :height="270" :options="chartSalesOptions" :series="chartSalesSeries"></apexchart>
            </div>
          </div>

          <div class="quantro-chart-card quantro-products-card">
            <div class="quantro-chart-header">
              <h4>{{ isArabic ? 'أكثر المنتجات مبيعاً' : 'Top Selling Products' }}</h4>
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
            <div v-if="topProductInsight" class="quantro-chart-footer">
              <lucide-icon name="trending-up" style="color:#00A882" />
              <span>{{ topProductInsight }}</span>
            </div>
          </div>
        </div>

        <div class="quantro-reference-grid-3">
          <div class="quantro-panel-card">
            <h4>{{ isArabic ? 'المبيعات حسب طريقة الدفع' : 'Sales by Payment' }}</h4>
            <div class="quantro-payment-list">
              <div v-for="row in paymentRows" :key="row.name" class="quantro-payment-row">
                <div class="quantro-payment-meta">
                  <span>{{ row.name }}</span>
                  <strong>{{ row.amount }} · {{ row.percent }}%</strong>
                </div>
                <div class="quantro-payment-bar"><span :style="{ width: row.percent + '%', background: row.color }"></span></div>
              </div>
            </div>
          </div>

          <div class="quantro-panel-card">
            <h4>{{ isArabic ? 'قيمة المخزون' : 'Stock Value' }}</h4>
            <div class="quantro-stock-value-list">
              <div v-for="item in stockValueRows" :key="item.label" class="quantro-stock-value-row">
                <span class="quantro-stock-value-icon" :style="{ background: item.bg, color: item.color }"><lucide-icon :name="item.icon" /></span>
                <span>{{ item.label }}</span>
                <strong>{{ item.value }}</strong>
              </div>
            </div>
            <div class="quantro-panel-foot">{{ stockSummaryLabel }}</div>
          </div>

          <div class="quantro-panel-card">
            <div class="quantro-card-title-row">
              <h4>{{ isArabic ? 'أفضل ٥ عملاء' : 'Top 5 Customers' }}</h4>
              <router-link to="/app/people/customers">{{ isArabic ? 'عرض الكل ←' : 'View all →' }}</router-link>
            </div>
            <div class="quantro-customer-list">
              <div v-for="customer in topCustomerRows" :key="customer.name" class="quantro-customer-row">
                <span class="quantro-avatar-sm" :style="{ background: customer.color }">{{ customer.initial }}</span>
                <span class="quantro-customer-meta"><strong>{{ customer.name }}</strong><em>{{ customer.orders }}</em></span>
                <strong>{{ customer.amount }}</strong>
              </div>
            </div>
          </div>
        </div>

        <div class="quantro-reference-grid-bottom">
          <div class="quantro-table-card">
            <div class="quantro-table-header">
              <h4>{{ isArabic ? 'تنبيهات المخزون' : 'Stock Alerts' }}</h4>
              <router-link to="/app/reports/quantity_alerts">{{ isArabic ? 'عرض الكل ←' : 'View all →' }}</router-link>
            </div>
            <div class="quantro-reference-table quantro-reference-table--alerts">
              <div class="quantro-reference-head">
                <span>{{ isArabic ? 'الرمز' : 'Code' }}</span><span>{{ isArabic ? 'المنتج' : 'Product' }}</span><span>{{ isArabic ? 'المستودع' : 'Warehouse' }}</span><span>{{ isArabic ? 'الكمية / التنبيه' : 'Qty / Alert' }}</span>
              </div>
              <div v-for="item in stockAlertRows" :key="item.code + item.name" class="quantro-reference-row">
                <router-link to="/app/reports/quantity_alerts">{{ item.code }}</router-link>
                <strong>{{ item.name }}</strong>
                <span>{{ item.warehouse || selectedWarehouseLabel }}</span>
                <em :style="{ color: item.barC }">{{ item.quantity }} / {{ item.stock_alert }}</em>
              </div>
            </div>
          </div>

          <div class="quantro-table-card">
            <div class="quantro-table-header">
              <h4>{{ isArabic ? 'أحدث المبيعات' : 'Recent Sales' }}</h4>
              <router-link to="/app/sales/list">{{ isArabic ? 'عرض الكل ←' : 'View all →' }}</router-link>
            </div>
            <div class="quantro-reference-table quantro-reference-table--sales">
              <div class="quantro-reference-head">
                <span>{{ isArabic ? 'المرجع' : 'Reference' }}</span><span>{{ isArabic ? 'العميل' : 'Customer' }}</span><span>{{ isArabic ? 'الإجمالي' : 'Total' }}</span><span>{{ isArabic ? 'المدفوع' : 'Paid' }}</span><span>{{ isArabic ? 'المستحق' : 'Due' }}</span><span>{{ isArabic ? 'الحالة' : 'Status' }}</span>
              </div>
              <div v-for="sale in recentSaleRows.slice(0, 5)" :key="sale.Ref" class="quantro-reference-row">
                <router-link :to="'/app/sales/detail/' + (sale.id || '')">{{ sale.Ref }}</router-link>
                <strong>{{ sale.client_name || '-' }}</strong>
                <strong>{{ formatPriceWithSymbol(currentUser && currentUser.currency, sale.GrandTotal || 0, 2) }}</strong>
                <span>{{ formatPriceWithSymbol(currentUser && currentUser.currency, sale.paid_amount || sale.paid || 0, 2) }}</span>
                <span>{{ formatPriceWithSymbol(currentUser && currentUser.currency, sale.due || sale.due_amount || 0, 2) }}</span>
                <span class="quantro-status-pill" :class="'quantro-status-pill--' + sale.statusTone">{{ sale.payment_status || sale.statut || '-' }}</span>
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
import DateRangePicker from "vue2-daterange-picker";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
import moment from "moment";
import { formatPriceDisplay as formatPriceDisplayHelper, getPriceFormatSetting, getPriceDecimals } from "../../../utils/priceFormat";

export default {
  components: { apexchart: VueApexCharts, "date-range-picker": DateRangePicker },
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
      sales_by_payment: [],
      loading: true,
      dashboardRefreshTimer: null,
      dashboardRequestInFlight: false,
      price_format_key: null,
      dashboardSectionOrder: [],
      dashboardFontSize: "",
      dashboardFontFamily: "",
      stock_value: { by_cost: 0, by_retail: 0, by_wholesale: 0 },
      stock_summary: { sku_count: 0, warehouse_count: 0 },
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
    warehouseOptions() {
      const allLabel = this.$t("All_Warehouses") || "All Warehouses";
      return [
        { label: allLabel, value: "" },
        ...(this.warehouses || []).map(warehouse => ({
          label: warehouse.name || warehouse.label || String(warehouse.id),
          value: warehouse.id,
        })),
      ];
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
    referenceKpis() {
      const symbol = this.currentUser && this.currentUser.currency;
      const salesTotal = this.cleanNumber(this.report_today.today_sales);
      const salesDue = this.cleanNumber(this.report_today.sales_due);
      const purchasesTotal = this.cleanNumber(this.report_today.today_purchases);
      const purchaseDue = this.cleanNumber(this.report_today.purchase_due);
      const returnSales = this.cleanNumber(this.report_today.return_sales);
      const returnPurchases = this.cleanNumber(this.report_today.return_purchases);
      const profit = this.cleanNumber(this.report_today.today_profit);
      const salesPaid = Math.max(salesTotal - salesDue, 0);
      const purchasesPaid = Math.max(purchasesTotal - purchaseDue, 0);
      const returnsTotal = returnSales + returnPurchases;
      const movementTotal = salesTotal + purchasesTotal;
      return [
        { key: "sales", to: "/app/sales/list", icon: "shopping-cart", label: this.isArabic ? "المبيعات" : "Sales", value: this.formatPriceWithSymbol(symbol, salesTotal, 2), trend: this.formatKpiPercent(salesPaid, salesTotal), trendTone: salesTotal ? "up" : "flat", footerLabel: this.isArabic ? "مبيعات مستحقة" : "Sales due", footerValue: this.formatPriceWithSymbol(symbol, salesDue, 2), footerColor: "#E88A00", bg: "rgba(37,99,235,.1)", color: "#2563EB" },
        { key: "purchases", to: "/app/purchases/list", icon: "shopping-bag", label: this.isArabic ? "المشتريات" : "Purchases", value: this.formatPriceWithSymbol(symbol, purchasesTotal, 2), trend: this.formatKpiPercent(purchasesPaid, purchasesTotal), trendTone: purchasesTotal ? "up" : "flat", footerLabel: this.isArabic ? "مشتريات مستحقة" : "Purchase due", footerValue: this.formatPriceWithSymbol(symbol, purchaseDue, 2), footerColor: "#E88A00", bg: "rgba(0,196,154,.12)", color: "#00A882" },
        { key: "returns", to: "/app/sale_return/list", icon: "undo", label: this.isArabic ? "المرتجعات" : "Returns", value: this.formatPriceWithSymbol(symbol, returnSales, 2), trend: this.formatKpiPercent(returnsTotal, movementTotal, true), trendTone: returnsTotal ? "down" : "flat", footerLabel: this.isArabic ? "مبيعات / مشتريات" : "Sales / Purchases", footerValue: `${this.formatPriceWithSymbol(symbol, returnSales, 2)} · ${this.formatPriceWithSymbol(symbol, returnPurchases, 2)}`, footerColor: "var(--q-ink, #0B1B33)", bg: "rgba(139,92,246,.12)", color: "#8B5CF6" },
        { key: "profit", to: "/app/reports/profit_and_loss", icon: "trending-up", label: this.isArabic ? "الربح" : "Profit", value: this.formatPriceWithSymbol(symbol, profit, 2), trend: this.formatKpiPercent(profit, salesTotal), trendTone: profit < 0 ? "down" : (salesTotal ? "up" : "flat"), footerLabel: this.isArabic ? "الفواتير الصادرة" : "Invoices issued", footerValue: String(this.cleanNumber(this.report_today.today_invoices)), footerColor: "var(--q-ink, #0B1B33)", bg: "rgba(0,196,154,.12)", color: "#00A882" },
      ];
    },
    paymentRows() {
      const colors = ["#2563EB", "#00C49A", "#8B5CF6", "#FF9F1C", "#64748B"];
      return (this.sales_by_payment || []).map((row, index) => ({
        name: row.name || "-",
        amount: this.formatPriceWithSymbol(this.currentUser && this.currentUser.currency, row.amount || 0, 2),
        percent: Number(row.percentage || row.percent || 0),
        color: colors[index % colors.length],
      }));
    },
    stockValueRows() {
      const symbol = this.currentUser && this.currentUser.currency;
      return [
        { label: this.isArabic ? "حسب التكلفة" : "By Cost", value: this.formatPriceWithSymbol(symbol, this.stock_value.by_cost || 0, 2), icon: "circle-dollar-sign", bg: "rgba(37,99,235,.1)", color: "#2563EB" },
        { label: this.isArabic ? "حسب التجزئة" : "By Retail", value: this.formatPriceWithSymbol(symbol, this.stock_value.by_retail || 0, 2), icon: "tag", bg: "rgba(255,159,28,.14)", color: "#E88A00" },
        { label: this.isArabic ? "حسب الجملة" : "By Wholesale", value: this.formatPriceWithSymbol(symbol, this.stock_value.by_wholesale || 0, 2), icon: "package", bg: "rgba(139,92,246,.12)", color: "#8B5CF6" },
      ];
    },
    topCustomerRows() {
      const colors = ["#2563EB", "#00A882", "#8B5CF6", "#FF9F1C", "#E8618C"];
      const source = (this.customers_top || []).slice(0, 5);
      return source.map((item, index) => {
        const name = item.name || item.client_name || item.customer_name || "-";
        return {
          name,
          initial: name.charAt(0).toUpperCase(),
          color: colors[index % colors.length],
          orders: `${item.orders || item.count || 0} ${this.isArabic ? "طلب" : "orders"}`,
          amount: this.formatPriceWithSymbol(this.currentUser && this.currentUser.currency, item.amount || item.total || item.value || 0, 2),
        };
      });
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
    topProductInsight() {
      const top = (this.products || [])[0];
      if (!top || !top.name) return "";
      const count = Number(top.total_sales || top.value || 0);
      return this.isArabic
        ? `${top.name} يتصدر بـ ${count} مبيعات`
        : `${top.name} leads with ${count} sales`;
    },
    stockSummaryLabel() {
      const skuCount = Number(this.stock_summary.sku_count || 0);
      const warehouseCount = Number(this.stock_summary.warehouse_count || 0);
      return this.isArabic
        ? `${skuCount} منتج عبر ${warehouseCount} مستودعات`
        : `${skuCount} SKUs across ${warehouseCount} warehouses`;
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
          warehouse: item.warehouse_name || item.warehouse || this.selectedWarehouseLabel,
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
  watch: {
    // Dark mode can also be toggled from the global top nav (e.g. on
    // narrower viewports where it isn't hidden) instead of this page's
    // own button. Without this watcher, that path flips the Vuex flag
    // and body.dark-theme class but never refreshes this component's
    // --q-* CSS variables, leaving the header stuck on light colors
    // against a dark page.
    isDark() {
      this.applyTheme();
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
        '--q-ink': '#FFFFFF',
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
    cleanNumber(value) {
      if (typeof value === "number") return Number.isFinite(value) ? value : 0;
      if (value === null || value === undefined || value === "") return 0;
      const parsed = Number(String(value).replace(/,/g, ""));
      return Number.isFinite(parsed) ? parsed : 0;
    },
    formatKpiPercent(value, base, inverse) {
      const amount = this.cleanNumber(value);
      const denominator = Math.abs(this.cleanNumber(base));
      const percent = denominator > 0 ? Math.abs((amount / denominator) * 100) : 0;
      const arrow = percent === 0 ? "•" : (inverse || amount < 0 ? "↓" : "↑");
      return `${arrow} ${percent.toFixed(1)}%`;
    },
    formatPriceDisplay(number, dec) {
      try {
        const decimals = this.priceDecimals;
        const n = this.cleanNumber(number);
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
    all_dashboard_data(showLoader = true) {
      if (this.dashboardRequestInFlight) return Promise.resolve();
      this.dashboardRequestInFlight = true;
      if (showLoader) this.loading = true;
      this.get_data_loaded();
      return axios
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
          this.customers_top = responseData.customers && responseData.customers.original ? responseData.customers.original : [];
          this.sales_by_payment = responseData.sales_by_payment || [];

          if (response.data.stock_value) {
            this.stock_value = {
              by_cost: Number(response.data.stock_value.by_cost) || 0,
              by_retail: Number(response.data.stock_value.by_retail) || 0,
              by_wholesale: Number(response.data.stock_value.by_wholesale) || 0,
            };
          }
          if (response.data.stock_summary) {
            this.stock_summary = {
              sku_count: Number(response.data.stock_summary.sku_count) || 0,
              warehouse_count: Number(response.data.stock_summary.warehouse_count) || 0,
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
            legend: { show: false },
            grid: { borderColor: "#e0e6ed" },
          };

          // Top Products Chart
          const productData = responseData.product_report.original || [];
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
        })
        .finally(() => {
          this.dashboardRequestInFlight = false;
        });
    },
    startDashboardAutoRefresh() {
      this.stopDashboardAutoRefresh();
      this.dashboardRefreshTimer = window.setInterval(() => {
        if (typeof document !== "undefined" && document.hidden) return;
        this.all_dashboard_data(false);
      }, 15000);
    },
    stopDashboardAutoRefresh() {
      if (this.dashboardRefreshTimer) {
        window.clearInterval(this.dashboardRefreshTimer);
        this.dashboardRefreshTimer = null;
      }
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
    onWarehouseChange() {
      this.today_mode = false;
      this.all_dashboard_data(true);
    },
    onDateRangeUpdate(range) {
      const start = moment(range.startDate);
      const end = moment(range.endDate);
      if (!start.isValid() || !end.isValid()) return;
      this.today_mode = false;
      this.startDate = start.format("YYYY-MM-DD");
      this.endDate = end.format("YYYY-MM-DD");
      this.all_dashboard_data(true);
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
    this.startDashboardAutoRefresh();
    this.applyTheme();
  },
  beforeDestroy() {
    this.stopDashboardAutoRefresh();
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
  gap: 12px;
  min-height: 84px;
  height: 84px;
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
  flex: 1 1 auto;
  min-width: 300px;
}

.quantro-header-left h2 {
  font-family: 'Sora', sans-serif;
  font-weight: 700;
  font-size: 17px;
  letter-spacing: -0.3px;
  margin: 0;
  color: var(--q-ink, #0B1B33) !important;
}

.quantro-welcome-text {
  color: var(--q-ink3, #8291A9);
  font-size: 11px;
  margin-top: 1px;
}

.quantro-header-right {
  display: flex;
  align-items: center;
  gap: 10px;
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
  height: 42px;
  min-width: 138px;
  padding: 0 18px;
  border-radius: 12px;
  background: var(--primary-color, #2563EB);
  color: #FFFFFF;
  border: 1px solid var(--primary-color, #2563EB);
  box-shadow: 0 12px 22px -12px rgba(37, 99, 235, 0.75);
  font-size: 13px;
  font-weight: 700;
  line-height: 1;
  text-decoration: none;
  white-space: nowrap;
  box-sizing: border-box;
  flex: 0 0 auto;
}

.quantro-pos-btn:hover {
  background: var(--primary-color-darker, #1D53D0);
  border-color: var(--primary-color-darker, #1D53D0);
  color: #FFFFFF;
  text-decoration: none;
}

.quantro-pos-btn svg {
  width: 15px;
  height: 15px;
  flex: 0 0 15px;
  color: #FFFFFF !important;
  stroke: #FFFFFF !important;
}

.quantro-pos-btn svg * {
  stroke: #FFFFFF !important;
}

.quantro-pos-btn span {
  display: inline-block;
  color: #FFFFFF;
  line-height: 1;
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
  height: 42px;
  box-sizing: border-box;
  white-space: nowrap;
}

.quantro-warehouse-select {
  background: var(--q-card2, #F6F9FC) !important;
  border: 1px solid var(--q-bd, #E4EAF3) !important;
  color: var(--q-ink, #0B1B33) !important;
  box-sizing: border-box !important;
  cursor: pointer !important;
}

.quantro-warehouse-select .vs__dropdown-toggle {
  min-height: 0 !important;
  padding: 0 !important;
  border: 0 !important;
  background: transparent !important;
}

.quantro-warehouse-select .vs__selected-options {
  flex-wrap: nowrap !important;
  padding: 0 !important;
}

.quantro-warehouse-select .vs__selected {
  display: inline-flex !important;
  align-items: center !important;
  gap: 7px !important;
  margin: 0 !important;
  padding: 0 !important;
  color: var(--q-ink, #0B1B33) !important;
  white-space: nowrap !important;
}

.quantro-warehouse-select .vs__actions {
  padding: 0 0 0 8px !important;
}

.quantro-warehouse-select .vs__search {
  margin: 0 !important;
  padding: 0 !important;
  width: 0 !important;
}

.quantro-warehouse-select.vs--open .vs__selected {
  opacity: 1 !important;
  position: static !important;
}

.quantro-date-picker {
  display: inline-flex !important;
}

.quantro-date-picker .reportrange-text {
  background: transparent !important;
  border: none !important;
  padding: 0 !important;
  width: auto !important;
  overflow: visible !important;
}

.quantro-warehouse-chip svg {
  width: 16px;
  height: 16px;
  color: var(--primary-color, #2563EB);
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
  padding: 0 14px;
  font-weight: 600;
  font-size: 12px;
  color: var(--q-ink, #0B1B33);
  cursor: pointer;
  height: 42px;
  white-space: nowrap;
  box-sizing: border-box;
}

.quantro-date-chip svg {
  color: var(--primary-color, #2563EB);
}

.quantro-lang-toggle {
  display: flex;
  background: var(--q-card2, #F6F9FC);
  border: 1px solid var(--q-bd, #E4EAF3);
  border-radius: 10px;
  padding: 3px;
  gap: 2px;
  height: 42px;
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
  color: var(--primary-color, #2563EB);
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
  width: 42px;
  height: 42px;
  padding: 0;
  flex: 0 0 42px;
}

.quantro-icon-btn:hover {
  border-color: var(--primary-color, #2563EB);
  color: var(--primary-color, #2563EB);
}

/* ===== Header controls: hover / press / focus / open states ===== */
.quantro-pos-btn,
.quantro-warehouse-select,
.quantro-date-chip,
.quantro-icon-btn,
.quantro-lang-toggle {
  transition: background-color .18s ease, border-color .18s ease, color .18s ease,
              box-shadow .18s ease, transform .12s ease;
  -webkit-tap-highlight-color: transparent;
}

/* --- Primary: Open POS --- */
.quantro-pos-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 14px 26px -12px rgba(11, 27, 51, .55);
}

.quantro-pos-btn:active {
  transform: translateY(0) scale(.975);
  box-shadow: 0 4px 10px -6px rgba(11, 27, 51, .6);
  filter: brightness(1.12);
}

.quantro-pos-btn:focus-visible {
  outline: none;
  box-shadow: 0 0 0 3px var(--q-card, #FFFFFF),
              0 0 0 5px var(--primary-color, #2563EB);
}

/* --- Secondary chips: warehouse / date --- */
.quantro-warehouse-select:hover,
.quantro-date-chip:hover {
  background: var(--q-card, #FFFFFF) !important;
  border-color: var(--primary-color, #2563EB) !important;
  box-shadow: 0 6px 16px -10px rgba(11, 27, 51, .45);
}

.quantro-date-chip:active,
.quantro-warehouse-select:active {
  transform: scale(.978);
  box-shadow: none;
}

.quantro-date-chip:focus-visible,
.quantro-warehouse-select:focus-within {
  outline: none;
  border-color: var(--primary-color, #2563EB) !important;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
}

/* open dropdown / open date picker keep the "pressed" look */
.quantro-warehouse-select.vs--open,
.quantro-date-picker.show-ranges .quantro-date-chip,
.quantro-date-picker[data-open="true"] .quantro-date-chip {
  border-color: var(--primary-color, #2563EB) !important;
  background: var(--q-card, #FFFFFF) !important;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
}

.quantro-warehouse-select .vs__open-indicator {
  transition: transform .18s ease;
}

.quantro-warehouse-select.vs--open .vs__open-indicator {
  transform: rotate(180deg);
}

/* --- Icon buttons (theme / bell) --- */
.quantro-icon-btn:hover {
  background: var(--q-card, #FFFFFF);
  box-shadow: 0 6px 16px -10px rgba(11, 27, 51, .45);
}

.quantro-icon-btn:active {
  transform: scale(.93);
  box-shadow: none;
}

.quantro-icon-btn:focus-visible {
  outline: none;
  border-color: var(--primary-color, #2563EB);
  box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
}

/* --- Language toggle --- */
.quantro-lang-btn {
  cursor: pointer;
  transition: background-color .18s ease, color .18s ease, transform .12s ease;
}

.quantro-lang-btn:not(.active):hover {
  color: var(--q-ink, #0B1B33);
  background: rgba(11, 27, 51, .06);
}

.quantro-lang-btn:active {
  transform: scale(.94);
}

.quantro-lang-btn:focus-visible {
  outline: none;
  box-shadow: 0 0 0 2px var(--primary-color, #2563EB);
}

/* --- Dark theme adjustments --- */
body.dark-theme .quantro-warehouse-select:hover,
body.dark-theme .quantro-date-chip:hover,
body.dark-theme .quantro-icon-btn:hover {
  background: #172844 !important;
  box-shadow: 0 6px 16px -10px rgba(0, 0, 0, .7);
}

body.dark-theme .quantro-lang-btn:not(.active):hover {
  color: #e5edf8;
  background: rgba(255, 255, 255, .07);
}

@media (prefers-reduced-motion: reduce) {
  .quantro-pos-btn,
  .quantro-warehouse-select,
  .quantro-date-chip,
  .quantro-icon-btn,
  .quantro-lang-btn {
    transition: none;
    transform: none !important;
  }
}

.quantro-bell-badge {
  position: absolute;
  top: -4px;
  inset-inline-end: -4px;
  background: var(--primary-color, #2563EB);
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
  height: 42px;
  overflow: hidden;
  flex: 0 0 auto;
}

.quantro-user-avatar {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  background: var(--primary-color, #2563EB);
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

@media (min-width: 992px) {
  body.quantro-dashboard-route .quantro-header {
    height: 82px !important;
    min-height: 82px !important;
    max-height: 82px !important;
    gap: 10px !important;
    padding: 0 30px !important;
  }

  body.quantro-dashboard-route .quantro-header-left h2 {
    font-size: 20px !important;
    line-height: 1.1 !important;
  }

  body.quantro-dashboard-route .quantro-welcome-text {
    font-size: 12px !important;
  }

  body.quantro-dashboard-route .quantro-pos-btn,
  body.quantro-dashboard-route .quantro-warehouse-chip,
  body.quantro-dashboard-route .quantro-warehouse-select,
  body.quantro-dashboard-route .quantro-date-chip,
  body.quantro-dashboard-route .quantro-lang-toggle,
  body.quantro-dashboard-route .quantro-icon-btn,
  body.quantro-dashboard-route .quantro-user {
    height: 38px !important;
    min-height: 38px !important;
    max-height: 38px !important;
    border-radius: 10px !important;
  }

  body.quantro-dashboard-route .quantro-pos-btn {
    width: 136px !important;
    min-width: 136px !important;
    max-width: 136px !important;
    flex: 0 0 136px !important;
    padding: 0 12px !important;
    gap: 7px !important;
    font-size: 12px !important;
  }

  body.quantro-dashboard-route .quantro-pos-btn span {
    display: inline-block !important;
    color: #fff !important;
  }

  body.quantro-dashboard-route .quantro-warehouse-chip {
    width: 188px !important;
    min-width: 188px !important;
    max-width: 188px !important;
    flex: 0 0 188px !important;
    padding: 0 12px !important;
    font-size: 12px !important;
  }

  body.quantro-dashboard-route .quantro-warehouse-select {
    width: 188px !important;
    min-width: 188px !important;
    max-width: 188px !important;
    flex: 0 0 188px !important;
    padding: 0 12px !important;
    font-size: 12px !important;
  }

  body.quantro-dashboard-route .quantro-date-chip {
    width: 198px !important;
    min-width: 198px !important;
    max-width: 198px !important;
    flex: 0 0 198px !important;
    padding: 0 11px !important;
    font-size: 11.5px !important;
  }

  body.quantro-dashboard-route .quantro-lang-toggle {
    width: 118px !important;
    min-width: 118px !important;
    max-width: 118px !important;
    flex: 0 0 118px !important;
    padding: 3px !important;
  }

  body.quantro-dashboard-route .quantro-icon-btn {
    width: 38px !important;
    min-width: 38px !important;
    max-width: 38px !important;
    flex-basis: 38px !important;
  }

  body.quantro-dashboard-route .quantro-user-avatar {
    width: 38px !important;
    min-width: 38px !important;
    height: 38px !important;
  }
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

.quantro-kpi-trend.flat {
  color: var(--q-ink3, #8291A9);
}

body.dark-theme .quantro-kpi-label,
body.dark-theme .quantro-kpi-footer {
  color: #FFFFFF;
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
body.dark-theme .quantro-warehouse-select,
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

/* Reference dashboard layout */
.dashboard-page-root.quantro-dashboard .quantro-content {
  padding: 22px 26px !important;
  gap: 18px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-grid--reference {
  display: grid !important;
  grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
  gap: 14px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-card--reference {
  border-radius: 16px !important;
  padding: 16px 17px !important;
  min-height: 128px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-card--reference .quantro-kpi-top {
  margin-bottom: 9px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-card--reference .quantro-kpi-trend {
  margin-inline-start: auto !important;
  font-size: 11px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-card--reference .quantro-kpi-value {
  margin: 0 !important;
  font-size: 22px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-footer--split {
  justify-content: space-between !important;
  margin-top: 9px !important;
  padding-top: 9px !important;
  border-top: 1px dashed var(--q-bd, #E4EAF3) !important;
}

.dashboard-page-root.quantro-dashboard .quantro-kpi-footer--split strong {
  font-weight: 700 !important;
}

.dashboard-page-root.quantro-dashboard .quantro-main-grid--reference {
  display: grid !important;
  grid-template-columns: 1.9fr 1fr !important;
  gap: 16px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-chart-card {
  border-radius: 16px !important;
  padding: 19px 20px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-chart-body--large {
  min-height: 270px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-products-card {
  display: flex !important;
  flex-direction: column !important;
}

.dashboard-page-root.quantro-dashboard .quantro-products-card .quantro-chart-footer {
  margin-top: auto !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-grid-3 {
  display: grid !important;
  grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
  gap: 16px !important;
  align-items: stretch !important;
}

.dashboard-page-root.quantro-dashboard .quantro-panel-card {
  background: var(--q-card, #fff) !important;
  border: 1px solid var(--q-bd, #E4EAF3) !important;
  border-radius: 16px !important;
  padding: 17px 18px !important;
  box-shadow: var(--q-sh, 0 1px 2px rgba(11,27,51,.04)) !important;
}

.dashboard-page-root.quantro-dashboard .quantro-panel-card h4,
.dashboard-page-root.quantro-dashboard .quantro-card-title-row h4 {
  font-family: Sora, sans-serif !important;
  font-weight: 700 !important;
  font-size: 14px !important;
  margin: 0 !important;
  color: var(--q-ink, #0B1B33) !important;
}

.dashboard-page-root.quantro-dashboard .quantro-payment-list,
.dashboard-page-root.quantro-dashboard .quantro-stock-value-list,
.dashboard-page-root.quantro-dashboard .quantro-customer-list {
  display: flex !important;
  flex-direction: column !important;
  gap: 11px !important;
  margin-top: 13px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-payment-meta {
  display: flex !important;
  justify-content: space-between !important;
  margin-bottom: 5px !important;
  color: var(--q-ink2, #47586F) !important;
  font-size: 11.5px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-payment-meta strong {
  color: var(--q-ink, #0B1B33) !important;
}

.dashboard-page-root.quantro-dashboard .quantro-payment-bar,
.dashboard-page-root.quantro-dashboard .quantro-branch-bar {
  height: 6px !important;
  border-radius: 3px !important;
  background: var(--q-bd, #E4EAF3) !important;
  overflow: hidden !important;
}

.dashboard-page-root.quantro-dashboard .quantro-payment-bar span {
  display: block !important;
  height: 100% !important;
  border-radius: 3px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-stock-value-row {
  display: flex !important;
  align-items: center !important;
  gap: 11px !important;
  padding: 12px 13px !important;
  border: 1px solid var(--q-bd, #E4EAF3) !important;
  border-radius: 11px !important;
  background: var(--q-card2, #F6F9FC) !important;
}

.dashboard-page-root.quantro-dashboard .quantro-stock-value-icon {
  width: 30px !important;
  height: 30px !important;
  border-radius: 9px !important;
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  flex: 0 0 30px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-stock-value-icon svg {
  width: 14px !important;
  height: 14px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-stock-value-row span:nth-child(2) {
  flex: 1 !important;
  color: var(--q-ink2, #47586F) !important;
  font-size: 12px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-stock-value-row strong {
  font-family: Sora, sans-serif !important;
  font-weight: 700 !important;
  font-size: 13.5px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-panel-foot {
  margin-top: 13px !important;
  padding-top: 12px !important;
  border-top: 1px solid var(--q-bd, #E4EAF3) !important;
  color: var(--q-ink3, #8291A9) !important;
  font-size: 11px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-card-title-row {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
}

.dashboard-page-root.quantro-dashboard .quantro-card-title-row a {
  font-size: 11.5px !important;
  font-weight: 600 !important;
  color: #2563EB !important;
}

.dashboard-page-root.quantro-dashboard .quantro-customer-row {
  display: flex !important;
  align-items: center !important;
  gap: 10px !important;
  padding: 9px 0 !important;
  border-bottom: 1px solid var(--q-bd, #E4EAF3) !important;
}

.dashboard-page-root.quantro-dashboard .quantro-customer-row:last-child {
  border-bottom: 0 !important;
}

.dashboard-page-root.quantro-dashboard .quantro-customer-meta {
  flex: 1 !important;
  min-width: 0 !important;
}

.dashboard-page-root.quantro-dashboard .quantro-customer-meta strong {
  display: block !important;
  font-size: 12px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-customer-meta em {
  display: block !important;
  color: var(--q-ink3, #8291A9) !important;
  font-size: 10.5px !important;
  font-style: normal !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-grid-bottom {
  display: grid !important;
  grid-template-columns: .95fr 1.35fr !important;
  gap: 16px !important;
  align-items: start !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-table {
  overflow-x: auto !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-head,
.dashboard-page-root.quantro-dashboard .quantro-reference-row {
  display: grid !important;
  gap: 8px !important;
  align-items: center !important;
  padding: 10px 20px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-table--alerts .quantro-reference-head,
.dashboard-page-root.quantro-dashboard .quantro-reference-table--alerts .quantro-reference-row {
  grid-template-columns: 1fr 1.6fr 1fr .8fr !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-table--sales .quantro-reference-head,
.dashboard-page-root.quantro-dashboard .quantro-reference-table--sales .quantro-reference-row {
  grid-template-columns: 1.2fr 1.3fr 1fr .8fr .8fr .9fr !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-head {
  background: var(--q-card2, #F6F9FC) !important;
  border-top: 1px solid var(--q-bd, #E4EAF3) !important;
  border-bottom: 1px solid var(--q-bd, #E4EAF3) !important;
  color: var(--q-ink3, #8291A9) !important;
  font-size: 10px !important;
  font-weight: 600 !important;
  letter-spacing: .6px !important;
  text-transform: uppercase !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-row {
  min-height: 48px !important;
  border-bottom: 1px solid var(--q-bd, #E4EAF3) !important;
  font-size: 12px !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-row:last-child {
  border-bottom: 0 !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-row a {
  color: #2563EB !important;
  font-weight: 700 !important;
}

.dashboard-page-root.quantro-dashboard .quantro-reference-row em {
  justify-self: start !important;
  padding: 4px 10px !important;
  border-radius: 999px !important;
  background: rgba(225, 72, 72, .1) !important;
  font-style: normal !important;
  font-weight: 700 !important;
}

@media (max-width: 1399px) {
  .dashboard-page-root.quantro-dashboard .quantro-kpi-grid--reference {
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
  }
}

@media (max-width: 1199px) {
  .dashboard-page-root.quantro-dashboard .quantro-main-grid--reference,
  .dashboard-page-root.quantro-dashboard .quantro-reference-grid-3,
  .dashboard-page-root.quantro-dashboard .quantro-reference-grid-bottom {
    grid-template-columns: 1fr !important;
  }
}
</style>
