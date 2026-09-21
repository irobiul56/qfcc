<template>
<Head title="Donations"/>
  <UserLayout title="Donations">
    <div class="min-h-screen w-full bg-[#FAFBFC] py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- ═══════════ PAGE HEADER ═══════════ -->
        <div class="mb-8">
          <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5">
            <a href="/" class="hover:text-slate-700 transition-colors">Home</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <a href="#" class="hover:text-slate-700 transition-colors">Admin</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <span class="text-slate-800 font-medium">Donations</span>
          </nav>

          <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
              <h1 class="text-2xl md:text-[28px] font-semibold text-slate-900 tracking-tight leading-tight">
                Donations Dashboard
              </h1>
              <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-xl">
                Track and manage all incoming donations — verify, refund, and export.
              </p>
            </div>

            <a
              :href="route('donations.export', exportQuery)"
              class="px-4 py-2.5 bg-white text-slate-700 text-sm font-medium rounded-lg ring-1 ring-slate-200 inline-flex items-center gap-2 hover:bg-slate-50 hover:ring-slate-300 transition-all"
            >
              <Icon name="download" class="w-4 h-4" />
              Export CSV
            </a>
          </div>
        </div>

        <!-- ═══════════ STATS CARDS ═══════════ -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Raised</p>
              <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <p class="text-2xl font-bold text-emerald-600 mt-2 tabular-nums">
              ${{ formatMoney(stats.total_completed) }}
            </p>
            <p class="text-[11px] text-slate-400 mt-1">
              From {{ stats.donors_count }} donors
            </p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Pending Verification</p>
              <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <p class="text-2xl font-bold text-amber-600 mt-2 tabular-nums">
              ${{ formatMoney(stats.total_pending) }}
            </p>
            <p class="text-[11px] text-slate-400 mt-1">
              Awaiting admin confirmation
            </p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">This Month</p>
              <Icon name="trending-up" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-bold text-slate-900 mt-2 tabular-nums">
              ${{ formatMoney(stats.this_month) }}
            </p>
            <p class="text-[11px] text-slate-400 mt-1">
              Today: ${{ formatMoney(stats.today) }}
            </p>
          </div>
        </div>

        <!-- ═══════════ FILTERS ═══════════ -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-3 mb-6 flex flex-col md:flex-row md:items-center gap-2.5">
          <!-- Search -->
          <div class="relative flex-1">
            <Icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" />
            <input
              v-model="filters.search"
              @input="applyFilters"
              type="text"
              placeholder="Search by donor name, email, or phone…"
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
            />
          </div>

          <!-- Campaign -->
          <select
            v-model="filters.campaign_id"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all max-w-[220px]"
          >
            <option value="">All campaigns</option>
            <option v-for="c in campaigns" :key="c.id" :value="c.id">{{ c.title }}</option>
          </select>

          <!-- Status -->
          <select
            v-model="filters.status"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All statuses</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
            <option value="refunded">Refunded</option>
          </select>

          <!-- Payment method -->
          <select
            v-model="filters.payment_method"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All methods</option>
            <option value="stripe">Stripe</option>
            <option value="zelle">Zelle</option>
            <option value="bank">Bank</option>
            <option value="cash">Cash</option>
          </select>

          <!-- Type -->
          <select
            v-model="filters.type"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All types</option>
            <option value="one_time">One Time</option>
            <option value="monthly">Monthly</option>
          </select>

          <!-- Reset -->
          <button
            v-if="hasActiveFilters"
            @click="resetFilters"
            class="px-3.5 py-2.5 text-slate-500 text-sm font-medium rounded-lg hover:bg-slate-100 transition-all inline-flex items-center gap-2 whitespace-nowrap"
          >
            <Icon name="x" class="w-3 h-3" />
            Clear
          </button>
        </div>

        <!-- ═══════════ TABLE ═══════════ -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 shadow-[0_1px_3px_rgba(15,23,42,0.04)] overflow-hidden">

          <!-- Empty state -->
          <div v-if="donations.data.length === 0" class="py-20 px-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-center mb-4">
              <Icon name="hand-heart" class="w-5 h-5 text-slate-400" />
            </div>
            <p class="text-sm font-medium text-slate-700">No donations found</p>
            <p class="text-xs text-slate-500 mt-1.5">Try adjusting your filters or search query.</p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Donor</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Campaign</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Method</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                  <th class="px-5 py-3 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="donation in donations.data"
                  :key="donation.id"
                  class="transition-colors group hover:bg-slate-50/60"
                >
                  <!-- Donor -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div :class="[
                        'w-8 h-8 rounded-full flex items-center justify-center text-[11px] font-semibold flex-shrink-0',
                        donation.is_anonymous
                          ? 'bg-slate-200 text-slate-500'
                          : 'bg-emerald-100 text-emerald-700'
                      ]">
                        <Icon v-if="donation.is_anonymous" name="user" class="w-3.5 h-3.5" />
                        <span v-else>{{ getInitials(donation.donor_name || donation.email) }}</span>
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-900 truncate">
                          {{ donation.is_anonymous ? 'Anonymous' : (donation.donor_name || 'Anonymous') }}
                        </p>
                        <p class="text-[11px] text-slate-400 truncate">{{ donation.email }}</p>
                      </div>
                    </div>
                  </td>

                  <!-- Campaign -->
                  <td class="px-5 py-4">
                    <p v-if="donation.campaign" class="text-xs font-medium text-slate-800 truncate max-w-[200px]">
                      {{ donation.campaign.title }}
                    </p>
                    <p v-else class="text-xs text-slate-400">—</p>
                    <p v-if="donation.type === 'monthly'" class="text-[10px] font-bold text-indigo-600 mt-0.5 uppercase tracking-wider">
                      <Icon name="repeat" class="w-2.5 h-2.5 inline mr-0.5" />Monthly
                    </p>
                  </td>

                  <!-- Amount -->
                  <td class="px-5 py-4">
                    <p class="text-sm font-bold text-slate-900 tabular-nums">
                      ${{ formatMoney(donation.amount) }}
                    </p>
                    <p v-if="donation.transaction?.reference" class="text-[10px] text-slate-400 font-mono mt-0.5 truncate max-w-[140px]">
                      {{ donation.transaction.reference }}
                    </p>
                  </td>

                  <!-- Method -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-2">
                      <div :class="[
                        'w-6 h-6 rounded flex items-center justify-center flex-shrink-0',
                        methodBgClass(donation.payment_method)
                      ]">
                        <Icon :name="methodIcon(donation.payment_method)" class="w-3 h-3" />
                      </div>
                      <span class="text-xs font-medium text-slate-700 capitalize">
                        {{ donation.payment_method || '—' }}
                      </span>
                    </div>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <span :class="statusBadgeClass(donation.status)">
                      <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(donation.status)"></span>
                      {{ capitalize(donation.status) }}
                    </span>
                  </td>

                  <!-- Date -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-600">{{ formatDate(donation.created_at) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ timeAgo(donation.created_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                      <!-- Verify (pending only) -->
                      <button
                        v-if="donation.status === 'pending' && donation.transaction"
                        @click="confirmVerify(donation)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                        title="Verify & Confirm"
                      >
                        <Icon name="check" class="w-4 h-4" />
                      </button>

                      <!-- Refund (completed only) -->
                      <button
                        v-if="donation.status === 'completed' && donation.transaction"
                        @click="confirmRefund(donation)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                        title="Refund"
                      >
                        <Icon name="refund" class="w-4 h-4" />
                      </button>

                      <!-- Delete -->
                      <button
                        @click="confirmDelete(donation)"
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
            v-if="donations.links?.length > 3"
            class="px-5 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4 flex-wrap"
          >
            <p class="text-xs text-slate-500">
              Showing
              <span class="font-semibold text-slate-700 tabular-nums">{{ donations.from }}</span>
              to
              <span class="font-semibold text-slate-700 tabular-nums">{{ donations.to }}</span>
              of
              <span class="font-semibold text-slate-700 tabular-nums">{{ donations.total }}</span>
              donations
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in donations.links" :key="i">
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

    <!-- ═══════════ VERIFY CONFIRM MODAL ═══════════ -->
    <Transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
    >
      <div
        v-if="showVerifyModal"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        @click.self="showVerifyModal = false"
      >
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden">
          <div class="px-6 pt-6 pb-5">
            <div class="w-10 h-10 rounded-full bg-emerald-50 ring-1 ring-emerald-200/70 flex items-center justify-center mb-4">
              <Icon name="check" class="w-4 h-4 text-emerald-600" />
            </div>
            <h3 class="text-base font-semibold text-slate-900">Verify this donation?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              Confirming
              <span class="font-semibold text-slate-700">${{ formatMoney(activeDonation?.amount) }}</span>
              from
              <span class="font-medium text-slate-700">{{ activeDonation?.donor_name || activeDonation?.email }}</span>.
              This will mark the transaction as completed and add it to the campaign total.
            </p>
          </div>

          <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
            <button
              @click="showVerifyModal = false"
              class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all"
            >
              Cancel
            </button>
            <button
              @click="verifyDonation"
              :disabled="actionProcessing"
              class="px-4 py-2 bg-emerald-600 text-white font-medium rounded-lg text-sm hover:bg-emerald-700 transition-all disabled:opacity-60 inline-flex items-center gap-2"
            >
              <Icon v-if="!actionProcessing" name="check" class="w-3.5 h-3.5" />
              <span v-else class="w-3.5 h-3.5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
              {{ actionProcessing ? 'Verifying…' : 'Verify Donation' }}
            </button>
          </div>
        </div>
      </div>
    </Transition>

    <!-- ═══════════ REFUND CONFIRM MODAL ═══════════ -->
    <Transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
    >
      <div
        v-if="showRefundModal"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        @click.self="showRefundModal = false"
      >
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden">
          <div class="px-6 pt-6 pb-5">
            <div class="w-10 h-10 rounded-full bg-amber-50 ring-1 ring-amber-200/70 flex items-center justify-center mb-4">
              <Icon name="refund" class="w-4 h-4 text-amber-600" />
            </div>
            <h3 class="text-base font-semibold text-slate-900">Refund this donation?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              Refunding
              <span class="font-semibold text-slate-700">${{ formatMoney(activeDonation?.amount) }}</span>
              will reduce the campaign's raised amount and mark this donation as refunded.
            </p>

            <label class="block mt-4 text-xs font-medium text-slate-700">
              Reason (optional)
              <textarea
                v-model="refundReason"
                rows="2"
                placeholder="e.g. Duplicate payment, donor request…"
                class="mt-1.5 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm outline-none focus:border-amber-400 focus:ring-2 focus:ring-amber-100 resize-none"
              ></textarea>
            </label>
          </div>

          <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
            <button
              @click="showRefundModal = false"
              class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all"
            >
              Cancel
            </button>
            <button
              @click="refundDonation"
              :disabled="actionProcessing"
              class="px-4 py-2 bg-amber-600 text-white font-medium rounded-lg text-sm hover:bg-amber-700 transition-all disabled:opacity-60 inline-flex items-center gap-2"
            >
              <Icon v-if="!actionProcessing" name="refund" class="w-3.5 h-3.5" />
              <span v-else class="w-3.5 h-3.5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
              {{ actionProcessing ? 'Refunding…' : 'Refund Donation' }}
            </button>
          </div>
        </div>
      </div>
    </Transition>

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
            <h3 class="text-base font-semibold text-slate-900">Delete this donation?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              This will soft-delete
              <span class="font-medium text-slate-700">{{ activeDonation?.donor_name || activeDonation?.email }}</span>'s
              donation of <span class="font-semibold">${{ formatMoney(activeDonation?.amount) }}</span>.
              This action can be undone by an admin.
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
              @click="deleteDonation"
              :disabled="actionProcessing"
              class="px-4 py-2 bg-rose-600 text-white font-medium rounded-lg text-sm hover:bg-rose-700 transition-all disabled:opacity-60"
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
      'trending-up': {
        paths: ['M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941'],
      },
      'hand-heart': {
        paths: [
          'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z',
        ],
      },
      'user': {
        paths: [
          'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z',
        ],
      },
      'repeat': {
        paths: ['M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99'],
      },
      'credit-card': {
        paths: [
          'M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z',
        ],
      },
      'bank': {
        paths: [
          'M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z',
        ],
      },
      'cash': {
        paths: [
          'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z',
        ],
      },
      'refund': {
        paths: ['M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3'],
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

/* ═══════════════════════════════════════════════════════════
   PROPS
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  donations: { type: Object, required: true },
  stats:     { type: Object, required: true },
  campaigns: { type: Array,  default: () => [] },
  filters:   { type: Object, default: () => ({}) },
})

/* ═══════════════════════════════════════════════════════════
   FILTERS
   ═══════════════════════════════════════════════════════════ */
const params = new URLSearchParams(window.location.search)
const filters = reactive({
  search:         props.filters?.search         ?? params.get('search')         ?? '',
  status:         props.filters?.status         ?? params.get('status')         ?? '',
  campaign_id:    props.filters?.campaign_id    ?? params.get('campaign_id')    ?? '',
  payment_method: props.filters?.payment_method ?? params.get('payment_method') ?? '',
  type:           props.filters?.type           ?? params.get('type')           ?? '',
})

const hasActiveFilters = computed(() =>
  filters.search || filters.status || filters.campaign_id || filters.payment_method || filters.type
)

const exportQuery = computed(() => ({
  status:         filters.status         || undefined,
  campaign_id:    filters.campaign_id    || undefined,
  payment_method: filters.payment_method || undefined,
  type:           filters.type           || undefined,
}))

let debounceTimer = null
function applyFilters() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    router.get(route('donations.index'), {
      search:         filters.search         || undefined,
      status:         filters.status         || undefined,
      campaign_id:    filters.campaign_id    || undefined,
      payment_method: filters.payment_method || undefined,
      type:           filters.type           || undefined,
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
  filters.campaign_id = ''
  filters.payment_method = ''
  filters.type = ''
  router.get(route('donations.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

/* ═══════════════════════════════════════════════════════════
   MODALS & ACTIONS
   ═══════════════════════════════════════════════════════════ */
const showVerifyModal = ref(false)
const showRefundModal = ref(false)
const showDeleteModal = ref(false)
const activeDonation = ref(null)
const refundReason = ref('')
const actionProcessing = ref(false)

function confirmVerify(donation) {
  activeDonation.value = donation
  showVerifyModal.value = true
}

function verifyDonation() {
  if (!activeDonation.value?.transaction) return
  actionProcessing.value = true

  router.post(route('transactions.verify', activeDonation.value.transaction.id), {}, {
    preserveScroll: true,
    onSuccess: () => {
      actionProcessing.value = false
      showVerifyModal.value = false
      activeDonation.value = null
    },
    onError: () => {
      actionProcessing.value = false
    },
  })
}

function confirmRefund(donation) {
  activeDonation.value = donation
  refundReason.value = ''
  showRefundModal.value = true
}

function refundDonation() {
  if (!activeDonation.value?.transaction) return
  actionProcessing.value = true

  router.post(route('transactions.refund', activeDonation.value.transaction.id), {
    reason: refundReason.value || null,
  }, {
    preserveScroll: true,
    onSuccess: () => {
      actionProcessing.value = false
      showRefundModal.value = false
      activeDonation.value = null
      refundReason.value = ''
    },
    onError: () => {
      actionProcessing.value = false
    },
  })
}

function confirmDelete(donation) {
  activeDonation.value = donation
  showDeleteModal.value = true
}

function deleteDonation() {
  if (!activeDonation.value) return
  actionProcessing.value = true

  router.delete(route('donations.destroy', activeDonation.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      actionProcessing.value = false
      showDeleteModal.value = false
      activeDonation.value = null
    },
    onError: () => {
      actionProcessing.value = false
    },
  })
}

function goToPage(url) {
  router.get(url, {}, { preserveState: true, preserveScroll: true })
}

/* ═══════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════ */
function getInitials(name) {
  if (!name) return '?'
  return name.split(' ').filter(Boolean).slice(0, 2).map(n => n[0].toUpperCase()).join('')
}

function capitalize(str) {
  if (!str) return ''
  return str.charAt(0).toUpperCase() + str.slice(1)
}

function formatMoney(amount) {
  if (amount === null || amount === undefined) return '0'
  return Number(amount).toLocaleString('en-US', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  })
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
    case 'completed': return `${base} bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70`
    case 'pending':   return `${base} bg-amber-50 text-amber-700 ring-1 ring-amber-200/70`
    case 'failed':    return `${base} bg-rose-50 text-rose-700 ring-1 ring-rose-200/70`
    case 'refunded':  return `${base} bg-slate-100 text-slate-600 ring-1 ring-slate-200`
    default:          return `${base} bg-slate-100 text-slate-600 ring-1 ring-slate-200`
  }
}

function statusDotClass(status) {
  switch (status) {
    case 'completed': return 'bg-emerald-500'
    case 'pending':   return 'bg-amber-500'
    case 'failed':    return 'bg-rose-500'
    case 'refunded':  return 'bg-slate-400'
    default:          return 'bg-slate-400'
  }
}

function methodIcon(method) {
  switch (method) {
    case 'stripe': return 'credit-card'
    case 'zelle':  return 'bank'
    case 'bank':   return 'bank'
    case 'cash':   return 'cash'
    default:       return 'credit-card'
  }
}

function methodBgClass(method) {
  switch (method) {
    case 'stripe': return 'bg-blue-50 text-blue-600'
    case 'zelle':  return 'bg-purple-50 text-purple-600'
    case 'bank':   return 'bg-indigo-50 text-indigo-600'
    case 'cash':   return 'bg-emerald-50 text-emerald-600'
    default:       return 'bg-slate-100 text-slate-500'
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