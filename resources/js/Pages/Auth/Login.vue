<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

/* ═══════════════════════════════════════════════════════════
   PROPS
   ═══════════════════════════════════════════════════════════ */
defineProps({
  canResetPassword: { type: Boolean },
  status:           { type: String },
})

/* ═══════════════════════════════════════════════════════════
   FORM STATE
   ═══════════════════════════════════════════════════════════ */
const form = useForm({
  email: '',
  password: '',
  remember: false,
})

const showPassword = ref(false)

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  })
}

const passwordType = computed(() => (showPassword.value ? 'text' : 'password'))
</script>

<template>
  <Head title="Sign In — QFCC Admin" />

  <div class="relative flex min-h-screen items-center justify-center bg-[#fafbfc] px-5 py-10 sm:px-8">

    <!-- Subtle background decoration -->
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
      <div class="absolute -top-40 -left-40 h-96 w-96 rounded-full bg-[#00583f]/5 blur-3xl"></div>
      <div class="absolute -bottom-40 -right-40 h-96 w-96 rounded-full bg-[#d9a52b]/5 blur-3xl"></div>
    </div>

    <!-- Login Card -->
    <div class="relative w-full max-w-[440px]">

      <!-- Logo & heading -->
      <div class="mb-8 flex flex-col items-center text-center">
        <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-[#00583f] to-[#008d49] shadow-lg shadow-[#00583f]/20">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>

        <h1 class="text-sm font-bold tracking-wide text-[#003d2c]">
          QFCC Admin Portal
        </h1>
        <p class="mt-0.5 text-[11px] text-slate-500">
          Queens Family &amp; Community Center
        </p>
      </div>

      <!-- Status message -->
      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 -translate-y-1"
        enter-to-class="opacity-100 translate-y-0"
      >
        <div
          v-if="status"
          class="mb-6 flex items-start gap-3 rounded-xl bg-emerald-50 px-4 py-3 ring-1 ring-emerald-200/70"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
          </svg>
          <p class="text-xs font-medium text-emerald-700">{{ status }}</p>
        </div>
      </Transition>

      <!-- Form card -->
      <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-[0_8px_40px_-12px_rgba(15,23,42,0.08)] sm:p-8">

        <form @submit.prevent="submit" class="space-y-5">

          <!-- Email -->
          <div>
            <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600">
              Email Address
            </label>

            <div class="relative">
              <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
              </div>

              <input
                id="email"
                v-model="form.email"
                type="email"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
                class="w-full rounded-xl border bg-white py-3.5 pl-11 pr-4 text-sm text-slate-800 outline-none transition-all placeholder:text-slate-400"
                :class="form.errors.email
                  ? 'border-rose-300 focus:border-rose-400 focus:ring-4 focus:ring-rose-100'
                  : 'border-slate-200 hover:border-slate-300 focus:border-[#00583f] focus:ring-4 focus:ring-[#00583f]/10'"
              />
            </div>

            <p v-if="form.errors.email" class="mt-2 flex items-center gap-1.5 text-xs text-rose-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.email }}
            </p>
          </div>

          <!-- Password -->
          <div>
            <div class="mb-2 flex items-center justify-between">
              <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                Password
              </label>

              <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="text-[11px] font-semibold text-[#00583f] transition-colors hover:text-[#008d49]"
              >
                Forgot?
              </Link>
            </div>

            <div class="relative">
              <div class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </div>

              <input
                id="password"
                v-model="form.password"
                :type="passwordType"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="w-full rounded-xl border bg-white py-3.5 pl-11 pr-12 text-sm text-slate-800 outline-none transition-all placeholder:text-slate-400"
                :class="form.errors.password
                  ? 'border-rose-300 focus:border-rose-400 focus:ring-4 focus:ring-rose-100'
                  : 'border-slate-200 hover:border-slate-300 focus:border-[#00583f] focus:ring-4 focus:ring-[#00583f]/10'"
              />

              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition-all hover:bg-slate-100 hover:text-slate-700"
                :aria-label="showPassword ? 'Hide password' : 'Show password'"
              >
                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
              </button>
            </div>

            <p v-if="form.errors.password" class="mt-2 flex items-center gap-1.5 text-xs text-rose-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ form.errors.password }}
            </p>
          </div>

          <!-- Remember me -->
          <div class="flex items-center justify-between">
            <label class="group flex cursor-pointer select-none items-center gap-2.5">
              <input
                v-model="form.remember"
                type="checkbox"
                class="sr-only"
              />
              <div
                class="relative h-5 w-5 rounded-md border-2 transition-all"
                :class="form.remember
                  ? 'border-[#00583f] bg-[#00583f]'
                  : 'border-slate-300 bg-white group-hover:border-slate-400'"
              >
                <svg
                  v-if="form.remember"
                  xmlns="http://www.w3.org/2000/svg"
                  class="absolute left-1/2 top-1/2 h-3 w-3 -translate-x-1/2 -translate-y-1/2 text-white"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="3.5"
                >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800 transition-colors">
                Remember me
              </span>
            </label>
          </div>

          <!-- Submit button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="group relative mt-2 inline-flex w-full items-center justify-center gap-2 overflow-hidden rounded-xl bg-gradient-to-r from-[#00583f] to-[#007a55] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-[#00583f]/25 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-[#00583f]/35 active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-60"
          >
            <template v-if="!form.processing">
              <span>Sign In</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
              </svg>
            </template>
            <template v-else>
              <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
              </svg>
              <span>Signing in…</span>
            </template>
          </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center gap-3">
          <div class="h-px flex-1 bg-slate-200"></div>
          <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Or</span>
          <div class="h-px flex-1 bg-slate-200"></div>
        </div>

        <!-- Back to site -->
        <Link
          :href="route('home')"
          class="group flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition-all hover:-translate-y-0.5 hover:border-slate-300 hover:bg-slate-50 hover:shadow-sm"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
          Back to Homepage
        </Link>

      </div>

      <!-- Footer note -->
      <p class="mt-6 text-center text-[11px] text-slate-400">
        By signing in, you agree to QFCC's
        <a href="#" class="font-semibold text-slate-500 hover:text-[#00583f] transition-colors">Terms</a>
        &amp;
        <a href="#" class="font-semibold text-slate-500 hover:text-[#00583f] transition-colors">Privacy Policy</a>
      </p>

    </div>
  </div>
</template>