<script setup>
import { ref, h, defineComponent, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

/* ═══════════════════════════════════════════════════════════
   PROPS — from ProgramController
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  programs: { type: Array, default: () => [] },
})

/* ═══════════════════════════════════════════════════════════
   PAGE STATE
   ═══════════════════════════════════════════════════════════ */
const activeModal = ref(null)

const openServiceModal = (program) => {
  activeModal.value = program
}

const closeModal = () => {
  activeModal.value = null
}

/* ═══════════════════════════════════════════════════════════
   SCROLL REVEAL
   ═══════════════════════════════════════════════════════════ */
onMounted(() => {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('opacity-100', 'translate-y-0')
          entry.target.classList.remove('opacity-0', 'translate-y-4')
          observer.unobserve(entry.target)
        }
      })
    },
    { threshold: 0.08 }
  )

  document.querySelectorAll('.reveal-on-scroll').forEach((el) => observer.observe(el))
})

/* ═══════════════════════════════════════════════════════════
   SvgIcon COMPONENT
   ═══════════════════════════════════════════════════════════ */
const SVG_PATHS = {
  'graduation-cap': ['M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5'],
  'users':          ['M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
  'heart':          ['M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z'],
  'user-plus':      ['M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z'],
  'globe':          ['M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
  'utensils':       ['M7.875 14.25l1.214 1.942a2.25 2.25 0 01.28.75v4.808a.75.75 0 01-1.5 0v-3.942L6.9 16.865a2.25 2.25 0 01-.4-1.276V7.125a.75.75 0 011.5 0v6.375zm11.25 4.316a9.765 9.765 0 001.5-4.601V4.125a.75.75 0 00-1.28-.53l-4.05 4.05a.75.75 0 00-.22.53v8.517c0 .414.336.75.75.75H15c.108 0 .214.008.318.023a.75.75 0 00.79-.899l-.001-.001zM6 10.5h12'],
  'heart-pulse':    ['M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z', 'M7.5 12h3l1.5-3 2 4.5 1.5-1.5h2.5'],
  'mosque':         ['M12 2.25c0 0-4.5 3.75-4.5 7.5 0 2.485 2.014 4.5 4.5 4.5s4.5-2.015 4.5-4.5c0-3.75-4.5-7.5-4.5-7.5z', 'M2.25 21h19.5M4.5 21V10.5c0-1.5 1.5-3 1.5-3M19.5 21V10.5c0-1.5-1.5-3-1.5-3', 'M8.25 21v-3a3.75 3.75 0 117.5 0v3'],
  'star':           ['M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z'],
}

const SvgIcon = defineComponent({
  props: {
    name: { type: String, required: true },
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    return () => {
      // Handle both 'graduation-cap' and 'fas fa-graduation-cap'
      let key = props.name || 'star'
      key = key.replace(/^(fas|far|fab|fa-solid|fa-regular|fa-brands|fa)\s+/, '').replace('fa-', '')

      const paths = SVG_PATHS[key] || SVG_PATHS['star']

      return h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: 'none',
        viewBox: '0 0 24 24',
        'stroke-width': props.strokeWidth,
        stroke: 'currentColor',
        class: 'shrink-0',
      }, paths.map((d, i) =>
        h('path', {
          key: i,
          'stroke-linecap': 'round',
          'stroke-linejoin': 'round',
          d,
        })
      ))
    }
  },
})
</script>

<template>
  <AppLayout>
    <Head title="Programs & Services — QFCC" />

    <main>
      <!-- ═══════════ HERO ═══════════ -->
      <section class="hero relative overflow-hidden bg-[#003d2c]">
        <img
          src="/storage/images/hero.jpg"
          alt="QFCC volunteers serving the community"
          class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-1000 hover:scale-105"
        />
        <div class="absolute inset-0 bg-gradient-to-r from-[#002d21]/95 via-[#003c2b]/80 to-transparent"></div>
        <div class="relative mx-auto flex min-h-[430px] max-w-[1500px] items-center px-5 py-14 sm:px-8 lg:min-h-[520px] lg:px-12">
          <div class="max-w-[570px] text-white">
            <p class="mb-4 text-xs font-bold tracking-[0.2em] text-[#e0ac2e]">PROGRAMS &amp; SERVICES</p>
            <h1 class="font-serif text-4xl font-bold leading-[1.04] sm:text-5xl lg:text-[52px]">
              Practical care,<br /><span class="text-[#e0ac2e]">lasting impact.</span>
            </h1>
            <p class="mt-6 max-w-[500px] text-base leading-7 text-white/95 sm:text-lg">
              Faith-inspired services designed to strengthen families and build a caring, connected community.
            </p>
            <div class="mt-7 flex flex-wrap gap-4">
              <a href="#services" class="inline-flex items-center gap-2 rounded bg-[#00583f] px-4 py-2.5 text-xs font-extrabold text-white transition hover:-translate-y-0.5 hover:brightness-105 border border-[#74a895]">
                EXPLORE SERVICES <span>↓</span>
              </a>
              <Link :href="route('get-involved')" class="inline-flex items-center gap-2 rounded bg-[#d9a52b] px-4 py-2.5 text-xs font-extrabold text-white transition hover:-translate-y-0.5 hover:brightness-105 border border-[#efc55c]">
                GET INVOLVED <span>→</span>
              </Link>
            </div>
          </div>
        </div>
      </section>

      <!-- ═══════════ MISSION STATEMENT ═══════════ -->
      <section class="bg-[#fbfaf4] px-5 py-12 sm:px-8 lg:py-14">
        <div class="mx-auto max-w-[1050px] text-center reveal-on-scroll transition-all duration-700 opacity-0 translate-y-4">
          <div class="mb-5 text-center">
            <h2 class="font-serif text-xl font-extrabold text-[#00583f]">DISCOVER QFCC</h2>
            <div class="mx-auto mt-2 h-0.5 w-[260px] max-w-[70%] bg-[#d9a52b]"></div>
          </div>
          <p class="text-sm leading-7 text-slate-600 sm:text-base">
            QFCC provides practical, compassionate, and faith-inspired services designed to strengthen families and build a caring, connected community. From family support and youth development to health and wellness, food assistance, immigrant services, and religious education, our programs respond to the real needs of people in our community.
          </p>
          <p class="mt-4 text-sm leading-7 text-slate-600 sm:text-base">
            We welcome individuals and families from all backgrounds and are committed to serving with dignity, respect, compassion, and excellence. Together, we work to create opportunities, strengthen relationships, and build a better future for our community.
          </p>
        </div>
      </section>

      <!-- ═══════════ SERVICES DIRECTORY ═══════════ -->
      <section id="services" class="relative mx-auto grid max-w-[1250px] scroll-mt-[110px] gap-8 px-5 py-12 sm:px-8 lg:grid-cols-[minmax(220px,.72fr)_minmax(0,1.9fr)] lg:gap-[46px] lg:py-16">

        <!-- Sticky Sidebar -->
        <div class="self-start px-0 py-5 lg:sticky lg:top-[125px]">
          <div class="mb-[22px] text-left">
            <p class="mb-2.5 text-[10px] font-extrabold tracking-[.18em] text-[#d9a52b]">HOW WE HELP</p>
            <h2 class="font-serif text-[25px] font-extrabold text-[#00583f]">OUR SERVICES</h2>
            <div class="mt-2 h-0.5 w-[260px] max-w-[70%] bg-[#d9a52b]"></div>
          </div>
          <p class="max-w-[255px] font-serif text-[25px] font-bold leading-[1.22] text-[#00583f]">
            Practical support for the moments that shape family, faith, and community.
          </p>
          <p class="my-[18px] max-w-[250px] text-sm leading-[1.65] text-[#5d6862]">
            Explore a starting point below. Our team can help connect you with the right program or resource.
          </p>
          <Link :href="route('contact')" class="inline-flex items-center gap-2 border-b border-[#d9a52b] pb-1 text-[10px] font-extrabold tracking-wider text-[#00583f] hover:text-[#d9a52b] transition-colors">
            TALK TO OUR TEAM <span class="text-[#d9a52b] text-base leading-none">↗</span>
          </Link>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 gap-4 pt-7 lg:grid-cols-2 lg:pt-5">

          <!-- Empty state -->
          <div v-if="programs.length === 0" class="col-span-full py-16 text-center text-sm text-slate-400">
            No programs available at the moment.
          </div>

          <!-- Program Cards -->
          <article
            v-for="(program, index) in programs"
            :key="program.id"
            class="reveal-on-scroll transition-all duration-500 opacity-0 translate-y-4 flex flex-col justify-between rounded-lg border border-[#e2e6de] border-t-4 border-t-[#d9a52b] bg-gradient-to-b from-white to-[#fcfdf9] p-[18px] hover:-translate-y-1 hover:border-t-[#00583f] hover:shadow-lg"
          >
            <div>
              <div class="flex items-center justify-between mb-3">
                <span class="rounded-full border border-[#e4e8e1] px-2.5 py-1 font-serif text-xs font-bold text-[#7a877f]">
                  {{ String(index + 1).padStart(2, '0') }}
                </span>
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#00583f] text-white">
                  <SvgIcon :name="program.icon" class="w-5 h-5" />
                </div>
              </div>

              <img
                :src="program.image"
                :alt="program.title"
                class="mb-4 h-[200px] w-full rounded-md object-cover"
              />

              <h3 class="font-serif text-sm font-bold text-[#003d2c] leading-snug">
                {{ program.title }}
              </h3>

              <p class="my-2 text-xs leading-relaxed text-[#59645e]" v-html="program.short_description"> </p>
            </div>

            <button
              @click="openServiceModal(program)"
              class="mt-4 flex w-full items-center justify-between border-t border-[#edf0ea] pt-3 text-[10px] font-extrabold tracking-wider text-[#00583f] hover:text-[#d9a52b] transition-colors"
            >
              EXPLORE DETAILS <b class="text-base text-[#d9a52b]">→</b>
            </button>
          </article>

        </div>
      </section>

      <!-- ═══════════ RESPONSIBLE SUPPORT ═══════════ -->
      <section class="bg-[#fbfaf4] px-5 py-12 sm:px-8 lg:py-14">
        <div class="mx-auto grid max-w-[1200px] items-center gap-8 lg:grid-cols-[.9fr_1.1fr] lg:gap-14">
          <div class="overflow-hidden rounded-lg shadow-lg">
            <img src="/storage/images/why-family.jpg" alt="QFCC families and community members" class="h-[280px] w-full object-cover sm:h-[360px]" />
          </div>
          <div>
            <div class="mb-5 text-left">
              <h2 class="font-serif text-xl font-extrabold text-[#00583f]">RESPONSIBLE SUPPORT</h2>
              <div class="mt-2 h-0.5 w-[260px] max-w-[70%] bg-[#d9a52b]"></div>
            </div>
            <h2 class="mt-5 font-serif text-3xl font-bold leading-tight text-[#00583f] sm:text-4xl">
              Support that respects every person.
            </h2>
            <p class="mt-5 text-sm leading-7 text-slate-600">
              QFCC does not intend to replace licensed professional services where professional licensing is required. When an individual requires specialized legal, medical, psychological, or other professional assistance, QFCC may refer the individual to an appropriate qualified service provider.
            </p>
            <p class="mt-4 text-sm leading-7 text-slate-600">
              Our goal is to connect people with the right support while continuing to walk alongside them with dignity, care, and respect.
            </p>
          </div>
        </div>
      </section>

      <!-- ═══════════ CTA BAND ═══════════ -->
      <section class="mx-auto max-w-[1200px] px-5 py-12 sm:px-8 lg:py-14">
        <div class="reveal-on-scroll transition-all duration-700 opacity-0 translate-y-4 group relative overflow-hidden rounded-lg bg-[#003d2c] text-white shadow-2xl p-8 sm:p-12">
          <img src="/storage/images/calligraphy.jpg" alt="QFCC volunteers" class="absolute inset-0 h-full w-full object-cover opacity-40 transition-transform duration-700 group-hover:scale-105" />
          <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#003d2c]/95 via-[#00583f]/80 to-[#003d2c]/35"></div>

          <div class="relative z-10 max-w-[680px]">
            <p class="mb-3 text-[10px] font-extrabold tracking-[.2em] text-[#f1ca69]">COMMUNITY IN ACTION</p>
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#d9a52b] text-2xl font-bold shadow-lg mb-4">♡</div>
            <h3 class="font-serif text-2xl font-bold text-white sm:text-3xl my-3">HELP US SERVE MORE FAMILIES</h3>
            <p class="max-w-[520px] text-sm leading-relaxed text-white/90 mb-6">
              Your time, partnership, and support help QFCC expand programs that create meaningful and lasting positive change.
            </p>
            <Link :href="route('get-involved')" class="inline-flex items-center gap-2 rounded bg-[#d9a52b] px-5 py-3 text-xs font-extrabold text-white transition hover:bg-[#c49323]">
              GET INVOLVED <span>→</span>
            </Link>
          </div>
        </div>
      </section>
    </main>

    <!-- ═══════════ DETAILS MODAL ═══════════ -->
    <div
      v-if="activeModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
      @click.self="closeModal"
    >
      <div class="relative w-full max-w-lg rounded-xl bg-white p-6 shadow-2xl transition-all max-h-[90vh] overflow-y-auto">
        <button
          @click="closeModal"
          class="absolute right-4 top-4 text-2xl font-bold text-slate-400 hover:text-slate-700"
        >
          ✕
        </button>

        <div class="flex items-center gap-3 mb-4">
          <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#00583f] text-white">
            <SvgIcon :name="activeModal.icon" class="w-6 h-6" />
          </div>
          <div class="min-w-0 flex-1">
            <span class="text-xs font-bold text-[#d9a52b] uppercase tracking-wider">Program Details</span>
            <h3 class="font-serif text-lg font-bold text-[#003d2c] leading-snug">
              {{ activeModal.title }}
            </h3>
          </div>
        </div>

        <img
          :src="activeModal.image"
          :alt="activeModal.title"
          class="h-48 w-full rounded-lg object-cover mb-4"
        />

        <p class="text-sm text-slate-600 leading-relaxed mb-4" v-html="activeModal.full_description || activeModal.short_description"></p>

        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
          <button
            @click="closeModal"
            class="rounded border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
          >
            Close
          </button>
          <Link
            :href="route('contact')"
            class="rounded bg-[#00583f] px-4 py-2 text-xs font-bold text-white hover:bg-[#004c37]"
          >
            Inquire About Program
          </Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>