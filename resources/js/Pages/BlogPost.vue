<template>
    <AppLayout title="Jagoroni Foundation">
  <div>
    <!-- Hero Section -->
    <section class="py-16 sm:py-24 bg-cover bg-center relative" 
             style="background-image: url('storage/images/headerbackground.jpeg');">
      <div class="absolute inset-0 bg-gray-900 opacity-70"></div>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-6 text-center">
          Blog
        </h1>
        <div class="w-24 h-1 bg-green-400 mx-auto rounded-full mb-12"></div>
      </div>
    </section>

    <!-- Blog Content Section -->
    <section class="py-16 sm:py-24 bg-gray-50">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Search and Language Toggle -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-10 space-y-4 sm:space-y-0">
          <div class="w-full sm:w-auto relative">
            <input 
              type="text" 
              placeholder="Search Blogs"
              v-model="searchQuery"
              class="w-full sm:w-80 px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150 shadow-sm"
            >
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>
          
          <button 
            @click="toggleLanguage"
            class="px-4 py-2 text-sm font-semibold text-white bg-green-brand rounded-lg hover:bg-green-700 transition duration-300 shadow-md flex-shrink-0"
          >
            {{ language === 'en' ? 'বাংলা' : 'English' }}
          </button>
        </div>

        <!-- Blog Posts -->
        <div class="space-y-10" v-if="blog.data && blog.data.length > 0">

          <!-- Featured Post (First blog post as featured) -->
          <Link :href="`/blog/${featuredPost.slug}`" 
             class="block bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden group border border-gray-100"
             v-if="featuredPost">
            <div class="grid grid-cols-1 lg:grid-cols-3">
              <div class="lg:col-span-2">
                <img 
                  :src="getImageUrl(featuredPost.image)" 
                  :alt="featuredPost.title"
                  class="w-full h-72 object-cover transition duration-500 group-hover:scale-[1.03]"
                  @error="handleImageError"
                >
              </div>
              <div class="lg:col-span-1 p-6 flex flex-col justify-between">
                <div>
                  <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-green-brand transition duration-150">
                    {{ featuredPost.title }}
                  </h3>
                  <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                    {{ getExcerpt(featuredPost.description, 150) }}
                  </p>
                </div>
                <div class="flex items-center justify-between">
                  <p class="text-xs text-gray-400 font-medium">
                    {{ formatDate(featuredPost.created_at) }}
                  </p>
                  <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                    {{ featuredPost.category?.name || 'Uncategorized' }}
                  </span>
                </div>
              </div>
            </div>
          </Link>
          
          <hr class="border-gray-200" v-if="featuredPost">

          <!-- Blog Posts Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- Blog Post Items -->
            <Link 
              :href="`/blog/${post.slug}`" 
              class="block bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden group border border-gray-100"
              v-for="post in filteredBlogPosts"
              :key="post.id"
            >
              <div class="h-48">
                <img 
                  :src="getImageUrl(post.image)" 
                  :alt="post.title"
                  class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                  @error="handleImageError"
                >
              </div>
              <div class="p-4 flex flex-col justify-between h-auto">
                <h4 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-brand transition duration-150 line-clamp-2">
                  {{ post.title }}
                </h4>
                <p class="text-gray-600 text-sm mb-3 line-clamp-3">
                  {{ getExcerpt(post.description, 100) }}
                </p>
                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                  <p class="text-xs text-gray-400 font-medium">
                    {{ formatDate(post.created_at) }}
                  </p>
                  <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">
                    {{ post.category?.name || 'Uncategorized' }}
                  </span>
                </div>
              </div>
            </Link>
            
          </div>
        </div>

        <!-- No posts message -->
        <div v-else class="text-center py-12">
          <p class="text-gray-500 text-lg">No blog posts available.</p>
        </div>
        
        <!-- Load More Button -->
        <div class="mt-12 text-center" v-if="blog.data && blog.data.length > 0 && blog.links?.next">
          <button 
            @click="loadMorePosts"
            :disabled="loading"
            class="px-6 py-3 border border-green-brand text-sm font-semibold rounded-lg text-green-brand hover:bg-green-brand hover:text-black transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="loading">Loading...</span>
            <span v-else>Load More Posts</span>
          </button>
        </div>

      </div>
    </section>
  </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Define props from Inertia
const props = defineProps({
  blog: {
    type: Object,
    default: () => ({ data: [] })
  }
})

// Reactive data
const searchQuery = ref('')
const language = ref('en')
const loading = ref(false)

// Computed properties
const featuredPost = computed(() => {
  return props.blog.data.length > 0 ? props.blog.data[0] : null
})

const filteredBlogPosts = computed(() => {
  let posts = props.blog.data
  
  // Skip the first post (featured) from grid if it exists
  if (featuredPost.value) {
    posts = posts.slice(1)
  }
  
  if (!searchQuery.value) return posts
  
  const query = searchQuery.value.toLowerCase()
  return posts.filter(post => 
    post.title?.toLowerCase().includes(query) || 
    post.description?.toLowerCase().includes(query)
  )
})

// Methods
const toggleLanguage = () => {
  language.value = language.value === 'en' ? 'bn' : 'en'
}

const handleImageError = (event) => {
  console.error('Image failed to load:', event.target.src)
  event.target.src = 'https://placehold.co/400x200/96d482/ffffff?text=Blog+Image'
}

const loadMorePosts = async () => {
  if (props.blog.links?.next && !loading.value) {
    loading.value = true
    try {
      await router.get(props.blog.links.next, {}, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          loading.value = false
        },
        onError: () => {
          loading.value = false
        }
      })
    } catch (error) {
      loading.value = false
      console.error('Error loading more posts:', error)
    }
  }
}

const getImageUrl = (imagePath) => {
  if (!imagePath) return 'https://placehold.co/400x200/96d482/ffffff?text=Blog+Image'
  
  // Check if it's already a full URL
  if (imagePath.startsWith('http')) {
    return imagePath
  }
  
  // Debug: Log the image path
  console.log('Image path:', imagePath)
  
  // For Laravel storage paths
  // If image is stored in storage/app/public
  // Remove 'public/' if it exists
  let cleanPath = imagePath.replace('public/', '')
  
  // If it starts with 'storage/', remove it (we'll add it back correctly)
  cleanPath = cleanPath.replace(/^storage\//, '')
  
  // Return the correct URL for storage
  return `/storage/${cleanPath}`
}

const getExcerpt = (description, length) => {
  if (!description) return ''
  
  // Strip HTML tags if any
  const plainText = description.replace(/<[^>]*>/g, '')
  
  if (plainText.length <= length) return plainText
  
  return plainText.substring(0, length) + '...'
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  
  try {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })
  } catch (error) {
    console.error('Error formatting date:', error)
    return dateString
  }
}

// Lifecycle hooks
onMounted(() => {
  console.log('Blog page component mounted')
  console.log('Blog data:', props.blog)
  
  // Check if images are loading
  if (props.blog.data && props.blog.data.length > 0) {
    props.blog.data.forEach((post, index) => {
      console.log(`Post ${index} image path:`, post.image)
      console.log(`Post ${index} image URL:`, getImageUrl(post.image))
    })
  }
})
</script>

<style scoped>
/* Custom brand colors */
.text-green-brand { color: #10B981; } 
.bg-green-brand { background-color: #10B481; }
.hover\:bg-green-brand:hover { background-color: #059669; }
.border-green-brand { border-color: #10B481; }

/* Line clamp utility */
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
</style>