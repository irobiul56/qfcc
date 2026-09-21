<!-- resources/js/Pages/Admin/Programs/Index.vue -->
<script setup>
import { ref, computed, watch } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import QuillEditor from '@/Components/QuillEditor.vue';

const props = defineProps({
  programs: Object,
  stats: Object,
  filters: Object,
  iconOptions: Array,
});

const page = usePage();

// ============ FILTERS ============
const search = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || 'all');
const sortBy = ref(props.filters.sort || 'order');

const programList = computed(() => props.programs.data || []);

const applyFilters = () => {
  router.get(
    route('programs.index'),
    {
      search: search.value || undefined,
      status: statusFilter.value !== 'all' ? statusFilter.value : undefined,
      sort: sortBy.value !== 'order' ? sortBy.value : undefined,
    },
    { preserveState: true, preserveScroll: true, replace: true }
  );
};

let searchTimeout = null;
watch(search, () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(applyFilters, 400);
});

watch([statusFilter, sortBy], applyFilters);

// ============ MODAL STATE ============
const showModal = ref(false);
const modalMode = ref('create');
const editingId = ref(null);
const submitting = ref(false);

// ============ FORM ============
const form = ref({
  title: '',
  slug: '',
  short_description: '',
  full_description: '',
  icon: 'fas fa-graduation-cap',
  image: null,
  order: 0,
  is_active: true,
});

const existingImage = ref(null);

const errors = ref({});

const iconOptions = ref(props.iconOptions || [
  { value: 'fas fa-graduation-cap', label: 'Graduation Cap' },
  { value: 'fas fa-users', label: 'Users' },
  { value: 'fas fa-home', label: 'Home' },
  { value: 'fas fa-user-plus', label: 'Senior' },
  { value: 'fas fa-plane', label: 'Immigrant' },
  { value: 'fas fa-utensils', label: 'Food' },
  { value: 'fas fa-heartbeat', label: 'Health' },
  { value: 'fas fa-mosque', label: 'Religious' },
  { value: 'fas fa-book', label: 'Education' },
  { value: 'fas fa-hand-holding-heart', label: 'Charity' },
  { value: 'fas fa-child', label: 'Youth' },
  { value: 'fas fa-hands-helping', label: 'Support' },
  { value: 'fas fa-bullhorn', label: 'Outreach' },
  { value: 'fas fa-balance-scale', label: 'Justice' },
  { value: 'fas fa-leaf', label: 'Environment' },
]);

// ============ DELETE MODAL ============
const showDeleteModal = ref(false);
const deletingProgram = ref(null);
const deleting = ref(false);

// ============ RESET FORM ============
const resetForm = () => {
  form.value = {
    title: '',
    slug: '',
    short_description: '',
    full_description: '',
    icon: 'fas fa-graduation-cap',
    image: null,
    order: 0,
    is_active: true,
  };
  existingImage.value = null;
  errors.value = {};
  editingId.value = null;
};

// ============ OPEN CREATE MODAL ============
const openCreateModal = () => {
  resetForm();
  modalMode.value = 'create';
  showModal.value = true;
};

// ============ OPEN EDIT MODAL ============
const openEditModal = (program) => {
  resetForm();
  modalMode.value = 'edit';
  editingId.value = program.id;
  form.value = {
    title: program.title || '',
    slug: program.slug || '',
    short_description: program.short_description || '',
    full_description: program.full_description || '',
    icon: program.icon || 'fas fa-graduation-cap',
    image: null,
    order: program.order ?? 0,
    is_active: !!program.is_active,
  };
  existingImage.value = program.image ? `/storage/${program.image}` : null;
  showModal.value = true;
};

// ============ CLOSE MODAL ============
const closeModal = () => {
  if (submitting.value) return;
  showModal.value = false;
  resetForm();
};

// ============ IMAGE HANDLER ============
const handleImage = (e) => {
  form.value.image = e.target.files[0] || null;
  if (form.value.image) {
    existingImage.value = null;
  }
};

// ============ SUBMIT ============
const submit = () => {
  submitting.value = true;
  errors.value = {};

  const isEdit = modalMode.value === 'edit';
  const url = isEdit
    ? route('programs.update', editingId.value)
    : route('programs.store');

  const payload = {
    title: form.value.title,
    slug: form.value.slug || undefined,
    short_description: form.value.short_description,
    full_description: form.value.full_description,
    icon: form.value.icon,
    order: form.value.order,
    is_active: form.value.is_active,
    ...(form.value.image ? { image: form.value.image } : {}),
  };

  const options = {
    preserveScroll: true,
    forceFormData: !!form.value.image,
    onSuccess: () => {
      submitting.value = false;
      showModal.value = false;
      resetForm();
    },
    onError: (err) => {
      errors.value = err;
      submitting.value = false;
    },
  };

  if (isEdit) {
    router.post(url, { _method: 'put', ...payload }, options);
  } else {
    router.post(url, payload, options);
  }
};

// ============ TOGGLE STATUS ============
const toggleStatus = (program) => {
  router.patch(route('programs.toggle-status', program.id), {}, { preserveScroll: true });
};

// ============ DELETE ============
const openDeleteModal = (program) => {
  deletingProgram.value = program;
  showDeleteModal.value = true;
};

const confirmDelete = () => {
  if (!deletingProgram.value) return;
  deleting.value = true;
  router.delete(route('programs.destroy', deletingProgram.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      deleting.value = false;
      showDeleteModal.value = false;
      deletingProgram.value = null;
    },
    onError: () => {
      deleting.value = false;
    },
  });
};

const closeDeleteModal = () => {
  if (deleting.value) return;
  showDeleteModal.value = false;
  deletingProgram.value = null;
};

// ============ AUTO SLUG ============
watch(() => form.value.title, (newTitle) => {
  if (modalMode.value === 'create' && newTitle) {
    form.value.slug = newTitle
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
  }
});

// ============ HELPERS ============
const formatDate = (date) =>
  new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });

const flash = computed(() => page.props.flash || {});
</script>

<template>
  <Head title="Programs" />

  <UserLayout>
    <div class="min-h-screen w-full bg-gray-50">
      <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 py-6">

        <!-- Flash Message -->
        <transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="transform -translate-y-2 opacity-0"
          enter-to-class="transform translate-y-0 opacity-100"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div v-if="flash.success"
            class="mb-4 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3">
            <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
            <span class="text-sm font-semibold">{{ flash.success }}</span>
          </div>
        </transition>

        <!-- ============ PAGE HEADER ============ -->
        <div class="mb-6">
          <nav class="flex items-center gap-2 text-xs text-gray-400 mb-3">
            <Link :href="route('dashboard')" class="hover:text-[#00583f] transition-colors">
              <i class="fa-solid fa-house text-[10px]"></i>
            </Link>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-[#00583f] font-semibold">Programs</span>
          </nav>

          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900">
                Programs &amp; Services
              </h1>
              <p class="text-sm text-gray-500 mt-1">
                Manage all your community programs and services
              </p>
            </div>

            <button @click="openCreateModal"
              class="inline-flex items-center gap-2 bg-[#00583f] hover:bg-[#004a34] text-white text-sm font-bold px-5 py-3 rounded-lg transition-all hover:shadow-lg hover:-translate-y-0.5 self-start sm:self-auto">
              <i class="fa-solid fa-plus text-xs"></i>
              <span>Add New Program</span>
            </button>
          </div>
        </div>

        <!-- ============ STATS CARDS ============ -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-[#00583f]/10 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-graduation-cap text-[#00583f] text-xl"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Programs</p>
              <p class="text-2xl font-bold text-gray-900 mt-0.5">{{ stats.total }}</p>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Active</p>
              <p class="text-2xl font-bold text-emerald-600 mt-0.5">{{ stats.active }}</p>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-circle-pause text-gray-500 text-xl"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Inactive</p>
              <p class="text-2xl font-bold text-gray-600 mt-0.5">{{ stats.inactive }}</p>
            </div>
          </div>
        </div>

        <!-- ============ MAIN CARD ============ -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

          <!-- Toolbar -->
          <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="relative flex-1 max-w-md">
              <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
              <input v-model="search" type="text" placeholder="Search programs..."
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10 outline-none transition-all">
            </div>

            <div class="flex items-center gap-2 flex-wrap">
              <select v-model="statusFilter"
                class="text-sm px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] outline-none transition-all font-medium text-gray-700 cursor-pointer">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>

              <select v-model="sortBy"
                class="text-sm px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] outline-none transition-all font-medium text-gray-700 cursor-pointer">
                <option value="order">Sort by Order</option>
                <option value="title">Sort by Title</option>
                <option value="newest">Newest First</option>
              </select>
            </div>
          </div>

          <!-- Desktop Table -->
          <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Order</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Program</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Description</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Created</th>
                  <th class="px-4 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                <tr v-for="program in programList" :key="program.id" class="hover:bg-gray-50 transition-colors">
                  <td class="px-4 py-3.5">
                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-gray-100 text-gray-600 text-xs font-bold">
                      {{ program.order }}
                    </span>
                  </td>

                  <td class="px-4 py-3.5">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 rounded-lg bg-[#00583f] text-white flex items-center justify-center flex-shrink-0">
                        <i :class="program.icon" class="text-base"></i>
                      </div>
                      <div class="min-w-0">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ program.title }}</p>
                        <p class="text-[10px] text-gray-400 truncate">/{{ program.slug }}</p>
                      </div>
                    </div>
                  </td>

                  <td class="px-4 py-3.5 max-w-md">
                    <p class="text-xs text-gray-600 leading-relaxed line-clamp-2" v-html="program.short_description">
                    </p>
                  </td>

                  <td class="px-4 py-3.5">
                    <button @click="toggleStatus(program)"
                      :class="[
                        program.is_active
                          ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                          : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                        'inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full transition-colors cursor-pointer'
                      ]">
                      <span :class="program.is_active ? 'bg-emerald-500' : 'bg-gray-400'" class="w-1.5 h-1.5 rounded-full"></span>
                      {{ program.is_active ? 'Active' : 'Inactive' }}
                    </button>
                  </td>

                  <td class="px-4 py-3.5">
                    <span class="text-xs text-gray-500">{{ formatDate(program.created_at) }}</span>
                  </td>

                  <td class="px-4 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button @click="openEditModal(program)" title="Edit"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-all">
                        <i class="fa-solid fa-pen text-xs"></i>
                      </button>
                      <button @click="openDeleteModal(program)" title="Delete"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                        <i class="fa-solid fa-trash text-xs"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr v-if="programList.length === 0">
                  <td colspan="6" class="py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                      <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fa-solid fa-folder-open text-gray-400 text-2xl"></i>
                      </div>
                      <div>
                        <p class="text-sm font-bold text-gray-700">No programs found</p>
                        <p class="text-xs text-gray-400 mt-1">Try adjusting your search or filters</p>
                      </div>
                      <button @click="search = ''; statusFilter = 'all'; sortBy = 'order'"
                        class="text-xs font-bold text-[#00583f] hover:text-[#d9a52b] transition-colors mt-2">
                        Clear filters
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Mobile Cards -->
          <div class="md:hidden divide-y divide-gray-100">
            <div v-for="program in programList" :key="program.id" class="p-4 hover:bg-gray-50 transition-colors">
              <div class="flex items-start gap-3 mb-3">
                <div class="w-12 h-12 rounded-lg bg-[#00583f] text-white flex items-center justify-center flex-shrink-0">
                  <i :class="program.icon" class="text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                      <p class="text-sm font-bold text-gray-800 truncate">{{ program.title }}</p>
                      <p class="text-[10px] text-gray-400 truncate">/{{ program.slug }}</p>
                    </div>
                    <button @click="toggleStatus(program)"
                      :class="[
                        program.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600',
                        'text-[9px] font-bold px-2 py-0.5 rounded-full flex-shrink-0'
                      ]">
                      {{ program.is_active ? 'Active' : 'Inactive' }}
                    </button>
                  </div>
                </div>
              </div>

              <p class="text-xs text-gray-600 leading-relaxed mb-3 line-clamp-2">
                {{ program.short_description }}
              </p>

              <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <div class="flex items-center gap-3 text-[10px] text-gray-400">
                  <span><i class="fa-solid fa-hashtag mr-1"></i>{{ program.order }}</span>
                  <span><i class="fa-regular fa-calendar mr-1"></i>{{ formatDate(program.created_at) }}</span>
                </div>
                <div class="flex items-center gap-1">
                  <button @click="openEditModal(program)"
                    class="w-7 h-7 rounded-md flex items-center justify-center text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-all">
                    <i class="fa-solid fa-pen text-xs"></i>
                  </button>
                  <button @click="openDeleteModal(program)"
                    class="w-7 h-7 rounded-md flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                    <i class="fa-solid fa-trash text-xs"></i>
                  </button>
                </div>
              </div>
            </div>

            <div v-if="programList.length === 0" class="py-16 text-center">
              <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                  <i class="fa-solid fa-folder-open text-gray-400 text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-700">No programs found</p>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="programs.data.length > 0"
            class="px-4 sm:px-5 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500">
              Showing <span class="font-bold text-gray-700">{{ programs.from }}</span> to
              <span class="font-bold text-gray-700">{{ programs.to }}</span> of
              <span class="font-bold text-gray-700">{{ programs.total }}</span> programs
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in programs.links" :key="i">
                <Link v-if="link.url" :href="link.url" preserve-scroll
                  :class="[
                    'min-w-[32px] h-8 px-2.5 rounded-lg flex items-center justify-center text-xs font-bold transition-colors',
                    link.active ? 'bg-[#00583f] text-white' : 'text-gray-600 hover:bg-gray-100'
                  ]">
                  <span v-html="link.label"></span>
                </Link>
                <span v-else v-html="link.label"
                  class="min-w-[32px] h-8 px-2.5 rounded-lg flex items-center justify-center text-xs font-bold text-gray-300 cursor-not-allowed" />
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ============================================== -->
    <!-- ============ CREATE / EDIT MODAL ============= -->
    <!-- ============================================== -->
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showModal"
        class="fixed inset-0 z-50 flex items-start sm:items-center justify-center p-4 overflow-y-auto"
        @click.self="closeModal">

        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" @click="closeModal"></div>

        <transition
          enter-active-class="transition duration-250 ease-out"
          enter-from-class="opacity-0 translate-y-4 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:scale-95"
        >
          <div v-if="showModal"
            class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl my-8 sm:my-0">

            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#00583f]/10 flex items-center justify-center">
                  <i :class="modalMode === 'create' ? 'fa-solid fa-plus text-[#00583f] text-sm' : 'fa-solid fa-pen text-[#00583f] text-sm'"></i>
                </div>
                <div>
                  <h3 class="text-base font-bold text-gray-900">
                    {{ modalMode === 'create' ? 'Add New Program' : 'Edit Program' }}
                  </h3>
                  <p class="text-xs text-gray-400">
                    {{ modalMode === 'create' ? 'Create a new program or service' : 'Update program details' }}
                  </p>
                </div>
              </div>

              <button @click="closeModal"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
              </button>
            </div>

            <!-- Modal Body -->
            <form @submit.prevent="submit" class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto">

              <!-- Title -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Title <span class="text-red-500">*</span>
                </label>
                <input v-model="form.title" type="text" placeholder="e.g. Education & Lifelong Learning"
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all"
                  :class="errors.title ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'">
                <p v-if="errors.title" class="text-[11px] text-red-500 mt-1">{{ errors.title }}</p>
              </div>

              <!-- Slug -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Slug
                </label>
                <input v-model="form.slug" type="text" placeholder="auto-generated-from-title"
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all font-mono text-[12px]"
                  :class="errors.slug ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'">
                <p class="text-[10px] text-gray-400 mt-1">Leave empty to auto-generate from title</p>
                <p v-if="errors.slug" class="text-[11px] text-red-500 mt-1">{{ errors.slug }}</p>
              </div>

              <!-- Icon Picker -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Icon <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-nowrap gap-2 overflow-x-auto pb-1">
                  <button v-for="ic in iconOptions" :key="ic.value" type="button"
                    @click="form.icon = ic.value"
                    :title="ic.label"
                    :class="[
                      'icon-picker-btn flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-all border',
                      form.icon === ic.value
                        ? 'bg-[#00583f] text-white border-[#00583f] shadow-md scale-105'
                        : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-[#00583f] hover:text-[#00583f]'
                    ]">
                    <i :class="ic.value" style="font-size: 16px; line-height: 1;"></i>
                  </button>
                </div>
                <p v-if="errors.icon" class="text-[11px] text-red-500 mt-1">{{ errors.icon }}</p>
              </div>

              <!-- Short Description -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Short Description <span class="text-red-500">*</span>
                </label>
                <QuillEditor v-model="form.short_description" 
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all resize-none"
                  :class="errors.short_description ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'"/>
                <div class="flex items-center justify-between mt-1">
                  <p v-if="errors.short_description" class="text-[11px] text-red-500">{{ errors.short_description }}</p>
                  <p class="text-[10px] text-gray-400 ml-auto">{{ form.short_description.length }}/500</p>
                </div>
              </div>

              <!-- Full Description -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Full Description
                </label>
                
                <QuillEditor v-model="form.full_description" 
                  placeholder="Detailed description for the program page"
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all resize-none"
                  :class="errors.full_description ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'"/>
                <p v-if="errors.full_description" class="text-[11px] text-red-500 mt-1">{{ errors.full_description }}</p>
              </div>

              <!-- Order + Status row -->
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                    Order
                  </label>
                  <input v-model.number="form.order" type="number" min="0"
                    class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all"
                    :class="errors.order ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'">
                  <p v-if="errors.order" class="text-[11px] text-red-500 mt-1">{{ errors.order }}</p>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                    Status
                  </label>
                  <button type="button" @click="form.is_active = !form.is_active"
                    :class="[
                      form.is_active
                        ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                        : 'bg-gray-50 border-gray-200 text-gray-600',
                      'w-full px-3.5 py-2.5 text-sm font-bold border rounded-lg flex items-center justify-between transition-all'
                    ]">
                    <span class="flex items-center gap-2">
                      <span :class="form.is_active ? 'bg-emerald-500' : 'bg-gray-400'" class="w-2 h-2 rounded-full"></span>
                      {{ form.is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <i :class="form.is_active ? 'fa-solid fa-toggle-on text-emerald-600' : 'fa-solid fa-toggle-off text-gray-400'" class="text-lg"></i>
                  </button>
                </div>
              </div>

              <!-- Image -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Image (optional)
                </label>

                <div v-if="existingImage" class="mb-3 rounded-xl border border-gray-200 bg-gray-50 p-2">
                  <div class="relative overflow-hidden rounded-lg border border-gray-200 bg-white">
                    <img :src="existingImage" alt="Current program image" class="h-32 w-full object-cover">
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent px-3 py-2 text-[11px] font-semibold text-white">
                      Current image
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-3">
                  <label class="flex-1 cursor-pointer">
                    <input type="file" accept="image/*" @change="handleImage" class="hidden">
                    <div class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-dashed border-gray-300 rounded-lg hover:border-[#00583f] hover:bg-[#00583f]/5 transition-all flex items-center gap-2">
                      <i class="fa-solid fa-cloud-arrow-up text-[#00583f]"></i>
                      <span class="text-gray-600 truncate">
                        {{ form.image ? form.image.name : 'Choose file...' }}
                      </span>
                    </div>
                  </label>
                  <button v-if="form.image" type="button" @click="form.image = null"
                    class="w-10 h-10 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors flex-shrink-0">
                    <i class="fa-solid fa-xmark"></i>
                  </button>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WEBP up to 2MB</p>
                <p v-if="errors.image" class="text-[11px] text-red-500 mt-1">{{ errors.image }}</p>
              </div>

            </form>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-100">
              <button type="button" @click="closeModal" :disabled="submitting"
                class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50">
                Cancel
              </button>
              <button type="button" @click="submit" :disabled="submitting"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold bg-[#00583f] hover:bg-[#004a34] text-white rounded-lg transition-all hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
                <i v-if="submitting" class="fa-solid fa-spinner fa-spin text-xs"></i>
                <i v-else :class="modalMode === 'create' ? 'fa-solid fa-plus text-xs' : 'fa-solid fa-check text-xs'"></i>
                <span>{{ submitting ? 'Saving...' : (modalMode === 'create' ? 'Create Program' : 'Update Program') }}</span>
              </button>
            </div>
          </div>
        </transition>
      </div>
    </transition>

    <!-- ============================================== -->
    <!-- ============ DELETE CONFIRM MODAL ============ -->
    <!-- ============================================== -->
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showDeleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click.self="closeDeleteModal">

        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" @click="closeDeleteModal"></div>

        <transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div v-if="showDeleteModal"
            class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 text-center">

            <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
              <i class="fa-solid fa-triangle-exclamation text-red-500 text-2xl"></i>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Program?</h3>
            <p class="text-sm text-gray-500 mb-6">
              Are you sure you want to delete
              <span class="font-bold text-gray-700">"{{ deletingProgram?.title }}"</span>?
              This action cannot be undone.
            </p>

            <div class="flex items-center gap-3">
              <button type="button" @click="closeDeleteModal" :disabled="deleting"
                class="flex-1 px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50">
                Cancel
              </button>
              <button type="button" @click="confirmDelete" :disabled="deleting"
                class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
                <i v-if="deleting" class="fa-solid fa-spinner fa-spin text-xs"></i>
                <i v-else class="fa-solid fa-trash text-xs"></i>
                <span>{{ deleting ? 'Deleting...' : 'Delete' }}</span>
              </button>
            </div>
          </div>
        </transition>
      </div>
    </transition>

  </UserLayout>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Font Awesome icon size fix */
i[class*="fa-"],
i.fa,
i.fas,
i.far,
i.fab,
i.fa-solid,
i.fa-regular,
i.fa-brands {
  font-size: inherit;
  line-height: 1;
  display: inline-block;
}

.icon-picker-btn i {
  font-size: 16px !important;
  line-height: 1 !important;
}
</style>