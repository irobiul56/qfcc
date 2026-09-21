<template>
   <Head title="Contact Messages" />
  <UserLayout title="Contact Messages">
    <div class="min-h-screen w-full bg-[#FAFBFC] py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="mb-8">
          <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5">
            <a href="/" class="hover:text-slate-700 transition-colors">Home</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <a href="#" class="hover:text-slate-700 transition-colors">Admin</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <span class="text-slate-800 font-medium">Contact Messages</span>
          </nav>

          <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
              <h1 class="text-2xl md:text-[28px] font-semibold text-slate-900 tracking-tight leading-tight">
                Contact Messages
              </h1>
              <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-xl">
                Review incoming messages from the contact form and reply to senders.
              </p>
            </div>
          </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total</p>
              <Icon name="inbox" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-semibold text-slate-900 mt-2 tabular-nums">{{ stats.total }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Unread</p>
              <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <p class="text-2xl font-semibold text-amber-600 mt-2 tabular-nums">{{ stats.unread }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Read</p>
              <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <p class="text-2xl font-semibold text-emerald-600 mt-2 tabular-nums">{{ stats.read }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Today</p>
              <Icon name="calendar" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-semibold text-slate-900 mt-2 tabular-nums">{{ stats.today }}</p>
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
              placeholder="Search by name, email, subject, or message…"
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
            />
          </div>

          <select
            v-model="filters.status"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All messages</option>
            <option value="unread">Unread</option>
            <option value="read">Read</option>
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
          <div v-if="messages.data.length === 0" class="py-20 px-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-center mb-4">
              <Icon name="inbox" class="w-5 h-5 text-slate-400" />
            </div>
            <p class="text-sm font-medium text-slate-700">No messages found</p>
            <p class="text-xs text-slate-500 mt-1.5">Try adjusting your filters or search query.</p>
          </div>

          <!-- Table -->
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">From</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Subject</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Preview</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Received</th>
                  <th class="px-5 py-3 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="msg in messages.data"
                  :key="msg.id"
                  :class="[
                    'transition-colors group cursor-pointer',
                    msg.is_read ? 'hover:bg-slate-50/60' : 'bg-amber-50/30 hover:bg-amber-50/60'
                  ]"
                  @click="viewMessage(msg)"
                >
                  <!-- From -->
                  <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                      <div :class="[
                        'w-8 h-8 rounded-full flex items-center justify-center text-[11px] font-semibold flex-shrink-0',
                        msg.is_read
                          ? 'bg-slate-100 ring-1 ring-slate-200/70 text-slate-600'
                          : 'bg-amber-100 ring-1 ring-amber-200/70 text-amber-700'
                      ]">
                        {{ getInitials(msg.full_name) }}
                      </div>
                      <div class="min-w-0">
                        <p :class="[
                          'text-sm truncate',
                          msg.is_read ? 'font-medium text-slate-900' : 'font-semibold text-slate-900'
                        ]">
                          {{ msg.full_name }}
                        </p>
                        <p class="text-[11px] text-slate-400 truncate">{{ msg.email }}</p>
                      </div>
                    </div>
                  </td>

                  <!-- Subject -->
                  <td class="px-5 py-4">
                    <p :class="[
                      'text-sm truncate max-w-[220px]',
                      msg.is_read ? 'text-slate-700' : 'font-semibold text-slate-900'
                    ]">
                      {{ msg.subject || '(No subject)' }}
                    </p>
                    <p v-if="msg.phone" class="text-[11px] text-slate-400 mt-0.5">{{ msg.phone }}</p>
                  </td>

                  <!-- Preview -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-500 truncate max-w-[280px]">
                      {{ truncate(msg.message, 70) }}
                    </p>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <span :class="statusBadgeClass(msg.is_read)">
                      <span class="w-1.5 h-1.5 rounded-full" :class="msg.is_read ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                      {{ msg.is_read ? 'Read' : 'Unread' }}
                    </span>
                  </td>

                  <!-- Received -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-600">{{ formatDate(msg.created_at) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ timeAgo(msg.created_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right" @click.stop>
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button
                        v-if="!msg.is_read"
                        @click="markRead(msg)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                        title="Mark as read"
                      >
                        <Icon name="check" class="w-4 h-4" />
                      </button>
                      <button
                        v-else
                        @click="markUnread(msg)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                        title="Mark as unread"
                      >
                        <Icon name="mail" class="w-4 h-4" />
                      </button>

                      <button
                        @click="confirmDelete(msg)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all"
                        title="Delete message"
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
            v-if="messages.links?.length > 3"
            class="px-5 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4 flex-wrap"
          >
            <p class="text-xs text-slate-500">
              Showing
              <span class="font-semibold text-slate-700 tabular-nums">{{ messages.from }}</span>
              to
              <span class="font-semibold text-slate-700 tabular-nums">{{ messages.to }}</span>
              of
              <span class="font-semibold text-slate-700 tabular-nums">{{ messages.total }}</span>
              messages
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in messages.links" :key="i">
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
    <!-- VIEW MESSAGE DRAWER                                    -->
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
                <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">
                  Message #{{ selected?.id }}
                </p>
                <h2 class="text-base font-semibold text-slate-900 mt-0.5 truncate max-w-md">
                  {{ selected?.subject || '(No subject)' }}
                </h2>
              </div>
              <button @click="closeViewDrawer"
                      class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                <Icon name="x" class="w-4 h-4" />
              </button>
            </div>

            <!-- Drawer body -->
            <div v-if="selected" class="flex-1 overflow-y-auto px-6 py-6 space-y-6">

              <!-- Sender info -->
              <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
                <div class="flex items-start gap-4">
                  <div class="w-12 h-12 rounded-full bg-white ring-1 ring-slate-200/70 flex items-center justify-center text-sm font-semibold text-slate-600 flex-shrink-0">
                    {{ getInitials(selected.full_name) }}
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-900">{{ selected.full_name }}</p>
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1">
                      <a :href="`mailto:${selected.email}`"
                         class="text-xs text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1.5">
                        <Icon name="mail" class="w-3 h-3" />
                        {{ selected.email }}
                      </a>
                      <a v-if="selected.phone"
                         :href="`tel:${selected.phone}`"
                         class="text-xs text-slate-600 hover:text-slate-800 inline-flex items-center gap-1.5">
                        <Icon name="phone" class="w-3 h-3" />
                        {{ selected.phone }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Meta row -->
              <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-3">
                  <span :class="statusBadgeClass(selected.is_read)">
                    <span class="w-1.5 h-1.5 rounded-full" :class="selected.is_read ? 'bg-emerald-500' : 'bg-amber-500'"></span>
                    {{ selected.is_read ? 'Read' : 'Unread' }}
                  </span>
                  <span class="text-slate-500">{{ timeAgo(selected.created_at) }}</span>
                </div>
              </div>

              <!-- Subject -->
              <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Subject</p>
                <p class="text-sm font-medium text-slate-800">{{ selected.subject || '(No subject)' }}</p>
              </div>

              <!-- Message body -->
              <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Message</p>
                <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
                  <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-line">{{ selected.message }}</p>
                </div>
              </div>
            </div>

            <!-- Drawer footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex justify-between gap-2 flex-shrink-0">
              <button
                @click="confirmDelete(selected); closeViewDrawer()"
                class="px-4 py-2 bg-white text-rose-600 font-medium rounded-lg text-sm border border-rose-200 hover:bg-rose-50 transition-all inline-flex items-center gap-1.5"
              >
                <Icon name="trash" class="w-3.5 h-3.5" /> Delete
              </button>

              <div class="flex items-center gap-2">
                <a
                  :href="`mailto:${selected?.email}?subject=Re: ${encodeURIComponent(selected?.subject || '')}`"
                  class="px-4 py-2 bg-slate-900 text-white font-medium rounded-lg text-sm hover:bg-slate-800 transition-all inline-flex items-center gap-1.5"
                >
                  <Icon name="send" class="w-3.5 h-3.5" /> Reply
                </a>
                <button @click="closeViewDrawer"
                        class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all">
                  Close
                </button>
              </div>
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
            <h3 class="text-base font-semibold text-slate-900">Delete message?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              This will permanently delete the message from <span class="font-medium text-slate-700">{{ deleting?.full_name }}</span>. This action cannot be undone.
            </p>
          </div>

          <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100 flex justify-end gap-2">
            <button @click="showDeleteModal = false"
                    class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all">
              Cancel
            </button>
            <button @click="deleteMessage"
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
import { router, Head } from '@inertiajs/vue3'
import { h, ref, reactive, computed, defineComponent } from 'vue'
import UserLayout from '@/Layouts/UserLayout.vue'

/* ═══════════════════════════════════════════════════════════
   ICON COMPONENT — inline SVG (heroicons style)
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
      'mail': {
        paths: [
          'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
        ],
      },
      'inbox': {
        paths: [
          'M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z',
        ],
      },
      'phone': {
        paths: [
          'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z',
        ],
      },
      'send': {
        paths: [
          'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5',
        ],
      },
      'calendar': {
        paths: [
          'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
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
  messages: { type: Object, required: true },
  stats:    { type: Object, required: true },
  filters:  { type: Object, default: () => ({}) },
})

/* --- Filters --- */
const params = new URLSearchParams(window.location.search)
const filters = reactive({
  search: props.filters?.search ?? params.get('search') ?? '',
  status: props.filters?.status ?? params.get('status') ?? '',
})

const hasActiveFilters = computed(() => filters.search || filters.status)

let debounceTimer = null
function applyFilters() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    router.get(route('contact-messages.index'), {
      search: filters.search || undefined,
      status: filters.status || undefined,
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
  router.get(route('contact-messages.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

/* --- View drawer --- */
const showViewDrawer = ref(false)
const selected = ref(null)

function viewMessage(msg) {
  selected.value = msg
  showViewDrawer.value = true

  // Auto-mark as read when opened
  if (!msg.is_read) {
    router.post(route('contact-messages.read', msg.id), {}, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        msg.is_read = true
        msg.read_at = new Date().toISOString()
      },
    })
  }
}

function closeViewDrawer() {
  showViewDrawer.value = false
  selected.value = null
}

/* --- Actions --- */
function markRead(msg) {
  router.post(route('contact-messages.read', msg.id), {}, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      msg.is_read = true
      msg.read_at = new Date().toISOString()
    },
  })
}

function markUnread(msg) {
  router.post(route('contact-messages.unread', msg.id), {}, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      msg.is_read = false
      msg.read_at = null
    },
  })
}

const showDeleteModal = ref(false)
const deleting = ref(null)

function confirmDelete(msg) {
  deleting.value = msg
  showDeleteModal.value = true
}

function deleteMessage() {
  if (!deleting.value) return
  router.delete(route('contact-messages.destroy', deleting.value.id), {
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

function truncate(str, len) {
  if (!str) return ''
  return str.length > len ? str.slice(0, len).trim() + '…' : str
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

function statusBadgeClass(isRead) {
  const base = 'inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] font-medium'
  return isRead
    ? `${base} bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70`
    : `${base} bg-amber-50 text-amber-700 ring-1 ring-amber-200/70`
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

* {
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  -webkit-font-smoothing: antialiased;
}
</style>