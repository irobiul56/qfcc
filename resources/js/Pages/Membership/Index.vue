<template>
  <Head title="Memberships" />
  <UserLayout title="Memberships">
    <div class="min-h-screen bg-slate-50 py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
              Memberships
            </h1>
            <p class="text-slate-500 text-sm mt-1.5">
              Manage membership applications, payments, and member statuses.
            </p>
          </div>

          <!-- Stats -->
          <div class="flex flex-wrap items-center gap-3">
            <div class="px-4 py-2.5 bg-white rounded-xl ring-1 ring-slate-200/80 flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              </div>
              <div>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Total</p>
                <p class="text-sm font-bold text-slate-900">{{ memberships.total }}</p>
              </div>
            </div>

            <div class="px-4 py-2.5 bg-white rounded-xl ring-1 ring-slate-200/80 flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Approved</p>
                <p class="text-sm font-bold text-slate-900">{{ approvedCount }}</p>
              </div>
            </div>

            <div class="px-4 py-2.5 bg-white rounded-xl ring-1 ring-slate-200/80 flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Pending</p>
                <p class="text-sm font-bold text-slate-900">{{ pendingCount }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Filters Bar -->
        <div class="bg-white rounded-2xl ring-1 ring-slate-200/80 p-4 mb-6 flex flex-col md:flex-row md:items-center gap-3">

          <!-- Search -->
          <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
              v-model="filters.search"
              @input="applyFilters"
              type="text"
              placeholder="Search by name, email, or reference..."
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
            />
          </div>

          <!-- Membership Type Filter -->
          <select
            v-model="filters.type"
            @change="applyFilters"
            class="px-4 py-2.5 bg-slate-50 rounded-lg text-sm text-slate-800 border border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
          >
            <option value="">All Types</option>
            <option value="General Member">General Member</option>
            <option value="Lifetime Member">Lifetime Member</option>
          </select>

          <!-- Status Filter -->
          <select
            v-model="filters.status"
            @change="applyFilters"
            class="px-4 py-2.5 bg-slate-50 rounded-lg text-sm text-slate-800 border border-slate-200 focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100 outline-none transition-all"
          >
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
          </select>

          <!-- Reset -->
          <button
            @click="resetFilters"
            class="px-4 py-2.5 text-slate-600 text-sm font-medium rounded-lg ring-1 ring-slate-200 hover:bg-slate-50 transition-all whitespace-nowrap"
          >
            Reset
          </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl ring-1 ring-slate-200/80 overflow-hidden">

          <!-- Empty state -->
          <div v-if="memberships.data.length === 0" class="p-16 text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <p class="text-slate-600 font-semibold">No memberships found</p>
            <p class="text-slate-400 text-sm mt-1">Try adjusting your filters or search query.</p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="bg-slate-50/70 border-b border-slate-200">
                  <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Member</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Amount</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Payment</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                  <th class="px-5 py-3.5 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="membership in memberships.data"
                  :key="membership.id"
                  class="hover:bg-slate-50/70 transition-colors"
                >
                  <!-- Member -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ getInitials(membership.full_name) }}
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">
                          {{ membership.full_name }}
                        </p>
                        <p class="text-xs text-slate-500 truncate">
                          {{ membership.email || '—' }}
                        </p>
                      </div>
                    </div>
                  </td>

                  <!-- Type -->
                  <td class="px-5 py-4">
                    <span :class="[
                      'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-semibold',
                      membership.membership_type === 'Lifetime Member'
                        ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200/70'
                        : 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200/70'
                    ]">
                      <span>{{ membership.membership_type === 'Lifetime Member' ? '★' : '👤' }}</span>
                      {{ membership.membership_type }}
                    </span>
                  </td>

                  <!-- Amount -->
                  <td class="px-5 py-4">
                    <p class="text-sm font-bold text-slate-900">
                      ${{ Number(membership.amount).toFixed(2) }}
                    </p>
                    <p v-if="membership.latest_transaction?.reference" class="text-[10px] text-slate-400 font-mono mt-0.5 truncate max-w-[140px]">
                      {{ membership.latest_transaction.reference }}
                    </p>
                  </td>

                  <!-- Payment Method -->
                  <td class="px-5 py-4">
                    <div v-if="membership.latest_transaction" class="flex items-center gap-2">
                      <div :class="[
                        'w-6 h-6 rounded flex items-center justify-center',
                        membership.latest_transaction.payment_method === 'stripe'
                          ? 'bg-blue-50'
                          : 'bg-purple-50'
                      ]">
                        <svg v-if="membership.latest_transaction.payment_method === 'stripe'" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span v-else class="text-[10px] font-bold text-purple-600">Z</span>
                      </div>
                      <div>
                        <p class="text-xs font-semibold text-slate-700 capitalize">
                          {{ membership.latest_transaction.payment_method }}
                          <span v-if="membership.latest_transaction.card_last4" class="text-slate-400 font-normal">
                            ••{{ membership.latest_transaction.card_last4 }}
                          </span>
                        </p>
                        <p class="text-[10px] text-slate-400 capitalize">
                          {{ membership.latest_transaction.status }}
                        </p>
                      </div>
                    </div>
                    <span v-else class="text-xs text-slate-400">No payment</span>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <span :class="statusBadgeClass(membership.status)">
                      <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(membership.status)"></span>
                      {{ capitalize(membership.status) }}
                    </span>
                  </td>

                  <!-- Date -->
                  <td class="px-5 py-4">
                    <p class="text-xs font-medium text-slate-700">{{ formatDate(membership.created_at) }}</p>
                    <p class="text-[10px] text-slate-400">{{ formatTime(membership.created_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">

                      <!-- View -->
                      <button
                        @click="viewMembership(membership)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all"
                        title="View details"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                      </button>

                      <!-- Approve (only if pending) -->
                      <button
                        v-if="membership.status === 'pending'"
                        @click="approveMembership(membership)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                        title="Approve"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                      </button>

                      <!-- Reject (only if pending) -->
                      <button
                        v-if="membership.status === 'pending'"
                        @click="rejectMembership(membership)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                        title="Reject"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>

                      <!-- Delete -->
                      <button
                        @click="confirmDelete(membership)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                        title="Delete"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div v-if="memberships.links?.length > 3" class="px-5 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between gap-4 flex-wrap">
            <p class="text-xs text-slate-500">
              Showing <span class="font-semibold text-slate-700">{{ memberships.from }}</span>
              to <span class="font-semibold text-slate-700">{{ memberships.to }}</span>
              of <span class="font-semibold text-slate-700">{{ memberships.total }}</span> results
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in memberships.links" :key="i">
                <component
                  :is="link.url ? 'a' : 'span'"
                  :href="link.url || '#'"
                  @click.prevent="link.url && goToPage(link.url)"
                  v-html="link.label"
                  :class="[
                    'px-3 py-1.5 rounded-lg text-xs font-medium transition-all',
                    link.active
                      ? 'bg-indigo-600 text-white'
                      : link.url
                        ? 'text-slate-600 hover:bg-slate-100'
                        : 'text-slate-300 cursor-not-allowed'
                  ]"
                />
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================= -->
    <!-- VIEW DETAILS MODAL                             -->
    <!-- ============================================= -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showViewModal"
           class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
           @click.self="showViewModal = false">
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
        >
          <div v-if="showViewModal"
               class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden max-h-[90vh] flex flex-col">

            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white text-sm font-bold">
                  {{ getInitials(selectedMembership?.full_name) }}
                </div>
                <div>
                  <h2 class="text-base font-semibold text-slate-900">
                    {{ selectedMembership?.full_name }}
                  </h2>
                  <p class="text-[11px] text-slate-500">
                    Applied on {{ formatDate(selectedMembership?.created_at) }}
                  </p>
                </div>
              </div>
              <button @click="showViewModal = false"
                      class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Body -->
            <div v-if="selectedMembership" class="p-6 overflow-y-auto flex-1 space-y-5">

              <!-- Membership + payment -->
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
                  <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Type</p>
                  <p class="text-sm font-semibold text-slate-900">{{ selectedMembership.membership_type }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
                  <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Amount</p>
                  <p class="text-sm font-bold text-slate-900">${{ Number(selectedMembership.amount).toFixed(2) }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
                  <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Status</p>
                  <span :class="statusBadgeClass(selectedMembership.status)">
                    <span class="w-1.5 h-1.5 rounded-full" :class="statusDotClass(selectedMembership.status)"></span>
                    {{ capitalize(selectedMembership.status) }}
                  </span>
                </div>
              </div>

              <!-- Personal Info -->
              <div>
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Personal Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                  <DetailRow label="Full Name" :value="selectedMembership.full_name" />
                  <DetailRow label="Email" :value="selectedMembership.email" />
                  <DetailRow label="Phone" :value="selectedMembership.phone" />
                  <DetailRow label="Date of Birth" :value="selectedMembership.dob" />
                  <DetailRow label="Gender" :value="selectedMembership.gender" />
                  <DetailRow label="Marital Status" :value="selectedMembership.marital_status" />
                  <DetailRow label="Occupation" :value="selectedMembership.occupation" />
                  <DetailRow label="Address" :value="selectedMembership.address" />
                  <DetailRow label="City" :value="selectedMembership.city" />
                  <DetailRow label="State" :value="selectedMembership.state" />
                  <DetailRow label="ZIP" :value="selectedMembership.zip" />
                </div>
              </div>

              <!-- Family Info -->
              <div v-if="selectedMembership.spouse_name || selectedMembership.children?.length">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Family Information</h3>
                <div class="space-y-3">
                  <div v-if="selectedMembership.spouse_name" class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Spouse</p>
                    <p class="text-sm font-semibold text-slate-900">{{ selectedMembership.spouse_name }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">
                      {{ selectedMembership.spouse_occupation || '—' }}
                    </p>
                  </div>

                  <div v-if="selectedMembership.children?.length" class="space-y-2">
                    <p class="text-xs font-medium text-slate-500">Children ({{ selectedMembership.children.length }})</p>
                    <div v-for="(child, i) in selectedMembership.children" :key="i"
                         class="p-3 rounded-lg bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-between">
                      <div>
                        <p class="text-sm font-semibold text-slate-900">{{ child.fullName }}</p>
                        <p class="text-[11px] text-slate-500">
                          {{ child.gender || '—' }} · {{ child.occupation || '—' }}
                        </p>
                      </div>
                      <p class="text-[11px] text-slate-400">{{ child.dob || '—' }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Emergency Contact -->
              <div v-if="selectedMembership.emergency_name">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Emergency Contact</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                  <DetailRow label="Name" :value="selectedMembership.emergency_name" />
                  <DetailRow label="Relationship" :value="selectedMembership.emergency_relationship" />
                  <DetailRow label="Phone" :value="selectedMembership.emergency_phone" />
                  <DetailRow label="Email" :value="selectedMembership.emergency_email" />
                </div>
              </div>

              <!-- Transaction -->
              <div v-if="selectedMembership.latest_transaction">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Transaction</h3>
                <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70 space-y-2">
                  <DetailRow label="Reference" :value="selectedMembership.latest_transaction.reference" mono />
                  <DetailRow label="Method" :value="capitalize(selectedMembership.latest_transaction.payment_method)" />
                  <DetailRow label="Status" :value="capitalize(selectedMembership.latest_transaction.status)" />
                  <DetailRow v-if="selectedMembership.latest_transaction.card_last4" label="Card" :value="'•••• ' + selectedMembership.latest_transaction.card_last4" />
                  <DetailRow v-if="selectedMembership.latest_transaction.zelle_reference" label="Zelle Ref" :value="selectedMembership.latest_transaction.zelle_reference" />
                </div>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>

    <!-- ============================================= -->
    <!-- DELETE CONFIRM MODAL                           -->
    <!-- ============================================= -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
    >
      <div v-if="showDeleteModal"
           class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
           @click.self="showDeleteModal = false">
        <div class="w-full max-w-sm bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 p-6 text-center">
          <div class="w-14 h-14 mx-auto rounded-full bg-rose-50 flex items-center justify-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <h3 class="text-base font-bold text-slate-900 mb-1.5">Delete membership?</h3>
          <p class="text-sm text-slate-500 leading-relaxed mb-6">
            This will permanently remove <span class="font-semibold text-slate-700">{{ deletingMembership?.full_name }}</span>'s application and all related transactions. This action cannot be undone.
          </p>
          <div class="flex gap-2.5">
            <button @click="showDeleteModal = false"
                    class="flex-1 px-4 py-2.5 bg-white text-slate-600 font-medium rounded-lg text-xs ring-1 ring-slate-200 hover:bg-slate-50 transition-all">
              Cancel
            </button>
            <button @click="deleteMembership"
                    class="flex-1 px-4 py-2.5 bg-rose-600 text-white font-semibold rounded-lg text-xs hover:bg-rose-700 transition-all">
              Delete
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </UserLayout>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { h, ref, reactive, computed, defineComponent } from 'vue'
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';

/* --- Inline DetailRow component --- */
const DetailRow = defineComponent({
  props: ['label', 'value', 'mono'],
  setup(props) {
    return () => h('div', { class: 'flex flex-col' }, [
      h('span', { class: 'text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5' }, props.label),
      h('span', {
        class: [
          'text-sm text-slate-700',
          props.mono ? 'font-mono text-xs' : 'font-medium'
        ]
      }, props.value || '—')
    ])
  }
})

/* --- Props from Inertia --- */
const props = defineProps({
  memberships: { type: Object, required: true }
})

/* --- Filters --- */
const filters = reactive({
  search: new URLSearchParams(window.location.search).get('search') || '',
  type: new URLSearchParams(window.location.search).get('type') || '',
  status: new URLSearchParams(window.location.search).get('status') || ''
})

let searchTimeout = null
function applyFilters() {
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(() => {
    router.get(route('membership.index'), {
      search: filters.search || undefined,
      type: filters.type || undefined,
      status: filters.status || undefined
    }, {
      preserveState: true,
      preserveScroll: true,
      replace: true
    })
  }, 300)
}

function resetFilters() {
  filters.search = ''
  filters.type = ''
  filters.status = ''
  router.get(route('membership.index'), {}, { preserveState: true, preserveScroll: true, replace: true })
}

/* --- Stats --- */
const approvedCount = computed(() =>
  props.memberships.data.filter(m => m.status === 'approved').length
)
const pendingCount = computed(() =>
  props.memberships.data.filter(m => m.status === 'pending').length
)

/* --- Modals --- */
const showViewModal = ref(false)
const selectedMembership = ref(null)

const showDeleteModal = ref(false)
const deletingMembership = ref(null)

/* --- Helpers --- */
function getInitials(name) {
  if (!name) return '?'
  return name
    .split(' ')
    .filter(Boolean)
    .slice(0, 2)
    .map(n => n[0].toUpperCase())
    .join('')
}

function capitalize(str) {
  if (!str) return ''
  return str.charAt(0).toUpperCase() + str.slice(1)
}

function formatDate(dateStr) {
  if (!dateStr) return '—'
  return new Date(dateStr).toLocaleDateString('en-US', {
    month: 'short', day: 'numeric', year: 'numeric'
  })
}

function formatTime(dateStr) {
  if (!dateStr) return ''
  return new Date(dateStr).toLocaleTimeString('en-US', {
    hour: 'numeric', minute: '2-digit'
  })
}

function statusBadgeClass(status) {
  const base = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-semibold'
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
function viewMembership(m) {
  selectedMembership.value = m
  showViewModal.value = true
}

function approveMembership(m) {
  if (!confirm(`Approve ${m.full_name}'s membership?`)) return
  router.post(route('membership.approve', m.id), {}, {
    preserveScroll: true,
    onSuccess: () => {
      // Success flash will show
    }
  })
}

function rejectMembership(m) {
  if (!confirm(`Reject ${m.full_name}'s membership?`)) return
  router.post(route('membership.reject', m.id), {}, {
    preserveScroll: true
  })
}

function confirmDelete(m) {
  deletingMembership.value = m
  showDeleteModal.value = true
}

function deleteMembership() {
  if (!deletingMembership.value) return
  router.delete(route('membership.destroy', deletingMembership.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
      deletingMembership.value = null
    }
  })
}

function goToPage(url) {
  router.get(url, {}, { preserveState: true, preserveScroll: true })
}
</script>