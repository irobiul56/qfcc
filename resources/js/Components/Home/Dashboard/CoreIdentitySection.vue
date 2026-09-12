<!-- Components/Home/Dashboard/CoreIdentitySection.vue -->
<template>
    <!-- Core Identity Section - Horizontal Layout -->
    <section class="mt-8 text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Add Button -->
            <div class="text-center mb-10 sm:mb-14">
                <div class="flex justify-between items-center">
                    <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                        Our <span class="text-blue-600">Core Identity</span>
                    </h2>
                    <button 
                        @click="openCreateModal"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors"
                    >
                        <i class="fas fa-plus"></i>
                        Add New
                    </button>
                </div>
                <p class="mt-2 text-xl text-gray-600">Background, Vision, and Mission.</p>
            </div>

            <!-- Horizontal Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Background Card -->
                <div 
                    v-for="identity in coreIdentities" 
                    :key="identity.id"
                    class="bg-white rounded-xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col relative"
                >
                    <!-- Edit/Delete Buttons -->
                    <div class="absolute top-4 right-4 flex gap-2">
                        <button 
                            @click="openEditModal(identity)"
                            class="p-2 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200 transition-colors"
                            title="Edit"
                        >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button 
                            @click="confirmDelete(identity)"
                            class="p-2 bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition-colors"
                            title="Delete"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>

                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                            <i :class="getIconClass(identity.type)" class="text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-blue-600 mb-4 capitalize">{{ identity.type }}</h3>
                    </div>
                    
                    <div class="h-48 overflow-hidden rounded-lg mb-4 flex-shrink-0">
                        <img 
                            class="w-full h-full object-cover" 
                            :src="identity.image ? `/storage/${identity.image}` : '/storage/images/default-identity.jpg'" 
                            :alt="identity.title"
                        >
                    </div>
                    
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ identity.title }}</h4>
                    <p class="text-gray-700 leading-relaxed line-clamp-4 flex-grow">
                        {{ identity.description }}
                    </p>
                    
                    <div class="mt-6 text-center">
                        <Link :href="route('about')" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium hover:underline">
                            Read More
                            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Header -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center gap-2">
                                        <i class="fas fa-id-card text-blue-600"></i>
                                        {{ isEditing ? 'Edit' : 'Create' }} Core Identity
                                    </h3>
                                    <button @click="closeModal" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </div>
                                
                                <form @submit.prevent="submitForm">
                                    <!-- Type Selection -->
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Type
                                        </label>
                                        <div class="grid grid-cols-3 gap-2">
                                            <button
                                                type="button"
                                                @click="form.type = 'background'"
                                                :class="form.type === 'background' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                                                class="py-2 px-3 rounded-md text-sm font-medium transition-colors flex items-center justify-center gap-2"
                                            >
                                                <i class="fas fa-landmark"></i>
                                                Background
                                            </button>
                                            <button
                                                type="button"
                                                @click="form.type = 'vision'"
                                                :class="form.type === 'vision' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                                                class="py-2 px-3 rounded-md text-sm font-medium transition-colors flex items-center justify-center gap-2"
                                            >
                                                <i class="fas fa-eye"></i>
                                                Vision
                                            </button>
                                            <button
                                                type="button"
                                                @click="form.type = 'mission'"
                                                :class="form.type === 'mission' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                                                class="py-2 px-3 rounded-md text-sm font-medium transition-colors flex items-center justify-center gap-2"
                                            >
                                                <i class="fas fa-bullseye"></i>
                                                Mission
                                            </button>
                                        </div>
                                        <div v-if="form.errors.type" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.type }}
                                        </div>
                                    </div>

                                    <!-- Title Input -->
                                    <div class="mb-4">
                                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                            Title
                                        </label>
                                        <input
                                            type="text"
                                            id="title"
                                            v-model="form.title"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Enter title"
                                            :class="{ 'border-red-500': form.errors.title }"
                                        />
                                        <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.title }}
                                        </div>
                                    </div>

                                    <!-- Description Input -->
                                    <div class="mb-4">
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                            Description (Short)
                                        </label>
                                        <textarea
                                            id="description"
                                            v-model="form.description"
                                            rows="3"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Enter short description"
                                            :class="{ 'border-red-500': form.errors.description }"
                                        ></textarea>
                                        <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.description }}
                                        </div>
                                    </div>

                                    <!-- Full Content Input -->
                                    <div class="mb-4">
                                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                                            Full Content (For "Read More")
                                        </label>
                                      
                                        <CKEditor id="content" :class="{ 'border-red-500': form.errors.content }" v-model="form.content" />

                                        <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.content }}
                                        </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Image
                                        </label>
                                        
                                        <!-- Current image preview -->
                                        <div v-if="form.image && typeof form.image === 'string' && !imagePreview" class="mb-3 relative">
                                            <img 
                                                :src="`/storage/${form.image}`" 
                                                alt="Current Image" 
                                                class="w-full h-48 object-cover rounded-md border"
                                            >
                                            <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                                                Current Image
                                            </div>
                                        </div>
                                        
                                        <!-- New image preview -->
                                        <div v-if="imagePreview" class="mb-3 relative">
                                            <img 
                                                :src="imagePreview" 
                                                alt="New Image Preview" 
                                                class="w-full h-48 object-cover rounded-md border"
                                            >
                                            <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                                                New Image Preview
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-center w-full">
                                            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                                                    <p class="mb-2 text-sm text-gray-500">
                                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        PNG, JPG, GIF up to 2MB
                                                    </p>
                                                </div>
                                                <input 
                                                    type="file" 
                                                    id="image"
                                                    @change="handleImageChange"
                                                    accept="image/*"
                                                    class="hidden"
                                                />
                                            </label>
                                        </div>
                                        <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.image }}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ isEditing ? 'Leave empty to keep current image' : 'Optional' }}
                                        </p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        >
                                            <i v-if="form.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-save mr-2"></i>
                                            {{ form.processing ? 'Saving...' : 'Save' }}
                                        </button>
                                        <button
                                            type="button"
                                            @click="closeModal"
                                            :disabled="form.processing"
                                            class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                                        >
                                            <i class="fas fa-times mr-2"></i>
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Delete Core Identity
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete "{{ identityToDelete?.title }}"? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                        <button
                            type="button"
                            @click="deleteIdentity"
                            :disabled="deleteProcessing"
                            class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        >
                            <i v-if="deleteProcessing" class="fas fa-spinner fa-spin mr-2"></i>
                            <i v-else class="fas fa-trash mr-2"></i>
                            {{ deleteProcessing ? 'Deleting...' : 'Delete' }}
                        </button>
                        <button
                            type="button"
                            @click="closeDeleteModal"
                            :disabled="deleteProcessing"
                            class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import CKEditor from '@/Components/CKEditor.vue';

const props = defineProps({
    coreIdentities: {
        type: Array,
        default: () => []
    }
});

// Modal states
const isModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const isEditing = ref(false);
const imagePreview = ref(null);
const identityToDelete = ref(null);
const deleteProcessing = ref(false);

// Form
const form = useForm({
    id: null,
    type: 'background',
    title: '',
    description: '',
    content: '',
    image: null
});

// Get icons based on type
const getIconClass = (type) => {
    switch(type) {
        case 'background': return 'fas fa-landmark';
        case 'vision': return 'fas fa-eye';
        case 'mission': return 'fas fa-bullseye';
        default: return 'fas fa-id-card';
    }
};

// Open create modal
const openCreateModal = () => {
    isEditing.value = false;
    form.reset();
    imagePreview.value = null;
    isModalOpen.value = true;
};

// Open edit modal
const openEditModal = (identity) => {
    isEditing.value = true;
    form.id = identity.id;
    form.type = identity.type;
    form.title = identity.title;
    form.description = identity.description;
    form.content = identity.content || '';
    form.image = identity.image || null;
    imagePreview.value = null;
    isModalOpen.value = true;
};

// Close modal
const closeModal = () => {
    isModalOpen.value = false;
    form.clearErrors();
    form.reset();
    imagePreview.value = null;
};

// Handle image change
const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Submit form - FIXED VERSION
const submitForm = () => {
    if (isEditing.value) {
        // For UPDATE with potential file upload
        // Create a new form instance specifically for update
        const updateForm = useForm({
            _method: 'PUT', // Add this for Laravel to recognize as PUT
            type: form.type,
            title: form.title,
            description: form.description,
            content: form.content || '',
            image: form.image instanceof File ? form.image : undefined // Only include if it's a File
        });
        
        // Log for debugging
        console.log('Updating identity ID:', form.id);
        console.log('Form image type:', typeof form.image);
        console.log('Form image value:', form.image);
        
        updateForm.post(route('core-identities.update', form.id), {
            preserveScroll: true,
            preserveState: false,
            forceFormData: true, // CRITICAL: This tells Inertia to use FormData
            onSuccess: (page) => {
                console.log('Update successful');
                closeModal();
                // Force a page reload to see changes
                router.reload({ 
                    only: ['coreIdentities'],
                    onFinish: () => {
                        console.log('Page reloaded');
                    }
                });
            },
            onError: (errors) => {
                console.log('Update errors:', errors);
            },
            onFinish: () => {
                console.log('Update request finished');
            }
        });
    } else {
        // For CREATE
        console.log('Creating new identity');
        
        form.post(route('core-identities.store'), {
            preserveScroll: true,
            preserveState: false,
            onSuccess: (page) => {
                console.log('Create successful');
                closeModal();
                router.reload({ 
                    only: ['coreIdentities'],
                    onFinish: () => {
                        console.log('Page reloaded after create');
                    }
                });
            },
            onError: (errors) => {
                console.log('Create errors:', errors);
            }
        });
    }
};


// Delete confirmation
const confirmDelete = (identity) => {
    identityToDelete.value = identity;
    isDeleteModalOpen.value = true;
};

// Close delete modal
const closeDeleteModal = () => {
    isDeleteModalOpen.value = false;
    identityToDelete.value = null;
    deleteProcessing.value = false;
};

// Delete identity
const deleteIdentity = () => {
    deleteProcessing.value = true;
    
    console.log('Deleting identity ID:', identityToDelete.value.id);
    
    router.delete(route('core-identities.destroy', identityToDelete.value.id), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            console.log('Delete successful');
            closeDeleteModal();
            router.reload({ 
                only: ['coreIdentities'],
                onFinish: () => {
                    console.log('Page reloaded after delete');
                }
            });
        },
        onError: (errors) => {
            console.log('Delete errors:', errors);
            deleteProcessing.value = false;
        }
    });
};
</script>

<style scoped>
.line-clamp-4 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
}

/* Smooth transitions */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

/* Fix for modal positioning */
.fixed.inset-0.z-50 {
    z-index: 9999;
}
</style>