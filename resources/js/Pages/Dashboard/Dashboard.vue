<script setup>
import { computed } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import UserLayout from '@/Layouts/UserLayout.vue'

/* ═══════════════════════════════════════════════════════════
   PROPS FROM CONTROLLER
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  stats:            { type: Object, required: true },
  donationChart:    { type: Array,  default: () => [] },
  donationTypes:    { type: Array,  default: () => [] },
  recentDonations:  { type: Array,  default: () => [] },
  upcomingEvents:   { type: Array,  default: () => [] },
  recentVolunteers: { type: Array,  default: () => [] },
  topDonors:        { type: Array,  default: () => [] },
  recentMessages:   { type: Array,  default: () => [] },
})

/* ═══════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════ */
const currentDate = new Date()

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(amount || 0)
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric',
  })
}

const formatDateTime = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric',
    hour: '2-digit', minute: '2-digit',
  })
}

const timeAgo = (date) => {
  const seconds = Math.floor((new Date() - new Date(date)) / 1000)
  if (seconds < 60) return 'just now'
  if (seconds < 3600) return `${Math.floor(seconds / 60)}m ago`
  if (seconds < 86400) return `${Math.floor(seconds / 3600)}h ago`
  if (seconds < 604800) return `${Math.floor(seconds / 86400)}d ago`
  return formatDate(date)
}

const donationTypeLabel = (type) => (type === 'monthly' ? 'Monthly' : 'One-time')

const statusBadge = (status) => {
  const map = {
    pending:  { bg: 'bg-amber-100',   text: 'text-amber-700' },
    approved: { bg: 'bg-emerald-100', text: 'text-emerald-700' },
    rejected: { bg: 'bg-red-100',     text: 'text-red-700' },
    active:   { bg: 'bg-emerald-100', text: 'text-emerald-700' },
    inactive: { bg: 'bg-gray-100',    text: 'text-gray-700' },
  }
  return map[status] || { bg: 'bg-gray-100', text: 'text-gray-700' }
}

/* ═══════════════════════════════════════════════════════════
   STAT CARDS
   ═══════════════════════════════════════════════════════════ */
const statCards = computed(() => [
  {
    label: 'Total Donations',
    value: formatCurrency(props.stats.total_donations),
    sub: `${formatCurrency(props.stats.donations_this_month)} this month`,
    icon: 'fa-solid fa-hand-holding-dollar',
    bgLight: 'bg-emerald-50',
    textColor: 'text-emerald-600',
    barColor: 'from-emerald-500 to-emerald-600',
  },
  {
    label: 'Total Volunteers',
    value: props.stats.total_volunteers,
    sub: `${props.stats.pending_volunteers} pending approval`,
    icon: 'fa-solid fa-hands-helping',
    bgLight: 'bg-blue-50',
    textColor: 'text-blue-600',
    barColor: 'from-blue-500 to-blue-600',
  },
  {
    label: 'Active Members',
    value: props.stats.active_members,
    sub: `${props.stats.total_members} total members`,
    icon: 'fa-solid fa-users',
    bgLight: 'bg-purple-50',
    textColor: 'text-purple-600',
    barColor: 'from-purple-500 to-purple-600',
  },
  {
    label: 'Upcoming Events',
    value: props.stats.upcoming_events,
    sub: `${props.stats.total_events} total events`,
    icon: 'fa-solid fa-calendar-days',
    bgLight: 'bg-amber-50',
    textColor: 'text-amber-600',
    barColor: 'from-amber-500 to-amber-600',
  },
  {
    label: 'Event Registrations',
    value: props.stats.total_registrations,
    sub: 'Total registrations',
    icon: 'fa-solid fa-clipboard-list',
    bgLight: 'bg-rose-50',
    textColor: 'text-rose-600',
    barColor: 'from-rose-500 to-rose-600',
  },
  {
    label: 'Newsletter Subscribers',
    value: props.stats.newsletter_subscribers,
    sub: 'Active subscribers',
    icon: 'fa-solid fa-envelope',
    bgLight: 'bg-cyan-50',
    textColor: 'text-cyan-600',
    barColor: 'from-cyan-500 to-cyan-600',
  },
  {
    label: 'Active Programs',
    value: props.stats.active_programs,
    sub: `${props.stats.total_programs} total programs`,
    icon: 'fa-solid fa-graduation-cap',
    bgLight: 'bg-indigo-50',
    textColor: 'text-indigo-600',
    barColor: 'from-indigo-500 to-indigo-600',
  },
  {
    label: 'Unread Messages',
    value: props.stats.unread_messages,
    sub: 'Need your attention',
    icon: 'fa-solid fa-envelope-open-text',
    bgLight: 'bg-red-50',
    textColor: 'text-red-600',
    barColor: 'from-red-500 to-red-600',
    alert: props.stats.unread_messages > 0,
  },
])

/* ═══════════════════════════════════════════════════════════
   QUICK ACTIONS
   ═══════════════════════════════════════════════════════════ */
const quickActions = [
  { label: 'Add Program',    icon: 'fa-solid fa-plus',          color: 'bg-indigo-500 hover:bg-indigo-600',   href: '#' },
  { label: 'Create Event',   icon: 'fa-solid fa-calendar-plus', color: 'bg-amber-500 hover:bg-amber-600',     href: '#' },
  { label: 'New Campaign',   icon: 'fa-solid fa-bullhorn',      color: 'bg-emerald-500 hover:bg-emerald-600', href: '#' },
  { label: 'View Donations', icon: 'fa-solid fa-list',          color: 'bg-blue-500 hover:bg-blue-600',       href: '#' },
]

/* ═══════════════════════════════════════════════════════════
   CHART
   ═══════════════════════════════════════════════════════════ */
const donationChartMax = computed(() => {
  if (!props.donationChart.length) return 1
  return Math.max(...props.donationChart.map(d => d.total)) * 1.15
})

const donationTypesTotal = computed(() =>
  props.donationTypes.reduce((sum, t) => sum + t.total, 0)
)
</script>

<template>
  <Head title="Dashboard" />

  <UserLayout>
    <div class="min-h-screen w-full bg-gray-50">
      <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 py-6">

        <!-- ═══════════ WELCOME HEADER ═══════════ -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#003d2c] via-[#00583f] to-[#006b4e] shadow-xl mb-6">
          <div class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(circle at 20% 50%, #d9a52b 0%, transparent 50%), radial-gradient(circle at 80% 80%, #d9a52b 0%, transparent 40%);">
          </div>

          <div class="relative px-6 py-8 sm:px-10 sm:py-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
              <p class="text-[#d9a52b] text-xs font-bold tracking-[0.2em] uppercase mb-2">
                Welcome Back
              </p>
              <h1 class="text-white text-2xl sm:text-3xl lg:text-4xl font-serif font-bold leading-tight">
                Assalamu Alaikum, <span class="text-[#e3b13a]">Admin</span>
              </h1>
              <p class="text-white/70 text-sm mt-2 max-w-xl">
                Here's an overview of your community center's activity and performance today.
              </p>
            </div>

            <div class="flex items-center gap-3">
              <div class="hidden sm:flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/20">
                <i class="fa-solid fa-clock text-[#d9a52b]"></i>
                <div>
                  <p class="text-white text-xs font-semibold">
                    {{ currentDate.toLocaleDateString('en-US', { weekday: 'long' }) }}
                  </p>
                  <p class="text-white/60 text-[10px]">
                    {{ currentDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }) }}
                  </p>
                </div>
              </div>

              <Link :href="route('events.index')"
                class="inline-flex items-center gap-2 bg-[#d9a52b] hover:bg-[#c9951f] text-white text-sm font-bold px-5 py-3 rounded-lg transition-all hover:shadow-lg hover:-translate-y-0.5">
                <i class="fa-solid fa-plus"></i>
                <span class="hidden sm:inline">New Event</span>
              </Link>
            </div>
          </div>
        </div>

        <!-- ═══════════ STAT CARDS GRID ═══════════ -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div v-for="(card, index) in statCards" :key="index"
            class="group relative bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r transition-all duration-300"
              :class="card.barColor"></div>

            <div class="flex items-start justify-between mb-3">
              <div class="flex items-center justify-center w-11 h-11 rounded-lg transition-transform duration-300 group-hover:scale-110"
                :class="card.bgLight">
                <i :class="[card.icon, card.textColor, 'text-lg']"></i>
              </div>

              <div v-if="card.alert"
                class="flex items-center gap-1 text-[10px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full animate-pulse">
                <i class="fa-solid fa-circle text-[6px]"></i>
                NEW
              </div>
              <div v-else class="flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <i class="fa-solid fa-arrow-trend-up"></i>
              </div>
            </div>

            <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">{{ card.label }}</p>
            <p class="text-gray-900 text-2xl font-bold leading-tight">{{ card.value }}</p>
            <p class="text-gray-400 text-xs mt-1">{{ card.sub }}</p>
          </div>
        </div>


        <!-- ═══════════ CHARTS ROW ═══════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

          <!-- Donation Chart -->
          <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
              <div>
                <h3 class="text-gray-900 font-bold text-base">Donation Overview</h3>
                <p class="text-gray-400 text-xs mt-0.5">Last 12 months performance</p>
              </div>
              <div class="flex items-center gap-2 text-xs">
                <span class="flex items-center gap-1.5 text-gray-500">
                  <span class="w-2.5 h-2.5 rounded-full bg-[#00583f]"></span>
                  Donations
                </span>
              </div>
            </div>

            <div v-if="donationChart.length" class="flex items-end justify-between gap-1.5 h-48">
              <div v-for="(item, i) in donationChart" :key="i" class="flex-1 flex flex-col items-center gap-2 group">
                <div class="relative w-full flex justify-center">
                  <div class="absolute -top-8 opacity-0 group-hover:opacity-100 transition-opacity bg-gray-900 text-white text-[10px] font-bold px-2 py-1 rounded whitespace-nowrap pointer-events-none z-10">
                    {{ formatCurrency(item.total) }}
                  </div>
                  <div
                    class="w-full max-w-[32px] bg-gradient-to-t from-[#00583f] to-[#007a55] rounded-t-md hover:from-[#d9a52b] hover:to-[#e3b13a] transition-all duration-300 cursor-pointer"
                    :style="{ height: `${Math.max((item.total / donationChartMax) * 160, 8)}px` }"
                  ></div>
                </div>
                <span class="text-[9px] font-semibold text-gray-400 group-hover:text-gray-700">
                  {{ new Date(item.month + '-01').toLocaleDateString('en-US', { month: 'short' }) }}
                </span>
              </div>
            </div>

            <div v-else class="flex items-center justify-center h-48 text-sm text-gray-400">
              No donation data yet
            </div>
          </div>

          <!-- Donation Types -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-gray-900 font-bold text-base mb-1">Donation Types</h3>
            <p class="text-gray-400 text-xs mb-5">Breakdown by type</p>

            <div class="space-y-4">
              <div v-for="type in donationTypes" :key="type.type" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                    :class="type.type === 'monthly' ? 'bg-purple-50 text-purple-600' : 'bg-emerald-50 text-emerald-600'">
                    <i :class="type.type === 'monthly' ? 'fa-solid fa-repeat' : 'fa-solid fa-hand-holding-heart'"></i>
                  </div>
                  <div>
                    <p class="text-sm font-bold text-gray-800">{{ donationTypeLabel(type.type) }}</p>
                    <p class="text-[10px] text-gray-400">{{ type.count }} donations</p>
                  </div>
                </div>
                <p class="text-sm font-bold text-gray-900">{{ formatCurrency(type.total) }}</p>
              </div>
            </div>

            <div class="mt-5 pt-5 border-t border-gray-100">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 uppercase">Total</span>
                <span class="text-lg font-bold text-[#00583f]">
                  {{ formatCurrency(donationTypesTotal) }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- ═══════════ MAIN CONTENT GRID ═══════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

          <!-- Recent Donations -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
              <h3 class="text-gray-900 font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-hand-holding-dollar text-emerald-500"></i>
                Recent Donations
              </h3>
              <Link :href="route('donations.index')" class="text-[11px] font-bold text-[#00583f] hover:text-[#d9a52b] transition-colors">
                View All <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </Link>
            </div>
            <div v-if="recentDonations.length" class="divide-y divide-gray-50">
              <div v-for="donation in recentDonations" :key="donation.id"
                class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ (donation.donor_name || 'A').charAt(0).toUpperCase() }}
                  </div>
                  <div class="min-w-0">
                    <p class="text-xs font-bold text-gray-800 truncate">{{ donation.donor_name || 'Anonymous' }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ timeAgo(donation.created_at) }}</p>
                  </div>
                </div>
                <div class="text-right flex-shrink-0">
                  <p class="text-sm font-bold text-emerald-600">{{ formatCurrency(donation.amount) }}</p>
                  <p class="text-[9px] text-gray-400">{{ donationTypeLabel(donation.type) }}</p>
                </div>
              </div>
            </div>
            <div v-else class="px-5 py-10 text-center text-xs text-gray-400">
              No donations yet
            </div>
          </div>

          <!-- Upcoming Events -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
              <h3 class="text-gray-900 font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-amber-500"></i>
                Upcoming Events
              </h3>
              <Link :href="route('events.index')" class="text-[11px] font-bold text-[#00583f] hover:text-[#d9a52b] transition-colors">
                View All <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </Link>
            </div>
            <div v-if="upcomingEvents.length" class="divide-y divide-gray-50">
              <div v-for="event in upcomingEvents" :key="event.id"
                class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-amber-400 to-amber-600 flex-shrink-0">
                  <div class="w-full h-full flex items-center justify-center text-white">
                    <i class="fa-solid fa-calendar text-lg"></i>
                  </div>
                </div>
                <div class="min-w-0 flex-1">
                  <p class="text-xs font-bold text-gray-800 truncate">{{ event.title }}</p>
                  <p class="text-[10px] text-gray-400 flex items-center gap-1 mt-0.5">
                    <i class="fa-regular fa-clock"></i>
                    {{ formatDateTime(event.starts_at) }}
                  </p>
                  <p v-if="event.location" class="text-[10px] text-gray-400 flex items-center gap-1">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ event.location }}
                  </p>
                </div>
              </div>
            </div>
            <div v-else class="px-5 py-10 text-center text-xs text-gray-400">
              No upcoming events
            </div>
          </div>

          <!-- Recent Volunteers -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
              <h3 class="text-gray-900 font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-hands-helping text-blue-500"></i>
                Recent Volunteers
              </h3>
              <Link :href="route('volunteer.index')" class="text-[11px] font-bold text-[#00583f] hover:text-[#d9a52b] transition-colors">
                View All <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </Link>
            </div>
            <div v-if="recentVolunteers.length" class="divide-y divide-gray-50">
              <div v-for="volunteer in recentVolunteers" :key="volunteer.id"
                class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                  <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0">
                    {{ volunteer.full_name.charAt(0).toUpperCase() }}
                  </div>
                  <div class="min-w-0">
                    <p class="text-xs font-bold text-gray-800 truncate">{{ volunteer.full_name }}</p>
                    <p class="text-[10px] text-gray-400 truncate">{{ volunteer.email }}</p>
                  </div>
                </div>
                <span :class="[statusBadge(volunteer.status).bg, statusBadge(volunteer.status).text, 'text-[9px] font-bold px-2 py-1 rounded-full capitalize flex-shrink-0']">
                  {{ volunteer.status }}
                </span>
              </div>
            </div>
            <div v-else class="px-5 py-10 text-center text-xs text-gray-400">
              No volunteers yet
            </div>
          </div>
        </div>

        <!-- ═══════════ BOTTOM ROW ═══════════ -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <!-- Top Donors -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
              <h3 class="text-gray-900 font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-crown text-[#d9a52b]"></i>
                Top Donors
              </h3>
              <span class="text-[10px] font-bold text-gray-400 uppercase">All Time</span>
            </div>
            <div v-if="topDonors.length" class="divide-y divide-gray-50">
              <div v-for="(donor, index) in topDonors" :key="index"
                class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                  <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                    :class="[
                      index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600 text-white' :
                      index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-white' :
                      index === 2 ? 'bg-gradient-to-br from-amber-600 to-amber-800 text-white' :
                      'bg-gray-100 text-gray-600'
                    ]">
                    {{ index + 1 }}
                  </div>
                  <div>
                    <p class="text-xs font-bold text-gray-800">{{ donor.name }}</p>
                    <p class="text-[10px] text-gray-400">{{ donor.email }}</p>
                  </div>
                </div>
                <p class="text-sm font-bold text-[#00583f]">{{ formatCurrency(donor.total_donated) }}</p>
              </div>
            </div>
            <div v-else class="px-5 py-10 text-center text-xs text-gray-400">
              No donor data yet
            </div>
          </div>

          <!-- Recent Messages -->
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
              <h3 class="text-gray-900 font-bold text-sm flex items-center gap-2">
                <i class="fa-solid fa-envelope text-rose-500"></i>
                Recent Messages
                <span v-if="stats.unread_messages > 0"
                  class="ml-1 text-[10px] font-bold bg-rose-500 text-white px-2 py-0.5 rounded-full">
                  {{ stats.unread_messages }} new
                </span>
              </h3>
              <Link :href="route('contact-messages.index')" class="text-[11px] font-bold text-[#00583f] hover:text-[#d9a52b] transition-colors">
                View All <i class="fa-solid fa-arrow-right text-[9px]"></i>
              </Link>
            </div>
            <div v-if="recentMessages.length" class="divide-y divide-gray-50">
              <div v-for="message in recentMessages" :key="message.id"
                class="flex items-start gap-3 px-5 py-3 hover:bg-gray-50 transition-colors cursor-pointer">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                  :class="message.is_read ? 'bg-gray-100 text-gray-500' : 'bg-rose-100 text-rose-600'">
                  {{ message.full_name.charAt(0).toUpperCase() }}
                </div>
                <div class="min-w-0 flex-1">
                  <div class="flex items-center justify-between gap-2">
                    <p class="text-xs font-bold text-gray-800 truncate">{{ message.full_name }}</p>
                    <span v-if="!message.is_read" class="w-2 h-2 rounded-full bg-rose-500 flex-shrink-0"></span>
                  </div>
                  <p class="text-[11px] text-gray-600 truncate mt-0.5">{{ message.subject }}</p>
                  <p class="text-[10px] text-gray-400 mt-0.5">{{ timeAgo(message.created_at) }}</p>
                </div>
              </div>
            </div>
            <div v-else class="px-5 py-10 text-center text-xs text-gray-400">
              No messages yet
            </div>
          </div>
        </div>

      </div>
    </div>
  </UserLayout>
</template>