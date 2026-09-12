<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { ref, computed, reactive } from 'vue'
import { usePage } from '@inertiajs/vue3';
import { ElMessage, ElDialog, ElForm, ElFormItem, ElInput, ElSelect, ElOption } from "element-plus";
import { router } from '@inertiajs/vue3'
import CKEditor from '@/Components/CKEditor.vue';

const { props } = usePage()
const notice = ref(props.notice)
const category = ref(props.category)

const itemsPerPage = ref(10)
const currentPage = ref(1)
const searchQuery = ref('')

// Modal states
const showCreateModal = ref(false)
const showEditModal = ref(false)
const isSubmitting = ref(false)
const editingNotice = ref(null)

// Form data
const form = reactive({
    title: '',
    description: '',
    category_id: '',
})

// Reset form
const resetForm = () => {
    form.title = ''
    form.description = ''
    form.category_id = ''
}

// Form validation rules
const rules = reactive({
    title: [
        { required: true, message: 'Please input notice title', trigger: 'blur' },
        { min: 3, message: 'Title should be at least 3 characters', trigger: 'blur' }
    ],
    description: [
        { required: true, message: 'Please input notice content', trigger: 'blur' }
    ],
    category_id: [
        { required: true, message: 'Please select a category', trigger: 'change' }
    ]
})

const filterednotice = computed(() => {
  const filtered = notice.value.filter(notice => 
  notice.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
  )
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filtered.slice(start, end)
})

const totalPages = computed(() => {
  return Math.ceil(
    notice.value.filter(notice => 
    notice.title.toLowerCase().includes(searchQuery.value.toLowerCase()) 
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

// Create notice function
const createNotice = () => {
    isSubmitting.value = true
    
    router.post(route('notices.store'), form, {
        onSuccess: () => {
            ElMessage.success("Notice created successfully!");
            showCreateModal.value = false
            resetForm()
            // Refresh the notices list from props
            notice.value = usePage().props.notice
        },
        onError: (errors) => {
            if (errors) {
                ElMessage.error("Please check the form for errors");
            }
        },
        onFinish: () => {
            isSubmitting.value = false
        }
    })
}

// Edit notice function
const editNotice = (noticeId) => {
    const noticeToEdit = notice.value.find(item => item.id === noticeId)
    if (noticeToEdit) {
        editingNotice.value = noticeToEdit
        form.title = noticeToEdit.title
        form.description = noticeToEdit.description
        form.category_id = noticeToEdit.category_id
        showEditModal.value = true
    }
}

// Update notice function
const updateNotice = () => {
    if (!editingNotice.value) return
    
    isSubmitting.value = true
    
    router.put(route('notices.update', editingNotice.value.id), form, {
        onSuccess: () => {
            ElMessage.success("Notice updated successfully!");
            showEditModal.value = false
            resetForm()
            editingNotice.value = null
            // Refresh the notices list from props
            notice.value = usePage().props.notice
        },
        onError: (errors) => {
            if (errors) {
                ElMessage.error("Please check the form for errors");
            }
        },
        onFinish: () => {
            isSubmitting.value = false
        }
    })
}

const deletenotice = (noticeId) => {
    if (confirm("Are you sure you want to delete this data?")) {
        router.delete(route('notices.destroy', noticeId), {
            onSuccess: () => {
                notice.value = notice.value.filter(item => item.id !== noticeId);
                ElMessage.success("Notice deleted successfully!");
            },
            onError: () => {
                ElMessage.error("Failed to delete the notice. Please try again.");
            },
        });
    }
};

// Open modal functions
const openCreateModal = () => {
    resetForm()
    showCreateModal.value = true
}

const closeEditModal = () => {
    showEditModal.value = false
    editingNotice.value = null
    resetForm()
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

</script>

<template>
    <UserLayout>
        <Head title="Notice Management" />

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
                <h1 class="text-3xl font-bold text-gray-800">Notice Management</h1>
                <p class="text-gray-600 mt-2">Manage your notices and their details</p>
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
                            placeholder="Search notices..."
                        >
                    </div>
                    
                    <!-- Add Button -->
                    <button 
                        @click="openCreateModal"
                        class="inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Notice
                    </button>
                </div>
            </div>

            <!-- Notice Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <!-- Mobile Card View -->
                <div class="md:hidden">
                    <div v-for="(notice, index) in filterednotice" :key="index" class="border-b border-gray-200 p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start space-x-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900 truncate">{{ notice.title }}</h3>
                                <div class="mt-2 flex space-x-2">
                                    <button 
                                        @click="editNotice(notice.id)" 
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors duration-200"
                                    >
                                        Edit
                                    </button>
                                    <button @click="deletenotice(notice.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition-colors duration-200">
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(notice, index) in filterednotice" :key="index" class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ notice.title }}</td>
                            <td class="px-6 py-4 whitespace-wrap text-sm text-gray-900"> <p class="p-1 border border-green-700 rounded-md border-dotted" v-html="notice.description "></p></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 "><el-tag>{{ notice.category.name }}</el-tag></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 "><el-tag>{{ formatDate(notice.created_at) }}</el-tag></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button 
                                        @click="editNotice(notice.id)" 
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-colors duration-200"
                                    >
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <button @click="deletenotice(notice.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 shadow-sm transition-colors duration-200">
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
                <div v-if="filterednotice.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No notices found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new notice.</p>
                    <div class="mt-6">
                        <button 
                            @click="openCreateModal"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Create Notice
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="filterednotice.length > 0" class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ (currentPage - 1) * itemsPerPage + 1 }}</span> to 
                    <span class="font-medium">{{ Math.min(currentPage * itemsPerPage, filterednotice.length + (currentPage - 1) * itemsPerPage) }}</span> of 
                    <span class="font-medium">{{ notice.length }}</span> results
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

        <!-- Create Notice Modal -->
        <ElDialog
            v-model="showCreateModal"
            title="Create New Notice"
            width="600px"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
        >
            <ElForm
                :model="form"
                :rules="rules"
                ref="formRef"
                label-width="120px"
                label-position="left"
            >
                <ElFormItem label="Title" prop="title">
                    <ElInput
                        v-model="form.title"
                        placeholder="Enter notice title"
                        maxlength="255"
                        show-word-limit
                    />
                </ElFormItem>

                <ElFormItem label="Description" prop="description">
                    <CKEditor class="m-5" v-model="form.description" />
                </ElFormItem>

                <ElFormItem style="margin-top: 10px;" label="Category" prop="category_id">
                    <ElSelect
                        v-model="form.category_id"
                        placeholder="Select category"
                        style="width: 100%;"
                    >
                        <ElOption
                            v-for="category in $page.props.category || []"
                            :key="category.id"
                            :label="category.name"
                            :value="category.id"
                        />
                    </ElSelect>
                </ElFormItem>
            </ElForm>

            <template #footer>
                <div class="flex justify-end space-x-3">
                    <button
                        @click="showCreateModal = false"
                        :disabled="isSubmitting"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        @click="createNotice"
                        :disabled="isSubmitting"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors duration-200"
                    >
                        <span v-if="isSubmitting">Creating...</span>
                        <span v-else>Create Notice</span>
                    </button>
                </div>
            </template>
        </ElDialog>

        <!-- Edit Notice Modal -->
        <ElDialog
            v-model="showEditModal"
            :title="`Edit Notice: ${editingNotice?.title || ''}`"
            width="600px"
            :close-on-click-modal="false"
            :close-on-press-escape="false"
        >
            <ElForm
                :model="form"
                :rules="rules"
                ref="editFormRef"
                label-width="120px"
                label-position="left"
            >
                <ElFormItem label="Title" prop="title">
                    <ElInput
                        v-model="form.title"
                        placeholder="Enter notice title"
                        maxlength="255"
                        show-word-limit
                    />
                </ElFormItem>

                <ElFormItem label="Description" prop="description">
                    <CKEditor class="m-5" v-model="form.description" />
                </ElFormItem>

                <ElFormItem style="margin-top: 10px;" label="Category" prop="category_id">
                    <ElSelect
                        v-model="form.category_id"
                        placeholder="Select category"
                        style="width: 100%;"
                    >
                        <ElOption
                            v-for="category in $page.props.category || []"
                            :key="category.id"
                            :label="category.name"
                            :value="category.id"
                        />
                    </ElSelect>
                </ElFormItem>
            </ElForm>

            <template #footer>
                <div class="flex justify-end space-x-3">
                    <button
                        @click="closeEditModal"
                        :disabled="isSubmitting"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors duration-200"
                    >
                        Cancel
                    </button>
                    <button
                        @click="updateNotice"
                        :disabled="isSubmitting"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-colors duration-200"
                    >
                        <span v-if="isSubmitting">Updating...</span>
                        <span v-else>Update Notice</span>
                    </button>
                </div>
            </template>
        </ElDialog>
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