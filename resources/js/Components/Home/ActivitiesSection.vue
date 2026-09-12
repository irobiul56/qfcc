<template>
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 text-center">Ongoing Activities</h2>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <!-- Activity Card -->
        <div 
          v-for="activity in activities" 
          :key="activity.id"
          class="bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden border-t-4 border-green-brand"
        >
          <!-- Featured Image -->
          <img 
            :src="`/storage/${activity.image}`"
            :alt="activity.title" 
            class="w-full h-48 object-cover"
            @error="handleImageError"
          >
          <div class="p-6">
            <!-- Tag -->
            <div class="inline-block px-3 py-1 mb-3 bg-green-100 text-green-700 text-xs font-bold rounded-full tracking-wide">
              {{ activity.category.name }}
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ activity.title }}</h3>
            <p v-html="getExcerpt(activity.description)" class="text-sm text-gray-500 mb-4"></p>
            <Link 
              :href="route('single.activity', activity.slug)" 
              class="text-green-brand font-semibold hover:text-green-brand-dark transition duration-150 inline-flex items-center"
            >
              See Details <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
            </Link>
          </div>
        </div>

      </div>
      
      <!-- View All Activities Button -->
      <div class="mt-12 text-center">
        <Link 
          :href="route('activities')" 
          class="inline-block w-full sm:w-auto text-center font-bold py-3 px-8 rounded-xl shadow-2xl text-lg transition duration-300 transform hover:scale-105 bg-green-600 hover:bg-green-700 text-white"
        >
          All Activities
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  activities: {
    type: Array,
    required: true,
    default: () => []
  }
})

const handleImageError = (event) => {
  const activityTitle = event.target.alt || 'Activity'
  event.target.src = `https://placehold.co/600x300/10B981/FFFFFF?text=${encodeURIComponent(activityTitle)}`
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
</script>

<style scoped>
.text-green-brand { 
  color: #10B981; 
}

.bg-green-brand { 
  background-color: #10B981; 
}

.hover\:text-green-brand-dark:hover { 
  color: #059669; 
}

.border-green-brand { 
  border-color: #10B981; 
}
</style>