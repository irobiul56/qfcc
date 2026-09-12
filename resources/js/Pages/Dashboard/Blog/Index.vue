<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3';
import { ElMessage } from "element-plus";
import { router } from '@inertiajs/vue3'

const { props } = usePage()
const blog = ref(props.blog)

const itemsPerPage = ref(10)
const currentPage = ref(1)
const searchQuery = ref('')

const filteredblog = computed(() => {
  const filtered = blog.value.filter(blog => 
  blog.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
  )
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filtered.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(
    blog.value.filter(blog => 
    blog.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
    ).length / itemsPerPage.value
  )
})

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++
  }
}

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--
  }
}

defineProps({ 
    errors: Object 
})

const deleteblog = (blogId) => {
    if (confirm("Are you sure you want to delete this data?")) {
        // Use Inertia's delete method directly
        router.delete(route('blogpost.destroy', blogId), {
            onSuccess: () => {
                // Remove the deleted blog from the local state
                blog.value = blog.value.filter(item => item.id !== blogId);
                ElMessage.success("blog deleted successfully!");
            },
            onError: () => {
                ElMessage.error("Failed to delete the blog. Please try again.");
            },
        });
    }
};
</script>

<template>
    <UserLayout>
        <Head title="Blog Management" />

        <!-- Success Message -->
        <div v-if="$page.props.flash?.message" class="mx-4 mt-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 shadow-sm transition-all duration-300">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ $page.props.flash?.message }}
            </div>
        </div>
      
        <div class="container mx-auto px-4 py-6">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Blog Management</h1>
                <p class="text-gray-600 mt-2">Manage your blog and their details</p>
            </div>

            <!-- Search and Add Button Section -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Search Input -->
                    <div class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input 
                            v-model="searchQuery"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                            type="text" 
                            placeholder="Search blog..."
                        >
                    </div>
                    
                    <!-- Add Button -->
                    <Link 
                        :href="route('blogpost.create')" 
                        class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Blog
                    </Link>
                </div>
            </div>

            <!-- blog Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <!-- Mobile Card View -->
                <div class="md:hidden">
                    <div v-for="(blog, index) in filteredblog" :key="index" class="border-b border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <img :src="`/storage/${blog.image}`" alt="Activity Image" class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900 truncate">{{ blog.title }}</h3>
                                <div class="mt-2 flex space-x-2">
                                    <Link :href="route('blogpost.edit', blog.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors duration-200">
                                        Edit
                                    </Link>
                                    <button @click="deleteblog(blog.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition-colors duration-200">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <table class="hidden md:table min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(blog, index) in filteredblog" :key="index" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img :src="`/storage/${blog.image}`" alt="Blog Image" class="h-12 w-12 object-cover rounded-lg border border-gray-200 shadow-sm">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ blog.title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 "><el-tag>{{ blog.category.name }}</el-tag></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <Link :href="route('blogpost.edit', blog.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </Link>
                                    <button @click="deleteblog(blog.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-sm transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Empty State -->
                <div v-if="filteredblog.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No blog found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new blog.</p>
                    <div class="mt-6">
                        <Link :href="route('blogpost.create')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Blog
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="filteredblog.length > 0" class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ (currentPage - 1) * itemsPerPage + 1 }}</span> to 
                    <span class="font-medium">{{ Math.min(currentPage * itemsPerPage, filteredblog.length + (currentPage - 1) * itemsPerPage) }}</span> of 
                    <span class="font-medium">{{ blog.length }}</span> results
                </div>
                <div class="flex items-center space-x-2">
                    <button 
                        @click="prevPage" 
                        :disabled="currentPage === 1"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                    >
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Previous
                    </button>
                    <span class="text-sm text-gray-700 px-3 py-2 bg-gray-100 rounded-md">
                        Page {{ currentPage }} of {{ totalPages }}
                    </span>
                    <button 
                        @click="nextPage" 
                        :disabled="currentPage === totalPages"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                    >
                        Next
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
/* Custom styles for transitions and animations */
.alert {
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Custom scrollbar for table */
.table-container {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
}

.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f7fafc;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background-color: #cbd5e0;
    border-radius: 4px;
}
</style>