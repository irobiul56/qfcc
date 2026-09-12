<!-- resources/js/Pages/Dashboard/Gallery/Index.vue -->
<template>
  <UserLayout>
    <Head title="Gallery" />

    <div class="container mx-auto px-4 py-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Media Library</h1>
          <p class="text-gray-600 mt-1">Manage your gallery images</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
          <!-- Category Filter -->
          <select 
            v-model="selectedCategory"
            @change="filterByCategory"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
          >
            <option value="">All Categories</option>
            <option 
              v-for="category in categories" 
              :key="category.id" 
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>

          <!-- Upload Section -->
          <div class="flex gap-2">
            <select 
              v-model="uploadForm.category_id"
              class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              :class="{ 'border-red-500': uploadForm.errors.category_id }"
            >
              <option value="">Select Category</option>
              <option 
                v-for="category in categories" 
                :key="category.id" 
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
            
            <div class="relative">
              <label for="image-upload" class="bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-700 transition-colors inline-flex items-center disabled:bg-gray-400 disabled:cursor-not-allowed" :class="{ 'bg-gray-400 cursor-not-allowed': !uploadForm.category_id }">
                <i class="fas fa-upload mr-2"></i>
                Upload Images
              </label>
              <input 
                id="image-upload"
                type="file" 
                multiple 
                accept="image/*" 
                class="hidden" 
                @change="handleImageUpload"
                :disabled="!uploadForm.category_id"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Error Messages -->
      <div v-if="uploadForm.errors.images" class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ uploadForm.errors.images }}
      </div>
      
      <div v-if="uploadForm.errors.category_id" class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ uploadForm.errors.category_id }}
      </div>

      <!-- Success Message -->
      <div v-if="$page.props.flash?.success" class="mb-6 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
        <div class="flex items-center">
          <i class="fas fa-check-circle mr-2"></i>
          {{ $page.props.flash.success }}
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="uploadForm.processing" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-center justify-between">
          <span class="text-blue-800">
            <i class="fas fa-spinner fa-spin mr-2"></i>
            Uploading {{ uploadForm.images.length }} images...
          </span>
        </div>
      </div>

      <!-- Gallery Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <div 
          v-for="item in media.data" 
          :key="item.id"
          class="relative group bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300"
        >
          <!-- Image -->
          <div class="aspect-square bg-gray-100 relative">
            <img 
              :src="item.url" 
              :alt="item.caption || item.original_name"
              class="w-full h-full object-cover"
              loading="lazy"
            />
            
            <!-- Overlay Actions -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
              <div class="flex space-x-2">
                <button 
                  @click="previewImage(item)"
                  class="bg-white bg-opacity-90 p-3 rounded-full hover:bg-opacity-100 transition-colors"
                  title="Preview"
                >
                  <i class="fas fa-eye text-gray-700"></i>
                </button>
                <button 
                  @click="editCaption(item)"
                  class="bg-white bg-opacity-90 p-3 rounded-full hover:bg-opacity-100 transition-colors"
                  title="Edit Caption"
                >
                  <i class="fas fa-edit text-blue-600"></i>
                </button>
                <button 
                  @click="deleteImage(item)"
                  class="bg-white bg-opacity-90 p-3 rounded-full hover:bg-opacity-100 transition-colors"
                  title="Delete"
                >
                  <i class="fas fa-trash text-red-600"></i>
                </button>
              </div>
            </div>

            <!-- Category Badge -->
            <div class="absolute top-2 left-2">
              <span class="bg-black bg-opacity-70 text-white text-xs px-2 py-1 rounded">
                {{ item.category?.name }}
              </span>
            </div>
          </div>

          <!-- Image Info -->
          <div class="p-3">
            <p class="text-sm font-medium text-gray-900 truncate" :title="item.original_name">
              {{ item.original_name }}
            </p>
            <!-- Caption Display -->
            <div class="mt-1">
              <p 
                v-if="item.caption" 
                class="text-xs text-gray-700 truncate"
                :title="item.caption"
              >
                {{ item.caption }}
              </p>
              <p 
                v-else 
                class="text-xs text-gray-400 italic"
              >
                No caption
              </p>
            </div>
            <p class="text-xs text-gray-500 mt-1">{{ item.formatted_size }}</p>
            <p class="text-xs text-gray-500">{{ formatDate(item.created_at) }}</p>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-8">
        <Pagination :links="media.links" />
      </div>

      <!-- Empty State -->
      <div v-if="media.data.length === 0" class="text-center py-12">
        <i class="fas fa-folder-open text-4xl text-gray-400 mb-4"></i>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No images found</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by uploading some images.</p>
      </div>

      <!-- Image Preview Modal -->
      <div v-if="previewItem" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
          <div class="p-4 border-b flex justify-between items-center">
            <div>
              <h3 class="text-lg font-medium">{{ previewItem.original_name }}</h3>
              <p class="text-sm text-gray-600">{{ previewItem.category?.name }}</p>
            </div>
            <button @click="previewItem = null" class="text-gray-400 hover:text-gray-600 transition-colors">
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>
          <div class="p-6 max-h-[calc(90vh-120px)] overflow-auto">
            <img 
              :src="previewItem.url" 
              :alt="previewItem.original_name" 
              class="max-w-full h-auto mx-auto rounded-lg"
            />
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <div>
                <strong class="text-gray-700">
                  <i class="fas fa-file-alt mr-2"></i>
                  File name:
                </strong> 
                <span class="ml-2">{{ previewItem.original_name }}</span>
              </div>
              <div>
                <strong class="text-gray-700">
                  <i class="fas fa-weight-hanging mr-2"></i>
                  File size:
                </strong> 
                <span class="ml-2">{{ previewItem.formatted_size }}</span>
              </div>
              <div>
                <strong class="text-gray-700">
                  <i class="fas fa-folder mr-2"></i>
                  Category:
                </strong> 
                <span class="ml-2">{{ previewItem.category?.name }}</span>
              </div>
              <div>
                <strong class="text-gray-700">
                  <i class="fas fa-calendar mr-2"></i>
                  Uploaded:
                </strong> 
                <span class="ml-2">{{ formatDate(previewItem.created_at) }}</span>
              </div>
              <div class="md:col-span-2">
                <strong class="text-gray-700">
                  <i class="fas fa-comment mr-2"></i>
                  Caption:
                </strong> 
                <span class="ml-2" :class="previewItem.caption ? 'text-gray-900' : 'text-gray-400 italic'">
                  {{ previewItem.caption || 'No caption' }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Edit Caption Modal -->
      <div v-if="editItem" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg max-w-md w-full">
          <div class="p-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-medium">Edit Caption</h3>
            <button @click="editItem = null" class="text-gray-400 hover:text-gray-600 transition-colors">
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>
          <div class="p-6">
            <!-- Image Preview -->
            <div class="mb-4 flex justify-center">
              <img 
                :src="editItem.url" 
                :alt="editItem.original_name" 
                class="h-32 w-auto rounded-lg object-cover"
              />
            </div>
            
            <form @submit.prevent="updateCaption">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Caption
                </label>
                <textarea
                  v-model="captionForm.caption"
                  rows="3"
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter image caption..."
                  maxlength="255"
                ></textarea>
                <p class="text-xs text-gray-500 mt-1">
                  {{ captionForm.caption.length }}/255 characters
                </p>
                <div v-if="captionForm.errors.caption" class="text-red-600 text-xs mt-1">
                  {{ captionForm.errors.caption }}
                </div>
              </div>
              
              <div class="flex justify-end space-x-3">
                <button
                  type="button"
                  @click="editItem = null"
                  class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="captionForm.processing"
                  class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:bg-blue-400"
                >
                  <span v-if="captionForm.processing">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Saving...
                  </span>
                  <span v-else>
                    <i class="fas fa-save mr-2"></i>
                    Save Caption
                  </span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router, useForm, Head } from '@inertiajs/vue3'
import UserLayout from '@/Layouts/UserLayout.vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  media: Object,
  categories: Array
})

const previewItem = ref(null)
const editItem = ref(null)
const selectedCategory = ref('')

const uploadForm = useForm({
  images: [],
  category_id: ''
})

const captionForm = useForm({
  caption: ''
})

const handleImageUpload = (event) => {
  const files = Array.from(event.target.files)
  
  if (!uploadForm.category_id) {
    uploadForm.setError('category_id', 'Please select a category before uploading')
    event.target.value = ''
    return
  }

  if (files.length === 0) {
    return
  }
  
  uploadForm.images = files

  uploadForm.post(route('photos.store'), {
    forceFormData: true,
    onSuccess: () => {
      uploadForm.reset()
      event.target.value = ''
    },
    onError: (errors) => {
      console.error('Upload failed:', errors)
      event.target.value = ''
    }
  })
}

const previewImage = (item) => {
  previewItem.value = item
}

const editCaption = (item) => {
  editItem.value = item
  captionForm.caption = item.caption || ''
}

const updateCaption = () => {
  if (!editItem.value) return

  captionForm.put(route('photos.update', editItem.value.id), {
    onSuccess: () => {
      editItem.value = null
      captionForm.reset()
    }
  })
}

const deleteImage = (item) => {
  if (confirm(`Are you sure you want to delete "${item.original_name}"?`)) {
    router.delete(route('photos.destroy', item.id))
  }
}

const filterByCategory = () => {
  router.get(route('photos.index'), {
    category: selectedCategory.value
  }, {
    preserveState: true,
    replace: true
  })
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}
</script>