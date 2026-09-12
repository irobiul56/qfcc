<template>
  <section id="donate" class="bg-gray-50 min-h-screen p-4 sm:p-8 font-sans">
    <div class="max-w-6xl mx-auto">
      
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4" style="font-family: 'SolaimanLipi', sans-serif;">
          {{donationData.title}}
        </h2>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
          {{ donationData.subtitle }}
        </p>
      </div>

    <div class="flex justify-center mb-10">
        <div class="w-32 h-32 sm:w-40 sm:h-40 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-red-100 p-2">
            <img :src="getImageUrl(donationData.main_image)">
        </div>
    </div>

    <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">

        <div class="bg-white p-6 rounded-xl shadow-lg border-t-4  hover:shadow-xl transition duration-300" :class="getBorderColor(donation_methods.title)" v-for="(donation_methods, index) in bankMethods" :key="index">
            <h3 class="text-lg font-semibold text-center mb-4 pb-2 border-b border-gray-200 text-gray-700" style="font-family: 'SolaimanLipi', sans-serif;">
                {{donation_methods.title}}
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center border-b pb-1">
                    <span class="font-medium text-gray-600 w-1/3">Bank Name</span>
                    <span class="text-right text-gray-800 font-medium w-2/3">{{ donation_methods.bank_name }}</span>
                </div>
                <div class="flex justify-between items-center border-b pb-1">
                    <span class="font-medium text-gray-600 w-1/3">Branch</span>
                    <span class="text-right text-gray-800 w-2/3">{{ donation_methods.branch }}</span>
                </div>
                <div class="flex justify-between items-center border-b pb-1">
                    <span class="font-medium text-gray-600 w-1/3">Routing Number</span>
                    <span class="text-right text-gray-800 w-2/3">{{ donation_methods.routing_number }}</span>
                </div>
                <div class="flex justify-between items-center border-b pb-1">
                    <span class="font-medium text-gray-600 w-1/3">Account Name</span>
                    <span class="text-right text-gray-800 w-2/3">{{donation_methods.account_name}}</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="font-medium text-gray-600 w-1/3">Account No</span>
                    <span class="text-right text-lg font-bold text-red-600 w-2/3">{{ donation_methods.account_no }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto flex flex-col sm:flex-row justify-center items-center gap-4 p-4">

        <div class="w-full sm:w-40 p-3 rounded-xl shadow-md bg-pink-100 flex flex-col items-center justify-center text-center hover:bg-pink-200 transition duration-300" v-for="(method, index) in mobileMethods" :key="index"
               :class="getMethodColorClass(method.platform)">>
            <span class="text-xl font-bold text-pink-700" :class="getMethodTextColor(method.platform)" style="font-family: 'SolaimanLipi', sans-serif;">
                {{method.platform_name}}
            </span>
            <span class="text-xs text-gray-700" style="font-family: 'SolaimanLipi', sans-serif;">
                {{method.merchant_type}}
            </span>
            <span class="text-lg font-semibold text-pink-600 mt-1" :class="getMethodTextColor(method.platform)">
                {{method.number}}
            </span>
        </div>



    </div>
</div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

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

const getBorderColor = (title) => {
  const lowerTitle = title.toLowerCase()
  if (lowerTitle.includes('Zakat Fund') || lowerTitle.includes('scholarship')) {
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

// Reactive state
const selectedAmount = ref(null)
const customAmount = ref('')
const showToast = ref(false)
const toastMessage = ref('')

// Quick donation amounts
const quickAmounts = [100, 500, 1000, 5000]

// Methods
const copyToClipboard = async (text, platform) => {
  try {
    await navigator.clipboard.writeText(text)
    showToastMessage(`${platform} number copied to clipboard!`)
  } catch (err) {
    showToastMessage('Failed to copy text')
  }
}

const selectAmount = (amount) => {
  selectedAmount.value = amount
  showToastMessage(`Selected amount: ৳ ${amount}`)
}

const selectCustomAmount = () => {
  if (!customAmount.value) {
    showToastMessage('Please enter an amount')
    return
  }
  selectedAmount.value = parseInt(customAmount.value)
  showToastMessage(`Selected custom amount: ৳ ${customAmount.value}`)
}

const showToastMessage = (message) => {
  toastMessage.value = message
  showToast.value = true
  setTimeout(() => {
    showToast.value = false
  }, 3000)
}

const formatNumber = (num) => {
  return new Intl.NumberFormat().format(num)
}
</script>

<style scoped>
/* Custom styles for Bengali font support */
@import url('https://fonts.maateen.me/solaiman-lipi/font.css');

/* Smooth transitions */
button, .group {
  transition: all 0.3s ease;
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
  background: #10B981;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #059669;
}
</style>