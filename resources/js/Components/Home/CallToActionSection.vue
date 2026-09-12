<template>
  <section class="bg-gradient-to-br from-green-50 to-blue-50 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      
      <!-- Main CTA Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

        <!-- Donate Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-green-200 p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
          <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6 border-4 border-green-200">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'SolaimanLipi', sans-serif;">Donate</h3>
          <p class="text-gray-600 leading-relaxed mb-6" style="font-family: 'SolaimanLipi', sans-serif;">
            All activities of the foundation will be carried out based on donations. 
            Your generous contribution helps us continue our mission of serving humanity 
            and building a better society for all.
          </p>
          <Link 
            :href="route('home') + '#donate'" 
            class="w-full bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300 transform hover:scale-105 flex items-center justify-center"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Donate Now
          </Link>
        </div>

        <!-- Dua Card -->
        <div class="bg-green-600 text-white rounded-2xl shadow-xl p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 relative overflow-hidden">
          <!-- Background Pattern -->
          <div class="absolute inset-0 opacity-40">
            <div class="absolute top-4 right-4 text-6xl">🤲</div>
         
          </div>
          <div class="relative z-10 ">
            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mb-6 border-4 border-green-400">
              <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold mb-4" style="font-family: 'SolaimanLipi', sans-serif;">Dua</h3>
            <p class="leading-relaxed mb-6 text-green-100" style="font-family: 'SolaimanLipi', sans-serif;">
              We sincerely desire your sincere prayers, along with your overall support and inspiration 
              as we move forward. This can be one of the driving forces to complete all our activities 
              smoothly and beautifully. Your prayers are our greatest strength.
            </p>
            <button 
              @click="openDuaModal"
              class="w-full bg-white text-green-600 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105 flex items-center justify-center"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
              Make Dua
            </button>
          </div>
        </div>

        <!-- Share Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-blue-200 p-8 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
          <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-6 border-4 border-blue-200">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'SolaimanLipi', sans-serif;">Share</h3>
          <p class="text-gray-600 leading-relaxed mb-6" style="font-family: 'SolaimanLipi', sans-serif;">
            Please inform your friends and family about our foundation. Let's join together 
            in the mission of gaining happiness in this life and the hereafter. Spread the 
            word and help us reach more people in need.
          </p>
          <div class="flex space-x-3 w-full">
            <button 
              v-for="platform in socialPlatforms" 
              :key="platform.name"
              @click="shareOnPlatform(platform)"
              class="flex-1 py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 flex items-center justify-center"
              :class="platform.class"
            >
              <i :class="platform.icon" class="text-lg"></i>
            </button>
          </div>
        </div>

      </div>

     

      <!-- Dua Modal -->
      <div v-if="showDuaModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-auto">
          <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
              </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'SolaimanLipi', sans-serif;">Thank You for Your Dua</h3>
            <p class="text-gray-600 mb-6" style="font-family: 'SolaimanLipi', sans-serif;">
              Your prayers mean the world to us. May Allah accept your sincere duas and reward you abundantly 
              for remembering us in your prayers.
            </p>
            <div class="bg-green-50 rounded-lg p-4 mb-6">
              <p class="text-green-800 text-sm" style="font-family: 'SolaimanLipi', sans-serif;">
                "رَبَّنَا تَقَبَّلْ مِنَّا إِنَّكَ أَنْتَ السَّمِيعُ الْعَلِيمُ"
              </p>
              <p class="text-green-600 text-xs mt-2">
                "Our Lord, accept [this] from us. Indeed You are the Hearing, the Knowing." (Quran 2:127)
              </p>
            </div>
            <button 
              @click="closeDuaModal"
              class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-300"
            >
              Ameen
            </button>
          </div>
        </div>
      </div>

      <!-- Toast Notification -->
      <div v-if="showToast" class="fixed bottom-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg z-50 transition-all duration-300">
        <div class="flex items-center">
          <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
          </svg>
          <span>{{ toastMessage }}</span>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'

// Reactive state
const showDuaModal = ref(false)
const showToast = ref(false)
const toastMessage = ref('')

// Social media platforms
const socialPlatforms = ref([
  {
    name: 'Facebook',
    icon: 'fab fa-facebook-f',
    class: 'bg-blue-600 hover:bg-blue-700 text-white',
    url: 'https://facebook.com/sharer/sharer.php?u='
  },
  {
    name: 'Twitter',
    icon: 'fab fa-twitter',
    class: 'bg-blue-400 hover:bg-blue-500 text-white',
    url: 'https://twitter.com/intent/tweet?url='
  },
  {
    name: 'WhatsApp',
    icon: 'fab fa-whatsapp',
    class: 'bg-green-500 hover:bg-green-600 text-white',
    url: 'https://api.whatsapp.com/send?text='
  }
])

// Methods
const openDuaModal = () => {
  showDuaModal.value = true
}

const closeDuaModal = () => {
  showDuaModal.value = false
  showToastMessage('May Allah accept your dua! 🤲')
}

const shareOnPlatform = (platform) => {
  const currentUrl = encodeURIComponent(window.location.href)
  const text = encodeURIComponent('Join Jagoroni Mohila Foundation in their mission to serve humanity and build a better society. Your support can make a difference!')
  
  let shareUrl = ''
  
  switch (platform.name) {
    case 'Facebook':
      shareUrl = `${platform.url}${currentUrl}`
      break
    case 'Twitter':
      shareUrl = `${platform.url}${currentUrl}&text=${text}`
      break
    case 'WhatsApp':
      shareUrl = `${platform.url}${text} ${currentUrl}`
      break
  }
  
  window.open(shareUrl, '_blank', 'width=600,height=400')
  showToastMessage(`Sharing on ${platform.name}...`)
}

const showToastMessage = (message) => {
  toastMessage.value = message
  showToast.value = true
  setTimeout(() => {
    showToast.value = false
  }, 3000)
}
</script>

<style scoped>
/* Import Bengali font */
@import url('https://fonts.maateen.me/solaiman-lipi/font.css');

/* Smooth transitions */
button, .transform {
  transition: all 0.3s ease;
}

/* Custom hover effects */
.hover\:-translate-y-2:hover {
  transform: translateY(-0.5rem);
}

.hover\:scale-105:hover {
  transform: scale(1.05);
}

/* Ensure proper z-index for modal */
.fixed {
  z-index: 50;
}
</style>