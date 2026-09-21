<template>
  <Head  title="Visions &amp; Missions"/>
  <UserLayout title="Visions &amp; Missions">
    <div class="min-h-screen w-full bg-[#FAFBFC] py-8 px-4 md:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">

        <!-- ═══════════ PAGE HEADER ═══════════ -->
        <div class="mb-8">
          <nav class="flex items-center gap-2 text-xs text-slate-500 mb-5">
            <a href="/" class="hover:text-slate-700 transition-colors">Home</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <a href="#" class="hover:text-slate-700 transition-colors">Admin</a>
            <Icon name="chevron-right" class="w-2.5 h-2.5 text-slate-300" />
            <span class="text-slate-800 font-medium">Visions &amp; Missions</span>
          </nav>

          <div class="flex items-start justify-between gap-6 flex-wrap">
            <div>
              <h1 class="text-2xl md:text-[28px] font-semibold text-slate-900 tracking-tight leading-tight">
                Visions &amp; Missions
              </h1>
              <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-xl">
                Manage the vision and mission statements that shape your organization.
              </p>
            </div>

            <button
              @click="openCreateModal"
              class="px-4 py-2.5 bg-slate-900 text-white text-sm font-medium rounded-lg inline-flex items-center gap-2 hover:bg-slate-800 transition-all"
            >
              <Icon name="plus" class="w-4 h-4" />
              Add New
            </button>
          </div>
        </div>

        <!-- ═══════════ STATS ═══════════ -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Total</p>
              <Icon name="layers" class="w-4 h-4 text-slate-300" />
            </div>
            <p class="text-2xl font-semibold text-slate-900 mt-2 tabular-nums">{{ stats.total }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Visions</p>
              <span class="w-2 h-2 rounded-full bg-blue-500"></span>
            </div>
            <p class="text-2xl font-semibold text-blue-600 mt-2 tabular-nums">{{ stats.visions }}</p>
          </div>

          <div class="bg-white rounded-xl ring-1 ring-slate-200/70 p-5">
            <div class="flex items-center justify-between">
              <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">Missions</p>
              <span class="w-2 h-2 rounded-full bg-purple-500"></span>
            </div>
            <p class="text-2xl font-semibold text-purple-600 mt-2 tabular-nums">{{ stats.missions }}</p>
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
              placeholder="Search by heading or content…"
              class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
            />
          </div>

          <select
            v-model="filters.type"
            @change="applyFilters"
            class="px-3.5 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-700 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
          >
            <option value="">All types</option>
            <option value="vision">Vision</option>
            <option value="mission">Mission</option>
          </select>

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

          <div v-if="items.data.length === 0" class="py-20 px-6 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-slate-50 ring-1 ring-slate-200/70 flex items-center justify-center mb-4">
              <Icon name="layers" class="w-5 h-5 text-slate-400" />
            </div>
            <p class="text-sm font-medium text-slate-700">No visions or missions yet</p>
            <p class="text-xs text-slate-500 mt-1.5">Click "Add New" to create your first one.</p>
          </div>

          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Order</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Icon</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Heading</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Type</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                  <th class="px-5 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Updated</th>
                  <th class="px-5 py-3 text-right text-[11px] font-semibold text-slate-500 uppercase tracking-wider"></th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                <tr
                  v-for="item in items.data"
                  :key="item.id"
                  class="transition-colors group hover:bg-slate-50/60"
                >
                  <!-- Order -->
                  <td class="px-5 py-4">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-slate-100 text-xs font-bold text-slate-600 tabular-nums">
                      {{ item.order }}
                    </span>
                  </td>

                  <!-- Icon (renders SVG from icon library) -->
                  <td class="px-5 py-4">
                    <div :class="[
                      'w-10 h-10 rounded-lg flex items-center justify-center ring-1',
                      item.type === 'vision'
                        ? 'bg-blue-50 text-blue-600 ring-blue-200/70'
                        : 'bg-purple-50 text-purple-600 ring-purple-200/70'
                    ]">
                      <SvgIcon :name="item.icon" class="w-5 h-5" />
                    </div>
                  </td>

                  <!-- Heading -->
                  <td class="px-5 py-4">
                    <p class="text-sm font-semibold text-slate-900 truncate max-w-[280px]">
                      {{ item.heading }}
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5 truncate max-w-[320px]">
                      {{ truncate(item.content, 80) }}
                    </p>
                  </td>

                  <!-- Type -->
                  <td class="px-5 py-4">
                    <span :class="[
                      'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-semibold uppercase tracking-wider',
                      item.type === 'vision'
                        ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200/70'
                        : 'bg-purple-50 text-purple-700 ring-1 ring-purple-200/70'
                    ]">
                      <SvgIcon :name="item.type === 'vision' ? 'eye' : 'target'" class="w-3 h-3" />
                      {{ item.type }}
                    </span>
                  </td>

                  <!-- Status -->
                  <td class="px-5 py-4">
                    <button
                      @click="toggleActive(item)"
                      :class="[
                        'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-medium transition-all',
                        item.is_active
                          ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200/70 hover:bg-emerald-100'
                          : 'bg-slate-100 text-slate-500 ring-1 ring-slate-200 hover:bg-slate-200'
                      ]"
                      :title="item.is_active ? 'Click to deactivate' : 'Click to activate'"
                    >
                      <span class="w-1.5 h-1.5 rounded-full" :class="item.is_active ? 'bg-emerald-500' : 'bg-slate-400'"></span>
                      {{ item.is_active ? 'Active' : 'Inactive' }}
                    </button>
                  </td>

                  <!-- Updated -->
                  <td class="px-5 py-4">
                    <p class="text-xs text-slate-600">{{ formatDate(item.updated_at) }}</p>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ timeAgo(item.updated_at) }}</p>
                  </td>

                  <!-- Actions -->
                  <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button
                        @click="openEditModal(item)"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all"
                        title="Edit"
                      >
                        <Icon name="edit" class="w-4 h-4" />
                      </button>
                      <button
                        @click="confirmDelete(item)"
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
            v-if="items.links?.length > 3"
            class="px-5 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4 flex-wrap"
          >
            <p class="text-xs text-slate-500">
              Showing
              <span class="font-semibold text-slate-700 tabular-nums">{{ items.from }}</span>
              to
              <span class="font-semibold text-slate-700 tabular-nums">{{ items.to }}</span>
              of
              <span class="font-semibold text-slate-700 tabular-nums">{{ items.total }}</span>
              items
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in items.links" :key="i">
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
                  {{ isEditing ? 'Edit Vision / Mission' : 'New Vision / Mission' }}
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

              <!-- Type -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                  Type <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                  <label
                    :class="[
                      'relative flex items-center gap-3 cursor-pointer rounded-xl border-2 p-3.5 transition',
                      form.type === 'vision'
                        ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/20'
                        : 'border-slate-200 bg-white hover:border-blue-300'
                    ]"
                  >
                    <input v-model="form.type" type="radio" value="vision" class="sr-only" />
                    <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                      <SvgIcon name="eye" class="w-5 h-5" />
                    </span>
                    <div>
                      <p class="text-sm font-bold text-slate-900">Vision</p>
                      <p class="text-[11px] text-slate-500">Aspirational future state</p>
                    </div>
                  </label>

                  <label
                    :class="[
                      'relative flex items-center gap-3 cursor-pointer rounded-xl border-2 p-3.5 transition',
                      form.type === 'mission'
                        ? 'border-purple-500 bg-purple-50/50 ring-2 ring-purple-500/20'
                        : 'border-slate-200 bg-white hover:border-purple-300'
                    ]"
                  >
                    <input v-model="form.type" type="radio" value="mission" class="sr-only" />
                    <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                      <SvgIcon name="target" class="w-5 h-5" />
                    </span>
                    <div>
                      <p class="text-sm font-bold text-slate-900">Mission</p>
                      <p class="text-[11px] text-slate-500">Purpose &amp; day-to-day focus</p>
                    </div>
                  </label>
                </div>
                <p v-if="form.errors.type" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.type }}</p>
              </div>

              <!-- Heading -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                  Heading <span class="text-rose-500">*</span>
                </label>
                <input
                  v-model="form.heading"
                  type="text"
                  placeholder="e.g., OUR VISION"
                  class="w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                />
                <p v-if="form.errors.heading" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.heading }}</p>
              </div>

              <!-- Content -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                  Content <span class="text-rose-500">*</span>
                </label>
                <textarea
                  v-model="form.content"
                  rows="4"
                  placeholder="Write the full statement here…"
                  class="w-full resize-y rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                ></textarea>
                <p v-if="form.errors.content" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.content }}</p>
                <p class="text-[11px] text-slate-400 mt-1">{{ (form.content || '').length }} / 5000 characters</p>
              </div>

              <!-- ═══════════ SVG ICON PICKER ═══════════ -->
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                  Icon <span class="text-rose-500">*</span>
                </label>

                <!-- Currently selected preview -->
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 ring-1 ring-slate-200/70 mb-3">
                  <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-lg bg-white ring-1 ring-slate-200 text-slate-700">
                    <SvgIcon :name="form.icon || 'star'" class="w-6 h-6" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Selected Icon</p>
                    <p class="text-sm font-medium text-slate-700 mt-0.5">{{ form.icon || 'star' }}</p>
                  </div>
                </div>

                <!-- Search icons -->
                <div class="relative mb-3">
                  <Icon name="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none" />
                  <input
                    v-model="iconSearch"
                    type="text"
                    placeholder="Search icons…"
                    class="w-full pl-10 pr-4 py-2.5 bg-slate-50/70 rounded-lg text-sm text-slate-800 placeholder-slate-400 border border-transparent focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-900/5 outline-none transition-all"
                  />
                </div>

                <!-- Icon grid -->
                <div class="rounded-xl border border-slate-200 bg-slate-50/40 p-3">
                  <div class="grid grid-cols-6 sm:grid-cols-8 gap-1.5 max-h-[200px] overflow-y-auto pr-1">

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

                  <!-- Empty state -->
                  <div v-if="filteredIcons.length === 0" class="py-6 text-center">
                    <p class="text-xs text-slate-500">No icons match "{{ iconSearch }}"</p>
                  </div>
                </div>

                <p v-if="form.errors.icon" class="mt-1.5 text-rose-500 text-xs">{{ form.errors.icon }}</p>
                <p class="text-[11px] text-slate-400 mt-2">
                  {{ filteredIcons.length }} icon{{ filteredIcons.length === 1 ? '' : 's' }} available
                </p>
              </div>

              <!-- Order -->
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

                <!-- Active toggle -->
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
            <h3 class="text-base font-semibold text-slate-900">Delete this item?</h3>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
              This will permanently remove
              <span class="font-medium text-slate-700">{{ deleting?.heading }}</span>.
              This action cannot be undone.
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
              @click="deleteItem"
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
   SVG ICON LIBRARY — 48 curated Heroicons (MIT license)
   ═══════════════════════════════════════════════════════════ */
const SVG_PATHS = {
  // Vision & mission
  'eye':              ['M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
  'target':           ['M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59'],
  'star':             ['M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z'],
  'flag':             ['M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5'],
  'compass':          ['M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM14.25 14.25l-6 2.25 2.25-6 6-2.25-2.25 6z'],
  'sparkles':         ['M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z'],
  'light-bulb':       ['M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18'],
  'rocket':           ['M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z'],

  // Community & people
  'users':            ['M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
  'user-group':       ['M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
  'heart':            ['M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
  'hand-raised':      ['M10.05 4.575a1.575 1.575 0 10-3.15 0v3m3.15-3v-1.5a1.575 1.575 0 013.15 0v1.5m-3.15 0l.075 5.925m3.075.75V4.575m0 0a1.575 1.575 0 013.15 0V15M6.9 7.575a1.575 1.575 0 10-3.15 0v8.175a6.75 6.75 0 006.75 6.75h2.018a5.25 5.25 0 003.712-1.538l1.732-1.732a5.25 5.25 0 001.538-3.712l.003-2.024a.668.668 0 01.198-.471 1.575 1.575 0 10-2.228-2.228 3.818 3.818 0 00-1.12 2.687M6.9 7.575V12m6.27 4.318A4.49 4.49 0 0116.35 15m.002 0h-.002'],
  'hand-heart':       ['M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z', 'M12 12l-2.5-2.5M12 12l2.5-2.5'],
  'face-smile':       ['M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z'],
  'sun':              ['M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z'],

  // Values & symbols
  'shield-check':     ['M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z'],
  'shield':           ['M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z'],
  'check-circle':     ['M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
  'check-badge':      ['M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z'],
  'globe':            ['M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
  'bookmark':         ['M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z'],
  'book-open':        ['M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
  'academic-cap':     ['M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
  'life-buoy':        ['M16.712 4.33a9.027 9.027 0 011.652 1.306c.51.51.944 1.064 1.306 1.652M16.712 4.33l-3.448 4.138m3.448-4.138a9.014 9.014 0 00-9.424 0M19.67 7.288l-4.138 3.448m4.138-3.448a9.014 9.014 0 010 9.424m-4.138-5.976a3.736 3.736 0 00-.88-1.388 3.737 3.737 0 00-1.388-.88m2.268 2.268a3.765 3.765 0 010 2.528m-2.268-4.796a3.765 3.765 0 00-2.528 0m4.796 4.796c-.181.506-.475.982-.88 1.388a3.736 3.736 0 01-1.388.88m2.268-2.268l4.138 3.448m0 0a9.027 9.027 0 01-1.306 1.652c-.51.51-1.064.944-1.652 1.306m0 0l-3.448-4.138m3.448 4.138a9.014 9.014 0 01-9.424 0m5.976-4.138a3.765 3.765 0 01-2.528 0m0 0a3.736 3.736 0 01-1.388-.88 3.737 3.737 0 01-.88-1.388m2.268 2.268L7.3 18.67m0 0a9.024 9.024 0 01-1.652-1.306 9.027 9.027 0 01-1.306-1.652m0 0l4.138-3.448M4.33 16.712a9.014 9.014 0 010-9.424m4.138 5.976a3.765 3.765 0 010-2.528m0 0c.181-.506.475-.982.88-1.388a3.736 3.736 0 011.388-.88m-2.268 2.268L4.33 7.288m6.406 1.18L7.3 5.58m5.976-2.268a3.765 3.765 0 012.528 0'],

  // Business & impact
  'chart-bar':        ['M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z'],
  'trending-up':      ['M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941'],
  'presentation':     ['M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6'],
  'briefcase':        ['M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z'],
  'gift':             ['M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H4.5a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
  'currency-dollar':  ['M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
  'banknotes':        ['M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z'],

  // Communication
  'chat-bubble':      ['M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z'],
  'envelope':         ['M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
  'megaphone':        ['M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46'],
  'bell':             ['M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0'],

  // Misc
  'bolt':             ['M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z'],
  'fire':             ['M15.362 5.214A8.252 8.252 0 0112 21 6.75 6.75 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z', 'M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z'],
  'cube':             ['M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9'],
  'puzzle':           ['M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.96.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z'],
  'trophy':           ['M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0'],
  'calendar':         ['M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],

  // Admin UI icons
  'chevron-right':    ['M8.25 4.5l7.5 7.5-7.5 7.5'],
  'x':                ['M6 18L18 6M6 6l12 12'],
  'check':            ['M4.5 12.75l6 6 9-13.5'],
  'plus':             ['M12 4.5v15m7.5-7.5h-15'],
  'search':           ['M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z'],
  'trash':            ['M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0'],
  'edit':             ['M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10'],
  'layers':           ['M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3'],
}

/* ═══════════════════════════════════════════════════════════
   SvgIcon COMPONENT — renders SVG from the library
   ═══════════════════════════════════════════════════════════ */
const SvgIcon = defineComponent({
  props: {
    name: { type: String, required: true },
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    return () => {
      const paths = SVG_PATHS[props.name]
      if (!paths) return null

      return h('svg', {
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
    }
  },
})

/* ═══════════════════════════════════════════════════════════
   Icon — small UI icon (uses same library)
   ═══════════════════════════════════════════════════════════ */
const Icon = SvgIcon

/* ═══════════════════════════════════════════════════════════
   ICON PICKER LIST — sorted alphabetically
   ═══════════════════════════════════════════════════════════ */
const ICON_LIBRARY = Object.keys(SVG_PATHS)
  .filter(name => ![
    'chevron-right', 'x', 'check', 'plus', 'search', 'trash', 'edit', 'layers'
  ].includes(name)) // exclude UI-only icons from picker
  .sort()
  .map(name => ({ name }))

/* ═══════════════════════════════════════════════════════════
   PROPS
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  items:   { type: Object, required: true },
  stats:   { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
})

/* ═══════════════════════════════════════════════════════════
   FILTERS
   ═══════════════════════════════════════════════════════════ */
const params = new URLSearchParams(window.location.search)
const filters = reactive({
  search:    props.filters?.search    ?? params.get('search')    ?? '',
  type:      props.filters?.type      ?? params.get('type')      ?? '',
  is_active: props.filters?.is_active ?? params.get('is_active') ?? '',
})

const hasActiveFilters = computed(() => filters.search || filters.type || filters.is_active)

let debounceTimer = null
function applyFilters() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => {
    router.get(route('visions-missions.index'), {
      search:    filters.search    || undefined,
      type:      filters.type      || undefined,
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
  filters.type = ''
  filters.is_active = ''
  router.get(route('visions-missions.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

/* ═══════════════════════════════════════════════════════════
   ICON PICKER — search
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
  type: 'vision',
  heading: '',
  content: '',
  icon: 'star',
  order: 0,
  is_active: true,
})

function openCreateModal() {
  form.reset()
  form.clearErrors()
  form.type = 'vision'
  form.icon = 'star'
  form.order = 0
  form.is_active = true
  iconSearch.value = ''
  isEditing.value = false
  editingId.value = null
  showFormModal.value = true
}

function openEditModal(item) {
  form.reset()
  form.clearErrors()
  form.type = item.type
  form.heading = item.heading
  form.content = item.content
  form.icon = item.icon || 'star'
  form.order = item.order
  form.is_active = item.is_active
  iconSearch.value = ''
  isEditing.value = true
  editingId.value = item.id
  showFormModal.value = true
}

function closeFormModal() {
  if (form.processing) return
  showFormModal.value = false
}

function submitForm() {
  if (isEditing.value) {
    form.put(route('visions-missions.update', editingId.value), {
      preserveScroll: true,
      onSuccess: () => {
        showFormModal.value = false
        form.reset()
      },
    })
  } else {
    form.post(route('visions-missions.store'), {
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
function toggleActive(item) {
  router.post(route('visions-missions.toggle', item.id), {}, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      item.is_active = !item.is_active
    },
  })
}

/* ═══════════════════════════════════════════════════════════
   DELETE
   ═══════════════════════════════════════════════════════════ */
const showDeleteModal = ref(false)
const deleting = ref(null)
const actionProcessing = ref(false)

function confirmDelete(item) {
  deleting.value = item
  showDeleteModal.value = true
}

function deleteItem() {
  if (!deleting.value) return
  actionProcessing.value = true

  router.delete(route('visions-missions.destroy', deleting.value.id), {
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