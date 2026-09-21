<template>
  <AppLayout
    :title="`${campaign.title} | Donate to QFCC`"
    :description="campaign.description"
  >
    <main>
      <!-- ═══════════════════════════════════════════════════ -->
      <!-- HERO                                                -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section
        class="relative isolate min-h-[290px] overflow-hidden bg-cover bg-center"
        style="background-color: #003d2c"
      >
        <img
          :src="campaign.image"
          :alt="campaign.title"
          class="absolute inset-0 h-full w-full object-cover"
          aria-hidden="true"
        />
        <div class="hero-glow absolute inset-0"></div>

        <div class="relative mx-auto flex min-h-[235px] max-w-7xl items-center justify-center px-5 py-12 text-center sm:px-8">
          <div class="max-w-4xl">
            <nav class="mb-4 flex items-center justify-center gap-2 text-xs text-white/70">
              <Link :href="route('donate')" class="hover:text-white transition-colors">Donate</Link>
              <span class="text-white/40">/</span>
              <span class="text-white/90 font-medium truncate max-w-[220px]">{{ campaign.title }}</span>
            </nav>

            <p class="mb-4 font-sans text-xs font-bold uppercase tracking-[.22em] text-qfcc-gold">
              {{ campaign.is_featured ? '★ FEATURED CAMPAIGN' : 'BUILDING BELONGING TOGETHER' }}
            </p>

            <h1 class="hero-title font-bengali text-3xl font-bold leading-relaxed text-white drop-shadow-md sm:text-4xl lg:text-5xl">
              {{ campaign.title }}
            </h1>
          </div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════════════ -->
      <!-- DONATION FORM + SIDEBAR                             -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section id="donation-form" class="donation-shell px-5 py-12 sm:px-8 lg:py-16">
        <div class="mx-auto grid max-w-6xl gap-10 lg:grid-cols-[1.1fr_.9fr] lg:items-start">

          <!-- FORM CARD -->
          <div class="donation-card order-1 rounded-2xl bg-white p-5 sm:p-8 lg:col-start-2 lg:row-start-1">

            <div class="instruction-panel mb-7 rounded-xl px-5 py-5 text-white sm:px-6">
              <p class="font-sans text-xs font-bold uppercase tracking-[.16em] text-qfcc-gold">DONATION INSTRUCTIONS</p>
              <h2 class="mt-2 font-sans text-2xl font-bold leading-relaxed">Support this mission with a secure donation</h2>
              <p class="mt-2 font-sans text-sm leading-loose text-white/85">
                Your contribution helps QFCC expand its education, service, and community-building programs.
              </p>
            </div>

            <div class="mb-6 flex items-end justify-between gap-4 border-b border-slate-200 pb-5">
              <div>
                <p class="font-sans text-xs font-bold uppercase tracking-[.16em] text-qfcc-green">COMMUNITY GIVING</p>
                <h2 class="mt-2 font-sans text-2xl font-bold text-qfcc-deep">Select your amount</h2>
              </div>
              <span class="font-sans text-3xl font-bold text-qfcc-gold">$</span>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
              <button
                v-for="amount in [20, 50, 100, 200]"
                :key="amount"
                type="button"
                @click="selectPreset(amount)"
                :class="[
                  'amount-button rounded-lg border px-3 py-3 font-sans text-lg font-bold transition',
                  selectedAmount === amount
                    ? 'border-qfcc-green bg-qfcc-green text-white shadow-md is-selected'
                    : 'border-slate-200 bg-white text-qfcc-deep hover:border-qfcc-green hover:bg-qfcc-green hover:text-white'
                ]"
              >
                $ {{ amount }}
              </button>
            </div>

            <label class="mt-5 block font-sans text-xs font-bold uppercase tracking-wider text-slate-600">
              Other amount
              <div class="mt-2 flex items-center rounded-lg border border-slate-200 bg-white px-3 focus-within:border-qfcc-green focus-within:ring-2 focus-within:ring-qfcc-green/15">
                <span class="font-sans text-sm text-slate-500">$</span>
                <input
                  v-model.number="customAmount"
                  @input="selectedAmount = null"
                  class="w-full border-0 px-3 py-3 font-sans text-sm outline-none"
                  type="number"
                  min="1"
                  placeholder="Enter donation amount"
                />
              </div>
            </label>

            <form @submit.prevent="openPaymentModal" class="mt-6 grid gap-4">
              <label class="font-sans text-xs font-bold uppercase tracking-wider text-slate-600">
                Your Name
                <input
                  v-model="form.full_name"
                  required
                  type="text"
                  placeholder="Full Name"
                  class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-qfcc-green focus:ring-2 focus:ring-qfcc-green/15"
                />
                <p v-if="form.errors.full_name" class="mt-1 text-rose-500 text-[11px] font-normal normal-case">
                  {{ form.errors.full_name }}
                </p>
              </label>

              <label class="font-sans text-xs font-bold uppercase tracking-wider text-slate-600">
                Email Address
                <input
                  v-model="form.email"
                  required
                  type="email"
                  placeholder="you@example.com"
                  class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-qfcc-green focus:ring-2 focus:ring-qfcc-green/15"
                />
                <p v-if="form.errors.email" class="mt-1 text-rose-500 text-[11px] font-normal normal-case">
                  {{ form.errors.email }}
                </p>
              </label>

              <label class="font-sans text-xs font-bold uppercase tracking-wider text-slate-600">
                Phone (optional)
                <input
                  v-model="form.phone"
                  type="tel"
                  placeholder="(123) 456-7890"
                  class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-qfcc-green focus:ring-2 focus:ring-qfcc-green/15"
                />
              </label>

              <label class="font-sans text-xs font-bold uppercase tracking-wider text-slate-600">
                Tribute or donor name (optional)
                <input
                  v-model="form.note"
                  type="text"
                  placeholder="Optional"
                  class="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 font-sans text-sm outline-none focus:border-qfcc-green focus:ring-2 focus:ring-qfcc-green/15"
                />
              </label>

              <button
                type="submit"
                :disabled="!donationAmount"
                class="mt-2 inline-flex items-center justify-center rounded-lg bg-qfcc-green px-5 py-4 font-sans text-sm font-bold text-white shadow-sm transition hover:bg-qfcc-deep disabled:cursor-not-allowed disabled:opacity-50"
              >
                Continue to Payment
                <span class="ml-2">→</span>
              </button>

              <p
                v-if="statusMessage"
                class="min-h-5 text-center font-sans text-xs text-qfcc-green"
                role="status"
              >
                {{ statusMessage }}
              </p>
            </form>
          </div>

          <!-- SIDEBAR -->
          <div class="order-2 grid gap-6 lg:col-start-1 lg:row-start-1">
            <div class="feature-card overflow-hidden rounded-2xl bg-white shadow-soft">
              <img
                :src="campaign.image"
                :alt="campaign.title"
                class="h-56 w-full object-cover sm:h-72"
              />
              <div class="p-5 sm:p-6">
                <h2 class="font-sans text-xl font-bold text-qfcc-deep">A foundation for tomorrow</h2>
                <p class="mt-2 font-sans text-sm leading-loose text-slate-600">
                  {{ campaign.description }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- PAYMENT MODAL                                           -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="showPaymentModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        @click.self="closePaymentModal"
      >
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
        >
          <div
            v-if="showPaymentModal"
            class="w-full max-w-lg bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden max-h-[90vh] flex flex-col"
          >
            <!-- Modal header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-start justify-between gap-4 flex-shrink-0">
              <div class="min-w-0 flex-1">
                <p class="font-sans text-[11px] font-bold text-qfcc-gold uppercase tracking-wider">
                  Complete Your Donation
                </p>
                <h2 class="mt-0.5 font-sans text-lg font-bold text-qfcc-deep truncate">
                  {{ campaign.title }}
                </h2>
                <p class="mt-1 font-sans text-xs text-slate-500">
                  <i class="fas fa-hand-holding-heart mr-1 text-qfcc-gold"></i>
                  Total: <strong class="text-qfcc-green">${{ donationAmount }}</strong>
                </p>
              </div>
              <button
                @click="closePaymentModal"
                :disabled="isProcessing"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all flex-shrink-0 disabled:opacity-40 disabled:cursor-not-allowed"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>

            <!-- Modal body -->
            <div class="p-6 overflow-y-auto flex-1">

              <!-- ═══════ SUCCESS STATE ═══════ -->
              <div v-if="paymentSuccess" class="text-center py-6">

                <!-- Success icon -->
                <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                  <i class="fas fa-check text-2xl text-emerald-600"></i>
                </div>

                <!-- Title -->
                <h3 class="font-sans text-lg font-bold text-qfcc-deep mb-2">
                  {{ paymentMethod === 'zelle' ? 'Donation Recorded!' : 'Payment Successful!' }}
                </h3>

                <!-- Server message -->
                <p class="font-sans text-sm text-slate-600 mb-5 leading-relaxed max-w-sm mx-auto">
                  {{ successMessage }}
                </p>

                <!-- Amount + Reference card -->
                <div class="mx-auto max-w-xs rounded-xl border border-qfcc-green/30 bg-qfcc-mist p-4 space-y-3">
                  <div>
                    <p class="font-sans text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                      Donation Amount
                    </p>
                    <p class="font-sans font-bold text-qfcc-deep text-2xl">
                      ${{ donationAmount }}
                    </p>
                  </div>

                  <div v-if="successReference" class="pt-3 border-t border-qfcc-green/20">
                    <p class="font-sans text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                      Reference Number
                    </p>
                    <p class="font-mono text-xs font-bold text-qfcc-deep select-all break-all">
                      {{ successReference }}
                    </p>
                  </div>
                </div>

                <!-- Info note -->
                <p
                  v-if="paymentMethod === 'zelle'"
                  class="mt-4 font-sans text-[11px] text-slate-500 max-w-sm mx-auto leading-relaxed"
                >
                  <i class="fas fa-info-circle mr-1 text-qfcc-gold"></i>
                  Please save your reference number. We'll verify your Zelle transfer and email you a confirmation.
                </p>

                <!-- Actions -->
                <div class="mt-6 flex flex-col sm:flex-row gap-2 justify-center">
                  <button
                    v-if="successReference"
                    @click="copyReference"
                    class="px-5 py-2.5 bg-white text-slate-700 font-sans font-medium rounded-lg text-sm ring-1 ring-slate-200 hover:bg-slate-50 transition-all inline-flex items-center justify-center gap-2"
                  >
                    <i :class="referenceCopied ? 'fas fa-check text-emerald-500' : 'fas fa-copy'"></i>
                    {{ referenceCopied ? 'Copied!' : 'Copy Reference' }}
                  </button>

                  <button
                    @click="closePaymentModalAndReset"
                    class="px-6 py-2.5 bg-qfcc-green text-white font-sans font-semibold rounded-lg text-sm hover:bg-qfcc-deep transition-all"
                  >
                    Done
                  </button>
                </div>
              </div>

              <!-- ═══════ PAYMENT SELECTION ═══════ -->
              <template v-else>
                <p class="font-sans text-xs font-bold uppercase tracking-wider text-slate-600 mb-3">
                  Choose payment method
                </p>

                <!-- Payment options -->
                <div class="grid grid-cols-1 gap-3">
                  <!-- Stripe -->
                  <label
                    :class="[
                      'payment-option group relative flex items-center gap-4 cursor-pointer rounded-xl border-2 p-4 transition',
                      paymentMethod === 'stripe'
                        ? 'border-qfcc-green bg-qfcc-mist ring-2 ring-qfcc-green/20'
                        : 'border-slate-200 bg-white hover:border-qfcc-green/50'
                    ]"
                  >
                    <input
                      v-model="paymentMethod"
                      type="radio"
                      value="stripe"
                      class="sr-only"
                      :disabled="isProcessing"
                    />
                    <span
                      :class="[
                        'flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full border-2',
                        paymentMethod === 'stripe' ? 'border-qfcc-green bg-white' : 'border-slate-300 bg-white'
                      ]"
                    >
                      <span v-if="paymentMethod === 'stripe'" class="h-2.5 w-2.5 rounded-full bg-qfcc-green"></span>
                    </span>
                    <span class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                      <i class="fas fa-credit-card text-xl"></i>
                    </span>
                    <div class="flex-1 min-w-0">
                      <p class="font-sans text-sm font-bold text-qfcc-deep">Card Payment (Stripe)</p>
                      <p class="font-sans text-xs text-slate-500 mt-0.5">
                        Visa · Mastercard · Amex · Discover
                      </p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-qfcc-green transition"></i>
                  </label>

                  <!-- Zelle -->
                  <label
                    :class="[
                      'payment-option group relative flex items-center gap-4 cursor-pointer rounded-xl border-2 p-4 transition',
                      paymentMethod === 'zelle'
                        ? 'border-qfcc-green bg-qfcc-mist ring-2 ring-qfcc-green/20'
                        : 'border-slate-200 bg-white hover:border-qfcc-green/50'
                    ]"
                  >
                    <input
                      v-model="paymentMethod"
                      type="radio"
                      value="zelle"
                      class="sr-only"
                      :disabled="isProcessing"
                    />
                    <span
                      :class="[
                        'flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-full border-2',
                        paymentMethod === 'zelle' ? 'border-qfcc-green bg-white' : 'border-slate-300 bg-white'
                      ]"
                    >
                      <span v-if="paymentMethod === 'zelle'" class="h-2.5 w-2.5 rounded-full bg-qfcc-green"></span>
                    </span>
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                      <i class="fas fa-university text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="font-sans text-sm font-bold text-qfcc-deep">Zelle</p>
                      <p class="font-sans text-xs text-slate-500 mt-0.5">
                        Bank transfer · Manual verification
                      </p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-qfcc-green transition"></i>
                  </label>
                </div>

                <!-- Zelle instructions -->
                <Transition
                  enter-active-class="transition duration-200 ease-out"
                  enter-from-class="opacity-0 -translate-y-1"
                  enter-to-class="opacity-100 translate-y-0"
                >
                  <div
                    v-if="paymentMethod === 'zelle'"
                    class="mt-5 rounded-xl border border-qfcc-green/30 bg-qfcc-mist p-5"
                  >
                    <h3 class="font-sans text-sm font-bold text-qfcc-deep flex items-center gap-2 mb-3">
                      <i class="fas fa-info-circle text-qfcc-green"></i>
                      Zelle Payment Instructions
                    </h3>

                    <div class="grid gap-2 sm:grid-cols-2">
                      <div class="rounded-lg border border-qfcc-green/20 bg-white p-3">
                        <p class="font-sans text-[10px] font-bold uppercase tracking-wider text-qfcc-green">Zelle Email</p>
                        <p class="mt-1 font-sans text-sm font-bold text-qfcc-deep select-all">mailtoqfcc@gmail.com</p>
                      </div>
                      <div class="rounded-lg border border-qfcc-green/20 bg-white p-3">
                        <p class="font-sans text-[10px] font-bold uppercase tracking-wider text-qfcc-green">Zelle Phone</p>
                        <p class="mt-1 font-sans text-sm font-bold text-qfcc-deep select-all">+1 (347) 233 5473</p>
                      </div>
                    </div>

                    <ol class="mt-3 grid gap-1.5 font-sans text-xs text-slate-600">
                      <li class="flex gap-2"><span class="font-bold text-qfcc-green">1.</span> Open your bank's Zelle app</li>
                      <li class="flex gap-2"><span class="font-bold text-qfcc-green">2.</span> Send <strong class="text-qfcc-green">${{ donationAmount }}</strong> to the email or phone above</li>
                      <li class="flex gap-2"><span class="font-bold text-qfcc-green">3.</span> Click "Confirm" below — we'll verify within 24 hours</li>
                    </ol>

                    <p class="mt-3 rounded-lg border border-amber-200 bg-amber-50 p-2.5 font-sans text-[11px] leading-relaxed text-amber-700">
                      ⚠️ <strong>Important:</strong> Zelle payments are irreversible. Please verify the recipient before sending.
                    </p>
                  </div>
                </Transition>

                <!-- Stripe info -->
                <Transition
                  enter-active-class="transition duration-200 ease-out"
                  enter-from-class="opacity-0 -translate-y-1"
                  enter-to-class="opacity-100 translate-y-0"
                >
                  <div
                    v-if="paymentMethod === 'stripe'"
                    class="mt-5 flex items-start gap-3 rounded-xl border border-blue-200 bg-blue-50 p-4"
                  >
                    <i class="fas fa-shield-alt text-blue-600 text-base mt-0.5"></i>
                    <p class="font-sans text-xs text-blue-800 leading-relaxed">
                      You'll be redirected to a secure Stripe checkout page to complete your payment.
                      Your card details are never stored on our servers.
                    </p>
                  </div>
                </Transition>

                <!-- Error -->
                <div
                  v-if="paymentError"
                  class="mt-4 flex items-start gap-2.5 p-3 rounded-lg bg-rose-50 border border-rose-200"
                >
                  <i class="fas fa-exclamation-circle text-rose-500 text-sm mt-0.5"></i>
                  <p class="font-sans text-xs text-rose-700">{{ paymentError }}</p>
                </div>
              </template>
            </div>

            <!-- Modal footer -->
            <div
              v-if="!paymentSuccess"
              class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row justify-end gap-2.5 flex-shrink-0"
            >
              <button
                type="button"
                @click="closePaymentModal"
                :disabled="isProcessing"
                class="px-5 py-2.5 bg-white text-slate-700 font-sans font-medium rounded-lg text-sm ring-1 ring-slate-200 hover:bg-slate-50 transition-all disabled:opacity-40 disabled:cursor-not-allowed"
              >
                Cancel
              </button>
              <button
                type="button"
                @click="confirmPayment"
                :disabled="isProcessing"
                :class="[
                  'px-6 py-2.5 font-sans font-semibold rounded-lg text-sm inline-flex items-center justify-center gap-2 transition-all',
                  isProcessing
                    ? 'bg-slate-300 text-slate-500 cursor-not-allowed'
                    : 'bg-qfcc-green text-white hover:bg-qfcc-deep'
                ]"
              >
                <i v-if="!isProcessing" class="fas fa-lock text-xs"></i>
                <i v-else class="fas fa-circle-notch fa-spin text-xs"></i>
                {{ isProcessing ? 'Processing…' : (paymentMethod === 'stripe' ? `Pay $${donationAmount}` : 'Confirm Zelle Payment') }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

/* ═══════════════════════════════════════════════════════════
   PROPS
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  campaign: { type: Object, required: true },
})

/* ═══════════════════════════════════════════════════════════
   FORM STATE — useForm gives us `form.errors` automatically
   ═══════════════════════════════════════════════════════════ */
const form = useForm({
  full_name: '',
  email: '',
  phone: '',
  note: '',
  amount: null,
  payment_method: 'stripe',
})

const selectedAmount = ref(20)
const customAmount = ref(null)
const statusMessage = ref('')

const donationAmount = computed(() => {
  const amount = selectedAmount.value ?? customAmount.value ?? 0
  return Number(amount) || 0
})

/* ═══════════════════════════════════════════════════════════
   PRESET SELECT
   ═══════════════════════════════════════════════════════════ */
function selectPreset(amount) {
  selectedAmount.value = amount
  customAmount.value = null
}

/* ═══════════════════════════════════════════════════════════
   PAYMENT MODAL STATE
   ═══════════════════════════════════════════════════════════ */
const showPaymentModal = ref(false)
const paymentMethod = ref('stripe')
const isProcessing = ref(false)
const paymentSuccess = ref(false)
const paymentError = ref('')
const successMessage = ref('')
const successReference = ref(null)
const referenceCopied = ref(false)

/* ═══════════════════════════════════════════════════════════
   OPEN MODAL
   ═══════════════════════════════════════════════════════════ */
function openPaymentModal() {
  form.clearErrors()

  // Basic validation
  if (!donationAmount.value || donationAmount.value < 1) {
    statusMessage.value = 'Please select or enter a donation amount.'
    return
  }
  if (!form.full_name || !form.full_name.trim()) {
    statusMessage.value = 'Please enter your name.'
    return
  }
  if (!form.email || !form.email.trim()) {
    statusMessage.value = 'Please enter your email.'
    return
  }

  statusMessage.value = ''
  paymentError.value = ''
  paymentSuccess.value = false
  successReference.value = null
  showPaymentModal.value = true
}

/* ═══════════════════════════════════════════════════════════
   CLOSE MODAL
   ═══════════════════════════════════════════════════════════ */
function closePaymentModal() {
  if (isProcessing.value) return
  showPaymentModal.value = false
  paymentError.value = ''
  paymentSuccess.value = false
}

function closePaymentModalAndReset() {
  showPaymentModal.value = false
  paymentSuccess.value = false
  paymentError.value = ''
  successReference.value = null
  successMessage.value = ''
  referenceCopied.value = false

  // Reset form via Inertia
  form.reset()

  // Reset local state
  selectedAmount.value = 20
  customAmount.value = null
  statusMessage.value = ''
}

/* ═══════════════════════════════════════════════════════════
   CONFIRM PAYMENT — uses useForm().post() with onSuccess/onError
   ═══════════════════════════════════════════════════════════ */
function confirmPayment() {
  paymentError.value = ''
  isProcessing.value = true

  // Attach the current values
  form.amount = donationAmount.value
  form.payment_method = paymentMethod.value

  form.post(route('donate.store', props.campaign.slug), {
    preserveScroll: true,
    preserveState: true,

    onSuccess: (page) => {
      isProcessing.value = false

      const data = page.props?.flash?.donation || page.props?.donation || null

      // Handle both flash-based and inline responses
      const checkoutUrl = page.props?.checkout_url || data?.checkout_url
      const reference   = data?.reference || page.props?.flash?.reference
      const message     = data?.message   || page.props?.flash?.message

      // ─── Stripe: redirect ───
      if (paymentMethod.value === 'stripe' && checkoutUrl) {
        window.location.href = checkoutUrl
        return
      }

      // ─── Zelle: show success modal ───
      paymentSuccess.value = true
      successMessage.value = message || 'Your donation has been recorded successfully.'
      successReference.value = reference || null
    },

    onError: (errors) => {
      isProcessing.value = false
      paymentError.value = Object.values(errors)[0] || 'Payment could not be processed. Please try again.'
    },

    onFinish: () => {
      isProcessing.value = false
    },
  })
}

/* ═══════════════════════════════════════════════════════════
   COPY REFERENCE
   ═══════════════════════════════════════════════════════════ */
function copyReference() {
  if (!successReference.value) return

  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(successReference.value)
      .then(() => {
        referenceCopied.value = true
        setTimeout(() => (referenceCopied.value = false), 2000)
      })
      .catch(() => fallbackCopy(successReference.value))
  } else {
    fallbackCopy(successReference.value)
  }
}

function fallbackCopy(text) {
  const textarea = document.createElement('textarea')
  textarea.value = text
  textarea.style.position = 'fixed'
  textarea.style.opacity = '0'
  document.body.appendChild(textarea)
  textarea.select()
  try {
    document.execCommand('copy')
    referenceCopied.value = true
    setTimeout(() => (referenceCopied.value = false), 2000)
  } catch (e) {
    console.error('Copy failed', e)
  }
  document.body.removeChild(textarea)
}

/* ═══════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════ */
function formatMoney(amount) {
  if (amount === null || amount === undefined) return '0'
  return Number(amount).toLocaleString('en-US', {
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  })
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Serif+Bengali:wght@500;600;700;800&display=swap');

.font-bengali { font-family: 'Noto Serif Bengali', Georgia, serif; }
.font-sans    { font-family: 'Noto Sans Bengali', Arial, sans-serif; }

.text-qfcc-green { color: #008d49; }
.text-qfcc-deep  { color: #003d2c; }
.text-qfcc-gold  { color: #d9a52b; }
.bg-qfcc-green   { background-color: #008d49; }
.bg-qfcc-deep    { background-color: #003d2c; }
.bg-qfcc-mist    { background-color: #f3f7f4; }
.border-qfcc-green { border-color: #008d49; }

.hero-glow {
  background:
    radial-gradient(circle at 18% 45%, rgba(217, 165, 43, 0.25), transparent 25%),
    linear-gradient(100deg, rgba(0, 61, 44, 0.98), rgba(0, 61, 44, 0.68) 55%, rgba(0, 61, 44, 0.9));
}

.donation-shell {
  background: linear-gradient(135deg, #f4f8f2 0%, #fffdf8 48%, #eef5ef 100%);
}

.donation-card {
  border: 1px solid rgba(0, 61, 44, 0.1);
  box-shadow: 0 18px 50px rgba(0, 66, 47, 0.12);
}

.instruction-panel {
  background: linear-gradient(135deg, #008d49, #006f40);
  box-shadow: inset 0 1px rgba(255, 255, 255, 0.18);
}

.amount-button.is-selected {
  border-color: #008d49;
  background: #008d49;
  color: white;
  box-shadow: 0 8px 18px rgba(0, 141, 73, 0.2);
}

.amount-button:focus-visible,
input:focus-visible {
  outline: 3px solid rgba(217, 165, 43, 0.45);
  outline-offset: 2px;
}

.feature-card {
  border: 1px solid rgba(0, 61, 44, 0.09);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.feature-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 14px 28px rgba(0, 66, 47, 0.1);
}

.shadow-soft { box-shadow: 0 8px 26px rgba(0, 66, 47, 0.09); }

@media (max-width: 640px) {
  .hero-title { font-size: 2rem; }
  .donation-card { border-radius: 1rem; }
}
</style>