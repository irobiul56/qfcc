<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Page state variables
const isMobileMenuOpen = ref(false)
const activeCategory = ref('all')
const activeModal = ref(null)

// Dynamic Programs & Services Data Model
const services = [
  {
    id: 1,
    number: '01',
    category: 'family',
    title: 'FAMILY & COMMUNITY SERVICES',
    description: 'Programs intended to strengthen families and improve community well-being.',
    image: '/storage/images/why-family.jpg',
    icon: '♡',
    items: [
      'Family counseling & guidance',
      'Marriage & parenting workshops',
      'Community resource referrals',
      'Financial literacy programs'
    ],
    fullDetails: 'Our Family & Community Services offer holistic guidance for individuals and families. We host group workshops, one-on-one family mentorship, and direct financial counseling to navigate modern community challenges with faith-inspired resilience.'
  },
  {
    id: 2,
    number: '02',
    category: 'youth',
    title: 'YOUTH DEVELOPMENT',
    description: 'Helping young people grow with confidence, character, and direction.',
    image: '/storage/images/event-youth.jpg',
    icon: '♙',
    items: [
      'Leadership development',
      'Mentorship programs',
      'Sports & recreation',
      'College & career readiness',
      'Character building'
    ],
    fullDetails: 'Empowering the next generation with constructive youth leadership bootcamps, structured sports programs, academic tutoring, and career readiness panels that connect youth with industry professionals.'
  },
  {
    id: 3,
    number: '03',
    category: 'health',
    title: 'HEALTH & WELLNESS',
    description: 'Supporting healthy living, awareness, and connection across generations.',
    image: '/storage/images/event-health.jpg',
    icon: '♥',
    items: [
      'Health screenings',
      'Mental health awareness',
      'Wellness workshops',
      'Senior support programs'
    ],
    fullDetails: 'Promoting physical and mental health through community wellness fairs, free routine health checks, specialized senior care groups, and accessible mental health support circles.'
  },
  {
    id: 4,
    number: '04',
    category: 'humanitarian',
    title: 'FOOD PANTRY & HUMANITARIAN RELIEF',
    description: 'Meeting urgent needs with compassion, dignity, and reliable community support.',
    image: '/storage/images/support.png',
    icon: '▣',
    items: [
      'Emergency food assistance',
      'Ramadan food distribution',
      'Winter clothing drives',
      'Disaster relief efforts'
    ],
    fullDetails: 'Our weekly food pantry and seasonal humanitarian drives ensure that no family in our community goes without essential groceries, warm clothes, and urgent emergency aid.'
  },
  {
    id: 5,
    number: '05',
    category: 'immigrant',
    title: 'IMMIGRANT & REFUGEE SUPPORT',
    description: 'Helping newcomers navigate resources and feel at home in their community.',
    image: '/storage/images/member.png',
    icon: '◉',
    items: [
      'Newcomer orientation',
      'Citizenship resources',
      'Translation & interpretation',
      'Social service navigation'
    ],
    fullDetails: 'Providing soft landing assistance for newly arrived families including English conversation circles, document translation assistance, legal referral networks, and local orientation.'
  },
  {
    id: 6,
    number: '06',
    category: 'spiritual',
    title: 'RELIGIOUS & SPIRITUAL SERVICES',
    description: 'Creating opportunities for learning, reflection, guidance, and spiritual growth.',
    image: '/storage/images/quran.png',
    icon: '✦',
    items: [
      'Educational lectures',
      'Adult & youth halaqa',
      'Interfaith dialogue',
      'Hajj & Umrah services',
      'Marriage & divorce guidance'
    ],
    fullDetails: 'Fostering deep spiritual development through regular study circles, faith-based counseling, interfaith bridge-building sessions, and community educational events.'
  }
]

// Toggle Mobile Menu
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value
}

// Open modal detail view
const openServiceModal = (service) => {
  activeModal.value = service
}

// Close modal detail view
const closeModal = () => {
  activeModal.value = null
}

// Scroll Intersection Observer for Vue lifecycle
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
</script>

<template>
  <AppLayout>
    <Head title="Programs & Services — QFCC" />

 

    <main>
      <!-- Hero Section -->
      <section class="hero relative overflow-hidden bg-[#003d2c]">
        <img src="/storage/images/hero.jpg" alt="QFCC volunteers serving the community" class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-1000 hover:scale-105" />
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
              <Link href="/get-involved" class="inline-flex items-center gap-2 rounded bg-[#d9a52b] px-4 py-2.5 text-xs font-extrabold text-white transition hover:-translate-y-0.5 hover:brightness-105 border border-[#efc55c]">
                GET INVOLVED <span>→</span>
              </Link>
            </div>
          </div>
        </div>
      </section>

      <!-- Mission Statement Section -->
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

      <!-- Main Interactive Services Directory -->
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
          <Link href="/contact" class="inline-flex items-center gap-2 border-b border-[#d9a52b] pb-1 text-[10px] font-extrabold tracking-wider text-[#00583f] hover:text-[#d9a52b] transition-colors">
            TALK TO OUR TEAM <span class="text-[#d9a52b] text-base leading-none">↗</span>
          </Link>
        </div>

        <!-- Services Cards Grid -->
        <div class="grid grid-cols-1 gap-4 pt-7 lg:grid-cols-2 lg:pt-5">
          <!-- Standard Cards (Vue Dynamic Render) -->
          <article 
            v-for="service in services" 
            :key="service.id" 
            class="reveal-on-scroll transition-all duration-500 opacity-0 translate-y-4 flex flex-col justify-between rounded-lg border border-[#e2e6de] border-t-4 border-t-[#d9a52b] bg-gradient-to-b from-white to-[#fcfdf9] p-[18px] hover:-translate-y-1 hover:border-t-[#00583f] hover:shadow-lg"
          >
            <div>
              <div class="flex items-center justify-between mb-3">
                <span class="rounded-full border border-[#e4e8e1] px-2.5 py-1 font-serif text-xs font-bold text-[#7a877f]">{{ service.number }}</span>
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#00583f] text-xl text-white font-bold">{{ service.icon }}</div>
              </div>
              <img :src="service.image" :alt="service.title" class="mb-4 h-[200px] w-full rounded-md object-cover" />
              <h3 class="font-serif text-sm font-bold text-[#003d2c] leading-snug">{{ service.title }}</h3>
              <p class="my-2 text-xs leading-relaxed text-[#59645e]">{{ service.description }}</p>
              <ul class="my-3 space-y-1">
                <li v-for="(item, idx) in service.items" :key="idx" class="relative pl-3 text-[11px] text-[#344139] before:absolute before:left-0 before:top-2 before:h-1.5 before:w-1.5 before:rounded-full before:bg-[#d9a52b]">
                  {{ item }}
                </li>
              </ul>
            </div>
            
            <button 
              @click="openServiceModal(service)" 
              class="mt-4 flex w-full items-center justify-between border-t border-[#edf0ea] pt-3 text-[10px] font-extrabold tracking-wider text-[#00583f] hover:text-[#d9a52b]"
            >
              EXPLORE DETAILS <b class="text-base text-[#d9a52b]">→</b>
            </button>
          </article>

          <!-- Featured Wide Card (#07) -->
          <article class="reveal-on-scroll transition-all duration-500 opacity-0 translate-y-4 relative overflow-hidden rounded-lg bg-gradient-to-br from-[#004c37] via-[#00583f] to-[#08745a] p-6 text-white shadow-xl sm:col-span-2 lg:col-span-2 flex flex-col justify-between group">
            <img src="/storage/images/calligraphy.jpg" alt="Calligraphy overlay" class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-screen transition-transform duration-700 group-hover:scale-105 group-hover:opacity-30" />
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-[#003d2c]/95 via-[#00583f]/85 to-[#00583f]/55"></div>
            
            <div class="relative z-10">
              <div class="flex items-center justify-between mb-4">
                <span class="rounded-full border border-white/25 px-2.5 py-1 font-serif text-xs font-bold text-white/80">07</span>
                <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#d9a52b] text-xl text-white font-bold">♧</div>
              </div>
              <span class="mb-1 block text-[10px] font-extrabold tracking-[.18em] text-[#f1ca69]">MAKE AN IMPACT</span>
              <h3 class="font-serif text-lg font-bold text-white">VOLUNTEER &amp; CIVIC ENGAGEMENT</h3>
              <p class="mt-2 mb-4 text-xs text-white/85">Turning shared values into practical action and stronger neighborhood partnerships.</p>

              <ul class="grid gap-2 sm:grid-cols-2 my-4">
                <li class="relative pl-3 text-xs text-white/90 before:absolute before:left-0 before:top-2 before:h-1.5 before:w-1.5 before:rounded-full before:bg-[#f1ca69]">Volunteer opportunities</li>
                <li class="relative pl-3 text-xs text-white/90 before:absolute before:left-0 before:top-2 before:h-1.5 before:w-1.5 before:rounded-full before:bg-[#f1ca69]">Community outreach</li>
                <li class="relative pl-3 text-xs text-white/90 before:absolute before:left-0 before:top-2 before:h-1.5 before:w-1.5 before:rounded-full before:bg-[#f1ca69]">Community service projects</li>
                <li class="relative pl-3 text-xs text-white/90 before:absolute before:left-0 before:top-2 before:h-1.5 before:w-1.5 before:rounded-full before:bg-[#f1ca69]">Civic education &amp; engagement</li>
              </ul>
            </div>

            <Link href="/get-involved" class="relative z-10 mt-4 flex items-center justify-between border-t border-white/20 pt-3 text-[10px] font-extrabold tracking-wider text-[#f1ca69] hover:text-white transition-colors">
              FIND YOUR ROLE <b class="text-base text-white">→</b>
            </Link>
          </article>
        </div>
      </section>

      <!-- Responsible Support Note -->
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

      <!-- Call to Action Band -->
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
            <Link href="/get-involved" class="inline-flex items-center gap-2 rounded bg-[#d9a52b] px-5 py-3 text-xs font-extrabold text-white transition hover:bg-[#c49323]">
              GET INVOLVED <span>→</span>
            </Link>
          </div>
        </div>
      </section>
    </main>

    <!-- Modal for Detailed Service Views -->
    <div v-if="activeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
      <div class="relative w-full max-w-lg rounded-xl bg-white p-6 shadow-2xl transition-all">
        <button @click="closeModal" class="absolute right-4 top-4 text-2xl font-bold text-slate-400 hover:text-slate-700">✕</button>
        <div class="flex items-center gap-3 mb-4">
          <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#00583f] text-white text-lg font-bold">{{ activeModal.icon }}</div>
          <div>
            <span class="text-xs font-bold text-[#d9a52b]">SERVICE #{{ activeModal.number }}</span>
            <h3 class="font-serif text-lg font-bold text-[#003d2c]">{{ activeModal.title }}</h3>
          </div>
        </div>
        <img :src="activeModal.image" :alt="activeModal.title" class="h-48 w-full rounded-lg object-cover mb-4" />
        <p class="text-sm text-slate-600 leading-relaxed mb-4">{{ activeModal.fullDetails }}</p>
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
          <button @click="closeModal" class="rounded border border-slate-300 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">Close</button>
          <Link href="/contact" class="rounded bg-[#00583f] px-4 py-2 text-xs font-bold text-white hover:bg-[#004c37]">Inquire About Service</Link>
        </div>
      </div>
    </div>
  </AppLayout>
</template>