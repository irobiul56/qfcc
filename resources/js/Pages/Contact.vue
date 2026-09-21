<template>
  <AppLayout
    title="Contact Us | QFCC"
    description="Whether you need support, want to collaborate, or simply have a question, the QFCC team is here to listen and help you find the next step."
  >
    <main>
      <!-- ================= HERO ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#002d21] via-[#003c2b] to-[#00583f] text-white">
        <div class="contact-hero-pattern pointer-events-none absolute inset-0 opacity-[0.08]"></div>

        <div
          class="relative mx-auto grid max-w-[1250px] items-center gap-10 px-5 py-16 sm:px-8 lg:grid-cols-[1.1fr_.9fr] lg:py-24"
        >
          <!-- Copy -->
          <div class="animate-slide-up">
            <p class="mb-4 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.25em] text-[#e0ac2e]">
              <span class="mr-3 inline-block h-px w-8 bg-[#e0ac2e]"></span>
              LET'S CONNECT
            </p>

            <h1 class="font-serif text-[clamp(2.25rem,5.5vw,4rem)] font-bold leading-[1.05] text-white">
              Good things<br />
              <span class="relative inline-block text-[#e0ac2e]">
                start with a hello.
                <svg
                  class="absolute -bottom-2 left-0 h-2 w-full"
                  viewBox="0 0 200 8"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M0 4C50 8 150 8 200 4C150 0 50 0 0 4Z" fill="rgba(224, 172, 46, 0.3)" />
                </svg>
              </span>
            </h1>

            <p class="mt-7 max-w-[520px] text-base leading-7 text-white/85 sm:text-[1.05rem]">
              Whether you need support, want to collaborate, or simply have a question, our team is here to listen and
              help you find the next step.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
              <a
                href="#contact-form"
                class="group inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)]"
              >
                SEND A MESSAGE
                <i class="fas fa-arrow-down ml-2 transition-transform group-hover:translate-y-1"></i>
              </a>
            </div>
          </div>

          <!-- Hero note card -->
          <div class="animate-slide-up animation-delay-300">
            <div
              class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] p-8 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-[#e0ac2e]/30 hover:bg-white/10"
            >
              <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#e0ac2e] to-transparent"></div>

              <span
                class="mb-4 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]"
              >
                <span class="mr-2 inline-block h-2 w-2 animate-pulse rounded-full bg-[#e0ac2e]"></span>
                WE ARE HERE TO HELP
              </span>

              <strong class="mb-5 block font-serif text-2xl font-bold leading-tight text-white">
                One conversation<br />can open a door.
              </strong>

              <div class="mb-5 h-px bg-gradient-to-r from-[#e0ac2e] to-transparent"></div>

              <p class="text-sm leading-7 text-white/80">
                Reach out about programs, services, partnerships, volunteering, or anything else on your mind.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= MAIN CONTACT ================= -->
      <section class="mx-auto grid max-w-[1250px] gap-8 px-5 py-14 sm:px-8 lg:grid-cols-[.8fr_1.2fr] lg:gap-16 lg:py-20">
        <!-- Contact details column -->
        <div>
          <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
            <i class="fas fa-address-book mr-2"></i>CONTACT QFCC
          </p>

          <h2 class="font-serif text-[clamp(1.75rem,3.5vw,2.5rem)] font-bold leading-tight text-[#00583f]">
            Let's find the right way forward.
          </h2>

          <p class="mt-4 text-base leading-7 text-slate-600">
            Our team welcomes questions from community members, families, partners, volunteers, and anyone looking to
            connect with QFCC.
          </p>

          <!-- Detail list -->
          <div class="mt-8 flex flex-col gap-3">
            <a
              href="tel:+13472335473"
              class="group flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:-translate-y-1 hover:border-[#00583f]/20 hover:shadow-[0_15px_35px_rgba(0,88,63,0.1)]"
            >
              <span
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-[#00583f]/10 text-xl text-[#00583f] transition-all duration-300 group-hover:rotate-[8deg] group-hover:scale-110 group-hover:bg-[#00583f] group-hover:text-white"
              >
                <i class="fas fa-phone-alt"></i>
              </span>
              <span class="flex flex-col">
                <small class="text-[0.6rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">CALL US</small>
                <strong class="text-sm font-bold text-[#00583f]">(347) 233-5473</strong>
              </span>
            </a>

            <a
              href="mailto:info@QFCC.org"
              class="group flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:-translate-y-1 hover:border-[#e0ac2e]/30 hover:shadow-[0_15px_35px_rgba(224,172,46,0.1)]"
            >
              <span
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-[#e0ac2e]/15 text-xl text-[#e0ac2e] transition-all duration-300 group-hover:rotate-[8deg] group-hover:scale-110 group-hover:bg-[#e0ac2e] group-hover:text-white"
              >
                <i class="fas fa-envelope"></i>
              </span>
              <span class="flex flex-col">
                <small class="text-[0.6rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">EMAIL US</small>
                <strong class="text-sm font-bold text-[#00583f]">info@QFCC.org</strong>
              </span>
            </a>

            <div
              class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-[0_4px_15px_rgba(0,0,0,0.03)]"
            >
              <span
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-[#00583f]/10 text-xl text-[#00583f]"
              >
                <i class="fas fa-map-marker-alt"></i>
              </span>
              <span class="flex flex-col">
                <small class="text-[0.6rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">
                  WHERE WE SERVE
                </small>
                <strong class="text-sm font-bold text-[#00583f]">
                  Queens, New York City<br />and beyond
                </strong>
              </span>
            </div>
          </div>

          <!-- Hours note -->
          <div class="mt-8 flex items-start gap-4 rounded-2xl border-l-4 border-[#e0ac2e] bg-[#fbfaf4] p-5">
            <span
              class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-[#e0ac2e]/20 text-lg text-[#e0ac2e]"
            >
              <i class="fas fa-clock"></i>
            </span>
            <div>
              <strong class="mb-1 block text-sm font-extrabold uppercase tracking-wider text-[#00583f]">
                We'll get back to you soon.
              </strong>
              <p class="text-xs leading-6 text-slate-600">
                Messages are reviewed by our team during regular program hours.
              </p>
            </div>
          </div>
        </div>

        <!-- Contact form -->
        <form
          id="contact-form"
          @submit.prevent="submit"
          class="relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-7 shadow-[0_10px_40px_rgba(0,65,47,0.08)] sm:p-10"
        >
          <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#e0ac2e] via-[#00583f] to-[#e0ac2e]"></div>

          <!-- Success banner -->
          <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <div
              v-if="showSuccess"
              class="mb-7 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4"
            >
              <span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white">
                <i class="fas fa-check text-sm"></i>
              </span>
              <div>
                <p class="text-sm font-bold text-emerald-800">Thank you — your message has been sent!</p>
                <p class="mt-1 text-xs leading-6 text-emerald-700">
                  We'll review it and get back to you soon. You can send another message below.
                </p>
              </div>
            </div>
          </Transition>

          <!-- Form heading -->
          <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
            <div>
              <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
                <i class="fas fa-paper-plane mr-2"></i>SEND A MESSAGE
              </p>
              <h2 class="font-serif text-[clamp(1.5rem,3vw,2rem)] font-bold leading-tight text-[#00583f]">
                How can we help?
              </h2>
            </div>
            <span class="font-serif text-2xl font-bold text-[#e0ac2e]">
              01 <i class="text-sm not-italic text-slate-400">/ 01</i>
            </span>
          </div>

          <!-- Form grid -->
          <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <!-- Full name -->
            <label class="flex flex-col gap-2">
              <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                <i class="fas fa-user mr-1 text-[#e0ac2e]"></i>YOUR NAME
                <span class="text-rose-500">*</span>
              </span>
              <input
                v-model="form.full_name"
                type="text"
                placeholder="First and last name"
                class="rounded-xl border bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:bg-white focus:ring-4"
                :class="form.errors.full_name
                  ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10'
                  : 'border-slate-200 focus:border-[#00583f] focus:ring-[#00583f]/10'"
              />
              <p v-if="form.errors.full_name" class="flex items-center gap-1.5 text-xs text-rose-600">
                <i class="fas fa-circle-exclamation text-[10px]"></i>
                {{ form.errors.full_name }}
              </p>
            </label>

            <!-- Email -->
            <label class="flex flex-col gap-2">
              <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                <i class="fas fa-envelope mr-1 text-[#e0ac2e]"></i>EMAIL ADDRESS
                <span class="text-rose-500">*</span>
              </span>
              <input
                v-model="form.email"
                type="email"
                placeholder="you@example.com"
                class="rounded-xl border bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:bg-white focus:ring-4"
                :class="form.errors.email
                  ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10'
                  : 'border-slate-200 focus:border-[#00583f] focus:ring-[#00583f]/10'"
              />
              <p v-if="form.errors.email" class="flex items-center gap-1.5 text-xs text-rose-600">
                <i class="fas fa-circle-exclamation text-[10px]"></i>
                {{ form.errors.email }}
              </p>
            </label>
          </div>

          <!-- Phone -->
          <label class="mt-5 flex flex-col gap-2">
            <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
              <i class="fas fa-phone mr-1 text-[#e0ac2e]"></i>PHONE NUMBER
              <span class="ml-1 text-[10px] font-medium normal-case tracking-normal text-slate-400">(optional)</span>
            </span>
            <input
              v-model="form.phone"
              type="tel"
              placeholder="(123) 456-7890"
              class="rounded-xl border bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:bg-white focus:ring-4"
              :class="form.errors.phone
                ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10'
                : 'border-slate-200 focus:border-[#00583f] focus:ring-[#00583f]/10'"
            />
            <p v-if="form.errors.phone" class="flex items-center gap-1.5 text-xs text-rose-600">
              <i class="fas fa-circle-exclamation text-[10px]"></i>
              {{ form.errors.phone }}
            </p>
          </label>

          <!-- Subject -->
          <label class="mt-5 flex flex-col gap-2">
            <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
              <i class="fas fa-comment-dots mr-1 text-[#e0ac2e]"></i>SUBJECT
              <span class="ml-1 text-[10px] font-medium normal-case tracking-normal text-slate-400">(optional)</span>
            </span>
            <input
              v-model="form.subject"
              type="text"
              placeholder="What is this about?"
              class="rounded-xl border bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:bg-white focus:ring-4"
              :class="form.errors.subject
                ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10'
                : 'border-slate-200 focus:border-[#00583f] focus:ring-[#00583f]/10'"
            />
            <p v-if="form.errors.subject" class="flex items-center gap-1.5 text-xs text-rose-600">
              <i class="fas fa-circle-exclamation text-[10px]"></i>
              {{ form.errors.subject }}
            </p>
          </label>

          <!-- Message -->
          <label class="mt-5 flex flex-col gap-2">
            <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
              <i class="fas fa-pen mr-1 text-[#e0ac2e]"></i>YOUR MESSAGE
              <span class="text-rose-500">*</span>
            </span>
            <textarea
              v-model="form.message"
              rows="5"
              placeholder="Tell us a little about what you need..."
              class="resize-none rounded-xl border bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:bg-white focus:ring-4"
              :class="form.errors.message
                ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10'
                : 'border-slate-200 focus:border-[#00583f] focus:ring-[#00583f]/10'"
            ></textarea>
            <p v-if="form.errors.message" class="flex items-center gap-1.5 text-xs text-rose-600">
              <i class="fas fa-circle-exclamation text-[10px]"></i>
              {{ form.errors.message }}
            </p>
          </label>

          <!-- Footer -->
          <div class="mt-7 flex flex-col gap-4 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="flex items-center text-xs leading-5 text-slate-500 sm:max-w-[280px]">
              <i class="fas fa-shield-alt mr-2 text-[#e0ac2e]"></i>
              We respect your privacy and will only use your details to respond.
            </p>
            <button
              type="submit"
              :disabled="form.processing"
              class="group inline-flex items-center justify-center rounded-full bg-[#00583f] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#003c2b] hover:shadow-[0_10px_30px_rgba(0,88,63,0.3)] disabled:opacity-60 disabled:hover:translate-y-0"
            >
              <template v-if="!form.processing">
                SEND MESSAGE
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </template>
              <template v-else>
                <i class="fas fa-circle-notch fa-spin mr-2"></i>
                SENDING…
              </template>
            </button>
          </div>
        </form>
      </section>

      <!-- ================= VISIT ================= -->
      <section class="bg-[#fbfaf4]">
        <div
          class="mx-auto grid max-w-[1250px] items-center gap-8 px-5 py-12 sm:px-8 lg:grid-cols-[1fr_1.05fr] lg:gap-16 lg:py-16"
        >
          <!-- Image -->
          <div class="group relative">
            <div class="overflow-hidden rounded-2xl shadow-[0_20px_60px_rgba(0,65,47,0.15)]">
              <img
                src="/storage/images/story-mosque.jpg"
                alt="A welcoming QFCC community space"
                class="block h-[380px] w-full object-cover transition-transform duration-700 group-hover:scale-105 lg:h-[480px]"
              />
            </div>

            <span
              class="absolute -bottom-4 left-6 inline-flex items-center rounded-full bg-[#e0ac2e] px-4 py-2.5 text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#002d21] shadow-[0_6px_20px_rgba(224,172,46,0.4)]"
            >
              <i class="fas fa-map-marked-alt mr-2"></i>COMMUNITY STARTS HERE
            </span>
          </div>

          <!-- Copy -->
          <div>
            <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
              <i class="fas fa-door-open mr-2"></i>COME AS YOU ARE
            </p>

            <h2 class="font-serif text-[clamp(1.75rem,3.5vw,2.5rem)] font-bold leading-tight text-[#00583f]">
              A place to feel welcome.
            </h2>

            <p class="mt-4 text-base leading-7 text-slate-600">
              QFCC brings people together through faith, learning, service, and care. Start a conversation today and let
              us help you find your place in the community.
            </p>

            <div class="mt-6 flex flex-col gap-3">
              <span class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                <b class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#00583f] text-xs font-extrabold text-white">
                  01
                </b>
                Listen first
              </span>
              <span class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                <b class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#e0ac2e] text-xs font-extrabold text-white">
                  02
                </b>
                Connect with care
              </span>
              <span class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                <b class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#00583f] text-xs font-extrabold text-white">
                  03
                </b>
                Move forward together
              </span>
            </div>

            <a
              href="mailto:info@QFCC.org"
              class="group mt-8 inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)]"
            >
              EMAIL OUR TEAM
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </section>
    </main>
  </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const form = useForm({
  full_name: '',
  email: '',
  phone: '',
  subject: '',
  message: '',
})

const showSuccess = ref(false)

// Auto-hide success banner after 6s
onMounted(() => {
  // nothing
})

function submit() {
  form.post(route('contact.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      showSuccess.value = true
      setTimeout(() => (showSuccess.value = false), 6000)
      // Scroll to the form so the success banner is visible
      document.getElementById('contact-form')?.scrollIntoView({ behavior: 'smooth', block: 'start' })
    },
    onError: () => {
      // Scroll to the first error
      document.querySelector('.text-rose-600')?.scrollIntoView({ behavior: 'smooth', block: 'center' })
    },
  })
}
</script>

<style scoped>
.contact-hero-pattern {
  background-image: radial-gradient(circle at 20% 30%, rgba(224, 172, 46, 0.4) 1.5px, transparent 1.5px),
    radial-gradient(circle at 80% 70%, rgba(224, 172, 46, 0.4) 1.5px, transparent 1.5px);
  background-size: 50px 50px;
  background-position: 0 0, 25px 25px;
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-slide-up {
  animation: slideUp 0.9s ease-out forwards;
  opacity: 0;
}

.animation-delay-300 {
  animation-delay: 300ms;
}

.font-serif {
  font-family: Georgia, 'Times New Roman', serif;
}

html {
  scroll-behavior: smooth;
}

*:focus-visible {
  outline: 2px solid #e0ac2e;
  outline-offset: 2px;
}
</style>