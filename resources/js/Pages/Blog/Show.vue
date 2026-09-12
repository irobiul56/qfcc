<script setup>
import { defineProps } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Applayout from '@/Layouts/AppLayout.vue';
import { ArrowRight } from '@element-plus/icons-vue'

const props = defineProps({
    blog: Object,
});
</script>

<template>
    <Head title="Blog" />
    <Applayout>
        <div class="relative w-full h-96">
            <!-- Background image with proper object-cover and fallback -->
            <img :src="`/storage/${blog.image}`"
                alt="{{ blog.title }}"
                class="absolute inset-0 w-full h-full object-cover"
                onerror="this.style.display='none'"
            >
            <!-- Dark overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <!-- Content -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="bg-green-600 text-white px-6 py-4 rounded-lg shadow-xl max-w-3xl mx-4 bg-opacity-30">
                    <h1 class="text-3xl md:text-4xl font-bold text-center">{{ blog.title }}</h1>
                </div>
            </div>
        </div>

        <div class="p-6 mx-auto max-w-5xl">
            <!-- Content wrapper with proper styling -->
            <div class="blog-content prose prose-lg max-w-none" v-html="blog.description"></div>
            <el-button class="mt-8" type="primary" @click="$inertia.get('/blog')">Back</el-button>
        </div>
    </Applayout>
</template>

<style scoped>
/* Container styles */
.steps-container {
    padding: 20px;
    text-align: center;
}

.title {
    font-size: 24px;
    margin-bottom: 20px;
}

.description {
    color: #555;
    font-size: 16px;
    line-height: 1.8;
    margin-top: 10px;
}
</style>

<style>
/* Global styles for CKEditor content */
.blog-content {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    line-height: 1.6;
    color: #333;
}

/* Headings */
.blog-content h1,
.blog-content h2,
.blog-content h3,
.blog-content h4 {
    margin-top: 1.5em;
    margin-bottom: 0.5em;
    font-weight: 600;
    line-height: 1.3;
}

.blog-content h1 { font-size: 2.25rem; }
.blog-content h2 { font-size: 1.875rem; }
.blog-content h3 { font-size: 1.5rem; }
.blog-content h4 { font-size: 1.25rem; }

/* Paragraphs and text */
.blog-content p {
    margin-bottom: 1.25rem;
    font-size: 1.125rem;
}

/* Lists */
.blog-content ul,
.blog-content ol {
    margin-bottom: 1.25rem;
    padding-left: 1.5rem;
}

.blog-content li {
    margin-bottom: 0.5rem;
}

/* Links */
.blog-content a {
    color: #3b82f6;
    text-decoration: none;
}

.blog-content a:hover {
    text-decoration: underline;
}

/* Blockquotes */
.blog-content blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    font-style: italic;
    color: #6b7280;
    margin: 1.5rem 0;
}

/* Images */
.blog-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    margin: 1.5rem 0;
}

/* Tables */
.blog-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}

.blog-content table th,
.blog-content table td {
    border: 1px solid #e5e7eb;
    padding: 0.75rem;
    text-align: left;
}

.blog-content table th {
    background-color: #f9fafb;
    font-weight: 600;
}

/* Code blocks */
.blog-content pre {
    background-color: #f3f4f6;
    border-radius: 0.375rem;
    padding: 1rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.blog-content code {
    font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace;
    font-size: 0.875rem;
}

/* Horizontal rule */
.blog-content hr {
    border: 0;
    border-top: 1px solid #e5e7eb;
    margin: 2rem 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .blog-content {
        font-size: 1rem;
    }
    
    .blog-content h1 { font-size: 1.875rem; }
    .blog-content h2 { font-size: 1.5rem; }
    .blog-content h3 { font-size: 1.25rem; }
    .blog-content h4 { font-size: 1.125rem; }
}
</style>