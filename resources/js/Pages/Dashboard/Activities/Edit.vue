<script setup>
import { ref } from 'vue';
import UserLayout from "@/Layouts/UserLayout.vue";
import { useForm, Link } from '@inertiajs/vue3';
import CKEditor from '@/Components/CKEditor.vue';
import { Head } from "@inertiajs/vue3";
import { ElMessage } from 'element-plus';

const props = defineProps({
    activity: Object,
    category: Array,
    errors: Object
});

// Form Setup
const form = useForm({
    title: props.activity?.title || '',
    description: props.activity?.description || '',
    category_id: props.activity?.category_id?.toString() || '',
    image: null,
    _method: 'PUT'
});

// Image preview
const imagePreview = ref(props.activity?.image ? `/storage/${props.activity.image}` : null);

const handleFileChange = (event) => {
    const file = event.target.files[0];
    form.image = file;
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Submit form
const updateActivity = () => {
    form.post(route("activites.update", props.activity.id), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            ElMessage.success("Activity updated successfully!");
        },
        onError: (errors) => {
            ElMessage.error("Failed to update activity. Please check the form.");
        }
    });
};
</script>

<template>
    <Head title="Edit Activity"/>

    <UserLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Activity</h2>
        </template>

        <div class="py-9">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="mb-6 text-2xl font-bold text-gray-800">Edit Activity</h1>
                        <form @submit.prevent="updateActivity" class="space-y-6">
                            <!-- Title Field -->
                            <div class="w-full">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                <input 
                                    v-model="form.title" 
                                    type="text" 
                                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                    placeholder="Enter activity title"
                                />
                                <span class="text-red-500 text-sm mt-1" v-if="errors.title">{{ errors.title }}</span>
                            </div>

                            <div class="flex flex-col lg:flex-row gap-6">
                                <!-- Left Side: CKEditor -->
                                <div class="lg:w-3/4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <div class="border border-gray-300 rounded-lg overflow-hidden">
                                        <CKEditor v-model="form.description" />
                                    </div>
                                    <span class="text-red-500 text-sm mt-1" v-if="errors.description">{{ errors.description }}</span>
                                </div>

                                <!-- Right Side: Category and Image -->
                                <div class="lg:w-1/4 space-y-6">
                                    <!-- Category Selection -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Category
                                        </label>
                                        <select 
                                            v-model="form.category_id"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-200"
                                        >
                                            <option value="" disabled>Select a category</option>
                                            <option 
                                                v-for="cat in category" 
                                                :key="cat.id" 
                                                :value="cat.id"
                                            >
                                                {{ cat.name }}
                                            </option>
                                        </select>
                                        <span class="text-red-500 text-sm mt-1" v-if="errors.category_id">{{ errors.category_id }}</span>
                                    </div>

                                    <!-- Image Upload -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Featured Image
                                        </label>
                                        <input 
                                            type="file" 
                                            @change="handleFileChange" 
                                            accept="image/*"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-3 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        />
                                        
                                        <!-- Current Image Preview -->
                                        <div v-if="imagePreview" class="mt-4">
                                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                            <img 
                                                :src="imagePreview" 
                                                alt="Current Image" 
                                                class="w-full h-48 object-cover rounded-lg border border-gray-300"
                                            />
                                            <p class="text-xs text-gray-500 mt-1">
                                                Upload a new image to replace the current one
                                            </p>
                                        </div>
                                        
                                        <span class="text-red-500 text-sm mt-1" v-if="errors.image">{{ errors.image }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-3 pt-6 border-t border-gray-200">
                                <button 
                                    type="submit" 
                                    :disabled="form.processing"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span v-if="form.processing">Updating...</span>
                                    <span v-else>Update Activity</span>
                                </button>
                                <Link 
                                    :href="route('activites.index')" 
                                    class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200"
                                >
                                    Cancel
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
h2 {
    margin-bottom: 1rem;
}
</style>