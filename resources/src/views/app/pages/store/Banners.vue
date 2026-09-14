<template>
  <div class="main-content">
<breadcumb :page="$t('Banners')" :folder="$t('Store')" />

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>

    <template v-else>
      <!-- ===== Theme position map: what's actually on the homepage right now ===== -->
      <b-card class="wrapper mb-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div class="h6 mb-0">{{ $t('Banner_Positions_For') }} "{{ activeThemeLabel }}"</div>
          <small class="text-muted">{{ $t('Banner_Positions_Help') }}</small>
        </div>

        <div v-if="!themePositions.length" class="empty-state">
          <div class="emoji">🧩</div>
          <div class="title">{{ $t('Theme_Has_No_Banner_Section') }}</div>
        </div>

        <div v-else class="position-grid">
          <div v-for="pos in themePositions" :key="pos" class="position-slot">
            <div class="slot-label">{{ positionLabel(pos) }}</div>

            <div v-if="bannerFor(pos)" class="slot-filled">
              <img :src="bannerFor(pos).image_url" class="slot-thumb">
              <div class="slot-info">
                <div class="slot-title text-truncate">{{ bannerFor(pos).title || $t('Untitled') }}</div>
                <b-badge :variant="bannerFor(pos).active ? 'success' : 'secondary'" pill>
                  {{ bannerFor(pos).active ? $t('Active') : $t('Disabled') }}
                </b-badge>
              </div>
              <b-button size="sm" variant="outline-secondary" @click="$router.push({name:'StoreBannerEdit', params:{id:bannerFor(pos).id}})">
                <lucide-icon name="pencil" />
              </b-button>
            </div>

            <div v-else class="slot-empty">
              <span class="text-muted small">{{ $t('Empty_Not_Set') }}</span>
              <b-button size="sm" variant="outline-primary" @click="$router.push({name:'StoreBannerEdit', params:{id:'new'}, query:{position:pos}})">
                <lucide-icon name="plus" /> {{ $t('Add') }}
              </b-button>
            </div>
          </div>
        </div>
      </b-card>

      <!-- ===== Full list (all banners, any position) ===== -->
      <b-card class="wrapper">
      <vue-good-table
        mode="remote"
        :columns="columns"
        :totalRows="totalRows"
        :rows="rows"
        :pagination-options="{ enabled: true, perPage: serverParams.perPage }"
        :search-options="{ enabled: false }"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-sort-change="onSortChange"
        styleClass="table-hover tableOne vgt-table"
      >
        <div slot="table-actions" class="mt-2 mb-3">
          <b-button @click="$router.push({name:'StoreBannerEdit', params:{id:'new'}})" size="sm" class="btn-rounded" variant="btn btn-primary btn-icon m-1">
            <lucide-icon name="plus" /> {{ $t('Add') }}
          </b-button>
        </div>

        <template slot="table-row" slot-scope="props">
          <span v-if="props.column.field==='preview'">
            <img :src="props.row.image_url" height="32">
          </span>
          <span v-else-if="props.column.field==='active'">
            <b-badge :variant="props.row.active ? 'success':'secondary'">{{ props.row.active ? $t('Active') : $t('Disabled') }}</b-badge>
          </span>
          <span v-else-if="props.column.field==='actions'">
            <a v-b-tooltip.hover :title="$t('Edit')" @click="$router.push({name:'StoreBannerEdit', params:{id:props.row.id}})">
              <lucide-icon class="text-20 text-info" name="pencil" />
            </a>
            <a v-b-tooltip.hover :title="$t('Delete')" class="ml-2" @click="remove(props.row.id)">
              <lucide-icon class="text-20 text-danger" name="x" />
            </a>
          </span>
          <span v-else>{{ props.formattedRow[props.column.field] }}</span>
        </template>
      </vue-good-table>
      </b-card>
    </template>
  </div>
</template>

<script>
export default {
  metaInfo: {
    title: "Store Banners"
  },
  data(){ return {
    isLoading:true,
    rows:[], totalRows:0,
    columns:[
      {label:this.$t('Preview'), field:'preview'},
      {label:this.$t('Title'), field:'title', sortable:true},
      {label:this.$t('Position'), field:'position', sortable:true},
      {label:this.$t('Active'), field:'active', sortable:true},
      {label:this.$t('Updated'), field:'updated_at', sortable:true},
      {label:this.$t('Actions'), field:'actions'}
    ],
    serverParams:{ page:1, perPage:10, sort:[{field:'updated_at', type:'desc'}] },
    activeThemeLabel: '',
    themePositions: [],
    positionLabels: {
      top_left: 'Top — Left',
      top_right: 'Top — Right',
      center_left: 'Center — Left',
      center_right: 'Center — Right',
      footer_left: 'Footer — Left',
      footer_right: 'Footer — Right',
    },
    allBanners: [],
  }},
  mounted(){ this.fetch(); this.fetchThemeContext() },
  methods:{
    async fetch() {
      this.isLoading = true
      try {
        const { data } = await axios.get('/store/banners', {
          params: {
            page: this.serverParams.page,
            per_page: this.serverParams.perPage,
            sort: this.serverParams.sort?.[0]?.field,
            dir: this.serverParams.sort?.[0]?.type,
          }
        })
        this.rows = data.data || []
        this.totalRows = data.meta?.total || this.rows.length
      } finally {
        this.isLoading = false
      }
    },

    // Separate from the paginated table above -- pulls the active theme's
    // supported positions plus every banner (unpaginated) so the position
    // map above can show exactly what's assigned to each slot right now.
    async fetchThemeContext() {
      try {
        const [settingsResp, allBannersResp] = await Promise.all([
          axios.get('/admin/store/settings'),
          axios.get('/store/banners', { params: { per_page: 200, page: 1 } }),
        ])
        this.activeThemeLabel = settingsResp.data?.active_theme_label || ''
        this.themePositions = Array.isArray(settingsResp.data?.active_theme_banner_positions)
          ? settingsResp.data.active_theme_banner_positions
          : []
        this.allBanners = allBannersResp.data?.data || []
      } catch (e) {
        this.themePositions = []
      }
    },

    positionLabel(pos) { return this.positionLabels[pos] || pos },

    bannerFor(pos) {
      // Mirrors the storefront's own ->first() pick (most recently updated,
      // since banners come back sorted by updated_at desc by default).
      return this.allBanners.find(b => b.position === pos && b.active) || null
    },

    onPageChange({currentPage}){ this.serverParams.page=currentPage; this.fetch() },
    onPerPageChange({currentPerPage}){ this.serverParams.perPage=currentPerPage; this.fetch() },
    onSortChange(params){ this.serverParams.sort = params[0] ? [params[0]] : []; this.fetch() },
   remove(id) {
      var self = this;

      self.$swal({
        title: self.$t('Delete_Title'),
        text: self.$t('Delete_Text'),
        type: 'warning', // for newer SweetAlert2 you can use icon: 'warning'
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: self.$t('Delete_cancelButtonText'),
        confirmButtonText: self.$t('Delete_confirmButtonText')
      }).then(function (result) {
        // support both old (result.value) and new (result.isConfirmed)
        var confirmed = !!(result && (result.value === true || result.isConfirmed === true));
        if (!confirmed) return;

        axios.delete('/store/banners/' + id)
          .then(function () {

            self.$swal(
              self.$t('Delete_Deleted'),
              self.$t('Deleted_in_successfully'),
              'success'
            );

           
            self.fetch();
            self.fetchThemeContext();
          })
          .catch(function (e) {

            var msg = (e && e.response && e.response.data && (e.response.data.message || e.response.data.error))
              || self.$t('Delete_Therewassomethingwronge');

            self.$swal(
              self.$t('Delete_Failed'),
              msg,
              'warning'
            );
          });
      });
    }


  }
}
</script>

<style scoped>
.position-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: .75rem;
}
.position-slot {
  border: 1px solid #e5e7eb;
  border-radius: .75rem;
  padding: .75rem;
  background: #fafafa;
}
.slot-label {
  font-size: .75rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #6b7280;
  margin-bottom: .5rem;
}
.slot-filled {
  display: flex;
  align-items: center;
  gap: .5rem;
}
.slot-thumb {
  width: 48px;
  height: 48px;
  object-fit: cover;
  border-radius: .5rem;
  flex-shrink: 0;
}
.slot-info { min-width: 0; flex: 1; }
.slot-title { font-weight: 600; font-size: .85rem; }
.slot-empty {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: .5rem;
}
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
</style>
