<template>
  <AppLayout title="Jagoroni Foundation">
    <div>
      <!-- Hero Section -->
      <section class="py-16 sm:py-24 bg-cover bg-center relative -mt-5" 
               style="background-image: url('storage/images/headerbackground.jpeg');">
        <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-6 text-center">
            Notices
          </h1>
          <div class="w-24 h-1 bg-green-400 mx-auto rounded-full mb-12"></div>
        </div>
      </section>

      <!-- Notices List -->
      <div class="max-w-4xl mx-auto p-4 md:p-8">
        <h3 class="text-xl text-gray-700 font-normal mb-6 pb-2 border-b border-gray-200">
          {{ currentMonthYear }}
        </h3>
        
        <!-- No Notices State -->
        <div v-if="notices.length === 0" class="text-center py-12">
          <div class="bg-white p-8 rounded-lg shadow-lg">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Notices Available</h3>
            <p class="text-gray-600">There are no notices to display at the moment.</p>
          </div>
        </div>

        <!-- Notices List -->
        <div v-else class="space-y-6">
          <div v-for="notice in notices" :key="notice.id" 
               class="bg-white p-6 md:p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 cursor-pointer"
               @click="viewNotice(notice.slug)">
            <div class="flex space-x-6">
              <div class="flex flex-col items-center text-center">
                <span class="text-sm font-semibold uppercase text-green-700">{{ getDayOfWeek(notice.created_at) }}</span>
                <span class="text-4xl font-bold text-gray-800 leading-none mt-1">{{ getDay(notice.created_at) }}</span>
                <span class="text-sm text-gray-500 mt-1">{{ getMonth(notice.created_at) }}</span>
              </div>
              
              <div class="flex-grow">
                <div class="flex justify-between items-start mb-2">
                  <p class="text-base text-gray-600 font-medium">{{ getFullDate(notice.created_at) }}</p>
                  <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                    {{ notice.category?.name || 'Uncategorized' }}
                  </span>
                </div>
                
                <h4 class="text-2xl font-bold text-green-700 mb-3 leading-tight">
                  {{ notice.title }}
                </h4>
                
                <!-- Truncated description preview -->
                <p v-if="!isHTML(notice.description)" class="text-base text-gray-600 leading-relaxed line-clamp-3">
                  {{ truncateText(notice.description, 200) }}
                </p>
                
                <!-- For HTML content preview -->
                <div v-else class="text-base text-gray-600 leading-relaxed line-clamp-3">
                  {{ stripHtml(notice.description) }}
                </div>

                <div class="mt-4 flex justify-between items-center">
                  <span class="text-sm text-gray-500">
                    {{ formatTime(notice.created_at) }}
                  </span>
                  <span class="text-green-600 font-medium text-sm hover:text-green-700 transition duration-200">
                    Read More →
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Load More Button (if paginated) -->
        <div v-if="notices.length > 0" class="mt-8 text-center">
          <button class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200 font-medium">
            Load More Notices
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { usePage, router } from '@inertiajs/vue3';

// Get notices data from Inertia props (now it's an array)
const { props } = usePage()
const notices = ref(props.notice || []) // Notice the prop name is 'notice' (singular) but it contains an array

// Get current month and year for header
const currentMonthYear = computed(() => {
  return new Date().toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long' 
  })
})

// Date formatting functions
const getDayOfWeek = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { weekday: 'long' })
}

const getDay = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.getDate()
}

const getMonth = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { month: 'short' })
}

const getFullDate = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
}

const formatTime = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleTimeString('en-US', { 
    hour: '2-digit', 
    minute: '2-digit' 
  })
}

// Text utility functions
const isHTML = (content) => {
  if (!content) return false
  return /<[a-z][\s\S]*>/i.test(content)
}

const stripHtml = (html) => {
  if (!html) return ''
  const tmp = document.createElement('DIV')
  tmp.innerHTML = html
  return tmp.textContent || tmp.innerText || ''
}

const truncateText = (text, length) => {
  if (!text) return ''
  if (text.length <= length) return text
  return text.substring(0, length) + '...'
}

// Navigation function
const viewNotice = (slug) => {
  router.visit(route('notices.show', slug))
}

// Lifecycle hooks
onMounted(() => {
  console.log('Notices component mounted')
  console.log('Notices data:', notices.value)
})
</script>

<style scoped>
/* Font and custom colors */
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;700;900&display=swap');

/* Custom brand colors */
.text-green-brand { color: #10B981; } 
.bg-green-brand { background-color: #10B981; }
.hover\:bg-green-brand-dark:hover { background-color: #059669; }
.border-green-brand { border-color: #10B981; }

/* Line clamp utility */
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Custom styles for the notice section */
.bg-pattern {
  background-image: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('placeholder-background.jpg'); 
  background-color: #dab15a; 
  background-blend-mode: multiply;
}

/* Smooth scrolling */
html {
  scroll-behavior: smooth;
}

/* Hover effects */
.cursor-pointer:hover {
  transform: translateY(-2px);
}
</style>