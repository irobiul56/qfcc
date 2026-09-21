<template>
  <AppLayout
    title="Get Involved | QFCC"
    description="A stronger community is built by people who show up. Give your time, your voice, or your support and help QFCC turn care into action."
  >
    <main>
      <!-- ================= HERO ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#002d21] via-[#003c2b] to-[#00583f] text-white">
        <!-- Decorative pattern -->
        <div class="involved-hero-pattern pointer-events-none absolute inset-0 opacity-[0.08]"></div>

        <div
          class="relative mx-auto grid max-w-[1250px] items-center gap-10 px-5 py-16 sm:px-8 lg:grid-cols-[1.1fr_.9fr] lg:py-24"
        >
          <!-- Copy -->
          <div class="animate-slide-up">
            <p class="mb-4 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.25em] text-[#e0ac2e]">
              <span class="mr-3 inline-block h-px w-8 bg-[#e0ac2e]"></span>
              GET INVOLVED
            </p>

            <h1
              class="font-serif text-[clamp(2.25rem,5.5vw,4rem)] font-bold leading-[1.05] text-white"
            >
              There is a place<br />
              for <span class="relative inline-block text-[#e0ac2e]">
                your good.
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
              A stronger community is built by people who show up. Give your time, your voice, or your support and help
              QFCC turn care into action.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
              <a
                href="#ways-to-help"
                class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group"
              >
                FIND YOUR ROLE
                <i class="fas fa-arrow-down ml-2 transition-transform group-hover:translate-y-1"></i>
              </a>
              <a
                href="#support"
                class="inline-flex items-center justify-center rounded-full border-2 border-white/20 px-6 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:border-white/40 hover:bg-white/10 group"
              >
                SEE WAYS TO GIVE
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </a>
            </div>
          </div>

          <!-- Hero card -->
          <div class="animate-slide-up animation-delay-300">
            <div
              class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] p-8 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-[#e0ac2e]/30 hover:bg-white/10"
            >
              <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#e0ac2e] to-transparent"></div>

              <span
                class="mb-4 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]"
              >
                <span class="mr-2 inline-block h-2 w-2 animate-pulse rounded-full bg-[#e0ac2e]"></span>
                ONE COMMUNITY, MANY WAYS TO HELP
              </span>

              <strong class="mb-5 block font-serif text-2xl font-bold leading-tight text-white">
                Small acts become<br />lasting change.
              </strong>

              <div class="mb-5 h-px bg-gradient-to-r from-[#e0ac2e] to-transparent"></div>

              <p class="text-sm leading-7 text-white/80">
                Every contribution helps create more opportunities for families, youth, seniors, and newcomers in
                Queens.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= WAYS TO HELP ================= -->
      <section id="ways-to-help" class="mx-auto max-w-[1250px] px-5 py-14 sm:px-8 lg:py-20">
        <!-- Section intro -->
        <div class="mx-auto max-w-3xl text-center">
          <p class="mb-3 flex items-center justify-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
            <i class="fas fa-bullseye mr-2"></i>MAKE AN IMPACT
          </p>
          <h2 class="font-serif text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#00583f]">
            Choose how you want to show up.
          </h2>
          <p class="mt-4 text-base leading-7 text-slate-600">
            There is no single way to serve. Start with what feels true to you today.
          </p>
        </div>

        <!-- Choice grid -->
        <div class="mt-14 grid grid-cols-1 gap-6 lg:grid-cols-3">
          <!-- Featured choice -->
          <Link
            :href="route('volunteer.create')"
            class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#00583f] to-[#002d21] p-8 text-white shadow-[0_10px_40px_rgba(0,65,47,0.2)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,65,47,0.3)] lg:row-span-2"
          >
            <div class="pointer-events-none absolute -right-1/3 -top-1/3 h-[200%] w-[200%]" style="background: radial-gradient(circle, rgba(224, 172, 46, 0.1) 0%, transparent 70%)"></div>

            <span
              class="absolute right-6 top-6 font-serif text-5xl font-bold text-white/10 transition-all duration-500 group-hover:text-[#e0ac2e]/20"
            >
              01
            </span>

            <div
              class="relative mb-6 flex h-[72px] w-[72px] items-center justify-center rounded-2xl bg-[#e0ac2e]/15 text-3xl text-[#e0ac2e] transition-all duration-500 group-hover:rotate-[8deg] group-hover:scale-110 group-hover:bg-[#e0ac2e]/25"
            >
              <i class="fas fa-hands-helping"></i>
            </div>

            <h3 class="relative mb-3 font-serif text-2xl font-bold leading-tight text-white">
              Give your time
            </h3>

            <p class="relative mb-6 text-sm leading-7 text-white/80">
              Volunteer at a program, lend a professional skill, or help make a community event possible.
            </p>

            <span
              class="relative inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e] transition-all group-hover:text-white"
            >
              VOLUNTEER WITH US
              <i class="fas fa-arrow-up-right-from-square ml-2 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-1"></i>
            </span>
          </Link>

          <!-- Choice 2 -->
          <Link
            :href="route('membership.create')"
            class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-500 hover:-translate-y-2 hover:border-[#e0ac2e]/30 hover:shadow-[0_20px_50px_rgba(224,172,46,0.15)]"
          >
            <div class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-[#e0ac2e] to-[#c9991f] transition-transform duration-500 group-hover:scale-x-100"></div>

            <span
              class="absolute right-6 top-6 font-serif text-5xl font-bold text-slate-100 transition-all duration-500 group-hover:text-[#e0ac2e]/20"
            >
              02
            </span>

            <div
              class="relative mb-6 flex h-[72px] w-[72px] items-center justify-center rounded-2xl bg-[#e0ac2e]/10 text-3xl text-[#e0ac2e] transition-all duration-500 group-hover:rotate-[8deg] group-hover:scale-110 group-hover:bg-[#e0ac2e]/20"
            >
              <i class="fas fa-bullseye"></i>
            </div>

            <h3 class="relative mb-3 font-serif text-2xl font-bold leading-tight text-[#00583f]">
              Join the community
            </h3>

            <p class="relative mb-6 text-sm leading-7 text-slate-600">
              Become a QFCC member and stay close to the people and programs shaping our shared future.
            </p>

            <span
              class="relative inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f] transition-all group-hover:text-[#e0ac2e]"
            >
              BECOME A MEMBER
              <i class="fas fa-arrow-up-right-from-square ml-2 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-1"></i>
            </span>
          </Link>

          <!-- Choice 3 -->
          <Link
            :href="route('donate')"
            class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-8 shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-500 hover:-translate-y-2 hover:border-[#00583f]/30 hover:shadow-[0_20px_50px_rgba(0,88,63,0.15)]"
          >
            <div class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-gradient-to-r from-[#00583f] to-[#003c2b] transition-transform duration-500 group-hover:scale-x-100"></div>

            <span
              class="absolute right-6 top-6 font-serif text-5xl font-bold text-slate-100 transition-all duration-500 group-hover:text-[#00583f]/20"
            >
              03
            </span>

            <div
              class="relative mb-6 flex h-[72px] w-[72px] items-center justify-center rounded-2xl bg-[#00583f]/10 text-3xl text-[#00583f] transition-all duration-500 group-hover:rotate-[8deg] group-hover:scale-110 group-hover:bg-[#00583f]/20"
            >
              <i class="fas fa-heart"></i>
            </div>

            <h3 class="relative mb-3 font-serif text-2xl font-bold leading-tight text-[#00583f]">
              Fuel the work
            </h3>

            <p class="relative mb-6 text-sm leading-7 text-slate-600">
              Your gift helps keep essential services available and opens the door for more families to participate.
            </p>

            <span
              class="relative inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f] transition-all group-hover:text-[#e0ac2e]"
            >
              SUPPORT QFCC
              <i class="fas fa-arrow-up-right-from-square ml-2 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-1"></i>
            </span>
          </Link>
        </div>
      </section>

      <!-- ================= VOLUNTEER FEATURE BAND ================= -->
      <section id="volunteer" class="bg-[#fbfaf4]">
        <div
          class="mx-auto grid max-w-[1250px] items-center gap-10 px-5 py-14 sm:px-8 lg:grid-cols-[.9fr_1.1fr] lg:gap-20 lg:py-20"
        >
          <!-- Photo -->
          <div class="group relative">
            <div class="overflow-hidden rounded-2xl shadow-[0_20px_60px_rgba(0,65,47,0.15)]">
              <img
                src="/storage/images/volunteer.png"
                alt="QFCC volunteers working together"
                class="block h-[420px] w-full object-cover transition-transform duration-700 group-hover:scale-105 lg:h-[520px]"
              />
            </div>

            <span
              class="absolute -bottom-4 left-6 inline-flex items-center rounded-full bg-[#e0ac2e] px-4 py-2.5 text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#002d21] shadow-[0_6px_20px_rgba(224,172,46,0.4)]"
            >
              <i class="fas fa-users mr-2"></i>COMMUNITY IN ACTION
            </span>
          </div>

          <!-- Copy -->
          <div>
            <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
              <i class="fas fa-hands-helping mr-2"></i>VOLUNTEER
            </p>

            <h2 class="font-serif text-[clamp(1.75rem,3.5vw,2.5rem)] font-bold leading-tight text-[#00583f]">
              Your time can become someone else's turning point.
            </h2>

            <p class="mt-5 text-base leading-7 text-slate-600">
              From welcoming guests to mentoring young people, volunteers make the warmth of QFCC tangible. We will
              help you find an opportunity that fits your strengths, availability, and interests.
            </p>

            <!-- Detail grid -->
            <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
              <div class="rounded-xl border-l-4 border-[#e0ac2e] bg-white p-4 shadow-sm">
                <strong class="mb-1 block text-sm font-extrabold uppercase tracking-wider text-[#00583f]">
                  <i class="fas fa-clock mr-1 text-[#e0ac2e]"></i>Flexible
                </strong>
                <span class="text-xs leading-5 text-slate-600">One-time and ongoing roles</span>
              </div>
              <div class="rounded-xl border-l-4 border-[#00583f] bg-white p-4 shadow-sm">
                <strong class="mb-1 block text-sm font-extrabold uppercase tracking-wider text-[#00583f]">
                  <i class="fas fa-hand-holding-heart mr-1 text-[#00583f]"></i>Welcoming
                </strong>
                <span class="text-xs leading-5 text-slate-600">Training and support included</span>
              </div>
              <div class="rounded-xl border-l-4 border-[#e0ac2e] bg-white p-4 shadow-sm">
                <strong class="mb-1 block text-sm font-extrabold uppercase tracking-wider text-[#00583f]">
                  <i class="fas fa-star mr-1 text-[#e0ac2e]"></i>Meaningful
                </strong>
                <span class="text-xs leading-5 text-slate-600">Work close to real needs</span>
              </div>
            </div>

            <Link
              :href="route('volunteer.create')"
              class="mt-8 inline-flex items-center justify-center rounded-full bg-[#00583f] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#003c2b] hover:shadow-[0_10px_30px_rgba(0,88,63,0.3)] group"
            >
              START A CONVERSATION
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </Link>
          </div>
        </div>
      </section>

      <!-- ================= MEMBERSHIP + SUPPORT PANELS ================= -->
      <section class="mx-auto grid max-w-[1250px] gap-5 px-5 py-14 sm:px-8 lg:grid-cols-2 lg:py-20">
        <!-- Membership panel -->
        <article
          id="membership"
          class="group relative overflow-hidden rounded-2xl border border-[#e0ac2e]/30 bg-gradient-to-br from-[#fbfaf4] to-white p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(224,172,46,0.15)] lg:p-10"
        >
          <div
            class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full"
            style="background: radial-gradient(circle, rgba(224, 172, 46, 0.12) 0%, transparent 70%)"
          ></div>

          <div
            class="mb-6 flex h-[72px] w-[72px] items-center justify-center rounded-2xl bg-[#e0ac2e]/15 text-3xl text-[#e0ac2e] transition-all duration-500 group-hover:rotate-[8deg] group-hover:scale-110"
          >
            <i class="fas fa-bullseye"></i>
          </div>

          <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
            <span class="mr-2 inline-block h-px w-6 bg-[#e0ac2e]"></span>MEMBERSHIP
          </p>

          <h2 class="mb-4 font-serif text-3xl font-bold leading-tight text-[#00583f]">
            Belong to the work.
          </h2>

          <p class="mb-6 text-sm leading-7 text-slate-600">
            Membership is a simple way to stay connected, participate in QFCC programs, and help shape a center that
            reflects the community it serves.
          </p>

          <Link
            :href="route('membership.create')"
            class="inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f] transition-all group-hover:text-[#e0ac2e]"
          >
            BECOME A MEMBER
            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
          </Link>
        </article>

        <!-- Support panel -->
        <article
          id="support"
          class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#00583f] to-[#002d21] p-8 text-white shadow-[0_10px_40px_rgba(0,65,47,0.2)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_rgba(0,65,47,0.3)] lg:p-10"
        >
          <div
            class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full"
            style="background: radial-gradient(circle, rgba(224, 172, 46, 0.15) 0%, transparent 70%)"
          ></div>

          <div
            class="mb-6 flex h-[72px] w-[72px] items-center justify-center rounded-2xl bg-[#e0ac2e]/20 text-3xl text-[#e0ac2e] transition-all duration-500 group-hover:rotate-[8deg] group-hover:scale-110"
          >
            <i class="fas fa-heart"></i>
          </div>

          <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
            <span class="mr-2 inline-block h-px w-6 bg-[#e0ac2e]"></span>SUPPORT
          </p>

          <h2 class="mb-4 font-serif text-3xl font-bold leading-tight text-white">
            Make more room for good.
          </h2>

          <p class="mb-6 text-sm leading-7 text-white/85">
            Gifts of every size help QFCC respond with dignity when a neighbor needs food, guidance, education, or a
            place to feel at home.
          </p>

          <Link
            :href="route('donate')"
            class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group/btn"
          >
            DONATE TO QFCC
            <i class="fas fa-arrow-right ml-2 transition-transform group-hover/btn:translate-x-1"></i>
          </Link>
        </article>
      </section>

      <!-- ================= QUOTE / NOTE ================= -->
      <section class="bg-[#fbfaf4]">
        <div class="mx-auto max-w-[850px] px-5 py-14 text-center sm:px-8 lg:py-20">
          <div
            class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full bg-[#e0ac2e]/10"
          >
            <i class="fas fa-quote-left text-3xl text-[#e0ac2e]"></i>
          </div>

          <p class="mb-6 font-serif text-xl italic leading-relaxed text-[#00583f] sm:text-2xl">
            "When we serve together, the distance between a need and a solution gets smaller."
          </p>

          <span
            class="inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]"
          >
            <span class="mr-3 inline-block h-px w-8 bg-[#e0ac2e]"></span>
            QFCC COMMUNITY PRINCIPLE
            <span class="ml-3 inline-block h-px w-8 bg-[#e0ac2e]"></span>
          </span>
        </div>
      </section>
    </main>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Head, Link, router, usePage } from '@inertiajs/vue3';

</script>

<style scoped>
/* ---------- Custom pattern for hero ---------- */
.involved-hero-pattern {
  background-image: radial-gradient(circle at 20% 30%, rgba(224, 172, 46, 0.4) 1.5px, transparent 1.5px),
    radial-gradient(circle at 80% 70%, rgba(224, 172, 46, 0.4) 1.5px, transparent 1.5px);
  background-size: 50px 50px;
  background-position: 0 0, 25px 25px;
}

/* ---------- Animations ---------- */
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

/* ---------- Font serif helper ---------- */
.font-serif {
  font-family: Georgia, 'Times New Roman', serif;
}

/* ---------- Smooth scrolling ---------- */
html {
  scroll-behavior: smooth;
}

/* ---------- Focus rings ---------- */
*:focus-visible {
  outline: 2px solid #e0ac2e;
  outline-offset: 2px;
}
</style>