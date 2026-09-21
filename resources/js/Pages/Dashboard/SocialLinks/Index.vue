<template>
    <Head title="Social Links"/>
  <UserLayout title="Social Links">
    <div class="min-h-screen w-full bg-[#FAFBFC] py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- ═══════════ PAGE HEADER ═══════════ -->
        <div class="mb-8">
          <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5">
            <a href="/" class="hover:text-slate-700 transition-colors">Home</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <a href="#" class="hover:text-slate-700 transition-colors">Admin</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <span class="text-slate-800 font-medium">Social Links</span>
          </nav>

          <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
              <h1 class="text-2xl md:text-[28px] font-semibold text-slate-900 tracking-tight leading-tight">
                Social Links
              </h1>
              <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-xl">
                Manage your social media presence — order, activate, and edit links.
              </p>
            </div>

            <button
              @click="openCreateModal"
              class="px-4 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-lg inline-flex items-center gap-2 hover:bg-slate-800 transition-all"
            >
              <Icon name="plus" class="w-4 h-4" />
              Add Link
            </button>
          </div>
        </div>

        <!-- ═══════════ STATS ═══════════ -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total Links</p>
              <Icon name="link" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-semibold text-slate-900 mt-2 tabular-nums">{{ stats.total }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Active</p>
              <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <p class="text-2xl font-semibold text-emerald-600 mt-2 tabular-nums">{{ stats.active }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Inactive</p>
              <span class="w-2 h-2 rounded-full bg-slate-400"></span>
            </div>
            <p class="text-2xl font-semibold text-slate-500 mt-2 tabular-nums">{{ stats.inactive }}</p>
          </div>
        </div>

        <!-- ═══════════ FILTERS ═══════════ -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-3 mb-6 flex flex-col md:flex-row md:items-center gap-2.5">
          <div class="relative flex-1">
            <Icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" />
            <input
              v-model="filters.search"
              @input="applyFilters"
              type="text"
              placeholder="Search by platform or URL…"
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
            />
          </div>

          <select
            v-model="filters.is_active"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
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

        <!-- ═══════════ TABLE ═══════════ -->
        <div class="bg-white rounded-xl ring-1 ring-slate-200/70 shadow-[0_1px_3px_rgba(15,23,42,0.04)] overflow-hidden">

          <div v-if="links.data.length === 0" class="py-20 px-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-center mb-4">
              <Icon name="link" class="w-5 h-5 text-slate-400" />
            </div>
            <p class="text-sm font-medium text-slate-700">No social links yet</p>
            <p class="text-xs text-slate-500 mt-1.5">Click "Add Link" to create your first one.</p>
          </div>

          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Order</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Icon</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Platform</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">URL</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Updated</th>
                  <th class="px-5 py-3 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="link in links.data"
                  :key="link.id"
                  class="transition-colors group hover:bg-slate-50/60"
                >
                  <!-- Order -->
                  <td class="px-5 py-4">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-slate-100 text-xs font-bold text-slate-600 tabular-nums">
                      {{ link.order }}
                    </span>
                  </td>

                  <!-- Icon -->
                  <td class="px-5 py-4">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-slate-50 ring-1 ring-slate-200 text-slate-700">
                      <SvgIcon :name="link.icon" class="w-5 h-5" />
                    </div>
                  </td>

                  <!-- Platform -->
                  <td class="px-5 py-4">
                    <p class="text-sm font-semibold text-slate-900 capitalize">
                      {{ link.platform }}
                    </p>
                  </td>

                  <!-- URL -->
                  <td class="px-5 py-4">
                    <a
                      :href="link.url"
                      target="_blank"
                      rel="noopener"
                      class="text-xs text-indigo-600 hover:text-indigo-800 hover:underline truncate max-w-[280px] inline-flex items-center gap-1.5"
                    >
                      <span class="truncate">{{ link.url }}</span>
                      <Icon name="external-link" class="w-3 h-3 flex-shrink-0" />
                    </a>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <button
                      @click="toggleActive(link)"
                      :class="[
                        'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium transition-all',
                        link.is_active
                          ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70 hover:bg-emerald-100'
                          : 'bg-slate-100 text-slate-500 ring-1 ring-slate-200 hover:bg-slate-200'
                      ]"
                      :title="link.is_active ? 'Click to deactivate' : 'Click to activate'"
                    >
                      <span class="w-1.5 h-1.5 rounded-full" :class="link.is_active ? 'bg-emerald-500' : 'bg-slate-400'"></span>
                      {{ link.is_active ? 'Active' : 'Inactive' }}
                    </button>
                  </td>

                  <!-- Updated -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-600">{{ formatDate(link.updated_at) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ timeAgo(link.updated_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button
                        @click="openEditModal(link)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all"
                        title="Edit"
                      >
                        <Icon name="edit" class="w-4 h-4" />
                      </button>
                      <button
                        @click="confirmDelete(link)"
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
            v-if="links.links?.length > 3"
            class="px-5 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4 flex-wrap"
          >
            <p class="text-xs text-slate-500">
              Showing
              <span class="font-semibold text-slate-700 tabular-nums">{{ links.from }}</span>
              to
              <span class="font-semibold text-slate-700 tabular-nums">{{ links.to }}</span>
              of
              <span class="font-semibold text-slate-700 tabular-nums">{{ links.total }}</span>
              links
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in links.links" :key="i">
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

    <!-- ═══════════ CREATE / EDIT MODAL ═══════════ -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="showFormModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        @click.self="closeFormModal"
      >
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
        >
          <div
            v-if="showFormModal"
            class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden max-h-[90vh] flex flex-col"
          >
            <!-- Modal header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
              <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                  {{ isEditing ? 'Edit' : 'Create' }}
                </p>
                <h2 class="text-lg font-bold text-slate-900 mt-0.5">
                  {{ isEditing ? 'Edit Social Link' : 'New Social Link' }}
                </h2>
              </div>
              <button
                @click="closeFormModal"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all"
              >
                <Icon name="x" class="w-4 h-4" />
              </button>
            </div>

            <!-- Modal body -->
            <form @submit.prevent="submitForm" class="p-6 overflow-y-auto flex-1 space-y-5">

              <!-- Platform -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                  Platform <span class="text-rose-500">*</span>
                </label>
                <input
                  v-model="form.platform"
                  type="text"
                  placeholder="e.g., Facebook"
                  class="w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                />
                <p v-if="form.errors.platform" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.platform }}</p>
              </div>

              <!-- URL -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                  URL <span class="text-rose-500">*</span>
                </label>
                <input
                  v-model="form.url"
                  type="url"
                  placeholder="https://facebook.com/yourpage"
                  class="w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                />
                <p v-if="form.errors.url" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.url }}</p>
              </div>

              <!-- ═══════════ ICON PICKER ═══════════ -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                  Icon <span class="text-rose-500">*</span>
                </label>

                <!-- Currently selected preview -->
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 ring-1 ring-slate-200/70 mb-3">
                  <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-slate-200 text-slate-700">
                    <SvgIcon :name="form.icon || 'link'" class="w-6 h-6" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Selected Icon</p>
                    <p class="text-sm font-medium text-slate-700 mt-0.5">{{ form.icon || 'link' }}</p>
                  </div>
                </div>

                <!-- Search icons -->
                <div class="relative mb-3">
                  <Icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" />
                  <input
                    v-model="iconSearch"
                    type="text"
                    placeholder="Search social icons…"
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
                  />
                </div>

                <!-- Icon grid -->
                <div class="rounded-xl border border-slate-200 bg-slate-50/40 p-3">
                  <div class="grid grid-cols-6 sm:grid-cols-8 gap-1.5 max-h-[240px] overflow-y-auto pr-1">

                    <button
                      v-for="icon in filteredIcons"
                      :key="icon.name"
                      type="button"
                      @click="form.icon = icon.name"
                      :title="icon.name"
                      :class="[
                        'group relative flex items-center justify-center w-full aspect-square rounded-lg border transition-all',
                        form.icon === icon.name
                          ? 'bg-slate-900 text-white border-slate-900 shadow-sm'
                          : 'bg-white text-slate-600 border-slate-200 hover:border-slate-900 hover:text-slate-900 hover:shadow-sm'
                      ]"
                    >
                      <SvgIcon :name="icon.name" class="w-5 h-5" />
                    </button>

                  </div>

                  <div v-if="filteredIcons.length === 0" class="py-6 text-center">
                    <p class="text-xs text-slate-500">No icons match "{{ iconSearch }}"</p>
                  </div>
                </div>

                <p v-if="form.errors.icon" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.icon }}</p>
                <p class="text-[11px] text-slate-400 mt-2">
                  {{ filteredIcons.length }} icon{{ filteredIcons.length === 1 ? '' : 's' }} available
                </p>
              </div>

              <!-- Order + Status -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Order
                  </label>
                  <input
                    v-model.number="form.order"
                    type="number"
                    min="0"
                    max="9999"
                    class="w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                  />
                  <p v-if="form.errors.order" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.order }}</p>
                </div>

                <div>
                  <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Status
                  </label>
                  <label class="flex items-center justify-between gap-3 h-[46px] px-3.5 rounded-lg bg-slate-50 ring-1 ring-slate-200/70 cursor-pointer hover:bg-slate-100/70 transition">
                    <span class="text-sm font-medium text-slate-700">
                      {{ form.is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <input v-model="form.is_active" type="checkbox" class="sr-only" />
                    <div :class="[
                      'relative w-11 h-6 rounded-full transition-all',
                      form.is_active ? 'bg-emerald-500' : 'bg-slate-300'
                    ]">
                      <span :class="[
                        'absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-all',
                        form.is_active ? 'translate-x-5' : 'translate-x-0'
                      ]"></span>
                    </div>
                  </label>
                </div>
              </div>
            </form>

            <!-- Modal footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex justify-end gap-2 flex-shrink-0">
              <button
                type="button"
                @click="closeFormModal"
                class="px-4 py-2 bg-white text-slate-700 font-medium rounded-lg text-sm border border-slate-200 hover:bg-slate-50 transition-all"
              >
                Cancel
              </button>
              <button
                type="button"
                @click="submitForm"
                :disabled="form.processing"
                class="px-5 py-2 bg-slate-900 text-white font-semibold rounded-lg text-sm hover:bg-slate-800 transition-all disabled:opacity-50 inline-flex items-center gap-2"
              >
                <Icon v-if="!form.processing" :name="isEditing ? 'check' : 'plus'" class="w-3.5 h-3.5" />
                <span v-else class="w-3.5 h-3.5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                {{ form.processing ? 'Saving…' : (isEditing ? 'Save Changes' : 'Create') }}
              </button>
            </div>
          </div>
        </Transition>
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
            <h3 class="text-base font-semibold text-slate-900">Delete this link?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              This will permanently remove the
              <span class="font-medium text-slate-700 capitalize">{{ deleting?.platform }}</span>
              link. This action cannot be undone.
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
              @click="deleteLink"
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
import { router, useForm, Head } from '@inertiajs/vue3'
import { h, ref, reactive, computed, defineComponent } from 'vue'
import UserLayout from '@/Layouts/UserLayout.vue'

/* ═══════════════════════════════════════════════════════════
   SVG ICON LIBRARY — includes social + UI icons
   ═══════════════════════════════════════════════════════════ */
const SVG_PATHS = {
  /* ─── Social platforms ─── */
  'facebook': ['M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z'],
  'twitter': ['M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
  'x-twitter': ['M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
  'instagram': ['M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z'],
  'youtube': ['M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'],
  'linkedin': ['M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'],
  'tiktok': ['M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z'],
  'whatsapp': ['M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z'],
  'pinterest': ['M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z'],
  'snapchat': ['M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.299 4.847l-.003.06c-.012.18-.022.345-.03.51.075.045.203.09.401.09.3-.016.659-.12 1.033-.301.165-.088.344-.104.464-.104.182 0 .359.029.509.09.45.149.734.479.734.838.015.449-.39.839-1.213 1.168-.089.029-.209.075-.344.119-.45.135-1.139.36-1.333.81-.09.224-.061.524.12.868l.015.015c.06.136 1.526 3.475 4.791 4.014.255.044.435.27.42.509 0 .075-.015.149-.045.225-.24.569-1.273.988-3.146 1.271-.059.091-.12.375-.164.57-.029.179-.074.36-.134.553-.076.271-.27.405-.555.405h-.03c-.135 0-.313-.031-.538-.074-.36-.075-.765-.135-1.273-.135-.3 0-.599.015-.913.074-.6.104-1.123.464-1.723.884-.853.599-1.826 1.288-3.294 1.288-.06 0-.119-.015-.18-.015h-.149c-1.468 0-2.427-.675-3.279-1.288-.599-.42-1.107-.779-1.707-.884-.314-.045-.629-.074-.928-.074-.54 0-.958.089-1.272.149-.211.043-.391.074-.54.074-.374 0-.523-.224-.583-.42-.061-.192-.09-.389-.135-.567-.046-.181-.105-.494-.166-.57-1.918-.222-2.95-.642-3.189-1.226-.031-.063-.052-.15-.055-.225-.015-.243.165-.465.42-.509 3.264-.54 4.73-3.879 4.791-4.02l.016-.029c.18-.345.224-.645.119-.869-.195-.434-.884-.658-1.332-.809-.121-.029-.24-.074-.346-.119-1.107-.435-1.257-.93-1.197-1.273.09-.479.674-.793 1.168-.793.146 0 .27.029.383.074.42.194.789.3 1.104.3.234 0 .384-.06.465-.105l-.046-.569c-.098-1.626-.225-3.651.307-4.837C7.392 1.077 10.739.807 11.727.807l.419-.015h.06z'],
  'reddit': ['M12 0C5.373 0 0 5.373 0 12c0 3.314 1.343 6.314 3.515 8.485l-2.286 2.286A.75.75 0 0 0 1.75 24h10.5c6.627 0 12-5.373 12-12S18.627 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.688-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z'],
  'telegram': ['M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z'],
  'discord': ['M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z'],

  /* ─── Generic link / web ─── */
  'link': ['M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244'],
  'globe': ['M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
  'external-link': ['M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25'],
  'share': ['M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z'],

  /* ─── Admin UI icons ─── */
  'chevron-right': ['M8.25 4.5l7.5 7.5-7.5 7.5'],
  'x': ['M6 18L18 6M6 6l12 12'],
  'check': ['M4.5 12.75l6 6 9-13.5'],
  'plus': ['M12 4.5v15m7.5-7.5h-15'],
  'search': ['M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z'],
  'trash': ['M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0'],
  'edit': ['M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10'],
}

/* ═══════════════════════════════════════════════════════════
   SvgIcon COMPONENT
   ═══════════════════════════════════════════════════════════ */
const SvgIcon = defineComponent({
  props: {
    name: { type: String, required: true },
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    return () => {
      const paths = SVG_PATHS[props.name]
      if (!paths) {
        // fallback: link icon
        return h('svg', {
          xmlns: 'http://www.w3.org/2000/svg',
          fill: 'none',
          viewBox: '0 0 24 24',
          'stroke-width': 1.75,
          stroke: 'currentColor',
          class: 'shrink-0',
        }, [
          h('path', {
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
            d: SVG_PATHS['link'][0],
          })
        ])
      }

      // Social icons use fill, others use stroke
      const isFilled = ['facebook', 'twitter', 'x-twitter', 'instagram', 'youtube', 'linkedin',
                        'tiktok', 'whatsapp', 'pinterest', 'snapchat', 'reddit', 'telegram', 'discord'].includes(props.name)

      return h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: isFilled ? 'currentColor' : 'none',
        viewBox: isFilled ? '0 0 24 24' : '0 0 24 24',
        ...(isFilled ? {} : { 'stroke-width': props.strokeWidth, stroke: 'currentColor' }),
        class: 'shrink-0',
      }, paths.map((d, i) =>
        h('path', {
          key: i,
          ...(isFilled ? {} : {
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
          }),
          d,
        })
      ))
    }
  },
})

const Icon = SvgIcon

/* ═══════════════════════════════════════════════════════════
   ICON LIBRARY — sorted alphabetically (social first)
   ═══════════════════════════════════════════════════════════ */
const UI_ONLY_ICONS = ['chevron-right', 'x', 'check', 'plus', 'search', 'trash', 'edit', 'external-link']

const ICON_LIBRARY = Object.keys(SVG_PATHS)
  .filter(name => !UI_ONLY_ICONS.includes(name))
  .sort()
  .map(name => ({ name }))

/* ═══════════════════════════════════════════════════════════
   PROPS
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  links:   { type: Object, required: true },
  stats:   { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
})

/* ═══════════════════════════════════════════════════════════
   FILTERS
   ═══════════════════════════════════════════════════════════ */
const params = new URLSearchParams(window.location.search)
const filters = reactive({
  search:    props.filters?.search    ?? params.get('search')    ?? '',
  is_active: props.filters?.is_active ?? params.get('is_active') ?? '',
})

const hasActiveFilters = computed(() => filters.search || filters.is_active)

let debounceTimer = null
function applyFilters() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    router.get(route('social-links.index'), {
      search:    filters.search    || undefined,
      is_active: filters.is_active || undefined,
    }, {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    })
  }, 300)
}

function resetFilters() {
  filters.search = ''
  filters.is_active = ''
  router.get(route('social-links.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

/* ═══════════════════════════════════════════════════════════
   ICON PICKER
   ═══════════════════════════════════════════════════════════ */
const iconSearch = ref('')

const filteredIcons = computed(() => {
  const q = iconSearch.value.trim().toLowerCase()
  if (!q) return ICON_LIBRARY
  return ICON_LIBRARY.filter(icon => icon.name.toLowerCase().includes(q))
})

/* ═══════════════════════════════════════════════════════════
   FORM MODAL
   ═══════════════════════════════════════════════════════════ */
const showFormModal = ref(false)
const isEditing = ref(false)
const editingId = ref(null)

const form = useForm({
  platform: '',
  url: '',
  icon: 'link',
  order: 0,
  is_active: true,
})

function openCreateModal() {
  form.reset()
  form.clearErrors()
  form.platform = ''
  form.url = ''
  form.icon = 'link'
  form.order = 0
  form.is_active = true
  iconSearch.value = ''
  isEditing.value = false
  editingId.value = null
  showFormModal.value = true
}

function openEditModal(link) {
  form.reset()
  form.clearErrors()
  form.platform = link.platform
  form.url = link.url
  form.icon = link.icon || 'link'
  form.order = link.order
  form.is_active = link.is_active
  iconSearch.value = ''
  isEditing.value = true
  editingId.value = link.id
  showFormModal.value = true
}

function closeFormModal() {
  if (form.processing) return
  showFormModal.value = false
}

function submitForm() {
  if (isEditing.value) {
    form.put(route('social-links.update', editingId.value), {
      preserveScroll: true,
      onSuccess: () => {
        showFormModal.value = false
        form.reset()
      },
    })
  } else {
    form.post(route('social-links.store'), {
      preserveScroll: true,
      onSuccess: () => {
        showFormModal.value = false
        form.reset()
      },
    })
  }
}

/* ═══════════════════════════════════════════════════════════
   TOGGLE ACTIVE
   ═══════════════════════════════════════════════════════════ */
function toggleActive(link) {
  router.post(route('social-links.toggle', link.id), {}, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      link.is_active = !link.is_active
    },
  })
}

/* ═══════════════════════════════════════════════════════════
   DELETE
   ═══════════════════════════════════════════════════════════ */
const showDeleteModal = ref(false)
const deleting = ref(null)
const actionProcessing = ref(false)

function confirmDelete(link) {
  deleting.value = link
  showDeleteModal.value = true
}

function deleteLink() {
  if (!deleting.value) return
  actionProcessing.value = true

  router.delete(route('social-links.destroy', deleting.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      actionProcessing.value = false
      showDeleteModal.value = false
      deleting.value = null
    },
    onError: () => {
      actionProcessing.value = false
    },
  })
}

/* ═══════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════ */
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