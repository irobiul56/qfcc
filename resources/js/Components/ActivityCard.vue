<template>
  <Head title="Activities" />
  <div class="bg-white rounded-lg shadow-lg overflow-hidden transition duration-300 ease-in-out hover:shadow-xl">
    <div class="aspect-w-16 aspect-h-9">
      <img 
        class="w-full h-full object-cover" 
        :src="`/storage/${activity.image}`"
        :alt="activity.title + ' Image'"
      >
    </div>

    <div class="p-6">
      <p class="text-sm font-medium text-green-600 mb-2">
        {{ activity.category.name }}
      </p>
      <h3 class="text-xl font-semibold text-gray-900 mb-3">
        {{ activity.title }}
      </h3>
      <p class="text-gray-500 text-base mb-4 line-clamp-3" v-html="activity.description">
        
      </p>

      <Link 
        :href="route('single.activity', activity.slug)" 
        class="inline-flex items-center justify-center w-full px-4 py-2 border border-green-600 text-base font-medium rounded-md text-green-600 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out"
      >
        See Details
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
  activity: {
    type: Object,
    required: true
  }
})
</script>