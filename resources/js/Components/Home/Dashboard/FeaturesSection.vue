<template>
  <section id="about" class="py-16 px-4 sm:px-6 lg:px-8 bg-white mx-auto my-8 max-w-full">
    <!-- Header -->
    <div class="flex flex-col items-center mb-12">
      <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 text-center">
        For Ummah<span class="text-accent-gold">,</span> With Sunnah
      </h2>
      <p class="mt-3 text-lg text-gray-500 max-w-2xl text-center">
        Our mission is built on three pillars to serve the community in alignment with Islamic principles.
      </p>
      <!-- Manage Features Button -->
      <button 
        @click="openFeaturesModal"
        class="mt-6 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition-colors shadow-sm"
      >
        <i class="fas fa-cog"></i>
        Manage Features
      </button>
    </div>

    <!-- Content Grid -->
    <div v-if="features && features.length > 0" class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-[1fr_auto_1fr_auto_1fr] gap-y-10 md:gap-y-0 md:gap-x-4 lg:gap-x-12 justify-items-center">
      
      <!-- Dynamic Feature Blocks -->
      <template v-for="(feature, index) in features" :key="feature.id">
        <!-- Feature Block -->
        <div 
          :class="{
            'flex flex-col items-center text-center w-full max-w-xs p-6 bg-white transition-all duration-300 hover:scale-[1.03] rounded-xl shadow-sm hover:shadow-lg border border-gray-100': true,
            'md:col-start-1 md:row-start-1': index === 0,
            'md:col-start-3 md:row-start-1': index === 1,
            'md:col-start-5 md:row-start-1': index === 2
          }"
        >
          <div class="relative group">
            <!-- Font Awesome Icon -->
            <i 
              :class="feature.icon" 
              class="h-14 w-14 mb-4 transition-transform duration-300 group-hover:scale-110"
              :style="{ color: feature.color || '#E8B65D' }"
            ></i>
            <!-- Active/Inactive Indicator -->
            <div 
              v-if="!feature.is_active"
              class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"
              title="Inactive"
            ></div>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ feature.title }}</h3>
          <p class="text-gray-600 text-base">{{ feature.description }}</p>
        </div>
        
        <!-- Vertical Separator (only between features on desktop) -->
        <div 
          v-if="index < features.length - 1"
          class="hidden md:block h-full w-px bg-gray-300 mx-4 self-stretch" 
          role="separator" 
          aria-orientation="vertical"
        ></div>
      </template>

      <!-- Know More Button -->
      <div class="md:col-span-5 w-full flex justify-center mt-10">
        <Link 
          :href="route('about')" 
          class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-lg font-medium rounded-xl shadow-xl text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-accent-gold/50 transition duration-200 ease-in-out transform hover:-translate-y-0.5"
        >
          Know More
          <i class="fas fa-arrow-right ml-3 h-5 w-5"></i>
        </Link>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
        <i class="fas fa-inbox text-2xl text-gray-400"></i>
      </div>
      <h3 class="text-lg font-medium text-gray-900 mb-2">No features available</h3>
      <p class="text-gray-500 mb-4">Add features to display here</p>
      <button 
        @click="openFeatureCreateModal"
        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 inline-flex items-center gap-2 shadow-sm"
      >
        <i class="fas fa-plus"></i>
        Add Features
      </button>
    </div>

    <!-- ============================== -->
    <!-- MODALS FOR CRUD OPERATIONS -->
    <!-- ============================== -->

    <!-- Features Management Modal -->
    <div v-if="isFeaturesModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-900 opacity-75" @click="closeFeaturesModal"></div>
        </div>

        <!-- Modal panel -->
        <div 
          class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full"
          @click.stop
        >
          <!-- Header -->
          <div class="bg-white px-6 pt-6 pb-4">
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-3">
                <i class="fas fa-cog text-2xl text-green-600"></i>
                <div>
                  <h3 class="text-xl font-bold text-gray-900">Manage Features</h3>
                  <p class="text-sm text-gray-600">Create, edit, or delete homepage features</p>
                </div>
              </div>
              <div class="flex items-center gap-3">
                <button 
                  @click="openFeatureCreateModal"
                  class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition-colors"
                >
                  <i class="fas fa-plus"></i>
                  Add Feature
                </button>
                <button 
                  @click="closeFeaturesModal"
                  class="p-2 text-gray-400 hover:text-gray-500 rounded-lg hover:bg-gray-100"
                >
                  <i class="fas fa-times text-xl"></i>
                </button>
              </div>
            </div>

            <!-- Features List -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Feature
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="feature in features" :key="feature.id">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-10 w-10">
                            <i 
                              :class="feature.icon" 
                              class="text-xl"
                              :style="{ color: feature.color }"
                            ></i>
                          </div>
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ feature.title }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-xs">{{ feature.description }}</div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                              :class="feature.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                          {{ feature.is_active ? 'Active' : 'Inactive' }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ feature.order }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex gap-2">
                          <button 
                            @click="openFeatureEditModal(feature)"
                            class="text-blue-600 hover:text-blue-900 p-2 hover:bg-blue-50 rounded-lg transition-colors"
                            title="Edit"
                          >
                            <i class="fas fa-edit"></i>
                          </button>
                          <button 
                            @click="handleDeleteFeature(feature.id)"
                            class="text-red-600 hover:text-red-900 p-2 hover:bg-red-50 rounded-lg transition-colors"
                            title="Delete"
                          >
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    <tr v-if="features.length === 0">
                      <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-2"></i>
                        <p>No features found. Add your first feature!</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="bg-gray-50 px-6 py-4 border-t">
            <div class="flex justify-between items-center">
              <div class="text-sm text-gray-500">
                {{ features.length }} feature{{ features.length !== 1 ? 's' : '' }}
              </div>
              <button
                @click="closeFeaturesModal"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Feature Form Modal (Create/Edit) -->
    <div v-if="isFeatureFormModalOpen" class="fixed inset-0 z-[60] overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-900 opacity-50" @click="closeFeatureFormModal"></div>
        </div>

        <!-- Modal panel -->
        <div 
          class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
          @click.stop
        >
          <!-- Header -->
          <div class="bg-white px-6 pt-6 pb-4">
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-3">
                <i 
                  :class="featureModalMode === 'create' ? 'fas fa-plus text-green-600' : 'fas fa-edit text-blue-600'" 
                  class="text-2xl"
                ></i>
                <h3 class="text-xl font-bold text-gray-900">
                  {{ featureModalMode === 'create' ? 'Create New Feature' : 'Edit Feature' }}
                </h3>
              </div>
              <button 
                @click="closeFeatureFormModal"
                class="p-2 text-gray-400 hover:text-gray-500 rounded-lg hover:bg-gray-100"
              >
                <i class="fas fa-times text-xl"></i>
              </button>
            </div>

            <!-- Form -->
            <div class="space-y-6">
              <!-- Title -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Title *
                </label>
                <input
                  type="text"
                  v-model="featureForm.title"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  placeholder="Enter feature title"
                  required
                />
                <div v-if="featureForm.errors.title" class="text-red-500 text-sm mt-1">
                  {{ featureForm.errors.title }}
                </div>
              </div>

              <!-- Description -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Description *
                </label>
                <textarea
                  v-model="featureForm.description"
                  rows="3"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  placeholder="Enter feature description"
                  required
                ></textarea>
                <div v-if="featureForm.errors.description" class="text-red-500 text-sm mt-1">
                  {{ featureForm.errors.description }}
                </div>
              </div>

              <!-- Icon Selection -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                  Icon *
                </label>
                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2 mb-4">
                  <button
                    v-for="iconOption in iconOptions"
                    :key="iconOption.value"
                    type="button"
                    @click="featureForm.icon = iconOption.value"
                    :class="[
                      'p-3 border rounded-lg flex flex-col items-center justify-center gap-2 transition-all hover:shadow-sm',
                      featureForm.icon === iconOption.value 
                        ? 'border-green-500 bg-green-50 ring-2 ring-green-200' 
                        : 'border-gray-200 hover:border-green-300'
                    ]"
                    :title="iconOption.label"
                  >
                    <i 
                      :class="iconOption.value" 
                      class="text-xl"
                      :style="{ color: featureForm.color }"
                    ></i>
                    <span class="text-xs text-gray-600 truncate w-full text-center">
                      {{ iconOption.label }}
                    </span>
                  </button>
                </div>
                <div v-if="featureForm.errors.icon" class="text-red-500 text-sm mt-1">
                  {{ featureForm.errors.icon }}
                </div>
              </div>

              <!-- Color Selection -->
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                  Color
                </label>
                <div class="flex flex-wrap gap-2 mb-4">
                  <button
                    v-for="colorOption in colorOptions"
                    :key="colorOption.value"
                    type="button"
                    @click="featureForm.color = colorOption.value"
                    :class="[
                      'w-8 h-8 rounded-full border transition-transform hover:scale-110',
                      featureForm.color === colorOption.value 
                        ? 'ring-2 ring-offset-2 ring-green-500' 
                        : 'border-gray-300'
                    ]"
                    :style="{ backgroundColor: colorOption.value }"
                    :title="colorOption.label"
                  />
                </div>
                <div class="flex items-center gap-3">
                  <input
                    type="color"
                    v-model="featureForm.color"
                    class="w-10 h-10 cursor-pointer rounded border border-gray-300"
                  />
                  <div class="flex items-center gap-2">
                    <input
                      type="text"
                      v-model="featureForm.color"
                      class="px-3 py-2 border border-gray-300 rounded text-sm w-32"
                      placeholder="#E8B65D"
                    />
                  </div>
                </div>
                <div v-if="featureForm.errors.color" class="text-red-500 text-sm mt-1">
                  {{ featureForm.errors.color }}
                </div>
              </div>

              <!-- Order and Status -->
              <div class="grid grid-cols-2 gap-6">
                <!-- Order -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Display Order
                  </label>
                  <input
                    type="number"
                    v-model="featureForm.order"
                    min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  />
                  <div v-if="featureForm.errors.order" class="text-red-500 text-sm mt-1">
                    {{ featureForm.errors.order }}
                  </div>
                </div>

                <!-- Status -->
                <div>
                  <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input
                      type="checkbox"
                      v-model="featureForm.is_active"
                      class="rounded border-gray-300 text-green-600 focus:ring-green-500"
                    />
                    <div>
                      <span class="text-sm font-medium text-gray-700">Active</span>
                      <p class="text-xs text-gray-500 mt-1">
                        Show on homepage
                      </p>
                    </div>
                  </label>
                </div>
              </div>

              <!-- Preview -->
              <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Preview</h4>
                <div class="flex flex-col items-center text-center max-w-xs mx-auto p-6 bg-white rounded-xl shadow-sm border">
                  <i 
                    :class="featureForm.icon"
                    class="h-14 w-14 mb-4"
                    :style="{ color: featureForm.color }"
                  ></i>
                  <h3 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ featureForm.title || 'Feature Title' }}
                  </h3>
                  <p class="text-gray-600">
                    {{ featureForm.description || 'Feature description...' }}
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="bg-gray-50 px-6 py-4 border-t">
            <div class="flex justify-end gap-3">
              <button
                @click="closeFeatureFormModal"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
                :disabled="featureForm.processing"
              >
                Cancel
              </button>
              <button
                @click="handleFeatureSubmit"
                :disabled="featureForm.processing"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center gap-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <i v-if="featureForm.processing" class="fas fa-spinner fa-spin"></i>
                <i v-else :class="featureModalMode === 'create' ? 'fas fa-plus' : 'fas fa-save'"></i>
                {{ featureForm.processing ? 'Processing...' : (featureModalMode === 'create' ? 'Create Feature' : 'Update Feature') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link, useForm, router } from '@inertiajs/vue3'
import { ref, reactive, onMounted, computed, watch } from 'vue'

// Props
const props = defineProps({
  initialFeatures: {
    type: Array,
    default: () => []
  }
})

// State
const features = ref(props.initialFeatures || [])
const isFeaturesModalOpen = ref(false)
const isFeatureFormModalOpen = ref(false)
const featureModalMode = ref('create')
const currentFeature = ref(null)

// Use Inertia's useForm for form handling
const featureForm = useForm({
  title: '',
  description: '',
  icon: 'fas fa-book-open',
  color: '#E8B65D',
  order: 0,
  is_active: true
})

// Common icons for selection
const iconOptions = ref([
  { value: 'fas fa-book-open', label: 'Book Open' },
  { value: 'fas fa-hands-helping', label: 'Helping Hands' },
  { value: 'fas fa-chart-line', label: 'Chart Line' },
  { value: 'fas fa-graduation-cap', label: 'Graduation Cap' },
  { value: 'fas fa-heart', label: 'Heart' },
  { value: 'fas fa-leaf', label: 'Leaf' },
  { value: 'fas fa-lightbulb', label: 'Lightbulb' },
  { value: 'fas fa-users', label: 'Users' },
  { value: 'fas fa-globe', label: 'Globe' },
  { value: 'fas fa-hands', label: 'Hands' },
  { value: 'fas fa-home', label: 'Home' },
  { value: 'fas fa-tree', label: 'Tree' },
  { value: 'fas fa-water', label: 'Water' },
  { value: 'fas fa-hand-holding-heart', label: 'Hand Holding Heart' },
  { value: 'fas fa-laptop', label: 'Laptop' },
  { value: 'fas fa-book', label: 'Book' },
  { value: 'fas fa-mosque', label: 'Mosque' },
  { value: 'fas fa-star', label: 'Star' },
  { value: 'fas fa-tools', label: 'Tools' },
  { value: 'fas fa-shield-alt', label: 'Shield' },
  { value: 'fas fa-user-graduate', label: 'Graduate' },
  { value: 'fas fa-hands-praying', label: 'Praying Hands' },
  { value: 'fas fa-seedling', label: 'Seedling' },
  { value: 'fas fa-hands-holding', label: 'Holding Hands' },
  { value: 'fas fa-university', label: 'University' },
  { value: 'fas fa-hands-wash', label: 'Hand Wash' },
  { value: 'fas fa-code', label: 'Code' },
  { value: 'fas fa-graduation-cap', label: 'Education' }
])

const colorOptions = ref([
  { value: '#E8B65D', label: 'Gold' },
  { value: '#10B981', label: 'Green' },
  { value: '#3B82F6', label: 'Blue' },
  { value: '#8B5CF6', label: 'Purple' },
  { value: '#EF4444', label: 'Red' },
  { value: '#F59E0B', label: 'Amber' },
  { value: '#06B6D4', label: 'Cyan' },
  { value: '#EC4899', label: 'Pink' },
  { value: '#8B4513', label: 'Brown' },
  { value: '#000000', label: 'Black' }
])

// Toast notification
const showToast = (message, type = 'success') => {
  const toast = document.createElement('div')
  toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-[70] transform transition-all duration-300 ${
    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
  }`
  toast.textContent = message
  
  document.body.appendChild(toast)
  
  setTimeout(() => {
    toast.classList.add('opacity-0', 'translate-x-full')
    setTimeout(() => document.body.removeChild(toast), 300)
  }, 3000)
}

// Load features
const loadFeatures = async () => {
  try {
    // Use Inertia's get method to reload the page and get fresh features
    router.reload({ 
      only: ['initialFeatures'],
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        // Features will be updated via the watcher below
      },
      onError: () => {
        showToast('Failed to load features', 'error')
      }
    })
  } catch (error) {
    showToast('Failed to load features', 'error')
    console.error(error)
  }
}

// Watch for prop changes to update features
watch(() => props.initialFeatures, (newFeatures) => {
  if (newFeatures) {
    features.value = newFeatures
  }
}, { immediate: true })

// Modal Handlers
const openFeaturesModal = () => {
  isFeaturesModalOpen.value = true
}

const closeFeaturesModal = () => {
  isFeaturesModalOpen.value = false
}

const openFeatureCreateModal = () => {
  featureModalMode.value = 'create'
  featureForm.reset()
  featureForm.icon = 'fas fa-book-open'
  featureForm.color = '#E8B65D'
  featureForm.order = 0
  featureForm.is_active = true
  isFeatureFormModalOpen.value = true
}

const openFeatureEditModal = (feature) => {
  featureModalMode.value = 'edit'
  currentFeature.value = feature
  
  // Populate form with current feature data
  featureForm.title = feature.title
  featureForm.description = feature.description
  featureForm.icon = feature.icon
  featureForm.color = feature.color || '#E8B65D'
  featureForm.order = feature.order || 0
  featureForm.is_active = feature.is_active !== false
  
  isFeatureFormModalOpen.value = true
}

const closeFeatureFormModal = () => {
  isFeatureFormModalOpen.value = false
  featureForm.reset()
  currentFeature.value = null
}

// Feature CRUD Operations using Inertia
const handleFeatureSubmit = () => {
  if (featureModalMode.value === 'create') {
    // Create new feature
    featureForm.post(route('features.store'), {
      preserveScroll: true,
      preserveState: false,
      onSuccess: (page) => {
        showToast('Feature created successfully!', 'success')
        closeFeatureFormModal()
        // Refresh features
        loadFeatures()
      },
      onError: (errors) => {
        // Inertia automatically populates featureForm.errors
        showToast('Please fix the errors in the form', 'error')
      }
    })
  } else {
    // Update existing feature
    featureForm.put(route('features.update', currentFeature.value.id), {
      preserveScroll: true,
      preserveState: false,
      onSuccess: (page) => {
        showToast('Feature updated successfully!', 'success')
        closeFeatureFormModal()
        // Refresh features
        loadFeatures()
      },
      onError: (errors) => {
        // Inertia automatically populates featureForm.errors
        showToast('Please fix the errors in the form', 'error')
      }
    })
  }
}

const handleDeleteFeature = (featureId) => {
  if (!confirm('Are you sure you want to delete this feature? This action cannot be undone.')) {
    return
  }
  
  // Using Inertia's delete method
  router.delete(route('features.destroy', featureId), {
    preserveScroll: true,
    preserveState: false,
    onSuccess: (page) => {
      showToast('Feature deleted successfully!', 'success')
      // Refresh features
      loadFeatures()
    },
    onError: () => {
      showToast('Failed to delete feature. Please try again.', 'error')
    }
  })
}

// Handle keyboard events for modals
const handleKeydown = (event) => {
  if (event.key === 'Escape') {
    if (isFeatureFormModalOpen.value) {
      closeFeatureFormModal()
    } else if (isFeaturesModalOpen.value) {
      closeFeaturesModal()
    }
  }
}

// Add keyboard event listener
onMounted(() => {
  window.addEventListener('keydown', handleKeydown)
  return () => {
    window.removeEventListener('keydown', handleKeydown)
  }
})
</script>

<style scoped>
.text-accent-gold {
  color: #E8B65D;
}

/* Modal animations */
.fixed {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Disabled button styles */
button:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}

/* Spinner animation for Font Awesome */
.fa-spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Form input focus styles */
input:focus, textarea:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(72, 187, 120, 0.1);
}

/* Table row hover effect */
tbody tr:hover {
  background-color: #f9fafb;
}

/* Ensure icons are properly sized */
i[class^="fas fa-"] {
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
</style>