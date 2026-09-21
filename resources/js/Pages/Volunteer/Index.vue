<template>
  <Head title="Volunteers" />
  <UserLayout>
    <div class="min-h-screen w-full bg-[#FAFBFC] py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-8">
          <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5">
            <a href="/" class="hover:text-slate-700 transition-colors">Home</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <a href="#" class="hover:text-slate-700 transition-colors">Admin</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <span class="text-slate-800 font-medium">Volunteers</span>
          </nav>

          <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
              <h1 class="text-2xl md:text-[28px] font-semibold text-slate-900 tracking-tight leading-tight">
                Volunteer Applications
              </h1>
              <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-xl">
                Review, approve, and manage incoming volunteer applications.
              </p>
            </div>

            <!-- Quick stats inline -->
            <div class="flex items-center gap-6">
              <div>
                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total</p>
                <p class="text-lg font-semibold text-slate-900 mt-0.5 tabular-nums">{{ volunteers.total }}</p>
              </div>
              <div class="w-px h-8 bg-slate-200"></div>
              <div>
                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Pending</p>
                <p class="text-lg font-semibold text-amber-600 mt-0.5 tabular-nums">{{ pendingCount }}</p>
              </div>
              <div class="w-px h-8 bg-slate-200"></div>
              <div>
                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Approved</p>
                <p class="text-lg font-semibold text-emerald-600 mt-0.5 tabular-nums">{{ approvedCount }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-3 mb-6 flex flex-col md:flex-row md:items-center gap-2.5">
          <!-- Search -->
          <div class="relative flex-1">
            <Icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" />
            <input
              v-model="filters.search"
              @input="applyFilters"
              type="text"
              placeholder="Search by name or email…"
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
            />
          </div>

          <!-- Status -->
          <select
            v-model="filters.status"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>

          <!-- Interest -->
          <select
            v-model="filters.interest"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All interests</option>
            <option v-for="opt in interestOptions" :key="opt.value" :value="opt.value">
              {{ opt.title }}
            </option>
          </select>

          <!-- Reset -->
          <button
            v-if="hasActiveFilters"
            @click="resetFilters"
            class="px-3.5 py-2.5 text-slate-500 text-sm font-medium rounded-lg hover:bg-slate-100 transition-all flex items-center gap-2 whitespace-nowrap"
          >
            <Icon name="x" class="w-3 h-3" />
            Clear
          </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 shadow-[0_1px_3px_rgba(15,23,42,0.04)] overflow-hidden">

          <!-- Empty state -->
          <div v-if="volunteers.data.length === 0" class="py-20 px-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-center mb-4">
              <Icon name="inbox" class="w-5 h-5 text-slate-400" />
            </div>
            <p class="text-sm font-medium text-slate-700">No volunteer applications</p>
            <p class="text-xs text-slate-500 mt-1.5">Try adjusting your filters or search query.</p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Applicant</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Interests</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Availability</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Applied</th>
                  <th class="px-5 py-3 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="volunteer in volunteers.data"
                  :key="volunteer.id"
                  class="hover:bg-slate-50/60 transition-colors group"
                >
                  <!-- Applicant -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-8 h-8 rounded-full bg-slate-100 ring-1 ring-slate-200/70 flex items-center justify-center text-[11px] font-semibold text-slate-600 flex-shrink-0">
                        {{ getInitials(volunteer.full_name) }}
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-900 truncate">{{ volunteer.full_name }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">#{{ volunteer.id }}</p>
                      </div>
                    </div>
                  </td>

                  <!-- Contact -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-700 truncate max-w-[200px]">{{ volunteer.email }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ volunteer.phone }}</p>
                  </td>

                  <!-- Interests -->
                  <td class="px-5 py-4">
                    <div v-if="volunteer.interests?.length" class="flex flex-wrap gap-1 max-w-[220px]">
                      <span
                        v-for="interest in volunteer.interests.slice(0, 2)"
                        :key="interest"
                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-600"
                      >
                        {{ interest }}
                      </span>
                      <span
                        v-if="volunteer.interests.length > 2"
                        class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-50 text-slate-500 ring-1 ring-slate-200"
                      >
                        +{{ volunteer.interests.length - 2 }}
                      </span>
                    </div>
                    <span v-else class="text-xs text-slate-400">—</span>
                  </td>

                  <!-- Availability -->
                  <td class="px-5 py-4">
                    <p v-if="volunteer.availability?.length" class="text-xs text-slate-600">
                      <span class="font-semibold text-slate-800">{{ volunteer.availability.length }}</span>
                      {{ volunteer.availability.length === 1 ? 'slot' : 'slots' }}
                    </p>
                    <span v-else class="text-xs text-slate-400">—</span>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <span :class="statusBadgeClass(volunteer.status)">
                      <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(volunteer.status)"></span>
                      {{ capitalize(volunteer.status) }}
                    </span>
                  </td>

                  <!-- Applied date -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-600">{{ formatDate(volunteer.created_at) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ timeAgo(volunteer.created_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                      <!-- View -->
                      <button
                        @click="viewVolunteer(volunteer)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all"
                        title="View details"
                      >
                        <Icon name="eye" class="w-4 h-4" />
                      </button>

                      <!-- Approve -->
                      <button
                        v-if="volunteer.status !== 'approved'"
                        @click="approveVolunteer(volunteer)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                        title="Approve"
                      >
                        <Icon name="check" class="w-4 h-4" />
                      </button>

                      <!-- Reject -->
                      <button
                        v-if="volunteer.status !== 'rejected'"
                        @click="rejectVolunteer(volunteer)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                        title="Reject"
                      >
                        <Icon name="x" class="w-4 h-4" />
                      </button>

                      <!-- Delete -->
                      <button
                        @click="confirmDelete(volunteer)"
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
            v-if="volunteers.links?.length > 3"
            class="px-5 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4 flex-wrap"
          >
            <p class="text-xs text-slate-500">
              Showing
              <span class="font-semibold text-slate-700 tabular-nums">{{ volunteers.from }}</span>
              to
              <span class="font-semibold text-slate-700 tabular-nums">{{ volunteers.to }}</span>
              of
              <span class="font-semibold text-slate-700 tabular-nums">{{ volunteers.total }}</span>
              applications
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in volunteers.links" :key="i">
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

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- VIEW DETAILS DRAWER                                    -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showViewDrawer"
           class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm"
           @click.self="closeViewDrawer">

        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="translate-x-full"
          enter-to-class="translate-x-0"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="translate-x-0"
          leave-to-class="translate-x-full"
        >
          <div v-if="showViewDrawer"
               class="absolute right-0 top-0 bottom-0 w-full max-w-xl bg-white shadow-2xl flex flex-col">

            <!-- Drawer header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
              <div>
                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Application #{{ selected?.id }}</p>
                <h2 class="text-base font-semibold text-slate-900 mt-0.5">{{ selected?.full_name }}</h2>
              </div>
              <button @click="closeViewDrawer"
                      class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                <Icon name="x" class="w-4 h-4" />
              </button>
            </div>

            <!-- Drawer body -->
            <div v-if="selected" class="flex-1 overflow-y-auto px-6 py-6 space-y-7">

              <!-- Status strip -->
              <div class="flex items-center justify-between p-3.5 rounded-lg bg-slate-50 ring-1 ring-slate-200/70">
                <div class="flex items-center gap-3">
                  <span :class="statusBadgeClass(selected.status)">
                    <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(selected.status)"></span>
                    {{ capitalize(selected.status) }}
                  </span>
                  <span class="text-xs text-slate-500">Applied {{ timeAgo(selected.created_at) }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                  <button
                    v-if="selected.status !== 'approved'"
                    @click="approveVolunteer(selected)"
                    class="px-2.5 py-1.5 rounded-md text-[11px] font-medium text-emerald-700 bg-emerald-50 ring-1 ring-emerald-200/70 hover:bg-emerald-100 transition-all inline-flex items-center gap-1"
                  >
                    <Icon name="check" class="w-3 h-3" /> Approve
                  </button>
                  <button
                    v-if="selected.status !== 'rejected'"
                    @click="rejectVolunteer(selected)"
                    class="px-2.5 py-1.5 rounded-md text-[11px] font-medium text-rose-700 bg-rose-50 ring-1 ring-rose-200/70 hover:bg-rose-100 transition-all inline-flex items-center gap-1"
                  >
                    <Icon name="x" class="w-3 h-3" /> Reject
                  </button>
                </div>
              </div>

              <!-- Personal Information -->
              <Section title="Personal Information">
                <DetailGrid :items="[
                  { label: 'Full Name', value: selected.full_name },
                  { label: 'Email', value: selected.email },
                  { label: 'Phone', value: selected.phone },
                ]" />
                <DetailGrid :items="[
                  { label: 'Address', value: selected.address },
                  { label: 'City', value: selected.city },
                  { label: 'State', value: selected.state },
                  { label: 'ZIP', value: selected.zip_code },
                ]" />
              </Section>

              <!-- Interests -->
              <Section title="Areas of Interest">
                <div v-if="selected.interests?.length" class="flex flex-wrap gap-2">
                  <span
                    v-for="interest in selected.interests"
                    :key="interest"
                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70"
                  >
                    {{ interest }}
                  </span>
                </div>
                <p v-else class="text-sm text-slate-400">Not specified</p>
              </Section>

              <!-- Availability -->
              <Section title="Availability">
                <div v-if="selected.availability?.length" class="flex flex-wrap gap-1.5">
                  <span
                    v-for="slot in selected.availability"
                    :key="slot"
                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700"
                  >
                    {{ slot }}
                  </span>
                </div>
                <p v-else class="text-sm text-slate-400">Not specified</p>
              </Section>

              <!-- Skills -->
              <Section v-if="selected.skills" title="Skills">
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ selected.skills }}</p>
              </Section>

              <!-- Message -->
              <Section v-if="selected.message" title="Message">
                <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ selected.message }}</p>
              </Section>
            </div>

            <!-- Drawer footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex justify-end gap-2 flex-shrink-0">
              <button @click="closeViewDrawer"
                      class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all">
                Close
              </button>
              <button @click="confirmDelete(selected); closeViewDrawer()"
                      class="px-4 py-2 bg-white text-rose-600 font-medium rounded-lg text-sm border border-rose-200 hover:bg-rose-50 transition-all inline-flex items-center gap-1.5">
                <Icon name="trash" class="w-3.5 h-3.5" /> Delete
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- DELETE CONFIRM MODAL                                   -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <Transition
      enter-active-class="transition duration-150 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
    >
      <div v-if="showDeleteModal"
           class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
           @click.self="showDeleteModal = false">
        <div class="w-full max-w-sm bg-white rounded-xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden">

          <div class="px-6 pt-6 pb-5">
            <div class="w-10 h-10 rounded-full bg-rose-50 ring-1 ring-rose-200/70 flex items-center justify-center mb-4">
              <Icon name="trash" class="w-4 h-4 text-rose-600" />
            </div>
            <h3 class="text-base font-semibold text-slate-900">Delete application?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              This will archive <span class="font-medium text-slate-700">{{ deleting?.full_name }}</span>'s volunteer application. You can restore it later if needed.
            </p>
          </div>

          <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
            <button @click="showDeleteModal = false"
                    class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all">
              Cancel
            </button>
            <button @click="deleteVolunteer"
                    class="px-4 py-2 bg-rose-600 text-white font-medium rounded-lg text-sm hover:bg-rose-700 transition-all">
              Delete
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </UserLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import { h, ref, reactive, computed, defineComponent } from 'vue'
import UserLayout from '@/Layouts/UserLayout.vue'
import { Head } from '@inertiajs/vue3'

/* ═══════════════════════════════════════════════════════════
   ICON COMPONENT — inline SVG (heroicons-style paths)
   Usage: <Icon name="trash" class="w-4 h-4" />
   ═══════════════════════════════════════════════════════════ */
const Icon = defineComponent({
  props: {
    name: { type: String, required: true },
    // optional: stroke width
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    const paths = {
      // Navigation
      'chevron-right': { d: 'M8.25 4.5l7.5 7.5-7.5 7.5', fill: 'none', stroke: true },

      // Search
      'search': {
        paths: [
          { d: 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z', stroke: true },
        ],
      },

      // X / close
      'x': { d: 'M6 18L18 6M6 6l12 12', stroke: true },

      // Check
      'check': { d: 'M4.5 12.75l6 6 9-13.5', stroke: true },

      // Eye
      'eye': {
        paths: [
          { d: 'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z', stroke: true },
          { d: 'M15 12a3 3 0 11-6 0 3 3 0 016 0z', stroke: true },
        ],
      },

      // Trash (solid-ish)
      'trash': {
        paths: [
          { d: 'M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0', stroke: true },
        ],
      },

      // Inbox (empty state)
      'inbox': {
        paths: [
          { d: 'M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z', stroke: true },
        ],
      },
    }

    const icon = paths[props.name] || {}

    return () => {
      // Multi-path icons
      if (icon.paths) {
        return h('svg', {
          xmlns: 'http://www.w3.org/2000/svg',
          fill: 'none',
          viewBox: '0 0 24 24',
          'stroke-width': props.strokeWidth,
          stroke: 'currentColor',
          class: 'shrink-0',
        }, icon.paths.map((p, i) =>
          h('path', {
            key: i,
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
            d: p.d,
          })
        ))
      }

      // Single path
      return h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: icon.fill || 'none',
        viewBox: '0 0 24 24',
        'stroke-width': icon.stroke ? props.strokeWidth : undefined,
        stroke: icon.stroke ? 'currentColor' : undefined,
        class: 'shrink-0',
      }, [
        h('path', {
          'stroke-linecap': 'round',
          'stroke-linejoin': 'round',
          d: icon.d,
        })
      ])
    }
  },
})

/* --- Inline Section component --- */
const Section = (props) =>
  h('div', {}, [
    h('h3', {
      class: 'text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-3'
    }, props.title),
    h('div', { class: 'space-y-4' }, [props.default?.()])
  ])
Section.props = ['title']

/* --- Inline DetailGrid component --- */
const DetailGrid = (props) =>
  h('div', { class: 'grid grid-cols-2 gap-x-6 gap-y-4' },
    props.items.map(item =>
      h('div', { class: 'min-w-0' }, [
        h('p', { class: 'text-[10px] font-medium text-slate-400 uppercase tracking-wider mb-1' }, item.label),
        h('p', { class: 'text-sm text-slate-700 break-words' }, item.value || '—')
      ])
    )
  )
DetailGrid.props = ['items']

/* --- Props --- */
const props = defineProps({
  volunteers: { type: Object, required: true },
})

/* --- Interest options --- */
const interestOptions = [
  { value: 'Event Support',       title: 'Event Support' },
  { value: 'Teaching & Tutoring', title: 'Teaching & Tutoring' },
  { value: 'Fundraising',         title: 'Fundraising' },
  { value: 'Food Distribution',   title: 'Food Distribution' },
  { value: 'Administrative',      title: 'Administrative' },
  { value: 'Community Outreach',  title: 'Community Outreach' },
]

/* --- Filters --- */
const params = new URLSearchParams(window.location.search)
const filters = reactive({
  search: params.get('search') || '',
  status: params.get('status') || '',
  interest: params.get('interest') || '',
})

const hasActiveFilters = computed(() =>
  filters.search || filters.status || filters.interest
)

let debounceTimer = null
function applyFilters() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    router.get(route('volunteer.index'), {
      search: filters.search || undefined,
      status: filters.status || undefined,
      interest: filters.interest || undefined,
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
  filters.interest = ''
  router.get(route('volunteer.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

/* --- Stats --- */
const pendingCount = computed(() =>
  props.volunteers.data.filter(v => v.status === 'pending').length
)
const approvedCount = computed(() =>
  props.volunteers.data.filter(v => v.status === 'approved').length
)

/* --- Modals --- */
const showViewDrawer = ref(false)
const showDeleteModal = ref(false)
const selected = ref(null)
const deleting = ref(null)

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
    case 'approved': return `${base} bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70`
    case 'pending':  return `${base} bg-amber-50 text-amber-700 ring-1 ring-amber-200/70`
    case 'rejected': return `${base} bg-rose-50 text-rose-700 ring-1 ring-rose-200/70`
    default:         return `${base} bg-slate-100 text-slate-600 ring-1 ring-slate-200`
  }
}

function statusDotClass(status) {
  switch (status) {
    case 'approved': return 'bg-emerald-500'
    case 'pending':  return 'bg-amber-500'
    case 'rejected': return 'bg-rose-500'
    default:         return 'bg-slate-400'
  }
}

/* --- Actions --- */
function viewVolunteer(v) {
  selected.value = v
  showViewDrawer.value = true
}

function closeViewDrawer() {
  showViewDrawer.value = false
  selected.value = null
}

function approveVolunteer(v) {
  router.post(route('volunteer.approve', v.id), {}, {
    preserveScroll: true,
    onSuccess: () => {
      if (selected.value?.id === v.id) selected.value.status = 'approved'
    },
  })
}

function rejectVolunteer(v) {
  router.post(route('volunteer.reject', v.id), {}, {
    preserveScroll: true,
    onSuccess: () => {
      if (selected.value?.id === v.id) selected.value.status = 'rejected'
    },
  })
}

function confirmDelete(v) {
  deleting.value = v
  showDeleteModal.value = true
}

function deleteVolunteer() {
  if (!deleting.value) return
  router.delete(route('volunteer.destroy', deleting.value.id), {
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
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  -webkit-font-smoothing: antialiased;
}
</style>