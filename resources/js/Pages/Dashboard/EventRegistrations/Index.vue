<template>
  <Head title="Event Registrations"/>
  <UserLayout title="Event Registrations">
    <div class="min-h-screen w-full bg-[#FAFBFC] py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-8">
          <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5">
            <a href="/" class="hover:text-slate-700 transition-colors">Home</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <a href="#" class="hover:text-slate-700 transition-colors">Admin</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <span class="text-slate-800 font-medium">Event Registrations</span>
          </nav>

          <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
              <h1 class="text-2xl md:text-[28px] font-semibold text-slate-900 tracking-tight leading-tight">
                Event Registrations
              </h1>
              <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-xl">
                Manage guest registrations across all events — confirm, cancel, and export.
              </p>
            </div>

            <a
              :href="route('event-registrations.export', exportQuery)"
              class="px-4 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg ring-1 ring-slate-200 inline-flex items-center gap-2 hover:bg-slate-50 hover:ring-slate-300 transition-all"
            >
              <Icon name="download" class="w-4 h-4" />
              Export CSV
            </a>
          </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total</p>
              <Icon name="users" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-semibold text-slate-900 mt-2 tabular-nums">{{ stats.total }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Pending</p>
              <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <p class="text-2xl font-semibold text-amber-600 mt-2 tabular-nums">{{ stats.pending }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Confirmed</p>
              <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <p class="text-2xl font-semibold text-emerald-600 mt-2 tabular-nums">{{ stats.confirmed }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Guests</p>
              <Icon name="user-group" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-semibold text-[#00583f] mt-2 tabular-nums">{{ stats.guests }}</p>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-3 mb-6 flex flex-col md:flex-row md:items-center gap-2.5">
          <div class="relative flex-1">
            <Icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" />
            <input
              v-model="filters.search"
              @input="applyFilters"
              type="text"
              placeholder="Search by name, email, or phone…"
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
            />
          </div>

          <select
            v-model="filters.event_id"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all max-w-[240px]"
          >
            <option value="">All events</option>
            <option v-for="ev in events" :key="ev.id" :value="ev.id">{{ ev.title }}</option>
          </select>

          <select
            v-model="filters.status"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="cancelled">Cancelled</option>
          </select>

          <button
            v-if="hasActiveFilters"
            @click="resetFilters"
            class="px-3.5 py-2.5 text-slate-500 text-sm font-medium rounded-lg hover:bg-slate-100 transition-all inline-flex items-center gap-2 whitespace-nowrap"
          >
            <Icon name="x" class="w-3 h-3" />
            Clear
          </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 shadow-[0_1px_3px_rgba(15,23,42,0.04)] overflow-hidden">

          <!-- Empty state -->
          <div v-if="registrations.data.length === 0" class="py-20 px-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-center mb-4">
              <Icon name="users" class="w-5 h-5 text-slate-400" />
            </div>
            <p class="text-sm font-medium text-slate-700">No registrations found</p>
            <p class="text-xs text-slate-500 mt-1.5">Try adjusting your filters or search query.</p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Guest</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Event</th>
                  <th class="px-5 py-3 text-center text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Guests</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Registered</th>
                  <th class="px-5 py-3 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="reg in registrations.data"
                  :key="reg.id"
                  class="transition-colors group hover:bg-slate-50/60"
                >
                  <!-- Guest -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-slate-100 ring-1 ring-slate-200/70 flex items-center justify-center text-[11px] font-semibold text-slate-600 flex-shrink-0">
                        {{ getInitials(reg.full_name) }}
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-900 truncate">{{ reg.full_name }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">#{{ reg.id }}</p>
                      </div>
                    </div>
                  </td>

                  <!-- Contact -->
                  <td class="px-5 py-4">
                    <a
                      :href="`mailto:${reg.email}`"
                      class="text-xs text-slate-700 hover:text-[#00583f] transition-colors truncate max-w-[200px] block"
                    >
                      {{ reg.email }}
                    </a>
                    <p v-if="reg.phone" class="text-[11px] text-slate-400 mt-0.5">{{ reg.phone }}</p>
                  </td>

                  <!-- Event -->
                  <td class="px-5 py-4">
                    <p class="text-xs font-medium text-slate-800 truncate max-w-[200px]">
                      {{ reg.event?.title || '—' }}
                    </p>
                    <p v-if="reg.event?.starts_at" class="text-[11px] text-slate-400 mt-0.5">
                      <i class="far fa-calendar mr-1"></i>{{ formatDate(reg.event.starts_at) }}
                    </p>
                  </td>

                  <!-- Guests count -->
                  <td class="px-5 py-4 text-center">
                    <span class="inline-flex items-center justify-center min-w-[32px] px-2 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-bold tabular-nums">
                      {{ 1 + (reg.guests || 0) }}
                    </span>
                    <p v-if="reg.guests > 0" class="text-[10px] text-slate-400 mt-1">
                      +{{ reg.guests }} extra
                    </p>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <span :class="statusBadgeClass(reg.status)">
                      <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(reg.status)"></span>
                      {{ capitalize(reg.status) }}
                    </span>
                  </td>

                  <!-- Registered -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-600">{{ formatDate(reg.created_at) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ timeAgo(reg.created_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button
                        v-if="reg.status !== 'confirmed'"
                        @click="updateStatus(reg, 'confirmed')"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                        title="Confirm"
                      >
                        <Icon name="check" class="w-4 h-4" />
                      </button>

                      <button
                        v-if="reg.status !== 'cancelled'"
                        @click="updateStatus(reg, 'cancelled')"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                        title="Cancel"
                      >
                        <Icon name="x" class="w-4 h-4" />
                      </button>

                      <button
                        @click="confirmDelete(reg)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                        title="Delete"
                      >
                        <Icon name="trash" class="w-4 h-4" />
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div
            v-if="registrations.links?.length > 3"
            class="px-5 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4 flex-wrap"
          >
            <p class="text-xs text-slate-500">
              Showing
              <span class="font-semibold text-slate-700 tabular-nums">{{ registrations.from }}</span>
              to
              <span class="font-semibold text-slate-700 tabular-nums">{{ registrations.to }}</span>
              of
              <span class="font-semibold text-slate-700 tabular-nums">{{ registrations.total }}</span>
              registrations
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in registrations.links" :key="i">
                <a
                  v-if="link.url"
                  :href="link.url"
                  @click.prevent="goToPage(link.url)"
                  :class="[
                    'px-3 py-1.5 rounded-md text-xs font-medium transition-all min-w-[32px] text-center',
                    link.active ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100'
                  ]"
                >
                  <span v-html="link.label" />
                </a>
                <span
                  v-else
                  :class="[
                    'px-3 py-1.5 rounded-md text-xs font-medium transition-all min-w-[32px] text-center',
                    link.active ? 'bg-slate-900 text-white' : 'text-slate-300 cursor-not-allowed'
                  ]"
                >
                  <span v-html="link.label" />
                </span>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════════ DELETE CONFIRM MODAL ═══════════ -->
    <Transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
    >
      <div
        v-if="showDeleteModal"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        @click.self="showDeleteModal = false"
      >
        <div class="w-full max-w-sm bg-white rounded-xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden">
          <div class="px-6 pt-6 pb-5">
            <div class="w-10 h-10 rounded-full bg-rose-50 ring-1 ring-rose-200/70 flex items-center justify-center mb-4">
              <Icon name="trash" class="w-4 h-4 text-rose-600" />
            </div>
            <h3 class="text-base font-semibold text-slate-900">Delete registration?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              This will permanently remove
              <span class="font-medium text-slate-700">{{ deleting?.full_name }}</span>'s
              registration. This action cannot be undone.
            </p>
          </div>

          <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
            <button
              @click="showDeleteModal = false"
              class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all"
            >
              Cancel
            </button>
            <button
              @click="deleteRegistration"
              class="px-4 py-2 bg-rose-600 text-white font-medium rounded-lg text-sm hover:bg-rose-700 transition-all"
            >
              Delete
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </UserLayout>
</template>

<script setup>
import { router, Head } from '@inertiajs/vue3'
import { h, ref, reactive, computed, defineComponent } from 'vue'
import UserLayout from '@/Layouts/UserLayout.vue'

/* ═══════════════════════════════════════════════════════════
   ICON COMPONENT — inline SVG
   ═══════════════════════════════════════════════════════════ */
const Icon = defineComponent({
  props: {
    name: { type: String, required: true },
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    const icons = {
      'chevron-right': { d: 'M8.25 4.5l7.5 7.5-7.5 7.5' },
      'x':             { d: 'M6 18L18 6M6 6l12 12' },
      'check':         { d: 'M4.5 12.75l6 6 9-13.5' },
      'search': {
        paths: ['M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z'],
      },
      'trash': {
        paths: [
          'M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0',
        ],
      },
      'download': {
        paths: ['M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3'],
      },
      'users': {
        paths: [
          'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
        ],
      },
      'user-group': {
        paths: [
          'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
        ],
      },
    }

    const icon = icons[props.name] || {}
    const paths = icon.paths || [icon.d].filter(Boolean)

    return () =>
      h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: 'none',
        viewBox: '0 0 24 24',
        'stroke-width': props.strokeWidth,
        stroke: 'currentColor',
        class: 'shrink-0',
      }, paths.map((d, i) =>
        h('path', {
          key: i,
          'stroke-linecap': 'round',
          'stroke-linejoin': 'round',
          d,
        })
      ))
  },
})

/* --- Props --- */
const props = defineProps({
  registrations: { type: Object, required: true },
  stats:         { type: Object, required: true },
  events:        { type: Array,  default: () => [] },
  filters:       { type: Object, default: () => ({}) },
})

/* --- Filters --- */
const params = new URLSearchParams(window.location.search)
const filters = reactive({
  search:   props.filters?.search   ?? params.get('search')   ?? '',
  status:   props.filters?.status   ?? params.get('status')   ?? '',
  event_id: props.filters?.event_id ?? params.get('event_id') ?? '',
})

const hasActiveFilters = computed(() =>
  filters.search || filters.status || filters.event_id
)

const exportQuery = computed(() => ({
  status:   filters.status   || undefined,
  event_id: filters.event_id || undefined,
}))

let debounceTimer = null
function applyFilters() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    router.get(route('event-registrations.index'), {
      search:   filters.search   || undefined,
      status:   filters.status   || undefined,
      event_id: filters.event_id || undefined,
    }, {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    })
  }, 300)
}

function resetFilters() {
  filters.search = ''
  filters.status = ''
  filters.event_id = ''
  router.get(route('event-registrations.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

/* --- Actions --- */
function updateStatus(reg, status) {
  router.patch(route('event-registrations.update-status', reg.id), { status }, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      reg.status = status
    },
  })
}

const showDeleteModal = ref(false)
const deleting = ref(null)

function confirmDelete(reg) {
  deleting.value = reg
  showDeleteModal.value = true
}

function deleteRegistration() {
  if (!deleting.value) return
  router.delete(route('event-registrations.destroy', deleting.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
      deleting.value = null
    },
  })
}

function goToPage(url) {
  router.get(url, {}, { preserveState: true, preserveScroll: true })
}

/* --- Helpers --- */
function getInitials(name) {
  if (!name) return '?'
  return name.split(' ').filter(Boolean).slice(0, 2).map(n => n[0].toUpperCase()).join('')
}

function capitalize(str) {
  if (!str) return ''
  return str.charAt(0).toUpperCase() + str.slice(1)
}

function formatDate(dateStr) {
  if (!dateStr) return '—'
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric',
  })
}

function timeAgo(dateStr) {
  if (!dateStr) return ''
  const diff = Date.now() - new Date(dateStr).getTime()
  const mins = Math.floor(diff / 60000)
  if (mins < 1) return 'just now'
  if (mins < 60) return `${mins}m ago`
  const hours = Math.floor(mins / 60)
  if (hours < 24) return `${hours}h ago`
  const days = Math.floor(hours / 24)
  if (days < 30) return `${days}d ago`
  return formatDate(dateStr)
}

function statusBadgeClass(status) {
  const base = 'inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] font-medium'
  switch (status) {
    case 'confirmed': return `${base} bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70`
    case 'pending':   return `${base} bg-amber-50 text-amber-700 ring-1 ring-amber-200/70`
    case 'cancelled': return `${base} bg-rose-50 text-rose-700 ring-1 ring-rose-200/70`
    default:          return `${base} bg-slate-100 text-slate-600 ring-1 ring-slate-200`
  }
}

function statusDotClass(status) {
  switch (status) {
    case 'confirmed': return 'bg-emerald-500'
    case 'pending':   return 'bg-amber-500'
    case 'cancelled': return 'bg-rose-500'
    default:          return 'bg-slate-400'
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  -webkit-font-smoothing: antialiased;
}
</style>