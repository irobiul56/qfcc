<!-- resources/js/Pages/Admin/DonationCampaigns/Index.vue -->
<script setup>
import { ref, computed, watch } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';

const props = defineProps({
  campaigns: Object,
  stats: Object,
  filters: Object,
});

const page = usePage();

// ============ FILTERS ============
const search = ref(props.filters.search || '');
const statusFilter = ref(props.filters.status || 'all');
const sortBy = ref(props.filters.sort || 'order');

const campaignList = computed(() => props.campaigns.data || []);

const applyFilters = () => {
  router.get(
    route('campaigns.index'),
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
const defaultForm = () => ({
  title: '',
  slug: '',
  description: '',
  image: null,
  existing_image: null,
  remove_image: false,
  goal_amount: '',
  raised_amount: '',
  start_date: '',
  end_date: '',
  is_featured: false,
  is_active: true,
  order: 0,
});

const form = ref(defaultForm());
const errors = ref({});

// ============ DELETE MODAL ============
const showDeleteModal = ref(false);
const deletingCampaign = ref(null);
const deleting = ref(false);

// ============ RESET ============
const resetForm = () => {
  form.value = defaultForm();
  errors.value = {};
  editingId.value = null;
};

// ============ OPEN MODALS ============
const openCreateModal = () => {
  resetForm();
  modalMode.value = 'create';
  showModal.value = true;
};

const openEditModal = (campaign) => {
  resetForm();
  modalMode.value = 'edit';
  editingId.value = campaign.id;

  const toDateInput = (dt) => {
    if (!dt) return '';
    const d = new Date(dt);
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
  };

  form.value = {
    title: campaign.title || '',
    slug: campaign.slug || '',
    description: campaign.description || '',
    image: null,
    existing_image: campaign.image || null,
    remove_image: false,
    goal_amount: campaign.goal_amount ?? '',
    raised_amount: campaign.raised_amount ?? '',
    start_date: toDateInput(campaign.start_date),
    end_date: toDateInput(campaign.end_date),
    is_featured: !!campaign.is_featured,
    is_active: !!campaign.is_active,
    order: campaign.order ?? 0,
  };
  showModal.value = true;
};

const closeModal = () => {
  if (submitting.value) return;
  showModal.value = false;
  resetForm();
};

// ============ IMAGE HANDLERS ============
const handleImage = (e) => {
  form.value.image = e.target.files[0] || null;
  if (form.value.image) {
    form.value.remove_image = false;
  }
};

const clearNewImage = () => {
  form.value.image = null;
};

const markRemoveExistingImage = () => {
  form.value.remove_image = true;
  form.value.image = null;
};

const undoRemoveExistingImage = () => {
  form.value.remove_image = false;
};

// ============ SUBMIT ============
const submit = () => {
  submitting.value = true;
  errors.value = {};

  const isEdit = modalMode.value === 'edit';
  const url = isEdit
    ? route('campaigns.update', editingId.value)
    : route('campaigns.store');

  const payload = {
    title: form.value.title,
    slug: form.value.slug || undefined,
    description: form.value.description,
    goal_amount: form.value.goal_amount,
    raised_amount: form.value.raised_amount || 0,
    start_date: form.value.start_date || null,
    end_date: form.value.end_date || null,
    is_featured: form.value.is_featured,
    is_active: form.value.is_active,
    order: form.value.order,
    remove_image: form.value.remove_image ? 1 : 0,
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

// ============ TOGGLES ============
const toggleStatus = (campaign) => {
  router.patch(route('campaigns.toggle-status', campaign.id), {}, { preserveScroll: true });
};

const toggleFeatured = (campaign) => {
  router.patch(route('campaigns.toggle-featured', campaign.id), {}, { preserveScroll: true });
};

// ============ DELETE ============
const openDeleteModal = (campaign) => {
  deletingCampaign.value = campaign;
  showDeleteModal.value = true;
};

const confirmDelete = () => {
  if (!deletingCampaign.value) return;
  deleting.value = true;
  router.delete(route('campaigns.destroy', deletingCampaign.value.id), {
    preserveScroll: true,
    onSuccess: () => {
      deleting.value = false;
      showDeleteModal.value = false;
      deletingCampaign.value = null;
    },
    onError: () => {
      deleting.value = false;
    },
  });
};

const closeDeleteModal = () => {
  if (deleting.value) return;
  showDeleteModal.value = false;
  deletingCampaign.value = null;
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
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  }).format(amount || 0);
};

const formatDate = (date) => {
  if (!date) return '—';
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    year: 'numeric',
  });
};

const progressPercent = (campaign) => {
  if (!campaign.goal_amount || campaign.goal_amount <= 0) return 0;
  return Math.min(100, Math.round((campaign.raised_amount / campaign.goal_amount) * 100));
};

const isCompleted = (campaign) => campaign.raised_amount >= campaign.goal_amount;

const flash = computed(() => page.props.flash || {});
</script>

<template>
  <Head title="Donation Campaigns" />

  <UserLayout>
    <div class="min-h-screen w-full bg-gray-50">
      <div class="mx-auto max-w-[1600px] px-4 sm:px-6 lg:px-8 py-6">

        <!-- Flash -->
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

        <!-- Page Header -->
        <div class="mb-6">
          <nav class="flex items-center gap-2 text-xs text-gray-400 mb-3">
            <Link :href="route('dashboard')" class="hover:text-[#00583f] transition-colors">
              <i class="fa-solid fa-house text-[10px]"></i>
            </Link>
            <i class="fa-solid fa-chevron-right text-[8px]"></i>
            <span class="text-[#00583f] font-semibold">Donation Campaigns</span>
          </nav>

          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900">
                Donation Campaigns
              </h1>
              <p class="text-sm text-gray-500 mt-1">
                Manage all your fundraising campaigns
              </p>
            </div>

            <button @click="openCreateModal"
              class="inline-flex items-center gap-2 bg-[#00583f] hover:bg-[#004a34] text-white text-sm font-bold px-5 py-3 rounded-lg transition-all hover:shadow-lg hover:-translate-y-0.5 self-start sm:self-auto">
              <i class="fa-solid fa-plus text-xs"></i>
              <span>New Campaign</span>
            </button>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-[#00583f]/10 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-bullhorn text-[#00583f] text-xl"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Campaigns</p>
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
            <div class="w-12 h-12 rounded-lg bg-[#d9a52b]/10 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-star text-[#d9a52b] text-xl"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Featured</p>
              <p class="text-2xl font-bold text-[#d9a52b] mt-0.5">{{ stats.featured }}</p>
            </div>
          </div>

          <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-hand-holding-dollar text-blue-600 text-xl"></i>
            </div>
            <div class="min-w-0">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Raised</p>
              <p class="text-xl font-bold text-blue-600 mt-0.5 truncate">
                {{ formatCurrency(stats.total_raised) }}
              </p>
            </div>
          </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

          <!-- Toolbar -->
          <div class="p-4 sm:p-5 border-b border-gray-100 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="relative flex-1 max-w-md">
              <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
              <input v-model="search" type="text" placeholder="Search campaigns..."
                class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10 outline-none transition-all">
            </div>

            <div class="flex items-center gap-2 flex-wrap">
              <select v-model="statusFilter"
                class="text-sm px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] outline-none transition-all font-medium text-gray-700 cursor-pointer">
                <option value="all">All Campaigns</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="featured">Featured</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
              </select>

              <select v-model="sortBy"
                class="text-sm px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] outline-none transition-all font-medium text-gray-700 cursor-pointer">
                <option value="order">Sort by Order</option>
                <option value="title">Sort by Title</option>
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="goal_high">Highest Goal</option>
                <option value="goal_low">Lowest Goal</option>
                <option value="raised_high">Most Raised</option>
              </select>
            </div>
          </div>

          <!-- Desktop Table -->
          <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Campaign</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Progress</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Goal</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Raised</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Duration</th>
                  <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                  <th class="px-4 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                <tr v-for="campaign in campaignList" :key="campaign.id" class="hover:bg-gray-50 transition-colors">
                  <td class="px-4 py-3.5 max-w-xs">
                    <div class="flex items-center gap-3">
                      <div class="w-11 h-11 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100">
                        <img v-if="campaign.image" :src="`/storage/${campaign.image}`" :alt="campaign.title" class="w-full h-full object-cover">
                        <div v-else class="w-full h-full bg-gradient-to-br from-[#00583f] to-[#007a55] flex items-center justify-center text-white">
                          <i class="fa-solid fa-bullhorn text-lg"></i>
                        </div>
                      </div>
                      <div class="min-w-0">
                        <div class="flex items-center gap-1.5">
                          <p class="text-sm font-bold text-gray-800 truncate">{{ campaign.title }}</p>
                          <i v-if="campaign.is_featured" class="fa-solid fa-star text-[#d9a52b] text-[10px] flex-shrink-0"></i>
                        </div>
                        <p class="text-[10px] text-gray-400 truncate">/{{ campaign.slug }}</p>
                      </div>
                    </div>
                  </td>

                  <td class="px-4 py-3.5 w-48">
                    <div class="flex items-center gap-2">
                      <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500"
                          :class="isCompleted(campaign) ? 'bg-emerald-500' : 'bg-gradient-to-r from-[#00583f] to-[#007a55]'"
                          :style="{ width: `${progressPercent(campaign)}%` }"></div>
                      </div>
                      <span class="text-[10px] font-bold text-gray-600 w-10 text-right">
                        {{ progressPercent(campaign) }}%
                      </span>
                    </div>
                  </td>

                  <td class="px-4 py-3.5">
                    <span class="text-xs font-bold text-gray-700">
                      {{ formatCurrency(campaign.goal_amount) }}
                    </span>
                  </td>

                  <td class="px-4 py-3.5">
                    <span :class="[
                      'text-xs font-bold',
                      isCompleted(campaign) ? 'text-emerald-600' : 'text-[#00583f]'
                    ]">
                      {{ formatCurrency(campaign.raised_amount) }}
                    </span>
                  </td>

                  <td class="px-4 py-3.5">
                    <div class="text-[10px] text-gray-500 leading-tight">
                      <p>{{ formatDate(campaign.start_date) }}</p>
                      <p class="text-gray-400">to {{ formatDate(campaign.end_date) }}</p>
                    </div>
                  </td>

                  <td class="px-4 py-3.5">
                    <div class="flex flex-col gap-1 items-start">
                      <button @click="toggleStatus(campaign)"
                        :class="[
                          campaign.is_active
                            ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200'
                            : 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                          'inline-flex items-center gap-1.5 text-[10px] font-bold px-2.5 py-1 rounded-full transition-colors cursor-pointer'
                        ]">
                        <span :class="campaign.is_active ? 'bg-emerald-500' : 'bg-gray-400'" class="w-1.5 h-1.5 rounded-full"></span>
                        {{ campaign.is_active ? 'Active' : 'Inactive' }}
                      </button>
                      <span v-if="isCompleted(campaign)"
                        class="inline-flex items-center gap-1 text-[9px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                        <i class="fa-solid fa-check text-[8px]"></i> Goal Met
                      </span>
                    </div>
                  </td>

                  <td class="px-4 py-3.5">
                    <div class="flex items-center justify-end gap-1">
                      <button @click="toggleFeatured(campaign)" :title="campaign.is_featured ? 'Remove from featured' : 'Mark as featured'"
                        :class="[
                          'w-8 h-8 rounded-lg flex items-center justify-center transition-all',
                          campaign.is_featured
                            ? 'text-[#d9a52b] bg-[#d9a52b]/10 hover:bg-[#d9a52b]/20'
                            : 'text-gray-400 hover:bg-amber-50 hover:text-[#d9a52b]'
                        ]">
                        <i :class="campaign.is_featured ? 'fa-solid fa-star text-sm' : 'fa-regular fa-star text-sm'"></i>
                      </button>
                      <button @click="openEditModal(campaign)" title="Edit"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-all">
                        <i class="fa-solid fa-pen text-xs"></i>
                      </button>
                      <button @click="openDeleteModal(campaign)" title="Delete"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                        <i class="fa-solid fa-trash text-xs"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr v-if="campaignList.length === 0">
                  <td colspan="7" class="py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                      <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fa-solid fa-bullhorn text-gray-400 text-2xl"></i>
                      </div>
                      <div>
                        <p class="text-sm font-bold text-gray-700">No campaigns found</p>
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
            <div v-for="campaign in campaignList" :key="campaign.id" class="p-4 hover:bg-gray-50 transition-colors">
              <div class="flex items-start gap-3 mb-3">
                <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100">
                  <img v-if="campaign.image" :src="`/storage/${campaign.image}`" :alt="campaign.title" class="w-full h-full object-cover">
                  <div v-else class="w-full h-full bg-gradient-to-br from-[#00583f] to-[#007a55] flex items-center justify-center text-white">
                    <i class="fa-solid fa-bullhorn text-lg"></i>
                  </div>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                      <div class="flex items-center gap-1.5">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ campaign.title }}</p>
                        <i v-if="campaign.is_featured" class="fa-solid fa-star text-[#d9a52b] text-[10px] flex-shrink-0"></i>
                      </div>
                      <p class="text-[10px] text-gray-400 truncate">/{{ campaign.slug }}</p>
                    </div>
                    <span :class="[
                      campaign.is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600',
                      'text-[9px] font-bold px-2 py-0.5 rounded-full flex-shrink-0'
                    ]">
                      {{ campaign.is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Progress -->
              <div class="mb-3">
                <div class="flex items-center justify-between mb-1.5">
                  <span class="text-[10px] font-bold text-gray-500 uppercase">Progress</span>
                  <span class="text-[10px] font-bold text-gray-700">{{ progressPercent(campaign) }}%</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                  <div class="h-full rounded-full transition-all duration-500"
                    :class="isCompleted(campaign) ? 'bg-emerald-500' : 'bg-gradient-to-r from-[#00583f] to-[#007a55]'"
                    :style="{ width: `${progressPercent(campaign)}%` }"></div>
                </div>
                <div class="flex items-center justify-between mt-2">
                  <span class="text-[10px] text-gray-500">
                    Raised: <b class="text-[#00583f]">{{ formatCurrency(campaign.raised_amount) }}</b>
                  </span>
                  <span class="text-[10px] text-gray-500">
                    Goal: <b class="text-gray-700">{{ formatCurrency(campaign.goal_amount) }}</b>
                  </span>
                </div>
              </div>

              <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <div class="text-[10px] text-gray-400">
                  <i class="fa-regular fa-calendar mr-1"></i>
                  {{ formatDate(campaign.start_date) }} — {{ formatDate(campaign.end_date) }}
                </div>
                <div class="flex items-center gap-1">
                  <button @click="toggleFeatured(campaign)"
                    :class="[
                      'w-7 h-7 rounded-md flex items-center justify-center transition-all',
                      campaign.is_featured ? 'text-[#d9a52b] bg-[#d9a52b]/10' : 'text-gray-400 hover:bg-amber-50'
                    ]">
                    <i :class="campaign.is_featured ? 'fa-solid fa-star text-xs' : 'fa-regular fa-star text-xs'"></i>
                  </button>
                  <button @click="openEditModal(campaign)"
                    class="w-7 h-7 rounded-md flex items-center justify-center text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-all">
                    <i class="fa-solid fa-pen text-xs"></i>
                  </button>
                  <button @click="openDeleteModal(campaign)"
                    class="w-7 h-7 rounded-md flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                    <i class="fa-solid fa-trash text-xs"></i>
                  </button>
                </div>
              </div>
            </div>

            <div v-if="campaignList.length === 0" class="py-16 text-center">
              <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                  <i class="fa-solid fa-bullhorn text-gray-400 text-2xl"></i>
                </div>
                <p class="text-sm font-bold text-gray-700">No campaigns found</p>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div v-if="campaigns.data.length > 0"
            class="px-4 sm:px-5 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-500">
              Showing <span class="font-bold text-gray-700">{{ campaigns.from }}</span> to
              <span class="font-bold text-gray-700">{{ campaigns.to }}</span> of
              <span class="font-bold text-gray-700">{{ campaigns.total }}</span> campaigns
            </p>

            <div class="flex items-center gap-1">
              <template v-for="(link, i) in campaigns.links" :key="i">
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

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#00583f]/10 flex items-center justify-center">
                  <i :class="modalMode === 'create' ? 'fa-solid fa-plus text-[#00583f] text-sm' : 'fa-solid fa-pen text-[#00583f] text-sm'"></i>
                </div>
                <div>
                  <h3 class="text-base font-bold text-gray-900">
                    {{ modalMode === 'create' ? 'New Campaign' : 'Edit Campaign' }}
                  </h3>
                  <p class="text-xs text-gray-400">
                    {{ modalMode === 'create' ? 'Create a new fundraising campaign' : 'Update campaign details' }}
                  </p>
                </div>
              </div>

              <button @click="closeModal"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <i class="fa-solid fa-xmark text-sm"></i>
              </button>
            </div>

            <!-- Body -->
            <form @submit.prevent="submit" class="px-6 py-5 space-y-4 max-h-[70vh] overflow-y-auto">

              <!-- Title -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Campaign Title <span class="text-red-500">*</span>
                </label>
                <input v-model="form.title" type="text" placeholder="e.g. Ramadan Food Drive 2025"
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all"
                  :class="errors.title ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'">
                <p v-if="errors.title" class="text-[11px] text-red-500 mt-1">{{ errors.title }}</p>
              </div>

              <!-- Slug -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Slug</label>
                <input v-model="form.slug" type="text" placeholder="auto-generated-from-title"
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10 outline-none transition-all font-mono text-[12px]">
                <p class="text-[10px] text-gray-400 mt-1">Leave empty to auto-generate</p>
              </div>

              <!-- Goal + Raised -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                    Goal Amount <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">$</span>
                    <input v-model.number="form.goal_amount" type="number" min="0" step="0.01" placeholder="10000"
                      class="w-full pl-8 pr-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all"
                      :class="errors.goal_amount ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'">
                  </div>
                  <p v-if="errors.goal_amount" class="text-[11px] text-red-500 mt-1">{{ errors.goal_amount }}</p>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                    Raised Amount
                  </label>
                  <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">$</span>
                    <input v-model.number="form.raised_amount" type="number" min="0" step="0.01" placeholder="0"
                      class="w-full pl-8 pr-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all"
                      :class="errors.raised_amount ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'">
                  </div>
                  <p v-if="errors.raised_amount" class="text-[11px] text-red-500 mt-1">{{ errors.raised_amount }}</p>
                </div>
              </div>

              <!-- Dates -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Start Date</label>
                  <input v-model="form.start_date" type="date"
                    class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10 outline-none transition-all">
                  <p v-if="errors.start_date" class="text-[11px] text-red-500 mt-1">{{ errors.start_date }}</p>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">End Date</label>
                  <input v-model="form.end_date" type="date"
                    class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10 outline-none transition-all">
                  <p v-if="errors.end_date" class="text-[11px] text-red-500 mt-1">{{ errors.end_date }}</p>
                </div>
              </div>

             

              <!-- Full Description -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Full Description <span class="text-red-500">*</span>
                </label>
                <textarea v-model="form.description" rows="3"
                  placeholder="Detailed campaign description"
                  class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border rounded-lg focus:bg-white outline-none transition-all resize-none"
                  :class="errors.description ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10'"></textarea>
                <p v-if="errors.description" class="text-[11px] text-red-500 mt-1">{{ errors.description }}</p>
              </div>

              <!-- Order + Status row -->
              <div class="grid grid-cols-3 gap-4">
                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Order</label>
                  <input v-model.number="form.order" type="number" min="0"
                    class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-[#00583f] focus:ring-2 focus:ring-[#00583f]/10 outline-none transition-all">
                  <p v-if="errors.order" class="text-[11px] text-red-500 mt-1">{{ errors.order }}</p>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Status</label>
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
                  </button>
                </div>

                <div>
                  <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">Featured</label>
                  <button type="button" @click="form.is_featured = !form.is_featured"
                    :class="[
                      form.is_featured
                        ? 'bg-amber-50 border-amber-300 text-amber-700'
                        : 'bg-gray-50 border-gray-200 text-gray-600',
                      'w-full px-3.5 py-2.5 text-sm font-bold border rounded-lg flex items-center justify-between transition-all'
                    ]">
                    <span class="flex items-center gap-2">
                      <i :class="form.is_featured ? 'fa-solid fa-star text-amber-500' : 'fa-regular fa-star'" class="text-sm"></i>
                      {{ form.is_featured ? 'Featured' : 'No' }}
                    </span>
                  </button>
                </div>
              </div>

              <!-- ========== IMAGE SECTION WITH EXISTING PREVIEW ========== -->
              <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1.5">
                  Campaign Image (optional)
                </label>

                <!-- Existing Image Preview -->
                <div v-if="modalMode === 'edit' && form.existing_image && !form.remove_image && !form.image"
                  class="relative rounded-lg overflow-hidden border border-gray-200 mb-3 group">
                  <img :src="`/storage/${form.existing_image}`" alt="Current image"
                    class="w-full h-40 object-cover">
                  <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                    <span class="text-white text-xs font-bold bg-black/60 px-3 py-1.5 rounded-full">
                      <i class="fa-solid fa-image mr-1"></i> Current Image
                    </span>
                    <button type="button" @click="markRemoveExistingImage"
                      class="text-white text-xs font-bold bg-red-500/90 hover:bg-red-500 px-3 py-1.5 rounded-full transition-colors">
                      <i class="fa-solid fa-trash mr-1"></i> Remove
                    </button>
                  </div>
                </div>

                <!-- Marked for removal -->
                <div v-if="modalMode === 'edit' && form.existing_image && form.remove_image"
                  class="flex items-center justify-between gap-3 bg-red-50 border border-red-200 rounded-lg px-3.5 py-2.5 mb-3">
                  <div class="flex items-center gap-2 text-red-700">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    <span class="text-xs font-semibold">Current image will be removed on save</span>
                  </div>
                  <button type="button" @click="undoRemoveExistingImage"
                    class="text-[11px] font-bold text-red-700 hover:text-red-900 underline">
                    Undo
                  </button>
                </div>

                <!-- New file preview -->
                <div v-if="form.image" class="relative rounded-lg overflow-hidden border border-[#00583f] bg-[#00583f]/5 mb-3">
                  <div class="flex items-center gap-3 p-3">
                    <div class="w-12 h-12 rounded-lg bg-[#00583f] flex items-center justify-center flex-shrink-0">
                      <i class="fa-solid fa-image text-white text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-xs font-bold text-gray-800 truncate">{{ form.image.name }}</p>
                      <p class="text-[10px] text-gray-500">
                        {{ (form.image.size / 1024).toFixed(1) }} KB · New image
                      </p>
                    </div>
                    <button type="button" @click="clearNewImage"
                      class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-red-50 hover:text-red-500 transition-colors flex-shrink-0">
                      <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                  </div>
                </div>

                <!-- File picker -->
                <label class="cursor-pointer block">
                  <input type="file" accept="image/*" @change="handleImage" class="hidden">
                  <div class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-dashed border-gray-300 rounded-lg hover:border-[#00583f] hover:bg-[#00583f]/5 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-cloud-arrow-up text-[#00583f]"></i>
                    <span class="text-gray-600">
                      {{ form.image ? 'Choose a different image...' : (form.existing_image && !form.remove_image ? 'Replace current image...' : 'Choose file...') }}
                    </span>
                  </div>
                </label>
                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WEBP up to 3MB</p>
                <p v-if="errors.image" class="text-[11px] text-red-500 mt-1">{{ errors.image }}</p>
              </div>

            </form>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 rounded-b-2xl border-t border-gray-100">
              <button type="button" @click="closeModal" :disabled="submitting"
                class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors disabled:opacity-50">
                Cancel
              </button>
              <button type="button" @click="submit" :disabled="submitting"
                class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold bg-[#00583f] hover:bg-[#004a34] text-white rounded-lg transition-all hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed">
                <i v-if="submitting" class="fa-solid fa-spinner fa-spin text-xs"></i>
                <i v-else :class="modalMode === 'create' ? 'fa-solid fa-plus text-xs' : 'fa-solid fa-check text-xs'"></i>
                <span>{{ submitting ? 'Saving...' : (modalMode === 'create' ? 'Create Campaign' : 'Update Campaign') }}</span>
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

            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Campaign?</h3>
            <p class="text-sm text-gray-500 mb-6">
              Are you sure you want to delete
              <span class="font-bold text-gray-700">"{{ deletingCampaign?.title }}"</span>?
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
</style>