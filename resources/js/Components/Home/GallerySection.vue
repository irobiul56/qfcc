<template>
  <section id="photos" class="p-4 md:p-8 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Photo Gallery</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Capturing moments from our various activities and community events
        </p>
      </div>

      <!-- Gallery Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Gallery Item -->
        <div 
          v-for="(image, index) in media.data" 
          :key="image.id"
          class="w-full group cursor-pointer"
          @click="openLightbox(index)"
        >
          <div class="relative overflow-hidden aspect-video rounded-xl shadow-lg group-hover:shadow-2xl transition-all duration-500">
            <img
              :src="image.url"
              :alt="image.caption || 'Gallery image'"
              class="w-full h-full object-cover transition duration-500 ease-in-out group-hover:scale-110"
              loading="lazy"
              @error="handleImageError"
            />
            
            <!-- Overlay on Hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end justify-center pb-4">
              <div class="transform translate-y-8 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100">
                <div class="text-center text-white">
                  <i class="fas fa-expand-alt text-2xl mb-2"></i>
                  <p class="text-sm font-medium">{{ image.caption || 'View Image' }}</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Image Caption -->
          <div v-if="image.caption" class="mt-4">
            <p class="text-sm text-gray-700 font-semibold">{{ image.caption }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ formatDate(image.created_at) }}</p>
          </div>
        </div>

      </div>

      <!-- View All Gallery Button -->
      <div class="mt-12 flex justify-center">
        <Link
          :href="route('gallery')"
          class="group inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-2xl shadow-lg text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl"
        >
          View Full Gallery
          <i class="ml-3 fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
        </Link>
      </div>

      <!-- Enhanced Lightbox Modal -->
<div 
  v-if="lightboxOpen"
  class="fixed inset-0 z-[100] flex items-center justify-center p-0 sm:p-4"
  @click="closeLightbox"
>
  <!-- Animated Backdrop -->
  <div 
    class="absolute inset-0 bg-gradient-to-br from-gray-900/95 via-purple-900/30 to-gray-900/95 backdrop-blur-xl"
    :class="lightboxOpen ? 'animate-fade-in' : ''"
  ></div>

  <!-- Floating Particles Effect -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div 
      v-for="i in 15" 
      :key="i"
      class="absolute rounded-full bg-white/5 animate-float"
      :style="{
        width: `${Math.random() * 20 + 5}px`,
        height: `${Math.random() * 20 + 5}px`,
        left: `${Math.random() * 100}%`,
        top: `${Math.random() * 100}%`,
        animationDelay: `${Math.random() * 5}s`,
        animationDuration: `${Math.random() * 10 + 10}s`
      }"
    ></div>
  </div>

  <!-- Main Modal Container - REMOVED max-height constraint -->
  <div 
    class="relative w-full h-full max-w-none lg:max-w-[95vw] xl:max-w-[90vw] bg-transparent"
    :class="lightboxOpen ? 'animate-modal-in' : ''"
    @click.stop
    @touchstart="handleTouchStart"
    @touchend="handleTouchEnd"
  >
    
    <!-- Header Bar - Positioned absolutely -->
    <div class="absolute top-0 left-0 right-0 z-30 flex items-center justify-between p-4 lg:p-6 bg-gradient-to-b from-black/90 via-black/70 to-transparent">
      <!-- Image Counter & Info -->
      <div class="flex items-center space-x-4 text-white">
        <div class="flex items-center px-4 py-2 bg-white/15 rounded-2xl backdrop-blur-lg border border-white/20">
          <i class="fas fa-camera text-sm text-yellow-400 mr-3"></i>
          <span class="text-sm font-bold">{{ currentImageIndex + 1 }} / {{ media.data.length }}</span>
        </div>
        <div v-if="currentImage.category" class="hidden sm:flex items-center px-3 py-1 bg-white/10 rounded-full">
          <i class="fas fa-tag text-xs text-white/60 mr-2"></i>
          <span class="text-xs font-medium">{{ currentImage.category.name }}</span>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex items-center space-x-3">
        <!-- Download Button -->
        <button
          @click="downloadImage"
          class="group p-3 hover:bg-white/20 rounded-2xl transition-all duration-300 transform hover:scale-110"
          title="Download Image"
        >
          <i class="fas fa-download text-white text-lg group-hover:text-green-400 transition-colors"></i>
        </button>
        
        <!-- Close Button -->
        <button
          @click="closeLightbox"
          class="group p-3 hover:bg-red-500/30 rounded-2xl transition-all duration-300 transform hover:scale-110"
          title="Close"
        >
          <i class="fas fa-times text-white text-xl group-hover:text-red-400 transition-colors"></i>
        </button>
      </div>
    </div>

    <!-- Main Image Container - FILLS THE SCREEN -->
    <div class="w-full h-full flex items-center justify-center p-4 lg:p-8 xl:p-12">
      <div class="relative w-full h-full flex items-center justify-center">
        <!-- Loading Spinner -->
        <div v-if="imageLoading" class="absolute inset-0 flex items-center justify-center z-10">
          <div class="flex flex-col items-center space-y-4">
            <div class="animate-spin rounded-full h-16 w-16 border-4 border-white/30 border-t-yellow-400"></div>
            <p class="text-white/70 text-sm font-medium">Loading image...</p>
          </div>
        </div>

        <!-- Main Image - FILLS AVAILABLE SPACE -->
        <img
          :src="currentImage.url"
          :alt="currentImage.caption || 'Gallery image'"
          class="max-w-full max-h-full object-contain rounded-lg lg:rounded-xl shadow-3xl transition-all duration-500"
          :class="{'opacity-0 scale-95': imageLoading, 'opacity-100 scale-100': !imageLoading}"
          @load="handleImageLoad"
          @error="handleModalImageError"
        />

        <!-- Navigation Arrows - Desktop -->
        <button
          v-if="currentImageIndex > 0"
          @click.stop="prevImage"
          class="hidden lg:flex absolute left-4 xl:left-8 top-1/2 transform -translate-y-1/2 items-center justify-center w-14 h-14 bg-black/60 hover:bg-black/80 backdrop-blur-xl rounded-2xl border border-white/30 text-white hover:text-yellow-400 transition-all duration-300 transform hover:scale-110 hover:-translate-x-1 group shadow-2xl"
          title="Previous image"
        >
          <i class="fas fa-chevron-left text-xl group-hover:animate-bounce-x"></i>
        </button>

        <button
          v-if="currentImageIndex < media.data.length - 1"
          @click.stop="nextImage"
          class="hidden lg:flex absolute right-4 xl:right-8 top-1/2 transform -translate-y-1/2 items-center justify-center w-14 h-14 bg-black/60 hover:bg-black/80 backdrop-blur-xl rounded-2xl border border-white/30 text-white hover:text-yellow-400 transition-all duration-300 transform hover:scale-110 hover:translate-x-1 group shadow-2xl"
          title="Next image"
        >
          <i class="fas fa-chevron-right text-xl group-hover:animate-bounce-x"></i>
        </button>
      </div>
    </div>

    <!-- Footer Info Section -->
    <div 
      v-if="currentImage.caption"
      class="absolute bottom-10 left-0 right-0 bg-gradient-to-t from-black/95 via-black/80 to-transparent p-6 pt-16 lg:pt-20"
    >
      <div class="text-center max-w-4xl mx-auto">
        <p class="text-white text-lg sm:text-xl lg:text-2xl font-bold mb-3 drop-shadow-2xl leading-relaxed">
          {{ currentImage.caption }}
        </p>
        <div class="flex items-center justify-center space-x-4 lg:space-x-6 text-white/80 text-sm lg:text-base">
          <div class="flex items-center space-x-2 bg-white/10 px-3 py-2 rounded-full">
            <i class="far fa-calendar text-yellow-400"></i>
            <span class="font-medium">{{ formatDate(currentImage.created_at) }}</span>
          </div>
          <div v-if="currentImage.original_name" class="flex items-center space-x-2 bg-white/10 px-3 py-2 rounded-full">
            <i class="far fa-image text-green-400"></i>
            <span class="font-medium">{{ getFileInfo(currentImage.original_name) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation - Bottom -->
    <div class="lg:hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 flex items-center space-x-4">
      <button
        v-if="currentImageIndex > 0"
        @click.stop="prevImage"
        class="flex items-center justify-center w-12 h-12 bg-white/25 hover:bg-white/35 backdrop-blur-xl rounded-xl border border-white/40 text-white transition-all duration-300 transform hover:scale-110 active:scale-95 shadow-2xl"
        title="Previous"
      >
        <i class="fas fa-chevron-left"></i>
      </button>

      <button
        @click.stop="closeLightbox"
        class="flex items-center justify-center w-12 h-12 bg-red-500/80 hover:bg-red-600 backdrop-blur-xl rounded-xl border border-white/40 text-white transition-all duration-300 transform hover:scale-110 active:scale-95 shadow-2xl"
        title="Close"
      >
        <i class="fas fa-times"></i>
      </button>

      <button
        v-if="currentImageIndex < media.data.length - 1"
        @click.stop="nextImage"
        class="flex items-center justify-center w-12 h-12 bg-white/25 hover:bg-white/35 backdrop-blur-xl rounded-xl border border-white/40 text-white transition-all duration-300 transform hover:scale-110 active:scale-95 shadow-2xl"
        title="Next"
      >
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>

    <!-- Progress Indicators -->
    <div class="absolute bottom-20 lg:bottom-6 left-1/2 transform -translate-x-1/2">
      <div class="flex space-x-2">
        <div 
          v-for="n in Math.min(7, media.data.length)" 
          :key="n"
          class="w-2 h-2 lg:w-3 lg:h-3 rounded-full transition-all duration-500 border border-white/30"
          :class="getIndicatorClass(n)"
        ></div>
      </div>
    </div>
  </div>

</div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, computed, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  media: {
    type: Object,
    default: () => ({ data: [] })
  }
})

// Reactive state
const lightboxOpen = ref(false)
const currentImageIndex = ref(0)
const imageLoading = ref(true)
const touchStartX = ref(0)
const touchStartY = ref(0)

// Computed properties
const currentImage = computed(() => {
  return props.media.data[currentImageIndex.value] || {}
})

// Methods
const openLightbox = (index) => {
  currentImageIndex.value = index
  lightboxOpen.value = true
  imageLoading.value = true
  document.body.style.overflow = 'hidden'
  document.documentElement.style.overflow = 'hidden'
}

const closeLightbox = () => {
  lightboxOpen.value = false
  document.body.style.overflow = 'auto'
  document.documentElement.style.overflow = 'auto'
}

const nextImage = () => {
  if (currentImageIndex.value < props.media.data.length - 1) {
    currentImageIndex.value++
    imageLoading.value = true
  }
}

const prevImage = () => {
  if (currentImageIndex.value > 0) {
    currentImageIndex.value--
    imageLoading.value = true
  }
}

const handleImageLoad = () => {
  imageLoading.value = false
}

const handleImageError = (event) => {
  const fallbackImage = 'https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80'
  event.target.src = fallbackImage
}

const handleModalImageError = (event) => {
  console.error('Failed to load modal image:', currentImage.value.url)
  event.target.src = 'https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1000&q=80'
  imageLoading.value = false
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

const getFileInfo = (filename) => {
  if (!filename) return ''
  return filename.length > 20 ? filename.substring(0, 20) + '...' : filename
}

const getIndicatorClass = (n) => {
  const current = currentImageIndex.value % props.media.data.length
  const indicatorIndex = Math.floor((n - 1) * props.media.data.length / 7)
  return current === indicatorIndex 
    ? 'bg-yellow-400 border-yellow-400 scale-125' 
    : 'bg-transparent'
}

// Touch handling for mobile swipe
const handleTouchStart = (event) => {
  touchStartX.value = event.touches[0].clientX
  touchStartY.value = event.touches[0].clientY
}

const handleTouchEnd = (event) => {
  const touchEndX = event.changedTouches[0].clientX
  const touchEndY = event.changedTouches[0].clientY
  const diffX = touchStartX.value - touchEndX
  const diffY = touchStartY.value - touchEndY

  // Only handle horizontal swipes with minimal vertical movement
  if (Math.abs(diffX) > 50 && Math.abs(diffY) < 100) {
    if (diffX > 0 && currentImageIndex.value < props.media.data.length - 1) {
      nextImage()
    } else if (diffX < 0 && currentImageIndex.value > 0) {
      prevImage()
    }
  }
}

// Download functionality
const downloadImage = async () => {
  try {
    const response = await fetch(currentImage.value.url)
    const blob = await response.blob()
    const url = window.URL.createObjectURL(blob)
    const link = document.createElement('a')
    link.href = url
    link.download = currentImage.value.original_name || `image-${currentImageIndex.value + 1}.jpg`
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    window.URL.revokeObjectURL(url)
  } catch (error) {
    console.error('Download failed:', error)
  }
}

// Keyboard navigation for lightbox
const handleKeydown = (event) => {
  if (!lightboxOpen.value) return

  switch (event.key) {
    case 'Escape':
      closeLightbox()
      break
    case 'ArrowLeft':
      prevImage()
      break
    case 'ArrowRight':
      nextImage()
      break
    case 'd':
    case 'D':
      downloadImage()
      break
  }
}

// Event listeners
onMounted(() => {
  document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
})
</script>

<style scoped>
/* Animations */
@keyframes fade-in {
  from { 
    opacity: 0; 
  }
  to { 
    opacity: 1; 
  }
}

@keyframes modal-in {
  from { 
    opacity: 0;
    transform: scale(0.8) translateY(30px) rotateX(10deg);
  }
  to { 
    opacity: 1;
    transform: scale(1) translateY(0) rotateX(0);
  }
}

@keyframes float {
  0%, 100% { 
    transform: translateY(0px) rotate(0deg);
  }
  50% { 
    transform: translateY(-20px) rotate(180deg);
  }
}

@keyframes bounce-x {
  0%, 100% { 
    transform: translateX(0);
  }
  50% { 
    transform: translateX(-3px);
  }
}

.animate-fade-in {
  animation: fade-in 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.animate-modal-in {
  animation: modal-in 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.animate-float {
  animation: float linear infinite;
}

.animate-bounce-x {
  animation: bounce-x 0.6s ease-in-out infinite;
}

/* Smooth transitions */
.modal-enter-active {
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 1, 1);
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(1.05);
}

/* Custom scrollbar for webkit */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}

/* Mobile optimizations */
@media (max-width: 640px) {
  .mobile-touch-area {
    min-height: 44px;
    min-width: 44px;
  }
}

/* Backdrop blur support fallback */
@supports not (backdrop-filter: blur(12px)) {
  .backdrop-blur-xl {
    background: rgba(0, 0, 0, 0.95);
  }
}

/* Prevent blue highlight on mobile */
button, .cursor-pointer {
  -webkit-tap-highlight-color: transparent;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  user-select: none;
}

/* Improved focus styles for accessibility */
button:focus-visible {
  outline: 2px solid #fbbf24;
  outline-offset: 2px;
}
</style>