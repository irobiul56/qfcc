<template>
  <AppLayout title="Membership Application Form">
    <div class="min-h-screen flex items-start justify-center p-4 mt-10 md:p-6 lg:p-8 bg-slate-50">
      <div class="w-full max-w-5xl bg-white rounded-2xl ring-1 ring-slate-200/80 shadow-[0_4px_20px_-4px_rgba(15,23,42,0.06),0_2px_6px_-2px_rgba(15,23,42,0.04)] p-6 md:p-10 lg:p-12">

        <!-- Header -->
        <div class="mb-14 text-center">
          <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
            Queens Family &amp; Community Center
          </h1>
          <p class="text-indigo-600 font-medium text-sm md:text-base mt-3">
            Membership Application Form
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

        <form @submit.prevent="openPaymentModal">

          <!-- Membership Type -->
          <section class="mb-14">
            <SectionTitle number="★" title="Membership Type" />
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <label v-for="plan in membershipPlans" :key="plan.value"
                     :class="[
                       'relative rounded-xl p-6 block cursor-pointer border transition-all duration-200',
                       form.membership_type === plan.value
                         ? 'border-indigo-400 bg-indigo-50/40 ring-1 ring-indigo-300/40'
                         : 'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50/50'
                     ]">
                <input type="radio" name="membership_type" :value="plan.value" v-model="form.membership_type" class="sr-only" />

                <div :class="[
                       'absolute top-5 right-5 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-all',
                       form.membership_type === plan.value
                         ? 'border-indigo-500 bg-indigo-500'
                         : 'border-slate-300 bg-white'
                     ]">
                  <svg v-if="form.membership_type === plan.value" xmlns="http://www.w3.org/2000/svg"
                       class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                  </svg>
                </div>

                <div class="flex items-start gap-4">
                  <div :class="['w-11 h-11 rounded-lg flex items-center justify-center flex-shrink-0', plan.iconBg]">
                    <span :class="['text-base', plan.iconColor]">{{ plan.icon }}</span>
                  </div>
                  <div class="flex-1 pr-8">
                    <h3 class="text-[15px] font-semibold text-slate-900">{{ plan.title }}</h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ plan.description }}</p>
                    <div class="flex items-baseline gap-1.5 mt-4">
                      <span class="text-lg font-bold text-slate-900">${{ plan.price }}</span>
                      <span class="text-[11px] font-medium text-slate-400">{{ plan.period }}</span>
                    </div>
                  </div>
                </div>
              </label>
            </div>
            <p v-if="form.errors.membership_type" class="text-rose-500 text-xs mt-3">{{ form.errors.membership_type }}</p>
          </section>

          <!-- 1. Personal Information -->
          <section class="mb-14 mt-5">
            <SectionTitle number="1" title="Personal Information" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div class="lg:col-span-2">
                <label class="label-text">Full Name <span class="text-rose-400">*</span></label>
                <input v-model="form.full_name" type="text" class="input-field" placeholder="e.g., John Michael Doe" />
                <p v-if="form.errors.full_name" class="text-rose-500 text-xs mt-2">{{ form.errors.full_name }}</p>
              </div>
              <div>
                <label class="label-text">Date of Birth</label>
                <input v-model="form.dob" type="date" class="input-field" />
              </div>
              <div>
                <label class="label-text">Gender</label>
                <select v-model="form.gender" class="input-field">
                  <option value="">Select gender</option>
                  <option>Female</option>
                  <option>Male</option>
                  <option>Non-binary</option>
                  <option>Prefer not to say</option>
                </select>
              </div>
              <div>
                <label class="label-text">Marital Status</label>
                <select v-model="form.marital_status" class="input-field">
                  <option value="">Select status</option>
                  <option>Single</option>
                  <option>Married</option>
                  <option>Divorced</option>
                  <option>Widowed</option>
                  <option>Domestic Partnership</option>
                </select>
              </div>
              <div>
                <label class="label-text">Occupation</label>
                <input v-model="form.occupation" type="text" class="input-field" placeholder="e.g., Educator" />
              </div>
              <div class="md:col-span-2 lg:col-span-3">
                <label class="label-text">Address</label>
                <input v-model="form.address" type="text" class="input-field" placeholder="Street address, P.O. Box, etc." />
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
                <input v-model="form.zip" type="text" class="input-field" placeholder="ZIP" />
              </div>
              <div>
                <label class="label-text">Phone</label>
                <input v-model="form.phone" type="tel" class="input-field" placeholder="(123) 456-7890" />
              </div>
              <div class="md:col-span-2">
                <label class="label-text">Email</label>
                <input v-model="form.email" type="email" class="input-field" placeholder="you@example.com" />
              </div>
              <div class="md:col-span-2 lg:col-span-3">
                <label class="label-text">Skills / Experience</label>
                <textarea v-model="form.skills" rows="3" class="input-field resize-y" placeholder="Any relevant skills, volunteer experience, or interests..."></textarea>
              </div>
            </div>
          </section>

          <!-- 2. Family Information -->
          <section class="mb-14">
            <SectionTitle number="2" title="Family Information" />
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
              <div class="md:col-span-2">
                <label class="label-text">Spouse's Full Name</label>
                <input v-model="form.spouse_name" type="text" class="input-field" placeholder="Spouse's full name" />
              </div>
              <div>
                <label class="label-text">Spouse's DOB</label>
                <input v-model="form.spouse_dob" type="date" class="input-field" />
              </div>
              <div class="md:col-span-3">
                <label class="label-text">Spouse's Occupation</label>
                <input v-model="form.spouse_occupation" type="text" class="input-field" placeholder="Spouse's occupation" />
              </div>
            </div>

            <div>
              <div class="flex flex-wrap items-center justify-between gap-6 mb-5">
                <div class="flex items-center gap-2.5">
                  <p class="text-sm font-semibold text-slate-700">Children</p>
                  <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-2 rounded-full bg-indigo-50 text-indigo-600 text-[11px] font-bold ring-1 ring-indigo-100">
                    {{ form.children.length }}
                  </span>
                  <span class="text-[11px] text-slate-400 hidden sm:inline">Max 10</span>
                </div>
                <button
                  type="button"
                  @click="addChild"
                  :disabled="form.children.length >= 10"
                  class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white text-indigo-600 text-xs font-semibold ring-1 ring-indigo-200 hover:bg-indigo-50 hover:ring-indigo-300 transition-all disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                  </svg>
                  Add Child
                </button>
              </div>

              <div v-if="form.children.length === 0"
                   class="p-10 text-center rounded-xl bg-slate-50/70 ring-1 ring-slate-200/60">
                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
                <p class="text-sm text-slate-500 font-medium">No children added yet</p>
                <p class="text-xs text-slate-400 mt-1.5">Click "Add Child" to include your children's details</p>
              </div>

              <div class="space-y-5">
                <div v-for="(child, index) in form.children" :key="index"
                     class="group relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-5 gap-y-6 p-5 rounded-xl bg-slate-50/70 ring-1 ring-slate-200/60 transition-all hover:bg-slate-50 hover:ring-slate-300/60">

                  <button
                    type="button"
                    @click="removeChild(index)"
                    class="absolute top-3 right-3 w-6 h-6 rounded-full bg-white ring-1 ring-slate-200 flex items-center justify-center text-slate-400 opacity-0 group-hover:opacity-100 hover:text-rose-500 hover:ring-rose-200 hover:bg-rose-50 transition-all"
                    :title="`Remove child ${index + 1}`"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>

                  <div class="sm:col-span-2 lg:col-span-1">
                    <label class="label-text">Full Name</label>
                    <input v-model="child.fullName" type="text" class="input-field" :placeholder="`Child ${index + 1} name`" />
                  </div>
                  <div>
                    <label class="label-text">DOB</label>
                    <input v-model="child.dob" type="date" class="input-field" />
                  </div>
                  <div>
                    <label class="label-text">Gender</label>
                    <select v-model="child.gender" class="input-field">
                      <option value="">Select</option>
                      <option>Female</option>
                      <option>Male</option>
                      <option>Other</option>
                    </select>
                  </div>
                  <div>
                    <label class="label-text">Occupation</label>
                    <input v-model="child.occupation" type="text" class="input-field" placeholder="Student, etc." />
                  </div>
                </div>
              </div>

              <p v-if="form.children.length >= 10" class="text-[11px] text-amber-600 mt-3 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Maximum of 10 children reached. Please use the back of the page for additional entries.
              </p>
            </div>
          </section>

          <!-- 3. Emergency Contact -->
          <section class="mb-14 mt-5">
            <SectionTitle number="3" title="Emergency Contact" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
              <div>
                <label class="label-text">Name</label>
                <input v-model="form.emergency_name" type="text" class="input-field" placeholder="Contact name" />
              </div>
              <div>
                <label class="label-text">Relationship</label>
                <input v-model="form.emergency_relationship" type="text" class="input-field" placeholder="e.g., Sister, Friend" />
              </div>
              <div>
                <label class="label-text">Phone</label>
                <input v-model="form.emergency_phone" type="tel" class="input-field" placeholder="(123) 456-7890" />
              </div>
              <div>
                <label class="label-text">Email</label>
                <input v-model="form.emergency_email" type="email" class="input-field" placeholder="contact@example.com" />
              </div>
            </div>
          </section>

          <!-- 4. Member Declaration -->
          <section class="mb-14 mt-5">
            <SectionTitle number="4" title="Member Declaration" />
            <div class="p-6 md:p-7 rounded-xl bg-slate-50 ring-1 ring-slate-200/70">
              <div class="flex items-start gap-4">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed">
                  I hereby apply for membership in Queens Family and Community Center (QFCC). I agree to uphold the mission, values, policies and objectives of the organization and conduct myself respectfully while participating in its programs and activities.
                </p>
              </div>
            </div>
          </section>

          <!-- Action Buttons -->
          <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-10 border-t border-slate-100 mt-5">
            <button type="button" @click="reset"
                    class="px-6 py-3 bg-white text-slate-600 font-medium rounded-lg text-sm flex items-center justify-center gap-2 ring-1 ring-slate-200 hover:bg-slate-50 hover:ring-slate-300 transition-all">
              Reset Form
            </button>
            <button type="submit" :disabled="isSubmitting"
                    class="px-7 py-3 bg-indigo-600 text-white font-semibold rounded-lg text-sm flex items-center justify-center gap-2 shadow-sm shadow-indigo-500/20 hover:bg-indigo-700 hover:shadow-md hover:shadow-indigo-500/25 active:scale-[0.99] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
              <svg v-if="!isSubmitting" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              <svg v-else class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              {{ isSubmitting ? 'Submitting...' : 'Submit & Continue to Payment' }}
            </button>
          </div>
        </form>

        <div class="mt-10 pt-6 border-t border-slate-100 text-center">
          <p class="text-[11px] text-slate-400 tracking-wide">
            QFCC Membership Form · All information provided will be kept confidential.
          </p>
        </div>
      </div>
    </div>

    <!-- ============================================= -->
    <!-- PAYMENT MODAL                                  -->
    <!-- ============================================= -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showPaymentModal"
           class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
           @click.self="closePaymentModal">
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div v-if="showPaymentModal"
               class="w-full max-w-lg bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden max-h-[90vh] flex flex-col">

            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
              <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-500 flex items-center justify-center text-white shadow-sm shadow-indigo-500/30">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                  </svg>
                </div>
                <div>
                  <h2 class="text-base font-semibold text-slate-900">Complete Payment</h2>
                  <p class="text-[11px] text-slate-500">Choose your preferred payment method</p>
                </div>
              </div>
              <button @click="closePaymentModal"
                      class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Modal Body (scrollable) -->
            <div class="p-6 overflow-y-auto flex-1">

              <!-- Loading state -->
              <div v-if="isSubmitting" class="text-center py-10">
                <svg class="animate-spin h-8 w-8 mx-auto text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <p class="text-sm text-slate-500 mt-4">Saving your application...</p>
              </div>

              <template v-else-if="membershipId">

                <!-- Order Summary -->
                <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70 mb-6">
                  <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Order Summary</span>
                    <span class="text-[11px] font-medium text-slate-400">Ref #{{ membershipId }}</span>
                  </div>
                  <div class="flex items-center justify-between py-2 border-t border-slate-200/70">
                    <span class="text-sm text-slate-700">{{ form.membership_type }}</span>
                    <span class="text-sm font-semibold text-slate-900">${{ selectedPlan?.price }}.00</span>
                  </div>
                  <div class="flex items-center justify-between pt-3 mt-1 border-t border-slate-200/70">
                    <span class="text-sm font-semibold text-slate-900">Total Due</span>
                    <span class="text-lg font-bold text-indigo-600">${{ selectedPlan?.price }}.00</span>
                  </div>
                </div>

                <!-- Payment Method Tabs -->
                <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl mb-6">
                  <button type="button" @click="paymentMethod = 'stripe'"
                          :class="[
                            'py-2.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-2',
                            paymentMethod === 'stripe'
                              ? 'bg-white text-indigo-600 shadow-sm'
                              : 'text-slate-500 hover:text-slate-700'
                          ]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Card (Stripe)
                  </button>
                  <button type="button" @click="paymentMethod = 'zelle'"
                          :class="[
                            'py-2.5 rounded-lg text-xs font-semibold transition-all flex items-center justify-center gap-2',
                            paymentMethod === 'zelle'
                              ? 'bg-white text-indigo-600 shadow-sm'
                              : 'text-slate-500 hover:text-slate-700'
                          ]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Zelle
                  </button>
                </div>

                <!-- Stripe Card Form -->
                <div v-if="paymentMethod === 'stripe'" class="space-y-5">
                  <div>
                    <label class="label-text">Card Number</label>
                    <div class="relative">
                      <input v-model="card.number" type="text" maxlength="19"
                             @input="formatCardNumber"
                             class="input-field pl-10"
                             placeholder="1234 5678 9012 3456" />
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                      </svg>
                    </div>
                    <!-- Card brand indicator -->
                    <p v-if="cardBrand" class="text-[11px] text-slate-500 mt-1.5 flex items-center gap-1.5">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      Detected: <span class="font-semibold text-slate-700">{{ cardBrand }}</span>
                    </p>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div>
                      <label class="label-text">Expiry</label>
                      <input v-model="card.expiry" type="text" maxlength="5"
                             @input="formatExpiry"
                             class="input-field"
                             placeholder="MM/YY" />
                    </div>
                    <div>
                      <label class="label-text">CVC</label>
                      <input v-model="card.cvc" type="text" maxlength="4"
                             class="input-field"
                             placeholder="123" />
                    </div>
                  </div>
                  <div>
                    <label class="label-text">Name on Card</label>
                    <input v-model="card.name" type="text" class="input-field" placeholder="John M. Doe" />
                  </div>

                  <div class="flex items-start gap-2 pt-2 text-[11px] text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Your payment is secured with 256-bit SSL encryption. Powered by Stripe.</span>
                  </div>
                </div>

                <!-- Zelle Instructions -->
                <div v-else class="space-y-4">
                  <div class="p-5 rounded-xl bg-gradient-to-br from-purple-50 to-indigo-50 ring-1 ring-purple-200/60">
                    <div class="flex items-center gap-2 mb-4">
                      <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center text-white text-xs font-bold">Z</div>
                      <span class="text-sm font-bold text-slate-900">Pay via Zelle</span>
                    </div>

                    <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                      Send the exact amount to the Zelle account below, then confirm your payment.
                    </p>

                    <div class="space-y-2.5">
                      <div class="flex items-center justify-between py-2.5 px-3.5 rounded-lg bg-white ring-1 ring-slate-200/70">
                        <div>
                          <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Zelle Email</p>
                          <p class="text-sm font-semibold text-slate-900 mt-0.5"> mailtoqfcc@gmail.com</p>
                        </div>
                        <button type="button" @click="copyZelle"
                                class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                          </svg>
                          {{ copied ? 'Copied!' : 'Copy' }}
                        </button>
                      </div>
                      <div class="flex items-center justify-between py-2.5 px-3.5 rounded-lg bg-white ring-1 ring-slate-200/70">
                        <div>
                          <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Amount</p>
                          <p class="text-sm font-semibold text-slate-900 mt-0.5">${{ selectedPlan?.price }}.00</p>
                        </div>
                      </div>
                      <div class="flex items-center justify-between py-2.5 px-3.5 rounded-lg bg-white ring-1 ring-slate-200/70">
                        <div>
                          <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Memo / Note</p>
                          <p class="text-sm font-semibold text-slate-900 mt-0.5">QFCC #{{ membershipId }}</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="p-4 rounded-xl bg-amber-50 ring-1 ring-amber-200/70">
                    <div class="flex items-start gap-2.5">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                      </svg>
                      <p class="text-[11px] text-amber-700 leading-relaxed">
                        Your membership will be activated once we verify your Zelle payment (usually within 24 hours). You'll receive a confirmation email.
                      </p>
                    </div>
                  </div>
                </div>

                <!-- Error message -->
                <div v-if="paymentError" class="mt-4 p-3 rounded-lg bg-rose-50 ring-1 ring-rose-200/70">
                  <p class="text-xs text-rose-600 font-medium">{{ paymentError }}</p>
                </div>
              </template>
            </div>

            <!-- Modal Footer -->
            <div v-if="!isSubmitting && membershipId" class="px-6 py-4 border-t border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row justify-end gap-2.5 flex-shrink-0">
              <button type="button" @click="closePaymentModal"
                      class="px-5 py-2.5 bg-white text-slate-600 font-medium rounded-lg text-xs ring-1 ring-slate-200 hover:bg-slate-100 transition-all">
                Cancel
              </button>
              <button type="button" @click="confirmPayment" :disabled="processingPayment"
                      class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg text-xs flex items-center justify-center gap-2 shadow-sm shadow-indigo-500/20 hover:bg-indigo-700 active:scale-[0.99] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <svg v-if="!processingPayment" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <svg v-else class="animate-spin h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                {{ processingPayment ? 'Processing...' : (paymentMethod === 'stripe' ? 'Pay $' + selectedPlan?.price + '.00' : 'I Have Sent Payment') }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>

    <!-- ============================================= -->
    <!-- SUCCESS MODAL (with transaction reference)     -->
    <!-- ============================================= -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="showSuccessModal"
           class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
           @click.self="closeSuccessModal">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden text-center p-8">

          <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
          </div>

          <h3 class="text-xl font-bold text-slate-900 mb-2">Payment Successful!</h3>
          <p class="text-sm text-slate-500 leading-relaxed mb-6">{{ successMessage }}</p>

          <!-- Transaction Reference Box -->
          <div class="p-4 rounded-xl bg-slate-50 ring-1 ring-slate-200/70 mb-6 text-left">
            <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1">Transaction Reference</p>
            <div class="flex items-center justify-between gap-3">
              <p class="text-sm font-bold text-slate-900 font-mono">{{ transactionReference }}</p>
              <button type="button" @click="copyReference"
                      class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                {{ refCopied ? 'Copied!' : 'Copy' }}
              </button>
            </div>
          </div>

          <div class="flex flex-col sm:flex-row gap-2.5">
            <button type="button" @click="downloadReceipt"
                    class="flex-1 px-5 py-2.5 bg-white text-slate-600 font-medium rounded-lg text-xs ring-1 ring-slate-200 hover:bg-slate-50 transition-all">
              Download Receipt
            </button>
            <button type="button" @click="finishAndReset"
                    class="flex-1 px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg text-xs hover:bg-indigo-700 transition-all">
              Done
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { h, ref, reactive, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

/* --- SectionTitle inline component --- */
const SectionTitle = (props) =>
  h('div', { class: 'flex items-center gap-3 mb-6' }, [
    h('span', {
      class: 'inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 text-[11px] font-bold ring-1 ring-indigo-100 flex-shrink-0'
    }, props.number),
    h('span', { class: 'text-[15px] md:text-base font-semibold text-slate-800 tracking-tight' }, props.title),
    h('span', { class: 'flex-1 h-px bg-slate-100' })
  ])
SectionTitle.props = ['number', 'title']

/* --- Membership plans --- */
const membershipPlans = [
  {
    value: 'General Member',
    title: 'General Member',
    description: 'Annual membership with full access to programs and activities.',
    price: '100',
    period: '/ year',
    icon: '👤',
    iconBg: 'bg-indigo-50 ring-1 ring-indigo-100',
    iconColor: 'text-indigo-600'
  },
  {
    value: 'Lifetime Member',
    title: 'Lifetime Member',
    description: 'One-time payment for permanent membership and exclusive benefits.',
    price: '300',
    period: 'one-time',
    icon: '★',
    iconBg: 'bg-amber-50 ring-1 ring-amber-100',
    iconColor: 'text-amber-500'
  }
]

const selectedPlan = computed(() =>
  membershipPlans.find(p => p.value === form.membership_type)
)

/* --- Form state --- */
const emptyChild = () => ({ fullName: '', dob: '', gender: '', occupation: '' })

const getInitialForm = () => ({
  membership_type: '',
  full_name: '', dob: '', gender: '', marital_status: '', occupation: '',
  address: '', city: '', state: '', zip: '', phone: '', email: '', skills: '',
  spouse_name: '', spouse_dob: '', spouse_occupation: '',
  children: [ emptyChild(), emptyChild(), emptyChild() ],
  emergency_name: '', emergency_relationship: '', emergency_phone: '', emergency_email: ''
})

const form = useForm(getInitialForm())

/* --- Modal state --- */
const showPaymentModal = ref(false)
const showSuccessModal = ref(false)
const isSubmitting = ref(false)
const membershipId = ref(null)
const paymentMethod = ref('stripe')
const processingPayment = ref(false)
const paymentError = ref('')
const copied = ref(false)

/* --- Success modal state --- */
const transactionReference = ref('')
const successMessage = ref('')
const refCopied = ref(false)

const card = reactive({
  number: '',
  expiry: '',
  cvc: '',
  name: ''
})

/* --- Card brand detection (computed) --- */
const cardBrand = computed(() => {
  const n = card.number.replace(/\s/g, '')
  if (!n) return ''
  if (/^4/.test(n)) return 'Visa'
  if (/^5[1-5]/.test(n)) return 'Mastercard'
  if (/^3[47]/.test(n)) return 'American Express'
  if (/^6(?:011|5)/.test(n)) return 'Discover'
  if (/^3(?:0[0-5]|[68])/.test(n)) return 'Diners Club'
  if (/^35/.test(n)) return 'JCB'
  return 'Card'
})

/* --- Children management --- */
function addChild() {
  if (form.children.length >= 10) return
  form.children.push(emptyChild())
}

function removeChild(index) {
  form.children.splice(index, 1)
}

/* --- CSRF helper --- */
function csrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
}

/* --- Open modal & submit form via fetch (JSON) --- */
async function openPaymentModal() {
  paymentError.value = ''
  isSubmitting.value = true
  showPaymentModal.value = true

  try {
    const response = await fetch(route('membership.store'), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken(),
      },
      body: JSON.stringify(form.data())
    })

    const data = await response.json()

    // Validation errors (422)
    if (response.status === 422 && data.errors) {
      isSubmitting.value = false
      showPaymentModal.value = false
      Object.keys(data.errors).forEach(key => {
        form.setError(key, data.errors[key][0])
      })
      return
    }

    if (!response.ok) {
      throw new Error(data.message || 'Submission failed')
    }

    // ✅ Success — populate modal with the returned membership id
    membershipId.value = data.membership.id
    isSubmitting.value = false
  } catch (err) {
    isSubmitting.value = false
    showPaymentModal.value = false
    paymentError.value = err.message || 'Something went wrong. Please try again.'
    console.error(err)
  }
}

function closePaymentModal() {
  showPaymentModal.value = false
  membershipId.value = null
  card.number = ''
  card.expiry = ''
  card.cvc = ''
  card.name = ''
  paymentError.value = ''
}

/* --- Input formatting --- */
function formatCardNumber(e) {
  let v = e.target.value.replace(/\D/g, '').slice(0, 16)
  card.number = v.replace(/(\d{4})(?=\d)/g, '$1 ')
}

function formatExpiry(e) {
  let v = e.target.value.replace(/\D/g, '').slice(0, 4)
  if (v.length >= 3) v = v.slice(0, 2) + '/' + v.slice(2)
  card.expiry = v
}

function copyZelle() {
  navigator.clipboard.writeText('payments@qfcc.org')
  copied.value = true
  setTimeout(() => (copied.value = false), 2000)
}

/* --- Confirm payment via fetch (JSON) --- */
async function confirmPayment() {
  if (!membershipId.value) return

  paymentError.value = ''

  if (paymentMethod.value === 'stripe') {
    if (!card.number || card.number.replace(/\s/g, '').length < 16) {
      paymentError.value = 'Please enter a valid card number.'
      return
    }
    if (!/^\d{2}\/\d{2}$/.test(card.expiry)) {
      paymentError.value = 'Please enter a valid expiry date (MM/YY).'
      return
    }
    if (!card.cvc || card.cvc.length < 3) {
      paymentError.value = 'Please enter a valid CVC.'
      return
    }
    if (!card.name.trim()) {
      paymentError.value = 'Please enter the name on the card.'
      return
    }
  }

  processingPayment.value = true

  try {
    const response = await fetch(route('membership.payment.confirm', membershipId.value), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken(),
      },
      body: JSON.stringify({
        payment_method: paymentMethod.value,
        card_last4: paymentMethod.value === 'stripe' ? card.number.replace(/\s/g, '').slice(-4) : null,
        card_brand: paymentMethod.value === 'stripe' ? cardBrand.value : null,
        zelle_reference: paymentMethod.value === 'zelle' ? `QFCC #${membershipId.value}` : null,
      })
    })

    const data = await response.json()

    if (!response.ok) {
      throw new Error(data.message || 'Payment failed')
    }

    processingPayment.value = false

    // ✅ Show success modal with transaction reference
    transactionReference.value = data.reference || `QFCC-TXN-${membershipId.value}`
    successMessage.value = data.message || 'Payment processed successfully.'
    showPaymentModal.value = false
    showSuccessModal.value = true

  } catch (err) {
    processingPayment.value = false
    paymentError.value = err.message || 'Payment failed. Please try again.'
    console.error(err)
  }
}

/* --- Success modal actions --- */
function copyReference() {
  navigator.clipboard.writeText(transactionReference.value)
  refCopied.value = true
  setTimeout(() => (refCopied.value = false), 2000)
}

function downloadReceipt() {
  // Simple text receipt — swap with a PDF endpoint if needed
  const content = `
QUEENS FAMILY & COMMUNITY CENTER
Membership Payment Receipt
--------------------------------------
Transaction Ref : ${transactionReference.value}
Member Name     : ${form.full_name}
Membership Type : ${form.membership_type}
Amount Paid     : $${selectedPlan.value?.price}.00
Payment Method  : ${paymentMethod.value === 'stripe' ? 'Card (Stripe)' : 'Zelle'}
Date            : ${new Date().toLocaleString()}
--------------------------------------
Thank you for your membership!
`.trim()

  const blob = new Blob([content], { type: 'text/plain' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = `QFCC-Receipt-${transactionReference.value}.txt`
  a.click()
  URL.revokeObjectURL(url)
}

function closeSuccessModal() {
  showSuccessModal.value = false
}

function finishAndReset() {
  showSuccessModal.value = false
  closePaymentModal()
  form.reset()
  window.location.href = route('membership.create')
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
  border-color: #818cf8;
  box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.12);
  outline: none;
}
</style>