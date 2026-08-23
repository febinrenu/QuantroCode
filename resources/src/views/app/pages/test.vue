<template>
  <div class="quantro-reference-dashboard-page">
    <iframe
      class="quantro-reference-dashboard-frame"
      src="/quantro-test/index.html"
      title="Dashboard"
    ></iframe>
  </div>
</template>

<script>
export default {
  metaInfo: { title: "Dashboard" },
  mounted() {
    document.body.classList.add("quantro-reference-dashboard-route");
  },
  beforeDestroy() {
    document.body.classList.remove("quantro-reference-dashboard-route");
  }
};
</script>

<style scoped>
.quantro-reference-dashboard-page {
  width: 100%;
  height: calc(100vh - 80px);
  min-height: 720px;
  background: #f4f7fb;
  overflow: hidden;
}

.quantro-reference-dashboard-frame {
  width: 100%;
  height: 100%;
  border: 0;
  display: block;
  background: #f4f7fb;
}
</style>
