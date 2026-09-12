<template>
  <section id="donate" class="bg-gray-50 min-h-screen p-4 sm:p-8 font-sans">
    <div class="max-w-6xl mx-auto">
      
      <!-- Section Header with Edit Button -->
      <div class="text-center mb-12 relative">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4" style="font-family: 'SolaimanLipi', sans-serif;">
          {{ donationData.title }}
         
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          {{ donationData.subtitle }}
        </p>
        
        <!-- Edit Button for Admin -->
        <button @click="openEditDonationModal"
          class="absolute top-0 right-0 hover:bg-green-600 text-sm hover:text-white px-4 py-2 rounded-full bg-white/90 border border-green-700 transition duration-200 flex items-center gap-2 hover:scale-105 transform">
          <i class="fas fa-edit"></i>
          Edit Section
        </button>
      </div>

      <!-- Main Image with Edit -->
      <div class="flex justify-center mb-10 relative group">
        <div class="w-32 h-32 sm:w-40 sm:h-40 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-red-100 p-2 relative">
          <img :src="getImageUrl(donationData.main_image)" alt="Donation Image" class="w-full h-full object-contain rounded-full">
          
          <!-- Edit Image Button -->
          <button @click="openEditImageModal"
            class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-blue-600">
            <i class="fas fa-camera text-sm"></i>
          </button>
        </div>
      </div>

      <!-- Donation Methods Grid -->
      <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
        <!-- Bank Account Cards -->
        <div v-for="(method, index) in bankMethods" :key="index"
          class="bg-white p-6 rounded-xl shadow-lg border-t-4 hover:shadow-xl transition duration-300 relative group"
          :class="getBorderColor(method.title)">
          <div class="absolute top-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <button @click="openEditDonationMethodModal(method)"
              class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition">
              <i class="fas fa-edit text-sm"></i>
            </button>
            <button @click="confirmDeleteMethod(method)"
              class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition">
              <i class="fas fa-trash text-sm"></i>
            </button>
          </div>
          
          <h3 class="text-lg font-semibold text-center mb-4 pb-2 border-b border-gray-200 text-gray-700" style="font-family: 'SolaimanLipi', sans-serif;">
            {{ method.title }}
          </h3>
          <div class="space-y-3 text-sm">
            <div v-for="(detail, key) in formatDetails(method)" :key="key" 
                 class="flex justify-between items-center border-b pb-1">
              <span class="font-medium text-gray-600 w-1/3">{{ formatLabel(key) }}</span>
              <span class="text-right text-gray-800 w-2/3 break-words">{{ detail }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Add New Bank Account Button -->
      <div class="flex justify-center mb-10">
        <button @click="openAddDonationMethodModal('bank')"
          class="hover:bg-green-600 hover:text-white px-6 py-3 rounded-full bg-white border-2 border-green-700 border-dashed transition duration-200 flex items-center gap-2 hover:scale-105 transform">
          <i class="fas fa-plus"></i>
          Add New Bank Account
        </button>
      </div>

      <!-- Mobile Banking Section -->
      <div class="max-w-2xl mx-auto mb-10">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-bold text-gray-800" style="font-family: 'SolaimanLipi', sans-serif;">
            Mobile Banking
          </h3>
          <button @click="openAddDonationMethodModal('mobile')"
            class="hover:bg-green-600 hover:text-white px-4 py-2 rounded-full bg-white border border-green-700 transition duration-200 flex items-center gap-2">
            <i class="fas fa-plus"></i>
            Add New
          </button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div v-for="(method, index) in mobileMethods" :key="index"
               class="relative group p-4 rounded-xl shadow-md hover:shadow-lg transition duration-300"
               :class="getMethodColorClass(method.platform)">
            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
              <button @click="openEditMobileBankingModal(method)"
                class="bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600">
                <i class="fas fa-edit text-xs"></i>
              </button>
              <button @click="confirmDeleteMobileMethod(method)"
                class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600">
                <i class="fas fa-trash text-xs"></i>
              </button>
            </div>
            
            <div class="flex flex-col items-center justify-center text-center">
              <span class="text-xl font-bold" :class="getMethodTextColor(method.platform)" style="font-family: 'SolaimanLipi', sans-serif;">
                {{ method.platform_name }}
              </span>
              <span class="text-xs text-gray-700 mt-1" style="font-family: 'SolaimanLipi', sans-serif;">
                {{ method.merchant_type }}
              </span>
              <div class="flex items-center gap-2 mt-2">
                <span class="text-lg font-semibold" :class="getMethodTextColor(method.platform)">
                  {{ method.number }}
                </span>
                <button @click="copyToClipboard(method.number, method.platform_name)"
                  class="text-gray-500 hover:text-gray-700 transition">
                  <i class="fas fa-copy"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ================= MODALS ================= -->

    <!-- Edit Donation Section Modal -->
    <div v-if="showEditDonationModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-green-600"></i>
                    Edit Donation Section
                  </h3>
                  <button @click="closeEditDonationModal" class="text-gray-400 hover:text-gray-500 transition">
                    <i class="fas fa-times text-lg"></i>
                  </button>
                </div>

                <form @submit.prevent="updateDonationSection">
                  <!-- Title Input -->
                  <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                      Section Title
                    </label>
                    <input type="text" id="title" v-model="donationForm.title"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                      :class="{ 'border-red-500': donationForm.errors.title }">
                    <div v-if="donationForm.errors.title" class="text-red-500 text-sm mt-1">
                      {{ donationForm.errors.title }}
                    </div>
                  </div>

                  <!-- Subtitle Input -->
                  <div class="mb-6">
                    <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-1">
                      Section Subtitle
                    </label>
                    <textarea id="subtitle" v-model="donationForm.subtitle" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                      :class="{ 'border-red-500': donationForm.errors.subtitle }"></textarea>
                    <div v-if="donationForm.errors.subtitle" class="text-red-500 text-sm mt-1">
                      {{ donationForm.errors.subtitle }}
                    </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="flex justify-end gap-3 mt-6">
                    <button type="button" @click="closeEditDonationModal" :disabled="donationForm.processing"
                      class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition disabled:opacity-50">
                      Cancel
                    </button>
                    <button type="submit" :disabled="donationForm.processing"
                      class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition disabled:opacity-50">
                      <i v-if="donationForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                      {{ donationForm.processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Image Modal -->
    <div v-if="showEditImageModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center gap-2">
                    <i class="fas fa-image text-green-600"></i>
                    Update Donation Image
                  </h3>
                  <button @click="closeEditImageModal" class="text-gray-400 hover:text-gray-500 transition">
                    <i class="fas fa-times text-lg"></i>
                  </button>
                </div>

                <form @submit.prevent="updateDonationImage" enctype="multipart/form-data">
                  <!-- Current Image Preview -->
                  <div v-if="donationData.main_image" class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                    <img :src="getImageUrl(donationData.main_image)" alt="Current Image" 
                      class="w-full h-48 object-contain rounded-md border">
                  </div>

                  <!-- Image Upload -->
                  <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                      Upload New Image
                    </label>
                    
                    <!-- New image preview -->
                    <div v-if="imagePreview" class="mb-3">
                      <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                      <img :src="imagePreview" alt="New Image Preview"
                        class="w-full h-48 object-cover rounded-md border">
                    </div>

                    <div class="flex items-center justify-center w-full">
                      <label for="imageUpload"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                          <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                          <p class="mb-2 text-sm text-gray-500">
                            <span class="font-semibold">Click to upload</span> or drag and drop
                          </p>
                          <p class="text-xs text-gray-500">
                            PNG, JPG, GIF, WEBP up to 2MB
                          </p>
                        </div>
                        <input type="file" id="imageUpload" @change="handleImageUpload" accept="image/*" class="hidden" />
                      </label>
                    </div>
                    
                    <!-- Error message -->
                    <div v-if="imageForm.errors.main_image" class="text-red-500 text-sm mt-1">
                      {{ imageForm.errors.main_image }}
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-1">
                      Leave empty to keep current image
                    </p>
                  </div>

                  <!-- Action Buttons -->
                  <div class="flex justify-end gap-3">
                    <button type="button" @click="closeEditImageModal" :disabled="imageForm.processing"
                      class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition disabled:opacity-50">
                      Cancel
                    </button>
                    <button type="submit" :disabled="imageForm.processing"
                      class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition disabled:opacity-50">
                      <i v-if="imageForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                      {{ imageForm.processing ? 'Uploading...' : 'Upload Image' }}
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add/Edit Donation Method Modal -->
    <div v-if="showDonationMethodModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                <div class="flex justify-between items-center mb-4">
                  <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center gap-2">
                    <i class="fas" :class="isEditingMethod ? 'fa-edit text-blue-600' : 'fa-plus-circle text-green-600'"></i>
                    {{ isEditingMethod ? 'Edit Donation Method' : 'Add New Donation Method' }}
                  </h3>
                  <button @click="closeDonationMethodModal" class="text-gray-400 hover:text-gray-500 transition">
                    <i class="fas fa-times text-lg"></i>
                  </button>
                </div>

                <form @submit.prevent="saveDonationMethod">
                  <!-- Method Type -->
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                      Method Type
                    </label>
                    <div class="flex gap-4">
                      <label class="flex items-center cursor-pointer">
                        <input type="radio" v-model="donationMethodForm.type" value="bank" 
                          class="mr-2" :disabled="isEditingMethod" @change="clearMobileFields">
                        <span>Bank Account</span>
                      </label>
                      <label class="flex items-center cursor-pointer">
                        <input type="radio" v-model="donationMethodForm.type" value="mobile"
                          class="mr-2" :disabled="isEditingMethod" @change="clearBankFields">
                        <span>Mobile Banking</span>
                      </label>
                    </div>
                  </div>

                  <!-- Title -->
                  <div class="mb-4">
                    <label for="methodTitle" class="block text-sm font-medium text-gray-700 mb-1">
                      Title *
                    </label>
                    <input type="text" id="methodTitle" v-model="donationMethodForm.title"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                      :class="{ 'border-red-500': donationMethodForm.errors.title }"
                      placeholder="e.g., General Fund, bKash Donation">
                    <div v-if="donationMethodForm.errors.title" class="text-red-500 text-sm mt-1">
                      {{ donationMethodForm.errors.title }}
                    </div>
                  </div>

                  <!-- Bank Account Fields -->
                  <div v-if="donationMethodForm.type === 'bank'" class="space-y-4">
                    <div>
                      <label for="bankName" class="block text-sm font-medium text-gray-700 mb-1">
                        Bank Name *
                      </label>
                      <input type="text" id="bankName" v-model="donationMethodForm.bank_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.bank_name }"
                        placeholder="e.g., Islami Bank Bangladesh PLC">
                      <div v-if="donationMethodForm.errors.bank_name" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.bank_name }}
                      </div>
                    </div>

                    <div>
                      <label for="branch" class="block text-sm font-medium text-gray-700 mb-1">
                        Branch *
                      </label>
                      <input type="text" id="branch" v-model="donationMethodForm.branch"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.branch }"
                        placeholder="e.g., Local Office (Corporate Branch)">
                      <div v-if="donationMethodForm.errors.branch" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.branch }}
                      </div>
                    </div>

                    <div>
                      <label for="routingNumber" class="block text-sm font-medium text-gray-700 mb-1">
                        Routing Number *
                      </label>
                      <input type="text" id="routingNumber" v-model="donationMethodForm.routing_number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.routing_number }"
                        placeholder="e.g., 125273888">
                      <div v-if="donationMethodForm.errors.routing_number" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.routing_number }}
                      </div>
                    </div>

                    <div>
                      <label for="accountName" class="block text-sm font-medium text-gray-700 mb-1">
                        Account Name *
                      </label>
                      <input type="text" id="accountName" v-model="donationMethodForm.account_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.account_name }"
                        placeholder="e.g., Hasanah Foundation">
                      <div v-if="donationMethodForm.errors.account_name" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.account_name }}
                      </div>
                    </div>

                    <div>
                      <label for="accountNumber" class="block text-sm font-medium text-gray-700 mb-1">
                        Account Number *
                      </label>
                      <input type="text" id="accountNumber" v-model="donationMethodForm.account_no"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.account_no }"
                        placeholder="e.g., 205010200033711">
                      <div v-if="donationMethodForm.errors.account_no" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.account_no }}
                      </div>
                    </div>
                  </div>

                  <!-- Mobile Banking Fields -->
                  <div v-if="donationMethodForm.type === 'mobile'" class="space-y-4">
                    <div>
                      <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">
                        Platform *
                      </label>
                      <select id="platform" v-model="donationMethodForm.platform"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.platform }"
                        @change="updatePlatformName">
                        <option value="">Select Platform</option>
                        <option value="bkash">bKash</option>
                        <option value="nogod">নগদ</option>
                        <option value="rocket">রকেট</option>
                        <option value="other">Other</option>
                      </select>
                      <div v-if="donationMethodForm.errors.platform" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.platform }}
                      </div>
                    </div>

                    <div v-if="donationMethodForm.platform === 'other'">
                      <label for="customPlatform" class="block text-sm font-medium text-gray-700 mb-1">
                        Platform Name *
                      </label>
                      <input type="text" id="customPlatform" v-model="donationMethodForm.platform_name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.platform_name }"
                        placeholder="Enter platform name">
                      <div v-if="donationMethodForm.errors.platform_name" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.platform_name }}
                      </div>
                    </div>

                    <div>
                      <label for="merchantType" class="block text-sm font-medium text-gray-700 mb-1">
                        Merchant Type *
                      </label>
                      <input type="text" id="merchantType" v-model="donationMethodForm.merchant_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.merchant_type }"
                        placeholder="e.g., বিকাশ মার্চেন্ট, নগদ মার্চেন্ট">
                      <div v-if="donationMethodForm.errors.merchant_type" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.merchant_type }}
                      </div>
                    </div>

                    <div>
                      <label for="mobileNumber" class="block text-sm font-medium text-gray-700 mb-1">
                        Account Number *
                      </label>
                      <input type="text" id="mobileNumber" v-model="donationMethodForm.number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        :class="{ 'border-red-500': donationMethodForm.errors.number }"
                        placeholder="e.g., 01304700700">
                      <div v-if="donationMethodForm.errors.number" class="text-red-500 text-sm mt-1">
                        {{ donationMethodForm.errors.number }}
                      </div>
                    </div>
                  </div>

                  <!-- Order -->
                  <div class="mb-6">
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">
                      Display Order
                    </label>
                    <input type="number" id="order" v-model="donationMethodForm.order"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                      :class="{ 'border-red-500': donationMethodForm.errors.order }"
                      min="0" placeholder="Lower numbers display first">
                    <div v-if="donationMethodForm.errors.order" class="text-red-500 text-sm mt-1">
                      {{ donationMethodForm.errors.order }}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                      Set the display order (0 = first, 1 = second, etc.)
                    </p>
                  </div>

                  <!-- Action Buttons -->
                  <div class="flex justify-end gap-3">
                    <button type="button" @click="closeDonationMethodModal" :disabled="donationMethodForm.processing"
                      class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition disabled:opacity-50">
                      Cancel
                    </button>
                    <button type="submit" :disabled="donationMethodForm.processing"
                      class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition disabled:opacity-50">
                      <i v-if="donationMethodForm.processing" class="fas fa-spinner fa-spin mr-2"></i>
                      {{ donationMethodForm.processing ? 'Saving...' : (isEditingMethod ? 'Update' : 'Save') }}
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
<div v-if="showDeleteConfirmationModal" class="fixed inset-0 z-50 overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <!-- Modal panel -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
            <!-- Header with icon -->
            <div class="flex items-center justify-center mb-4">
              <div :class="[
                'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10',
                isDeleting ? 'bg-blue-100' : 'bg-red-100'
              ]">
                <i v-if="isDeleting" class="fas fa-spinner fa-spin text-blue-600"></i>
                <i v-else class="fas fa-exclamation-triangle text-red-600"></i>
              </div>
              <div class="ml-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                  {{ isDeleting ? 'Deleting...' : 'Confirm Delete' }}
                </h3>
                <p class="text-sm text-gray-500">
                  <template v-if="isDeleting">
                    Please wait while we delete "{{ methodToDelete?.title }}"...
                  </template>
                  <template v-else>
                    Are you sure you want to delete "{{ methodToDelete?.title }}"?
                    This action cannot be undone.
                  </template>
                </p>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-6">
              <button 
                @click="closeDeleteConfirmationModal" 
                :disabled="isDeleting"
                :class="[
                  'px-4 py-2 text-sm font-medium rounded-md transition flex items-center justify-center min-w-[80px]',
                  isDeleting 
                    ? 'text-gray-400 bg-gray-100 cursor-not-allowed' 
                    : 'text-gray-700 bg-gray-100 hover:bg-gray-200'
                ]"
              >
                <span>Cancel</span>
              </button>
              
              <button 
                @click="deleteDonationMethod" 
                :disabled="isDeleting"
                :class="[
                  'px-4 py-2 text-sm font-medium text-white rounded-md transition flex items-center justify-center gap-2 min-w-[80px]',
                  isDeleting 
                    ? 'bg-blue-600 hover:bg-blue-700 cursor-wait' 
                    : 'bg-red-600 hover:bg-red-700'
                ]"
              >
                <i v-if="isDeleting" class="fas fa-spinner fa-spin"></i>
                <span>{{ isDeleting ? 'Deleting...' : 'Delete' }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Toast Notification -->
    <div v-if="showToast" 
      class="fixed bottom-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg animate-slide-up flex items-center gap-2">
      <i class="fas fa-check-circle"></i>
      <span>{{ toastMessage }}</span>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

// Props for data from backend
const props = defineProps({
  donationData: {
    type: Object,
    default: () => ({
      id: null,
      title: 'Support Our Cause',
      subtitle: 'Your donation helps us continue our mission of serving humanity and building a better society',
      main_image: null,
      donation_methods: []
    })
  }
})

// Reactive states
const showEditDonationModal = ref(false)
const showEditImageModal = ref(false)
const showDonationMethodModal = ref(false)
const showDeleteConfirmationModal = ref(false)
const showToast = ref(false)
const toastMessage = ref('')
const imagePreview = ref(null)

// Editing states
const isEditingMethod = ref(false)
const methodToDelete = ref(null)
const editingMethod = ref(null)

// Forms
const donationForm = useForm({
  title: props.donationData.title,
  subtitle: props.donationData.subtitle
})

const imageForm = useForm({
  main_image: null
})

const donationMethodForm = useForm({
  type: 'bank',
  title: '',
  bank_name: '',
  branch: '',
  routing_number: '',
  account_name: '',
  account_no: '',
  platform: 'bkash',
  platform_name: '',
  merchant_type: '',
  number: '',
  order: 0
})

// Computed properties
const bankMethods = computed(() => {
  return props.donationData.donation_methods
    ?.filter(method => method.type === 'bank')
    .sort((a, b) => a.order - b.order) || []
})

const mobileMethods = computed(() => {
  return props.donationData.donation_methods
    ?.filter(method => method.type === 'mobile')
    .sort((a, b) => a.order - b.order) || []
})

// Methods for donation section
const openEditDonationModal = () => {
  donationForm.title = props.donationData.title
  donationForm.subtitle = props.donationData.subtitle
  showEditDonationModal.value = true
}

const closeEditDonationModal = () => {
  showEditDonationModal.value = false
  donationForm.clearErrors()
}

const updateDonationSection = () => {
  donationForm.patch(route('donations.update', props.donationData.id), {
    preserveScroll: true,
    preserveState: false,
    onSuccess: () => {
      showToastMessage('Donation section updated successfully!')
      closeEditDonationModal()
    },
    onError: (errors) => {
      console.log('Update failed:', errors)
    }
  })
}

// Methods for image
const openEditImageModal = () => {
  imagePreview.value = null
  imageForm.main_image = null
  showEditImageModal.value = true
}

const closeEditImageModal = () => {
  showEditImageModal.value = false
  imagePreview.value = null
  imageForm.clearErrors()
  imageForm.reset()
}

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    // Validate file size (2MB = 2 * 1024 * 1024 bytes)
    if (file.size > 2 * 1024 * 1024) {
      showToastMessage('File size must be less than 2MB')
      event.target.value = ''
      return
    }
    
    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
    if (!validTypes.includes(file.type)) {
      showToastMessage('Please upload a valid image file (JPEG, PNG, GIF, WEBP)')
      event.target.value = ''
      return
    }
    
    imageForm.main_image = file

    // Create preview
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const updateDonationImage = () => {
  // If no file selected, close modal
  if (!imageForm.main_image) {
    showToastMessage('Please select an image to upload')
    return
  }

  imageForm.post(route('donations.update-image', props.donationData.id), {
    preserveScroll: true,
    preserveState: false,
    onSuccess: () => {
      showToastMessage('Donation image updated successfully!')
      closeEditImageModal()
      // Reset file input
      const fileInput = document.getElementById('imageUpload')
      if (fileInput) fileInput.value = ''
    },
    onError: (errors) => {
      console.log('Image update failed:', errors)
    }
  })
}

// Methods for donation methods
const openAddDonationMethodModal = (type) => {
  isEditingMethod.value = false
  editingMethod.value = null
  donationMethodForm.reset()
  donationMethodForm.type = type
  donationMethodForm.order = props.donationData.donation_methods?.length || 0
  
  // Set default platform name
  if (type === 'mobile') {
    updatePlatformName()
  }
  
  showDonationMethodModal.value = true
}

const openEditDonationMethodModal = (method) => {
  isEditingMethod.value = true
  editingMethod.value = method
  
  // Fill form with method data
  donationMethodForm.type = method.type
  donationMethodForm.title = method.title
  donationMethodForm.order = method.order || 0
  
  if (method.type === 'bank') {
    donationMethodForm.bank_name = method.bank_name || ''
    donationMethodForm.branch = method.branch || ''
    donationMethodForm.routing_number = method.routing_number || ''
    donationMethodForm.account_name = method.account_name || ''
    donationMethodForm.account_no = method.account_no || ''
  } else {
    donationMethodForm.platform = method.platform || 'bkash'
    donationMethodForm.platform_name = method.platform_name || ''
    donationMethodForm.merchant_type = method.merchant_type || ''
    donationMethodForm.number = method.number || ''
  }
  
  showDonationMethodModal.value = true
}

const openEditMobileBankingModal = (method) => {
  openEditDonationMethodModal(method)
}

const closeDonationMethodModal = () => {
  showDonationMethodModal.value = false
  isEditingMethod.value = false
  editingMethod.value = null
  donationMethodForm.reset()
}

const clearBankFields = () => {
  donationMethodForm.bank_name = ''
  donationMethodForm.branch = ''
  donationMethodForm.routing_number = ''
  donationMethodForm.account_name = ''
  donationMethodForm.account_no = ''
}

const clearMobileFields = () => {
  donationMethodForm.platform = 'bkash'
  donationMethodForm.platform_name = ''
  donationMethodForm.merchant_type = ''
  donationMethodForm.number = ''
}

const updatePlatformName = () => {
  if (donationMethodForm.platform !== 'other') {
    const platformNames = {
      bkash: 'bKash',
      nogod: 'নগদ',
      rocket: 'রকেট'
    }
    donationMethodForm.platform_name = platformNames[donationMethodForm.platform] || ''
  } else {
    donationMethodForm.platform_name = ''
  }
}

const saveDonationMethod = () => {
  if (isEditingMethod.value) {
    // Update existing method
    donationMethodForm.patch(route('donations.methods.update', editingMethod.value.id), {
      preserveScroll: true,
      preserveState: false,
      onSuccess: () => {
        showToastMessage('Donation method updated successfully!')
        closeDonationMethodModal()
      },
      onError: (errors) => {
        console.log('Update failed:', errors)
      }
    })
  } else {
    // Create new method - PASS donation ID
    donationMethodForm.post(route('donations.methods.store', props.donationData.id), {
      preserveScroll: true,
      preserveState: false,
      onSuccess: () => {
        showToastMessage('Donation method added successfully!')
        closeDonationMethodModal()
      },
      onError: (errors) => {
        console.log('Creation failed:', errors)
      }
    })
  }
}

const confirmDeleteMethod = (method) => {
  methodToDelete.value = method
  showDeleteConfirmationModal.value = true
}

const confirmDeleteMobileMethod = (method) => {
  confirmDeleteMethod(method)
}

const closeDeleteConfirmationModal = () => {
  showDeleteConfirmationModal.value = false
  methodToDelete.value = null
}

const deleteDonationMethod = () => {
  if (!methodToDelete.value) return

  const deleteForm = useForm({})
  deleteForm.delete(route('donations.methods.destroy', methodToDelete.value.id), {
    preserveScroll: true,
    preserveState: false,
    onSuccess: () => {
      showToastMessage('Donation method deleted successfully!')
      closeDeleteConfirmationModal()
    },
    onError: (errors) => {
      console.log('Deletion failed:', errors)
      showToastMessage('Failed to delete donation method')
      closeDeleteConfirmationModal()
    }
  })
}

// Utility methods
const copyToClipboard = async (text, platform) => {
  try {
    await navigator.clipboard.writeText(text)
    showToastMessage(`${platform} number copied to clipboard!`)
  } catch (err) {
    showToastMessage('Failed to copy text')
  }
}

const showToastMessage = (message) => {
  toastMessage.value = message
  showToast.value = true
  setTimeout(() => {
    showToast.value = false
  }, 3000)
}

const formatLabel = (key) => {
  const labels = {
    bank_name: 'Bank Name',
    branch: 'Branch',
    routing_number: 'Routing Number',
    account_name: 'Account Name',
    account_no: 'Account Number'
  }
  return labels[key] || key.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
}

const getBorderColor = (title) => {
  const lowerTitle = title.toLowerCase()
  if (lowerTitle.includes('zakat') || lowerTitle.includes('scholarship')) {
    return 'border-green-500'
  } else if (lowerTitle.includes('general')) {
    return 'border-red-500'
  } else if (lowerTitle.includes('emergency') || lowerTitle.includes('relief')) {
    return 'border-orange-500'
  } else if (lowerTitle.includes('education')) {
    return 'border-blue-500'
  } else {
    return 'border-indigo-500'
  }
}

const getMethodColorClass = (platform) => {
  const colors = {
    bkash: 'bg-pink-100 hover:bg-pink-200',
    nogod: 'bg-red-100 hover:bg-red-200',
    rocket: 'bg-purple-100 hover:bg-purple-200',
    other: 'bg-gray-100 hover:bg-gray-200'
  }
  return colors[platform] || 'bg-gray-100 hover:bg-gray-200'
}

const getMethodTextColor = (platform) => {
  const colors = {
    bkash: 'text-pink-700',
    nogod: 'text-red-700',
    rocket: 'text-purple-700',
    other: 'text-gray-700'
  }
  return colors[platform] || 'text-gray-700'
}

const getPlatformName = (platform) => {
  const names = {
    bkash: 'bKash',
    nogod: 'নগদ',
    rocket: 'রকেট'
  }
  return names[platform] || platform
}

const getImageUrl = (path) => {
  if (!path) return '/storage/images/donate.png'
  if (path.startsWith('http')) return path
  if (path.startsWith('/storage/')) return path
  return `/storage/${path}`
}

// Format details for display
const formatDetails = (method) => {
  if (method.type === 'bank') {
    return {
      bank_name: method.bank_name,
      branch: method.branch,
      routing_number: method.routing_number,
      account_name: method.account_name,
      account_no: method.account_no
    }
  }
  return {}
}
</script>

<style scoped>
/* Import Bengali font */
@import url('https://fonts.maateen.me/solaiman-lipi/font.css');

/* Animations */
.animate-slide-up {
  animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
  from {
    transform: translateY(100%);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

/* Modal transitions */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* Smooth transitions */
button, .group, input, textarea, select {
  transition: all 0.3s ease;
}

/* Line breaking for long text */
.break-words {
  word-break: break-word;
  overflow-wrap: break-word;
}

/* Hover effects */
.hover-scale:hover {
  transform: scale(1.05);
}

/* Loading spinner animation */
.fa-spinner {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Focus styles */
input:focus, textarea:focus, select:focus {
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Image hover effect */
img {
  transition: transform 0.3s ease;
}

img:hover {
  transform: scale(1.02);
}

/* Card hover effect */
.bg-white:hover {
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>