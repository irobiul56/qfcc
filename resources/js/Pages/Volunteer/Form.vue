<template>
  <AppLayout title="Volunteer Application">
    <div class="min-h-screen w-full flex items-start justify-center p-4 mt-10 md:p-6 lg:p-8 bg-slate-50">
      <div class="w-full max-w-5xl bg-white rounded-2xl ring-1 ring-slate-200/80 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06),0_2px_6px_-2px_rgba(15,23,42,0.04)] p-6 md:p-10 lg:p-12">

        <!-- Header -->
        <div class="mb-14 text-center">
          <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
            Queens Family &amp; Community Center
          </h1>
          <p class="text-emerald-600 font-medium text-sm md:text-base mt-3">
            Volunteer Application Form
          </p>
          <p class="text-slate-500 text-xs md:text-sm mt-3 max-w-xl mx-auto leading-relaxed">
            Thank you for your interest in volunteering! Please fill out the form below and our team will be in touch.
          </p>
        </div>

        <!-- Success flash -->
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="opacity-0 -translate-y-2"
          enter-to-class="opacity-100 translate-y-0"
        >
          <div v-if="$page.props.flash?.success"
               class="mb-10 p-4 rounded-xl bg-emerald-50 ring-1 ring-emerald-200/70 text-emerald-700 text-sm font-medium flex items-center gap-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ $page.props.flash.success }}
          </div>
        </Transition>

        <form @submit.prevent="submit">

          <!-- 1. Personal Information -->
          <section class="mb-14">
            <SectionTitle number="1" title="Personal Information" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="lg:col-span-2">
                <label class="label-text">Full Name <span class="text-rose-400">*</span></label>
                <input v-model="form.full_name" type="text" class="input-field" placeholder="e.g., Jane Doe" />
                <p v-if="form.errors.full_name" class="text-rose-500 text-xs mt-2">{{ form.errors.full_name }}</p>
              </div>
              <div>
                <label class="label-text">Email <span class="text-rose-400">*</span></label>
                <input v-model="form.email" type="email" class="input-field" placeholder="you@example.com" />
                <p v-if="form.errors.email" class="text-rose-500 text-xs mt-2">{{ form.errors.email }}</p>
              </div>
              <div>
                <label class="label-text">Phone <span class="text-rose-400">*</span></label>
                <input v-model="form.phone" type="tel" class="input-field" placeholder="(123) 456-7890" />
                <p v-if="form.errors.phone" class="text-rose-500 text-xs mt-2">{{ form.errors.phone }}</p>
              </div>
              <div class="md:col-span-2 lg:col-span-3">
                <label class="label-text">Address</label>
                <input v-model="form.address" type="text" class="input-field" placeholder="Street address, apartment, etc." />
              </div>
              <div>
                <label class="label-text">City</label>
                <input v-model="form.city" type="text" class="input-field" placeholder="City" />
              </div>
              <div>
                <label class="label-text">State</label>
                <input v-model="form.state" type="text" class="input-field" placeholder="State" />
              </div>
              <div>
                <label class="label-text">ZIP Code</label>
                <input v-model="form.zip_code" type="text" class="input-field" placeholder="ZIP" />
              </div>
            </div>
          </section>

          <!-- 2. Areas of Interest -->
          <section class="mb-14">
            <SectionTitle number="2" title="Areas of Interest" />
            <p class="text-xs text-slate-500 -mt-3 mb-5">Select all the areas you're interested in volunteering for.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
              <label v-for="interest in interestOptions" :key="interest.value"
                     :class="[
                       'relative rounded-xl p-5 block cursor-pointer border transition-all duration-200',
                       form.interests.includes(interest.value)
                         ? 'border-emerald-400 bg-emerald-50/40 ring-1 ring-emerald-300/40'
                         : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50/50'
                     ]">
                <input type="checkbox" :value="interest.value" v-model="form.interests" class="sr-only" />

                <div :class="[
                       'absolute top-4 right-4 w-5 h-5 rounded-md border-2 flex items-center justify-center transition-all',
                       form.interests.includes(interest.value)
                         ? 'border-emerald-500 bg-emerald-500'
                         : 'border-slate-300 bg-white'
                     ]">
                  <svg v-if="form.interests.includes(interest.value)" xmlns="http://www.w3.org/2000/svg"
                       class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                </div>

                <div class="flex items-start gap-4">
                  <div :class="['w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0', interest.iconBg]">
                    <span :class="['text-base', interest.iconColor]">{{ interest.icon }}</span>
                  </div>
                  <div class="flex-1 pr-6">
                    <h3 class="text-sm font-semibold text-slate-900">{{ interest.title }}</h3>
                    <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">{{ interest.description }}</p>
                  </div>
                </div>
              </label>
            </div>
          </section>

          <!-- 3. Availability -->
          <section class="mb-14">
            <SectionTitle number="3" title="Availability" />
            <p class="text-xs text-slate-500 -mt-3 mb-5">Select all the days and times that work for you.</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3">
              <button
                v-for="slot in availabilitySlots"
                :key="slot"
                type="button"
                @click="toggleAvailability(slot)"
                :class="[
                  'px-4 py-3 rounded-lg text-xs font-semibold ring-1 transition-all flex items-center justify-between gap-2',
                  form.availability.includes(slot)
                    ? 'bg-emerald-50 text-emerald-700 ring-emerald-300'
                    : 'bg-white text-slate-600 ring-slate-200 hover:bg-slate-50 hover:ring-slate-300'
                ]"
              >
                <span>{{ slot }}</span>
                <svg v-if="form.availability.includes(slot)"
                     xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500 flex-shrink-0"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </button>
            </div>
            <p v-if="form.availability.length > 0" class="text-[11px] text-slate-500 mt-3">
              Selected: <span class="font-semibold text-emerald-600">{{ form.availability.length }}</span> slot{{ form.availability.length === 1 ? '' : 's' }}
            </p>
          </section>

          <!-- 4. Skills & Message -->
          <section class="mb-14">
            <SectionTitle number="4" title="Skills & Message" />
            <div class="space-y-6">
              <div>
                <label class="label-text">Relevant Skills</label>
                <textarea v-model="form.skills" rows="3" class="input-field resize-y"
                          placeholder="e.g., Event planning, teaching, social media, translation, driving..."></textarea>
              </div>
              <div>
                <label class="label-text">Message / Motivation</label>
                <textarea v-model="form.message" rows="4" class="input-field resize-y"
                          placeholder="Tell us why you'd like to volunteer with QFCC and anything else you'd like us to know..."></textarea>
              </div>
            </div>
          </section>

          <!-- Action Buttons -->
          <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-10 border-t border-slate-100">
            <button type="button" @click="reset"
                    class="px-6 py-3 bg-white text-slate-600 font-medium rounded-lg text-sm flex items-center justify-center gap-2 ring-1 ring-slate-200 hover:bg-slate-50 hover:ring-slate-300 transition-all">
              Reset Form
            </button>
            <button type="submit" :disabled="form.processing"
                    class="px-7 py-3 bg-emerald-600 text-white font-semibold rounded-lg text-sm flex items-center justify-center gap-2 shadow-sm shadow-emerald-500/20 hover:bg-emerald-700 hover:shadow-md hover:shadow-emerald-500/25 active:scale-[0.99] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
              <svg v-if="!form.processing" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              {{ form.processing ? 'Submitting...' : 'Submit Application' }}
            </button>
          </div>
        </form>

        <div class="mt-10 pt-6 border-t border-slate-100 text-center">
          <p class="text-[11px] text-slate-400 tracking-wide">
            QFCC Volunteer Form · All information will be kept confidential.
          </p>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
    >
      <div v-if="showSuccessModal"
           class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 p-8 text-center">
          <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-slate-900 mb-2">Application Received!</h3>
          <p class="text-sm text-slate-500 leading-relaxed mb-6">
            {{ $page.props.flash?.success || 'Thank you for applying to volunteer with QFCC. Our team will review your application and contact you within a few days.' }}
          </p>
          <button type="button" @click="finish"
                  class="w-full px-5 py-3 bg-emerald-600 text-white font-semibold rounded-lg text-sm hover:bg-emerald-700 transition-all">
            Done
          </button>
        </div>
      </div>
    </Transition>
  </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { h, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

/* --- SectionTitle --- */
const SectionTitle = (props) =>
  h('div', { class: 'flex items-center gap-3 mb-6' }, [
    h('span', {
      class: 'inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 text-[11px] font-bold ring-1 ring-emerald-100 flex-shrink-0'
    }, props.number),
    h('span', { class: 'text-[15px] md:text-base font-semibold text-slate-800 tracking-tight' }, props.title),
    h('span', { class: 'flex-1 h-px bg-slate-100' })
  ])
SectionTitle.props = ['number', 'title']

/* --- Interest options --- */
const interestOptions = [
  { value: 'Event Support',       title: 'Event Support',       description: 'Help organize and run community events.',        icon: '🎉', iconBg: 'bg-pink-50 ring-1 ring-pink-100',       iconColor: 'text-pink-600' },
  { value: 'Teaching & Tutoring', title: 'Teaching & Tutoring', description: 'Assist with educational programs and classes.',  icon: '📚', iconBg: 'bg-indigo-50 ring-1 ring-indigo-100',   iconColor: 'text-indigo-600' },
  { value: 'Fundraising',         title: 'Fundraising',         description: 'Support donor outreach and campaigns.',          icon: '💝', iconBg: 'bg-rose-50 ring-1 ring-rose-100',       iconColor: 'text-rose-600' },
  { value: 'Food Distribution',   title: 'Food Distribution',   description: 'Help with food drives and meal programs.',       icon: '🍎', iconBg: 'bg-orange-50 ring-1 ring-orange-100',   iconColor: 'text-orange-600' },
  { value: 'Administrative',      title: 'Administrative',      description: 'Office help, data entry, and coordination.',     icon: '📋', iconBg: 'bg-sky-50 ring-1 ring-sky-100',         iconColor: 'text-sky-600' },
  { value: 'Community Outreach',  title: 'Community Outreach',  description: 'Connect with local families and partners.',      icon: '🤝', iconBg: 'bg-emerald-50 ring-1 ring-emerald-100', iconColor: 'text-emerald-600' },
]

/* --- Availability slots --- */
const availabilitySlots = [
  'Mon AM', 'Mon PM',
  'Tue AM', 'Tue PM',
  'Wed AM', 'Wed PM',
  'Thu AM', 'Thu PM',
  'Fri AM', 'Fri PM',
  'Sat AM', 'Sat PM',
  'Sun AM', 'Sun PM',
  'Flexible',
]

/* --- Form state --- */
const getInitialForm = () => ({
  full_name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  zip_code: '',
  interests: [],
  availability: [],
  skills: '',
  message: '',
})

const form = useForm(getInitialForm())
const showSuccessModal = ref(false)

function toggleAvailability(slot) {
  const idx = form.availability.indexOf(slot)
  if (idx > -1) form.availability.splice(idx, 1)
  else form.availability.push(slot)
}

function submit() {
  form.post(route('volunteer.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showSuccessModal.value = true
      form.reset()
    },
  })
}

function finish() {
  showSuccessModal.value = false
  window.location.href = route('volunteer.create')
}

function reset() {
  form.defaults(getInitialForm())
  form.reset()
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

* { font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif; }

.label-text {
  display: block;
  font-size: 0.6875rem;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 0.625rem;
}

.input-field {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  color: #0f172a;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.input-field::placeholder { color: #94a3b8; }
.input-field:hover { border-color: #cbd5e1; }
.input-field:focus {
  border-color: #34d399;
  box-shadow: 0 0 0 3px rgba(52, 211, 153, 0.15);
  outline: none;
}
</style>