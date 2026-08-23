(function () {
  function isDashboard() {
    return window.location && window.location.pathname === "/app/dashboard";
  }

  function clearPwaCaches() {
    if ("caches" in window) {
      window.caches.keys().then(function (keys) {
        keys.forEach(function (key) {
          if (key.indexOf("stocky-pwa-") === 0) window.caches.delete(key);
        });
      }).catch(function () {});
    }
    if ("serviceWorker" in navigator) {
      navigator.serviceWorker.getRegistrations().then(function (regs) {
        regs.forEach(function (reg) { reg.update().catch(function () {}); });
      }).catch(function () {});
    }
  }

  function installStyles() {
    if (document.getElementById("quantro-sidebar-force-style")) return;
    var style = document.createElement("style");
    style.id = "quantro-sidebar-force-style";
    style.textContent = [
      "body.quantro-dashboard-route .layout-sidebar-large .sidebar-left .quantro-sidebar-brand{height:120px!important;padding:24px 28px 20px!important;display:flex!important;align-items:center!important;justify-content:center!important;border-bottom:1px solid rgba(255,255,255,.07)!important}",
      "body.quantro-dashboard-route .layout-sidebar-large .sidebar-left .quantro-sidebar-brand a{display:flex!important;align-items:center!important;justify-content:center!important;width:100%!important}",
      "body.quantro-dashboard-route .layout-sidebar-large .sidebar-left .quantro-sidebar-brand img{width:235px!important;max-width:100%!important;max-height:76px!important;object-fit:contain!important;display:block!important;margin:0 auto!important}",
      "body.quantro-dashboard-route .layout-sidebar-large .main-header{height:82px!important;min-height:82px!important;padding:0 32px!important;background:#fff!important;border-bottom:1px solid #dfe7f2!important;box-shadow:none!important;display:flex!important;align-items:center!important;gap:16px!important}",
      "body.quantro-dashboard-route .layout-sidebar-large .main-header .menu-toggle,body.quantro-dashboard-route .layout-sidebar-large .main-header .logo{display:none!important}",
      "body.quantro-dashboard-route .tenant-header-title{display:flex!important;flex-direction:column!important;justify-content:center!important;flex:1 1 auto!important;min-width:360px!important;max-width:520px!important}",
      "body.quantro-dashboard-route .tenant-header-heading{font-size:22px!important;line-height:1!important;font-weight:800!important;color:#061326!important}",
      "body.quantro-dashboard-route .tenant-header-subtitle{font-size:13px!important;line-height:1.45!important;font-weight:600!important;color:#8291a9!important;margin-top:8px!important;white-space:normal!important}",
      "body.quantro-dashboard-route .layout-sidebar-large .main-header .header-part-right.nav-right>*:not(.quantro-forced-header-controls){display:none!important}",
      "body.quantro-dashboard-route .layout-sidebar-large .main-header .header-part-right.nav-right{display:flex!important;align-items:center!important;gap:10px!important;margin-left:auto!important;flex:0 0 auto!important}",
      ".quantro-forced-header-controls{display:flex!important;align-items:center!important;gap:10px!important;white-space:nowrap!important}",
      ".quantro-forced-pos{height:48px!important;padding:0 20px!important;border-radius:11px!important;background:#2563eb!important;border:1px solid #2563eb!important;color:#fff!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;gap:9px!important;font-size:14px!important;font-weight:800!important;text-decoration:none!important;box-shadow:0 10px 18px -10px rgba(37,99,235,.7)!important}",
      ".quantro-forced-chip{height:48px!important;padding:0 16px!important;border:1px solid #d9e1ef!important;border-radius:12px!important;background:#f8fbff!important;color:#061326!important;display:inline-flex!important;align-items:center!important;gap:11px!important;font-size:14px!important;font-weight:800!important}",
      ".quantro-forced-chip svg{width:17px!important;height:17px!important;color:#2563eb!important;stroke:currentColor!important}",
      ".quantro-forced-date{min-width:202px!important}",
      ".quantro-forced-lang{height:48px!important;border:1px solid #d9e1ef!important;border-radius:12px!important;background:#f8fbff!important;padding:3px!important;display:inline-flex!important;align-items:center!important;gap:0!important}",
      ".quantro-forced-lang button{height:40px!important;border:0!important;border-radius:10px!important;background:transparent!important;color:#8291a9!important;font-size:13px!important;font-weight:800!important;line-height:1!important;padding:0 13px!important;cursor:pointer!important}",
      ".quantro-forced-lang button:first-child{background:#fff!important;color:#2563eb!important;box-shadow:0 4px 12px rgba(15,23,42,.12)!important}",
      ".quantro-forced-icon{width:48px!important;height:48px!important;border:1px solid #d9e1ef!important;border-radius:12px!important;background:#f8fbff!important;color:#1d2940!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;position:relative!important}",
      ".quantro-forced-icon svg{width:18px!important;height:18px!important;stroke:currentColor!important}",
      ".quantro-forced-badge{position:absolute!important;top:-8px!important;right:4px!important;min-width:20px!important;height:20px!important;padding:0 6px!important;border-radius:999px!important;background:#2563eb!important;color:#fff!important;font-size:12px!important;font-weight:900!important;line-height:20px!important;text-align:center!important}",
      ".quantro-forced-user{height:50px!important;display:inline-flex!important;align-items:center!important;gap:12px!important;color:#061326!important}",
      ".quantro-forced-avatar{width:46px!important;height:46px!important;border-radius:12px!important;background:#2563eb!important;color:#fff!important;display:inline-flex!important;align-items:center!important;justify-content:center!important;font-size:17px!important;font-weight:900!important}",
      ".quantro-forced-user strong{display:block!important;font-size:15px!important;line-height:1.1!important;font-weight:800!important;color:#061326!important}",
      ".quantro-forced-user span{display:block!important;font-size:12px!important;line-height:1.2!important;font-weight:500!important;color:#8291a9!important;margin-top:2px!important}"
    ].join("\n");
    document.head.appendChild(style);
  }

  function icon(name) {
    var icons = {
      monitor: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><rect x="3" y="4" width="18" height="12" rx="1"></rect><path d="M8 20h8M12 16v4"></path></svg>',
      shield: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"></path></svg>',
      chevron: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2.5"><path d="m6 9 6 6 6-6"></path></svg>',
      calendar: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M8 2v4M16 2v4M3 10h18"></path><rect x="3" y="4" width="18" height="18" rx="2"></rect></svg>',
      moon: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 3a6 6 0 0 0 9 7.4A9 9 0 1 1 12 3Z"></path></svg>',
      bell: '<svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M10.3 21a2 2 0 0 0 3.4 0"></path><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path></svg>'
    };
    return icons[name] || "";
  }

  function forceDashboardHeader() {
    if (!isDashboard()) return;
    var header = document.querySelector(".layout-sidebar-large .main-header");
    if (!header) return;

    var title = header.querySelector(".tenant-header-title");
    if (!title) {
      title = document.createElement("div");
      title.className = "tenant-header-title";
      header.insertBefore(title, header.firstChild);
    }
    title.innerHTML = '<div class="tenant-header-heading">Dashboard</div><div class="tenant-header-subtitle">Welcome back, William Castillo! Here is what is happening today.</div>';

    var nav = header.querySelector(".header-part-right.nav-right") || header.querySelector(".nav-right");
    if (!nav) {
      nav = document.createElement("div");
      nav.className = "header-part-right nav-right";
      header.appendChild(nav);
    }

    var forced = nav.querySelector(".quantro-forced-header-controls");
    if (!forced) {
      forced = document.createElement("div");
      forced.className = "quantro-forced-header-controls";
      nav.appendChild(forced);
    }

    forced.innerHTML = [
      '<a class="quantro-forced-pos" href="/app/pos">' + icon("monitor") + '<span>Open POS</span></a>',
      '<div class="quantro-forced-chip">' + icon("shield") + '<span>All Warehouses</span>' + icon("chevron") + '</div>',
      '<div class="quantro-forced-chip quantro-forced-date">' + icon("calendar") + '<span>Jul 26 - Aug 1, 2026</span></div>',
      '<div class="quantro-forced-lang"><button type="button" data-q-lang="en">EN</button><button type="button" data-q-lang="ar">\\u0627\\u0644\\u0639\\u0631\\u0628\\u064a\\u0629</button></div>',
      '<button type="button" class="quantro-forced-icon" aria-label="Dark mode">' + icon("moon") + '</button>',
      '<button type="button" class="quantro-forced-icon" aria-label="Notifications">' + icon("bell") + '<span class="quantro-forced-badge">5</span></button>',
      '<div class="quantro-forced-user"><div class="quantro-forced-avatar">W</div><div><strong>William Castillo</strong><span>Admin</span></div></div>'
    ].join("");

    forced.querySelectorAll("[data-q-lang]").forEach(function (button) {
      button.onclick = function () {
        try { localStorage.setItem("language", button.getAttribute("data-q-lang")); } catch (e) {}
      };
    });
  }

  function forceSidebarLogo() {
    if (!isDashboard()) return;
    document.body.classList.add("quantro-dashboard-route");
    installStyles();
    forceDashboardHeader();
    var brand = document.querySelector(".layout-sidebar-large .sidebar-left .quantro-sidebar-brand");
    var img = document.querySelector(".layout-sidebar-large .sidebar-left .quantro-sidebar-brand img");
    if (brand) {
      brand.style.setProperty("height", "120px", "important");
      brand.style.setProperty("padding", "24px 28px 20px", "important");
    }
    if (img) {
      img.src = "/images/super/landing-design/quantro/quantro-lockup.png?v=quantro-horizontal-0822";
      img.style.setProperty("width", "235px", "important");
      img.style.setProperty("max-height", "76px", "important");
      img.style.setProperty("object-fit", "contain", "important");
    }
  }

  clearPwaCaches();
  var ticks = 0;
  var timer = window.setInterval(function () {
    forceSidebarLogo();
    ticks += 1;
    if (ticks > 80) window.clearInterval(timer);
  }, 125);
  window.addEventListener("load", forceSidebarLogo);
})();
