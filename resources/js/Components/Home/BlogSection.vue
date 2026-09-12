<template>
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Latest Updates & Blogs</h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          Stay informed with our latest activities, news, and insights from the field
        </p>
      </div>

      <!-- Blog blogs Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- Blog blog Card -->
        <article 
          v-for="blog in displayedblogs" 
          :key="blog.id"
          class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group cursor-pointer"
          @click="viewblog(blog)"
        >
          <!-- Featured Image -->
          <div class="relative overflow-hidden h-48">
            <img
              :src="`/storage/${blog.image}`"
              :alt="blog.title"
              class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
              @error="handleImageError"
            />
            <!-- Category Badge -->
            <div class="absolute top-4 left-4">
              <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full" 
                    :class="getCategoryClass(blog.category)">
                <!-- {{ blog.category.name }} -->
              </span>
            </div>
            <!-- Read Time -->
            <div class="absolute top-4 right-4 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
              {{ blog.category.name }}
            </div>
          </div>

          <!-- Content -->
          <div class="p-6">
            <!-- Date -->
            

            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors duration-200">
              {{ blog.title }}
            </h3>

            <div 
              class="text-gray-600 text-sm mb-4 line-clamp-3 quill-content"
              v-html="getExcerpt(blog.description)"
            ></div>

            <div class="flex items-center text-sm text-gray-500 mb-2">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              {{ formatDate(blog.created_at) }}
            </div>
          </div>
        </article>

      </div>

      <!-- View All Blog blogs Button -->
      <div class="mt-8 text-center">
        <Link
          :href="route('blog')"
          class="inline-flex items-center justify-center px-6 py-3 border-2 border-green-600 text-base font-medium rounded-md text-green-600 hover:bg-green-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
        >
          View All Blog blogs
          <svg class="ml-2 -mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

const props = defineProps({
  blog: {
    type: Array,
    default: () => []
  }
})

// Reactive state
const blogsPerLoad = ref(3)
const loadedCount = ref(3)
const loadingMore = ref(false)
const newsletterEmail = ref('')

// Computed properties
const displayedblogs = computed(() => {
  return props.blog.slice(0, loadedCount.value)
})

const hasMoreblogs = computed(() => {
  return loadedCount.value < props.blog.length
})

// Methods
const viewblog = (blog) => {
  // Navigate to blog blog detail page
  window.location.href = `/blog/${blog.slug}`
}

const loadMoreblog = async () => {
  loadingMore.value = true
  
  // Simulate loading delay
  await new Promise(resolve => setTimeout(resolve, 800))
  
  loadedCount.value += blogsPerLoad.value
  loadingMore.value = false
}

const handleImageError = (event) => {
  const fallbackImage = 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
  event.target.src = fallbackImage
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const getCategoryClass = (category) => {
  const categoryClasses = {
    'Activities': 'bg-blue-100 text-blue-800',
    'News': 'bg-green-100 text-green-800',
    'Events': 'bg-purple-100 text-purple-800',
    'Stories': 'bg-orange-100 text-orange-800',
    'Updates': 'bg-red-100 text-red-800'
  }
  return categoryClasses[category] || 'bg-gray-100 text-gray-800'
}

const getInitials = (name) => {
  return name.split(' ').map(word => word[0]).join('').toUpperCase()
}

const subscribeNewsletter = () => {
  if (!newsletterEmail.value) return
  
  // Simulate newsletter subscription
  alert(`Thank you for subscribing with: ${newsletterEmail.value}`)
  newsletterEmail.value = ''
}

const getExcerpt = (htmlContent, maxLength = 120) => {
  if (!htmlContent) return 'No content available'
  
  // Remove HTML tags and get plain text
  const tempDiv = document.createElement('div')
  tempDiv.innerHTML = htmlContent
  const plainText = tempDiv.textContent || tempDiv.innerText || ''
  
  // Truncate to max length
  if (plainText.length <= maxLength) return plainText
  
  return plainText.substring(0, maxLength) + '...'
}

// For full content display (if you need it elsewhere)
const renderFullContent = (htmlContent) => {
  return htmlContent || '<p>No content available</p>'
}
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

/* Smooth transitions */
.group:hover .group-hover\:scale-105 {
  transform: scale(1.05);
}
</style>