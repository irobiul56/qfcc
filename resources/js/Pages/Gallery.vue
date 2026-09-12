<template>
<AppLayout title="Gallery">
  <div>
    <!-- Hero Section -->
    <section 
      class="py-16 sm:py-24 bg-cover bg-center relative -mt-5" 
      :style="{ backgroundImage: `url('storage/images/${heroImage}')` }"
    >
      <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-6 text-center">
          Gallery
        </h1>
        <div class="w-24 h-1 bg-green-400 mx-auto rounded-full mb-12"></div>
      </div>
    </section>

    <!-- Gallery Content -->
    <div class="p-4 sm:p-8 bg-gray-50 min-h-screen">
      <div class="max-w-5xl mx-auto">
        
        <!-- Tab Switcher -->
        <div class="flex justify-center mb-8">
          <div class="flex p-1 bg-white rounded-full shadow-md">
            <button 
              class="px-6 py-2 rounded-full text-sm font-semibold transition duration-150 shadow-lg"
              :class="activeTab === 'picture' 
                ? 'text-white bg-green-500 hover:bg-green-600' 
                : 'text-gray-700 hover:text-green-500'"
              @click="setActiveTab('picture')"
            >
              Picture
            </button>
            <button 
              class="px-6 py-2 rounded-full text-sm font-semibold transition duration-150"
              :class="activeTab === 'video' 
                ? 'text-white bg-green-500 hover:bg-green-600' 
                : 'text-gray-700 hover:text-green-500'"
              @click="setActiveTab('video')"
            >
              Video
            </button>
          </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
          
          <!-- Category Sidebar -->
          <div class="w-full lg:w-1/4 bg-white p-2 rounded-lg shadow-xl h-fit">
            <ul class="space-y-2">
              <li 
                class="p-3 rounded-md text-sm font-medium cursor-pointer transition duration-150"
                :class="activeCategory === null 
                  ? 'text-green-700 bg-green-50/70 border-l-4 border-green-500 font-semibold' 
                  : 'text-gray-700 hover:bg-gray-100'"
                @click="setActiveCategory(null)"
              >
                All Categories
              </li>
              <li 
                v-for="category in categories" 
                :key="category.id"
                class="p-3 rounded-md text-sm font-medium cursor-pointer transition duration-150"
                :class="activeCategory === category.id 
                  ? 'text-green-700 bg-green-50/70 border-l-4 border-green-500 font-semibold' 
                  : 'text-gray-700 hover:bg-gray-100'"
                @click="setActiveCategory(category.id)"
              >
                {{ category.name }}
              </li>
            </ul>
          </div>

          <!-- Gallery Grid -->
          <div class="w-full lg:w-3/4">
            <!-- Picture Gallery -->
            <div v-if="activeTab === 'picture'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
              <div 
                v-for="(item, index) in filteredMedia" 
                :key="index"
                class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-[1.02] transition duration-300 cursor-pointer"
                @click="item.type === 'image' ? openLightbox(item) : null"
              >
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center overflow-hidden relative">
                  <!-- Image -->
                  <div v-if="item.type === 'image'" class="w-full h-full">
                    <img 
                      :src="item.url" 
                      :alt="item.caption || item.original_name"
                      class="w-full h-full object-cover"
                      @error="handleImageError"
                    />
                    <div 
                      v-if="item.caption" 
                      class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3"
                    >
                      <p class="text-white text-sm line-clamp-2">{{ item.caption }}</p>
                    </div>
                  </div>
                  
                  <!-- Video Placeholder -->
                  <div v-else class="text-center">
                    <div class="text-gray-600 mb-2">
                      <i class="fas fa-video text-3xl"></i>
                    </div>
                    <p class="text-sm text-gray-700 font-medium">{{ item.original_name }}</p>
                  </div>
                </div>
                
                <!-- Info Section -->
                <div class="p-3">
                  <p class="text-xs text-gray-500 mb-1">
                    Added: {{ formatDate(item.created_at) }}
                  </p>
                  <div v-if="item.category" class="flex items-center justify-between">
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                      {{ item.category.name }}
                    </span>
                    <button 
                      v-if="item.type === 'image'"
                      @click.stop="openLightbox(item)"
                      class="text-green-600 hover:text-green-800 text-sm"
                    >
                      <i class="fas fa-expand"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Video Gallery -->
            <div v-if="activeTab === 'video'" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
              <div 
                v-for="item in filteredMedia" 
                :key="item.id"
                class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-[1.02] transition duration-300"
              >
                <div class="w-full h-48 bg-gray-800 flex items-center justify-center relative">
                  <div class="text-white text-center">
                    <i class="fas fa-play-circle text-5xl mb-3 opacity-80"></i>
                    <p class="text-sm font-medium">{{ item.original_name }}</p>
                  </div>
                </div>
                <div class="p-3">
                  <div v-if="item.category" class="flex justify-between items-center">
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                      {{ item.category.name }}
                    </span>
                    <button class="text-blue-600 hover:text-blue-800 text-sm">
                      <i class="fas fa-download"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div v-if="media.data && media.data.length > 0" class="mt-8 flex justify-center">
              <nav class="flex items-center space-x-2">
                <button
                  v-for="(link, index) in media.links"
                  :key="index"
                  @click="link.url ? $inertia.get(link.url) : null"
                  class="px-3 py-1 rounded-md text-sm"
                  :class="{
                    'bg-green-500 text-white': link.active,
                    'bg-white text-gray-700 hover:bg-gray-100': !link.active && link.url,
                    'text-gray-400 cursor-not-allowed': !link.url
                  }"
                  v-html="link.label"
                  :disabled="!link.url"
                ></button>
              </nav>
            </div>

            <!-- No Results -->
            <div v-if="filteredMedia.length === 0" class="text-center py-12">
              <div class="text-gray-400 text-6xl mb-4">
                <i class="fas fa-image"></i>
              </div>
              <p class="text-gray-600 text-lg">No media found for this category</p>
              <p class="text-gray-500 text-sm mt-2">Try selecting a different category</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Lightbox Modal -->
    <div 
      v-if="showLightbox" 
      class="fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center p-4"
      @click="closeLightbox"
    >
      <div class="relative max-w-5xl max-h-[90vh] w-full" @click.stop>
        <button 
          class="absolute -top-12 right-0 text-white text-3xl hover:text-gray-300 transition duration-150 z-10"
          @click="closeLightbox"
        >
          <i class="fas fa-times"></i>
        </button>
        
        <div class="bg-white rounded-lg overflow-hidden">
          <img 
            :src="currentMedia.url" 
            :alt="currentMedia.caption || currentMedia.original_name"
            class="w-full max-h-[70vh] object-contain"
          />
          <div v-if="currentMedia.caption" class="p-4 bg-white">
            <p class="text-gray-800">{{ currentMedia.caption }}</p>
            <div class="flex justify-between items-center mt-2">
              <span class="text-sm text-gray-500">
                {{ currentMedia.original_name }}
              </span>
              <span v-if="currentMedia.category" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                {{ currentMedia.category.name }}
              </span>
            </div>
          </div>
        </div>
        
        <!-- Navigation Arrows -->
        <button 
          v-if="currentMediaIndex > 0"
          @click="prevImage"
          class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300"
        >
          <i class="fas fa-chevron-left"></i>
        </button>
        
        <button 
          v-if="currentMediaIndex < filteredMedia.length - 1"
          @click="nextImage"
          class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-3xl hover:text-gray-300"
        >
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
  </div>
</AppLayout>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Get props from Inertia
const props = defineProps({
  media: Object,
  categories: Array
})

// Reactive data
const activeTab = ref('picture')
const activeCategory = ref(null)
const showLightbox = ref(false)
const currentMedia = ref({})
const currentMediaIndex = ref(0)
const heroImage = ref('1.jpeg')

// Computed properties
const filteredMedia = computed(() => {
  if (!props.media || !props.media.data) return []
  
  const mediaData = props.media.data
  
  // Filter by tab (picture/video)
  let filtered = mediaData.filter(item => {
    if (activeTab.value === 'picture') {
      return item.type === 'image'
    } else if (activeTab.value === 'video') {
      return item.type === 'video'
    }
    return true
  })
  
  // Filter by category
  if (activeCategory.value !== null) {
    filtered = filtered.filter(item => 
      item.category && item.category.id === activeCategory.value
    )
  }
  
  return filtered
})

// Methods
const setActiveTab = (tab) => {
  activeTab.value = tab
}

const setActiveCategory = (categoryId) => {
  activeCategory.value = categoryId
}

const openLightbox = (media) => {
  if (media.type !== 'image') return
  
  currentMedia.value = media
  currentMediaIndex.value = filteredMedia.value.findIndex(item => item.id === media.id)
  showLightbox.value = true
}

const closeLightbox = () => {
  showLightbox.value = false
  currentMedia.value = {}
  currentMediaIndex.value = 0
}

const nextImage = () => {
  if (currentMediaIndex.value < filteredMedia.value.length - 1) {
    currentMediaIndex.value++
    currentMedia.value = filteredMedia.value[currentMediaIndex.value]
  }
}

const prevImage = () => {
  if (currentMediaIndex.value > 0) {
    currentMediaIndex.value--
    currentMedia.value = filteredMedia.value[currentMediaIndex.value]
  }
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const handleImageError = (event) => {
  // Set fallback image
  event.target.src = '/storage/images/placeholder.jpg'
}

// Keyboard events for lightbox
const handleKeydown = (event) => {
  if (!showLightbox.value) return
  
  switch(event.key) {
    case 'Escape':
      closeLightbox()
      break
    case 'ArrowRight':
      nextImage()
      break
    case 'ArrowLeft':
      prevImage()
      break
  }
}

// Lifecycle hooks
onMounted(() => {
  window.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown)
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.transform {
  transition: transform 0.3s ease;
}

/* Lightbox animation */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Image hover effects */
img {
  transition: transform 0.3s ease;
}

.bg-gradient-to-t {
  background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
}
</style>