<template>
  <AppLayout
    title="Events | QFCC"
    description="Join Queens Family and Community Center at our upcoming events. From shared meals to meaningful conversations, our events turn community values into real connection."
  >
    <main>
      <!-- ================= HERO ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#002d21] via-[#003c2b] to-[#00583f] text-white">
        <!-- Decorative pattern -->
        <div class="pointer-events-none absolute inset-0 opacity-[0.08] events-hero-pattern"></div>

        <div
          class="relative mx-auto grid max-w-[1500px] items-end gap-8 px-5 py-16 sm:px-8 lg:grid-cols-[1.05fr_.95fr] lg:px-12 lg:py-24"
        >
          <!-- Hero copy -->
          <div class="max-w-[640px] animate-slide-up">
            <p class="mb-5 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.25em] text-[#e0ac2e]">
              <span class="mr-3 inline-block h-px w-8 bg-[#e0ac2e] align-middle"></span>
              GATHER. LEARN. SERVE.
            </p>

            <h1 class="font-serif text-[clamp(2.25rem,5.5vw,4rem)] font-bold leading-[1.05]">
              Moments that<br />
              <span class="relative inline-block text-[#e0ac2e]">
                bring us together.
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

            <p class="mt-7 max-w-[480px] text-[1.05rem] leading-7 text-white/85">
              From shared meals to meaningful conversations, our events turn community
              values into real connection.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
              <a
                href="#upcoming"
                class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group"
              >
                SEE UPCOMING EVENTS
                <i class="fas fa-arrow-down ml-2 transition-transform group-hover:translate-y-1"></i>
              </a>

              <a
                href="#involved"
                class="inline-flex items-center justify-center rounded-full border-2 border-white/20 px-6 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:border-white/40 hover:bg-white/10 group"
              >
                GET INVOLVED
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </a>
            </div>
          </div>

          <!-- Next gathering card -->
          <div class="animate-slide-up animation-delay-300">
            <div
              class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] p-7 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-[#e0ac2e]/30 hover:bg-white/10"
            >
              <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#e0ac2e] to-transparent"></div>

              <span class="mb-3 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
                <span class="mr-2 inline-block h-2 w-2 animate-pulse rounded-full bg-[#e0ac2e]"></span>
                NEXT GATHERING
              </span>

              <strong class="mb-3 block font-serif text-2xl font-bold leading-tight text-white">
                Community Iftar Dinner
              </strong>

              <div class="mb-5 flex items-center gap-4 border-b border-white/10 pb-5">
                <b class="text-xs font-extrabold uppercase tracking-[0.1em] text-[#e0ac2e]">JUN 08</b>
                <span class="text-sm text-white/70">Queens, New York · 6:00 PM</span>
              </div>

              <a
                href="#featured"
                class="inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-white transition-colors hover:text-[#e0ac2e] group"
              >
                VIEW EVENT DETAILS
                <i
                  class="fas fa-arrow-up-right-from-square ml-2 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-1"
                ></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-6 left-1/2 hidden -translate-x-1/2 animate-bounce text-white/40 lg:block">
          <i class="fas fa-chevron-down text-xl"></i>
        </div>
      </section>

      <!-- ================= INTRO ================= -->
      <section class="bg-[#fbfaf4]">
        <div
          class="mx-auto grid max-w-[1200px] items-end gap-5 px-5 py-12 sm:px-8 md:grid-cols-[.7fr_1.3fr] lg:py-16"
        >
          <div>
            <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
              <i class="fas fa-calendar-alt mr-2"></i>THE QFCC CALENDAR
            </p>
            <h2 class="font-serif text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#00583f]">
              Make room<br />for community.
            </h2>
          </div>
          <p class="text-base leading-[1.85] text-slate-600">
            Our calendar is filled with opportunities to grow, connect, and care for one another. Join us at an
            upcoming gathering and help make the next moment meaningful.
          </p>
        </div>
      </section>

      <!-- ================= FEATURED EVENT ================= -->
      <section id="featured" class="mx-auto max-w-[1200px] px-5 py-10 sm:px-8 lg:py-16">
        <div class="grid items-center gap-10 md:grid-cols-[1.1fr_1fr] md:gap-14">
          <!-- Image -->
          <div
            class="group relative overflow-hidden rounded-[20px] shadow-[0_20px_60px_rgba(0,65,47,0.15)]"
          >
            <img
              src="/storage/images/event-iftar.jpg"
              alt="Community members sharing an iftar meal"
              class="block h-[380px] w-full object-cover transition-transform duration-700 group-hover:scale-105 md:h-[480px]"
            />
            <span
              class="absolute left-5 top-5 inline-flex items-center rounded-full bg-[#e0ac2e] px-4 py-2.5 text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#002d21] shadow-[0_4px_15px_rgba(224,172,46,0.4)]"
            >
              <i class="fas fa-star mr-2"></i>FEATURED EVENT
            </span>
          </div>

          <!-- Copy -->
          <div>
            <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
              <i class="fas fa-calendar-day mr-2"></i>SUN, JUNE 08, 2025
            </p>

            <h2 class="mt-2 mb-5 font-serif text-[clamp(1.75rem,3.5vw,2.5rem)] font-bold leading-tight text-[#00583f]">
              QFCC Community<br />Iftar Dinner
            </h2>

            <p class="mb-7 text-[0.95rem] leading-[1.85] text-slate-600">
              Come together around the table for an evening of fellowship, reflection,
              and gratitude. Everyone is welcome to share in this community gathering.
            </p>

            <div
              class="mb-6 flex flex-wrap gap-6 border-y border-slate-200 py-5"
            >
              <span class="flex flex-col gap-1 text-sm font-semibold text-slate-600">
                <b class="flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                  <i class="fas fa-clock mr-1"></i>TIME
                </b>
                6:00 PM
              </span>
              <span class="flex flex-col gap-1 text-sm font-semibold text-slate-600">
                <b class="flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                  <i class="fas fa-map-marker-alt mr-1"></i>PLACE
                </b>
                Queens, New York
              </span>
            </div>

            <a
              href="#contact"
              class="mt-2 inline-flex items-center justify-center rounded-full bg-[#00583f] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#003c2b] hover:shadow-[0_10px_30px_rgba(0,88,63,0.3)] group"
            >
              SAVE YOUR SPOT
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </section>

      <!-- ================= UPCOMING EVENTS ================= -->
      <section id="upcoming" class="bg-gradient-to-b from-white to-[#fbfaf4]">
        <div class="mx-auto max-w-[1200px] px-5 py-12 sm:px-8 lg:py-16">
          <!-- Heading -->
          <div class="mb-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
              <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
                <i class="fas fa-forward mr-2"></i>WHAT'S NEXT
              </p>
              <h2 class="font-serif text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#00583f]">
                Upcoming events
              </h2>
            </div>

            <div class="flex flex-wrap gap-2" role="group" aria-label="Event filters">
              <button
                v-for="tab in filterTabs"
                :key="tab.value"
                @click="activeFilter = tab.value"
                :class="[
                  'inline-flex items-center rounded-full border-2 px-5 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.1em] transition-all duration-300',
                  activeFilter === tab.value
                    ? 'border-[#00583f] bg-[#00583f] text-white shadow-[0_6px_20px_rgba(0,88,63,0.25)]'
                    : 'border-slate-200 bg-white text-slate-600 hover:-translate-y-0.5 hover:border-[#00583f] hover:text-[#00583f]',
                ]"
              >
                <i :class="[tab.icon, 'mr-2']"></i>{{ tab.label }}
              </button>
            </div>
          </div>

          <!-- Grid -->
          <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Event cards -->
            <article
              v-for="event in filteredEvents"
              :key="event.id"
              class="group relative flex flex-col overflow-hidden rounded-[20px] bg-white shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,65,47,0.15)]"
            >
              <!-- Top gradient bar -->
              <div
                class="absolute inset-x-0 top-0 z-10 h-1 origin-left scale-x-0 bg-gradient-to-r from-[#e0ac2e] to-[#00583f] transition-transform duration-500 group-hover:scale-x-100"
              ></div>

              <div class="relative h-[220px] overflow-hidden">
                <img
                  :src="event.image"
                  :alt="event.title"
                  class="block h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <span
                  class="absolute right-4 top-4 flex min-w-[58px] flex-col items-center rounded-xl bg-white px-3 py-2 text-center shadow-[0_4px_15px_rgba(0,0,0,0.15)]"
                >
                  <b class="text-[0.6rem] font-extrabold uppercase tracking-[0.1em] text-[#e0ac2e]">
                    {{ event.month }}
                  </b>
                  <strong class="font-serif text-2xl font-bold leading-none text-[#00583f]">
                    {{ event.day }}
                  </strong>
                </span>
              </div>

              <div class="flex flex-1 flex-col p-7">
                <p
                  class="mb-3 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]"
                >
                  <i class="fas fa-tag mr-1"></i>{{ event.category }}
                </p>

                <h3 class="mb-3 font-serif text-xl font-bold leading-tight text-[#00583f]">
                  {{ event.title }}
                </h3>

                <p class="mb-5 flex-1 text-sm leading-7 text-slate-600">
                  {{ event.description }}
                </p>

                <div class="flex items-center justify-between border-t border-slate-100 pt-5">
                  <span class="flex items-center text-xs font-semibold text-slate-500">
                    <i class="fas fa-clock mr-1"></i>{{ event.time }}
                  </span>
                  <a
                    href="#contact"
                    :aria-label="`Learn more about ${event.title}`"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#fbfaf4] text-[#00583f] transition-all duration-300 hover:scale-110 hover:bg-[#00583f] hover:text-white group/arrow"
                  >
                    <i class="fas fa-arrow-right transition-transform group-hover/arrow:translate-x-0.5"></i>
                  </a>
                </div>
              </div>
            </article>

            <!-- Propose event card -->
            <article
              class="relative flex flex-col items-start justify-center overflow-hidden rounded-[20px] bg-gradient-to-br from-[#00583f] to-[#002d21] p-8 text-white"
            >
              <div
                class="pointer-events-none absolute -right-1/2 -top-1/2 h-[200%] w-[200%]"
                style="
                  background: radial-gradient(
                    circle,
                    rgba(224, 172, 46, 0.08) 0%,
                    transparent 70%
                  );
                "
              ></div>

              <div
                class="relative mb-6 flex h-[60px] w-[60px] items-center justify-center rounded-full border-2 border-dashed border-[#e0ac2e]/40 bg-[#e0ac2e]/15 text-xl text-[#e0ac2e] transition-all duration-300 hover:rotate-90 hover:scale-110 hover:bg-[#e0ac2e]/25"
              >
                <i class="fas fa-plus"></i>
              </div>

              <p class="relative mb-3 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">
                <i class="fas fa-lightbulb mr-1"></i>YOUR NEXT STEP
              </p>

              <h3 class="relative mb-4 font-serif text-2xl font-bold leading-tight text-white">
                Bring your idea to life.
              </h3>

              <p class="relative mb-6 text-sm leading-7 text-white/80">
                Have a workshop, gathering, or service idea for the community? We would love to hear it.
              </p>

              <a
                href="#contact"
                class="relative mt-auto inline-flex items-center rounded-full border-2 border-[#e0ac2e]/30 px-5 py-3 text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e] transition-all duration-300 hover:border-[#e0ac2e] hover:bg-[#e0ac2e] hover:text-[#002d21] group"
              >
                PROPOSE AN EVENT
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </a>
            </article>
          </div>
        </div>
      </section>

      <!-- ================= CTA ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#fbfaf4] to-white">
        <div
          class="pointer-events-none absolute -right-24 -top-24 h-[300px] w-[300px] rounded-full"
          style="
            background: radial-gradient(
              circle,
              rgba(224, 172, 46, 0.1) 0%,
              transparent 70%
            );
          "
        ></div>

        <div
          class="relative mx-auto flex max-w-[1200px] flex-col gap-7 px-5 py-12 sm:px-8 md:flex-row md:items-center md:justify-between lg:py-16"
        >
          <div>
            <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
              <i class="fas fa-hands-helping mr-2"></i>BE PART OF THE STORY
            </p>
            <h2 class="font-serif text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#00583f]">
              There is always room<br />for one more.
            </h2>
          </div>

          <div class="max-w-[420px]">
            <p class="mb-6 text-[0.95rem] leading-7 text-slate-600">
              Bring your time, talent, or simply your presence. Community grows when we show up for each other.
            </p>
            <a
              href="#involved"
              class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group"
            >
              GET INVOLVED
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </a>
          </div>
        </div>
      </section>
    </main>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, computed } from 'vue'

/* ---------- Filters ---------- */
const filterTabs = [
  { value: 'all', label: 'ALL EVENTS', icon: 'fas fa-th-large' },
  { value: 'youth', label: 'YOUTH', icon: 'fas fa-child' },
  { value: 'wellness', label: 'WELLNESS', icon: 'fas fa-heartbeat' },
]
const activeFilter = ref('all')

/* ---------- Event Data ---------- */
const events = [
  {
    id: 1,
    category: 'youth',
    categoryLabel: 'YOUTH DEVELOPMENT',
    month: 'JUN',
    day: '15',
    title: 'Youth Leadership Workshop',
    description:
      'Build confidence, leadership skills, and positive community connections in an afternoon designed for young people.',
    time: '2:00 PM · Queens, NY',
    image: '/storage/images/event-youth.jpg',
  },
  {
    id: 2,
    category: 'wellness',
    categoryLabel: 'HEALTH & WELLNESS',
    month: 'JUN',
    day: '22',
    title: 'Health & Wellness Seminar',
    description:
      'Learn practical ways to support healthy living, raise awareness, and care for wellness across generations.',
    time: '1:00 PM · Queens, NY',
    image: '/storage/images/event-health.jpg',
  },
].map((e) => ({
  ...e,
  category: e.categoryLabel,
}))

/* ---------- Filtered Events ---------- */
const filteredEvents = computed(() => {
  if (activeFilter.value === 'all') return events
  return events.filter((e) => e.categoryLabel.toLowerCase().includes(activeFilter.value))
})
</script>

<style scoped>
/* ---------- Custom pattern for hero ---------- */
.events-hero-pattern {
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

/* ---------- Smooth scroll ---------- */
html {
  scroll-behavior: smooth;
}

/* ---------- Focus rings ---------- */
*:focus-visible {
  outline: 2px solid #e0ac2e;
  outline-offset: 2px;
}
</style>