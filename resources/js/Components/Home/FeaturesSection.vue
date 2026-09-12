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
    </div>

    <!-- Content Grid -->
    <div class="max-w-7xl mx-auto">
      <!-- Desktop Layout -->
      <div class="hidden md:grid md:grid-cols-[1fr_auto_1fr_auto_1fr] lg:gap-x-12 justify-items-center">
        <template v-for="(feature, index) in initialFeatures" :key="index">
          <!-- Feature Block -->
          <div class="flex flex-col items-center text-center w-full max-w-xs p-6 bg-white transition-transform duration-300 hover:scale-[1.03] rounded-xl">
            <i :class="feature.icon" :style="{ color: feature.color }" style="font-size:30px"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-2 mt-2">{{feature.title}}</h3>
            <p class="text-gray-600 text-base">
              {{ feature.description }}
            </p>
          </div>
          
          <!-- Vertical Separator (except after last item) -->
          <div 
            v-if="index < initialFeatures.length - 1" 
            class="h-full w-px bg-gray-300 mx-4 self-stretch" 
            role="separator" 
            aria-orientation="vertical"
          ></div>
        </template>
      </div>

      <!-- Mobile Layout -->
      <div class="md:hidden flex flex-col items-center">
        <template v-for="(feature, index) in initialFeatures" :key="index">
          <!-- Feature Block -->
          <div class="flex flex-col items-center text-center w-full max-w-xs p-6 bg-white transition-transform duration-300 hover:scale-[1.03] rounded-xl">
            <i :class="feature.icon" :style="{ color: feature.color }" style="font-size:30px"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-2 mt-2">{{feature.title}}</h3>
            <p class="text-gray-600 text-base">
              {{ feature.description }}
            </p>
          </div>
          
          <!-- Horizontal Separator (except after last item) -->
          <div 
            v-if="index < initialFeatures.length - 1" 
            class="w-3/4 h-px bg-gray-200 my-4" 
            role="separator"
          ></div>
        </template>
      </div>

      <!-- Know More Button -->
      <div class="w-full flex justify-center mt-10">
        <Link :href="route('about')" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-lg font-medium rounded-xl shadow-xl text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-accent-gold/50 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
          Know More
          <span class="ml-3 h-5 w-5" role="img" aria-label="right arrow icon">
            <svg class="h-5 w-5" focusable="false" aria-hidden="true" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_2364_10373_2)">
                <path d="M19.7709 9.44699C19.7706 9.44676 19.7704 9.44648 19.7702 9.44625L15.688 5.38375C15.3821 5.07941 14.8875 5.08054 14.5831 5.3864C14.2787 5.69222 14.2799 6.18687 14.5857 6.49125L17.3265 9.21875H0.78125C0.349766 9.21875 0 9.56851 0 10C0 10.4315 0.349766 10.7812 0.78125 10.7812H17.3264L14.5857 13.5087C14.2799 13.8131 14.2787 14.3078 14.5831 14.6136C14.8875 14.9195 15.3822 14.9205 15.688 14.6162L19.7702 10.5537C19.7704 10.5535 19.7706 10.5532 19.7709 10.553C20.0769 10.2476 20.0759 9.75137 19.7709 9.44699Z" fill="currentColor"></path>
              </g>
              <defs>
                <clipPath id="clip0_2364_10373_2">
                  <rect width="20" height="20" fill="currentColor"></rect>
                </clipPath>
              </defs>
            </svg>
          </span>
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  initialFeatures: {
    type: Array,
    default: () => []
  }
})
</script>

<style scoped>
.text-accent-gold {
  color: #E8B65D;
}
</style>