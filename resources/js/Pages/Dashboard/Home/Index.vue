<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import CoreIdentitySection from '@/Components/Home/Dashboard/CoreIdentitySection.vue';
import FeaturesSection from '@/Components/Home/Dashboard/FeaturesSection.vue';
import DonationSection from '@/Components/Home/Dashboard/DonationSection.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

const isModalOpen = ref(false);
const imagePreview = ref(null);

// Get slide data from backend props
const props = defineProps({
    slide: Object,
    coreIdentities: Array,
    features: Array,
    donationData:Object
});

// Initialize slideData with props or default values
const slideData = ref({
    title: props.slide?.title || 'Your Slide Title',
    description: props.slide?.description || 'Your slide description goes here',
    background_image: props.slide?.background_image
        ? `/storage/${props.slide.background_image}`
        : '/storage/images/headerbackground.jpeg'
});

const form = useForm({
    title: slideData.value.title,
    description: slideData.value.description,
    background_image: null
});

const openModal = () => {
    form.title = slideData.value.title;
    form.description = slideData.value.description;
    form.background_image = null;
    imagePreview.value = null;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    form.clearErrors();
    imagePreview.value = null;
};

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.background_image = file;

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submitForm = () => {
    // Use post method with proper form data
    form.post(route('slide.update'), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: (page) => {
            // Update slideData with new data from backend
            if (page.props.slide) {
                slideData.value.title = page.props.slide.title;
                slideData.value.description = page.props.slide.description;
                if (page.props.slide.background_image) {
                    slideData.value.background_image = `/storage/${page.props.slide.background_image}`;
                }
            }

            // Clear the form image
            form.background_image = null;
            imagePreview.value = null;
            closeModal();

            // Show success message if available
            if (page.props.flash?.success) {
                // You can add a toast notification here
                console.log(page.props.flash.success);
            }
        },
        onError: (errors) => {
            console.log('Update failed:', errors);
        }
    });
};

// Convert storage path to URL
const getImageUrl = (path) => {
    if (!path) return '/storage/images/headerbackground.jpeg';
    if (path.startsWith('http')) return path;
    return `/storage/${path}`;
};
</script>

<template>

    <Head title="Slide" />

    <UserLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Slide
            </h2>
        </template>

        <div class="container p-4">
            <!-- Slide Section -->
            <div class="relative p-8 py-14 border border-green-700 bg-gradient-to-r from-white via-green-50 to-green-100 my-2 text-center rounded-lg overflow-hidden"
                :style="{
                    backgroundImage: `url('${slideData.background_image}')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    minHeight: '300px'
                }">
                <!-- Overlay for better text readability -->
                <div class="absolute inset-0 bg-black/30 z-0"></div>

                <div class="relative z-10 h-full flex items-center justify-center">
                    <div class="max-w-4xl mx-auto">
                        <h1
                            class="flex gap-2 justify-center items-center text-3xl md:text-4xl lg:text-5xl font-bold text-white drop-shadow-lg mb-4">
                            <i class="fas fa-star text-yellow-300"></i>
                            <span class="line-clamp-2">{{ slideData.title }}</span>
                        </h1>
                        <div class="text-white text-lg md:text-xl drop-shadow mb-6">
                            <span class="line-clamp-3">{{ slideData.description }}</span>
                        </div>
                        <div class="mt-4 flex justify-center">
                            <button @click="openModal"
                                class="hover:bg-green-600 text-sm hover:text-white px-6 py-3 rounded-full bg-white/90 border border-green-700 transition duration-200 flex items-center gap-2 hover:scale-105 transform">
                                <i class="fas fa-edit"></i>
                                Update Slide
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <CoreIdentitySection :core-identities="coreIdentities" />

            <FeaturesSection :initial-features="features || []" />

            <!-- Donation Section -->
            <DonationSection :donationData ="donationData" />

        </div>

        <!-- Update Slide Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Header -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center gap-2">
                                        <i class="fas fa-sliders-h text-green-600"></i>
                                        Update Slide
                                    </h3>
                                    <button @click="closeModal" class="text-gray-400 hover:text-gray-500">
                                        <i class="fas fa-times text-lg"></i>
                                    </button>
                                </div>

                                <form @submit.prevent="submitForm" enctype="multipart/form-data">
                                    <!-- Title Input -->
                                    <div class="mb-4">
                                        <label for="title"
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <i class="fas fa-heading text-green-600 text-sm"></i>
                                            Title
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="title" v-model="form.title"
                                                class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                                placeholder="Enter slide title"
                                                :class="{ 'border-red-500': form.errors.title }" />
                                            <i class="fas fa-pencil-alt absolute left-3 top-3 text-gray-400"></i>
                                        </div>
                                        <div v-if="form.errors.title"
                                            class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ form.errors.title }}
                                        </div>
                                    </div>

                                    <!-- Description Input -->
                                    <div class="mb-4">
                                        <label for="description"
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <i class="fas fa-align-left text-green-600 text-sm"></i>
                                            Description
                                        </label>
                                        <div class="relative">
                                            <textarea id="description" v-model="form.description" rows="3"
                                                class="w-full px-3 py-2 pl-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                                placeholder="Enter slide description"
                                                :class="{ 'border-red-500': form.errors.description }"></textarea>
                                            <i class="fas fa-file-alt absolute left-3 top-3 text-gray-400"></i>
                                        </div>
                                        <div v-if="form.errors.description"
                                            class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ form.errors.description }}
                                        </div>
                                    </div>

                                    <!-- Background Image Upload -->
                                    <div class="mb-6">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-2">
                                            <i class="fas fa-image text-green-600 text-sm"></i>
                                            Background Image
                                        </label>

                                        <!-- Current image preview -->
                                        <div v-if="slideData.background_image && !imagePreview" class="mb-3 relative">
                                            <img :src="slideData.background_image" alt="Current Background"
                                                class="w-full h-48 object-cover rounded-md border">
                                            <div
                                                class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                                                Current Image
                                            </div>
                                        </div>

                                        <!-- New image preview -->
                                        <div v-if="imagePreview" class="mb-3 relative">
                                            <img :src="imagePreview" alt="New Background Preview"
                                                class="w-full h-48 object-cover rounded-md border">
                                            <div
                                                class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded">
                                                New Image Preview
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-center w-full">
                                            <label for="background_image"
                                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                                                    <p class="mb-2 text-sm text-gray-500">
                                                        <span class="font-semibold">Click to upload</span> or drag and
                                                        drop
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        PNG, JPG, GIF up to 5MB
                                                    </p>
                                                </div>
                                                <input type="file" id="background_image" @change="handleImageChange"
                                                    accept="image/*" class="hidden" />
                                            </label>
                                        </div>
                                        <div v-if="form.errors.background_image"
                                            class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ form.errors.background_image }}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Leave empty to keep current image
                                        </p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-3">
                                        <button type="submit" :disabled="form.processing"
                                            class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                            <i v-if="form.processing" class="fas fa-spinner fa-spin mr-2"></i>
                                            <i v-else class="fas fa-save mr-2"></i>
                                            {{ form.processing ? 'Saving...' : 'Save Changes' }}
                                        </button>
                                        <button type="button" @click="closeModal" :disabled="form.processing"
                                            class="inline-flex justify-center items-center w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
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
    </UserLayout>
</template>

<style scoped>
/* Add smooth transitions */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

/* Smooth image loading */
img {
    transition: opacity 0.3s ease;
}

img:not([src]) {
    opacity: 0;
}

/* Line clamp utilities */
.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

.line-clamp-4 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
}

/* Hover effects for cards */
.bg-white {
    transition: all 0.3s ease;
}

.bg-white:hover {
    transform: translateY(-5px);
}

/* Custom scrollbar for modal */
.modal-content::-webkit-scrollbar {
    width: 8px;
}

.modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.modal-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>