<template>
  <section class="py-12 sm:py-20 text-gray-900 bg-gray-200 bg-opacity-95 min-h-screen bg-cover bg-repeat">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header -->
      <div class="text-center mb-10 sm:mb-14">
        <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
          Our <span class="text-blue-600">Core Identity</span>
        </h2>
        <p class="mt-2 text-xl text-gray-600">Background, Vision, and Mission.</p>
      </div>

      <!-- Tab Navigation -->
      <div class="flex justify-center mb-8">
        <div class="inline-flex rounded-xl bg-gray-200 border border-white p-1.5 space-x-1 sm:space-x-2 shadow-inner">
          <button 
            @click="activeTab = 'background'"
            class="tab-btn py-2 px-4 sm:px-6 rounded-lg text-sm sm:text-base transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="activeTab === 'background' ? 'bg-white text-blue-700 shadow-md font-semibold' : 'text-gray-600 hover:text-blue-600'"
          >
            Background
          </button>
          
          <button 
            @click="activeTab = 'vision'"
            class="tab-btn py-2 px-4 sm:px-6 rounded-lg text-sm sm:text-base transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="activeTab === 'vision' ? 'bg-white text-blue-700 shadow-md font-semibold' : 'text-gray-600 hover:text-blue-600'"
          >
            Vision
          </button>
          
          <button 
            @click="activeTab = 'mission'"
            class="tab-btn py-2 px-4 sm:px-6 rounded-lg text-sm sm:text-base transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="activeTab === 'mission' ? 'bg-white text-blue-700 shadow-md font-semibold' : 'text-gray-600 hover:text-blue-600'"
          >
            Mission
          </button>
        </div>
      </div>

      <!-- Tab Content -->
      <div class="rounded-xl p-6 sm:p-10 border border-white">
        
        <!-- Background Content -->
        <div v-show="activeTab === 'background'" class="tab-content-panel space-y-6">
          <div>
            <h3 class="text-3xl font-bold text-blue-600 border-b border-white pb-3 mb-6">
              {{ backgroundIdentity.title }}
            </h3>
            
            <div class="flex flex-col md:flex-row items-stretch">
              <!-- Image -->
              <div class="md:w-1/2 w-full h-64 md:h-auto overflow-hidden">
                <img 
                  class="rounded-xl w-full h-full object-cover" 
                  :src="backgroundIdentity.image ? `/storage/${backgroundIdentity.image}` : '/storage/images/background.jpeg'" 
                  :alt="backgroundIdentity.title"
                >
              </div>
              
              <!-- Text Content -->
              <div class="md:w-1/2 w-full pt-6 md:pt-0 md:pl-10 flex flex-col justify-center">
                <!-- Short Description -->
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                  {{ backgroundIdentity.description }}
                </p>

                <!-- Read More Link -->
                <div class="mt-6">
                  <Link :href="route('about')" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium hover:underline group">
                    <span>Read More </span>
                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Vision Content -->
        <div v-show="activeTab === 'vision'" class="tab-content-panel space-y-6">
          <div>
            <h3 class="text-3xl font-bold text-blue-600 border-b border-white pb-3 mb-6">
              {{ visionIdentity.title }}
            </h3>
            
            <div class="flex flex-col md:flex-row-reverse items-stretch">
              <!-- Image -->
              <div class="md:w-1/2 w-full h-64 md:h-auto overflow-hidden rounded-lg">
                <img 
                  class="rounded-xl w-full h-full object-cover" 
                  :src="visionIdentity.image ? `/storage/${visionIdentity.image}` : '/storage/images/vison.jpeg'" 
                  :alt="visionIdentity.title"
                >
              </div>
              
              <!-- Text Content -->
              <div class="md:w-1/2 w-full pt-6 md:pt-0 md:pr-10 flex flex-col justify-center">
                <!-- Short Description -->
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                  {{ visionIdentity.description }}
                </p>
                

                
                <!-- Read More Link -->
                <div class="mt-6">
                  <Link :href="route('about')" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium hover:underline group">
                    <span>Read More</span>
                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Mission Content -->
        <div v-show="activeTab === 'mission'" class="tab-content-panel space-y-6">
          <div v-if="missionIdentity">
            <h3 class="text-3xl font-bold text-blue-600 border-b border-white pb-3 mb-6">
              {{ missionIdentity.title }}
            </h3>
            
            <div class="flex flex-col md:flex-row items-stretch">
              <!-- Image -->
              <div class="md:w-1/2 w-full h-64 md:h-auto overflow-hidden rounded-lg">
                <img 
                  class="rounded-xl shadow-lg w-full h-full object-cover" 
                  :src="missionIdentity.image ? `/storage/${missionIdentity.image}` : '/storage/images/mission.jpeg'" 
                  :alt="missionIdentity.title"
                >
              </div>
              
              <!-- Text Content -->
              <div class="md:w-1/2 w-full pt-6 md:pt-0 md:pl-10 flex flex-col justify-center">
                <!-- Short Description -->
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                  {{ missionIdentity.description }}
                </p>
                
                <div class="mt-6">
                    <Link :href="route('about')" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium hover:underline group">
                      <span>Read More</span>
                      <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </Link>
                  </div>
           
              </div>
            </div>
          </div>
        
        </div>
        
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const activeTab = ref('background')

const props = defineProps({
    coreIdentities: {
        type: Array,
        default: () => []
    }
});

// Computed properties to filter identities by type
const backgroundIdentity = computed(() => {
    return props.coreIdentities.find(identity => identity.type === 'background');
});

const visionIdentity = computed(() => {
    return props.coreIdentities.find(identity => identity.type === 'vision');
});

const missionIdentity = computed(() => {
    return props.coreIdentities.find(identity => identity.type === 'mission');
});

// Check if we have data for each type
const hasBackgroundData = computed(() => {
    return backgroundIdentity.value !== undefined;
});

const hasVisionData = computed(() => {
    return visionIdentity.value !== undefined;
});

const hasMissionData = computed(() => {
    return missionIdentity.value !== undefined;
});

</script>

<style scoped>
.tab-content-panel {
  transition: opacity 0.3s ease-in-out;
}

/* Ensure images maintain aspect ratio */
img {
  max-height: 400px;
  object-fit: cover;
}

/* Style for rich text content from CKEditor */
.prose :deep(h1) {
  font-size: 2.25rem;
  font-weight: bold;
  margin-top: 1.5rem;
  margin-bottom: 1rem;
  color: #1e40af;
}

.prose :deep(h2) {
  font-size: 1.875rem;
  font-weight: bold;
  margin-top: 1.25rem;
  margin-bottom: 0.75rem;
  color: #1e40af;
}

.prose :deep(h3) {
  font-size: 1.5rem;
  font-weight: bold;
  margin-top: 1rem;
  margin-bottom: 0.5rem;
  color: #1e40af;
}

.prose :deep(p) {
  margin-bottom: 1rem;
  line-height: 1.75;
}

.prose :deep(ul) {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin-bottom: 1rem;
}

.prose :deep(ol) {
  list-style-type: decimal;
  padding-left: 1.5rem;
  margin-bottom: 1rem;
}

.prose :deep(li) {
  margin-bottom: 0.5rem;
}

.prose :deep(a) {
  color: #2563eb;
  text-decoration: underline;
}

.prose :deep(a:hover) {
  color: #1d4ed8;
}

.prose :deep(strong) {
  font-weight: bold;
}

.prose :deep(em) {
  font-style: italic;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .md\:flex-row {
    flex-direction: column;
  }
  
  .md\:w-1\/2 {
    width: 100%;
  }
  
  .md\:pl-10, .md\:pr-10 {
    padding-left: 0;
    padding-right: 0;
  }
  
  .md\:pt-0 {
    padding-top: 1.5rem;
  }
}

/* Smooth tab transition */
.tab-btn {
  transition: all 0.3s ease;
}

.tab-btn:hover {
  transform: translateY(-1px);
}

/* Improve readability */
.whitespace-pre-line {
  white-space: pre-line;
}

/* Custom scrollbar for better UX */
.tab-content-panel {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f1f5f9;
}

.tab-content-panel::-webkit-scrollbar {
  width: 8px;
}

.tab-content-panel::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 4px;
}

.tab-content-panel::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 4px;
}

.tab-content-panel::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}
</style>