<template>
  <div v-if="links.length > 3" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
      <Link
        :href="links[0].url"
        :class="[
          'relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50',
          !links[0].url && 'pointer-events-none opacity-50'
        ]"
        preserve-scroll
      >
        Previous
      </Link>
      <Link
        :href="links[links.length - 1].url"
        :class="[
          'relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50',
          !links[links.length - 1].url && 'pointer-events-none opacity-50'
        ]"
        preserve-scroll
      >
        Next
      </Link>
    </div>
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700">
          Showing
          <span class="font-medium">{{ from }}</span>
          to
          <span class="font-medium">{{ to }}</span>
          of
          <span class="font-medium">{{ total }}</span>
          results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <Link
            v-for="(link, key) in links"
            :key="key"
            :href="link.url"
            :class="[
              'relative inline-flex items-center px-4 py-2 text-sm font-semibold focus:z-20',
              key === 0 ? 'rounded-l-md' : '',
              key === links.length - 1 ? 'rounded-r-md' : '',
              link.active
                ? 'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0',
              !link.url && 'pointer-events-none text-gray-400 opacity-50'
            ]"
            v-html="link"
            preserve-scroll
          />
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  links: Array,
  from: Number,
  to: Number,
  total: Number
})

// Fallback computed properties in case from/to/total are not provided
const computedFrom = computed(() => props.from || 0)
const computedTo = computed(() => props.to || 0)
const computedTotal = computed(() => props.total || 0)
</script>