<template>
    <Head title="Create Activity" />

    <UserLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create Activities</h2>
        </template>

        <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-8">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <!-- Header Card -->
                <div class="mb-8 overflow-hidden rounded-2xl bg-white shadow-xl">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-white">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-full bg-white/20 p-3">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold">Create New Activity</h1>
                                <p class="mt-2 opacity-90">Share your experiences and adventures with the community</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form Card -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-8">
                            <!-- Title Section -->
                            <div class="space-y-4">
                                <label class="flex items-center text-lg font-semibold text-gray-800">
                                    <svg class="mr-2 h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Activity Title
                                   
                                </label>
                                <input 
                                    v-model="form.title" 
                                    type="text" 
                                    placeholder="Enter a captivating title for your activity..."
                                    class="w-full rounded-xl border-2 border-gray-200 px-4 py-3 text-lg transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                />
                                <p class="text-sm text-gray-500">Make it descriptive and engaging to attract readers</p>
                            </div>

                            <div class="flex flex-col gap-8 lg:flex-row">
                                <!-- Left Column - Content Editor -->
                                <div class="flex-1 space-y-6">
                                    <!-- Content Editor -->
                                    <div class="space-y-4">
                                        <label class="flex items-center text-lg font-semibold text-gray-800">
                                            <svg class="mr-2 h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9m0 0v12m0-12a2 2 0 012-2h2a2 2 0 012 2m-6 9v-2"></path>
                                            </svg>
                                            Activity Content
                                        </label>
                                        <div class="rounded-xl border-2 border-gray-200 p-1 transition-all duration-200 focus-within:border-blue-500">
                                            <CKEditor v-model="form.description" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Sidebar -->
                                <div class="w-full space-y-6 lg:w-80">
                                    <!-- Category Selection -->
                                    <div class="space-y-4">
                                        <label class="flex items-center text-lg font-semibold text-gray-800">
                                            <svg class="mr-2 h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            Category
                                        </label>
                                        <div class="relative">
                                            <select 
                                                v-model="form.category_id"
                                                class="w-full appearance-none rounded-xl border-2 border-gray-200 bg-white px-4 py-3 pr-10 transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                                            >
                                                <option value="" disabled selected>Select a category</option>
                                                <option 
                                                    v-for="(cat, index) in category" 
                                                    :key="index" 
                                                    :value="cat.id"
                                                >
                                                    {{ cat.name }}
                                                </option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Featured Image Upload -->
                                    <div class="space-y-4">
                                        <label class="flex items-center text-lg font-semibold text-gray-800">
                                            <svg class="mr-2 h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Featured Image
                                        </label>
                                        
                                        <!-- Upload Area -->
                                        <div 
                                            @click="$refs.fileInput.click()"
                                            class="group cursor-pointer rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-6 text-center transition-all duration-200 hover:border-blue-400 hover:bg-blue-50"
                                        >
                                            <input 
                                                type="file" 
                                                ref="fileInput"
                                                @change="handleFileChange" 
                                                class="hidden"
                                                accept="image/*"
                                            />
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <div class="rounded-full bg-blue-100 p-4 group-hover:bg-blue-200 transition-colors duration-200">
                                                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-gray-700">Click to upload image</p>
                                                    <p class="text-sm text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Image Preview -->
                                        <div v-if="imagePreview" class="mt-4 overflow-hidden rounded-xl shadow-lg transition-all duration-300">
                                            <div class="relative">
                                                <img 
                                                    :src="imagePreview" 
                                                    alt="Image Preview" 
                                                    class="w-full object-cover"
                                                />
                                                <button 
                                                    @click="imagePreview = null; form.image = null"
                                                    class="absolute top-3 right-3 rounded-full bg-red-500 p-2 text-white shadow-lg transition-all duration-200 hover:bg-red-600"
                                                >
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-6">
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="flex items-center space-x-2 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-4 font-semibold text-white shadow-lg transition-all duration-200 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50"
                                >
                                    <svg v-if="form.processing" class="h-5 w-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <svg v-else class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>{{ form.processing ? 'Creating...' : 'Create Activity' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="mt-8 overflow-hidden rounded-2xl bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-xl">
                    <div class="p-6">
                        <h3 class="mb-4 flex items-center text-xl font-bold">
                            <svg class="mr-2 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tips for a Great Activity Post
                        </h3>
                        <ul class="grid gap-3 md:grid-cols-2">
                            <li class="flex items-start">
                                <svg class="mr-2 mt-1 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Use high-quality, engaging images</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="mr-2 mt-1 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Write a clear, descriptive title</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="mr-2 mt-1 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Include relevant details and location</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="mr-2 mt-1 h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Choose the appropriate category</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import { ref } from 'vue';
import UserLayout from "@/Layouts/UserLayout.vue";
import { useForm, usePage } from '@inertiajs/vue3';
import { Head } from "@inertiajs/vue3";
import { ElMessage } from 'element-plus';
import CKEditor from '@/Components/CKEditor.vue';

const { props } = usePage()
const category = ref(props.category)

const form = useForm({
    title: '',
    description: '', // Fixed: was 'desctiption'
    category_id: '',
    image: null,
});

const imagePreview = ref(null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];
        if (!validTypes.includes(file.type)) {
            ElMessage({ 
                type: 'error', 
                message: 'Invalid file type. Please upload JPEG, PNG, JPG, GIF, or SVG.' 
            });
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            ElMessage({ 
                type: 'error', 
                message: 'File size too large. Maximum size is 2MB.' 
            });
            return;
        }

        form.image = file;
        
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    // Basic validation
    if (!form.title || !form.description || !form.category_id) {
        ElMessage({ 
            type: 'error', 
            message: 'Please fill in all required fields.' 
        });
        return;
    }

    form.post(route('activites.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            ElMessage({ 
                type: 'success', 
                message: 'Activity created successfully!' 
            });
            form.reset();
            imagePreview.value = null;
        },
        onError: (errors) => {
            let errorMessage = 'Failed to create activity. Please try again.';
            
            if (errors.title) {
                errorMessage = errors.title;
            } else if (errors.description) {
                errorMessage = errors.description;
            } else if (errors.category_id) {
                errorMessage = errors.category_id;
            } else if (errors.image) {
                errorMessage = errors.image;
            }
            
            ElMessage({ 
                type: 'error', 
                message: errorMessage 
            });
        },
        onFinish: () => {
            // Reset processing state
        }
    });
};
</script>

<style scoped>
/* Custom scrollbar for webkit browsers */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, transform, box-shadow;
    transition-duration: 200ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>