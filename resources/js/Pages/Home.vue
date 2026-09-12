<template>
  <AppLayout title="Welcome">
  <div class="min-h-screen flex flex-col">
    <!-- Main Content -->
    <main class="flex-1">
      <!-- Hero -->
      <section class="relative overflow-hidden min-h-[520px] sm:min-h-[570px] lg:min-h-[520px] isolate">
        <img
          src="/storage/images/hero.jpg"
          alt="QFCC community volunteers serving families"
          class="absolute inset-0 h-full w-full object-cover object-center transition-transform duration-[1.2s] ease hover:scale-[1.012] sm:object-[62%_center]"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-[#002d21]/95 via-[#003c2b]/75 to-transparent" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent pointer-events-none" />
        <!-- Mobile overlay -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#002a1e]/94 via-[#003728]/78 to-[#003728]/35 sm:hidden z-0" />

        <div class="relative mx-auto flex min-h-[430px] max-w-[1500px] items-center px-5 py-14 sm:px-8 lg:min-h-[520px] lg:px-12 z-[2]">
          <div class="max-w-[500px] text-white sm:max-w-full">
            <h1 class="font-serif text-4xl font-bold leading-[1.04] sm:text-5xl lg:text-[52px]">
              Together today,<br>
              <span class="text-[#e0ac2e]">building a better tomorrow.</span>
            </h1>
            <p class="mt-6 max-w-[470px] text-base leading-7 text-white/95 sm:text-lg">
              QFCC is dedicated to strengthening families, empowering youth, supporting seniors,
              assisting immigrants and newcomers, and serving individuals and families in need.
            </p>
            <div class="mt-7 flex flex-wrap gap-4">
              <a href="#about" class="inline-flex items-center justify-center gap-2 rounded-md px-4 py-2.5 text-xs font-extrabold tracking-wide transition-all duration-200 border border-[#74a895] bg-[#00583f] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)] sm:min-w-[145px]">LEARN ABOUT QFCC <span>→</span></a>
              <a href="#involved" class="inline-flex items-center justify-center gap-2 rounded-md px-4 py-2.5 text-xs font-extrabold tracking-wide transition-all duration-200 border border-[#efc55c] bg-[#dca62b] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)] sm:min-w-[145px]">GET INVOLVED <span>→</span></a>
            </div>
          </div>
        </div>
      </section>

      <!-- Vision / Mission -->
      <section id="about" class="bg-[#fbfaf4]">
        <div class="mx-auto grid max-w-[1200px] gap-8 px-5 py-9 md:grid-cols-2 md:gap-0 md:px-8">
          <div class="grid grid-cols-[64px_1fr] gap-[18px] items-start md:grid-cols-[52px_1fr]">
            <div class="w-[58px] h-[58px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-[28px] font-bold flex-shrink-0 transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)] md:w-[50px] md:h-[50px]">◉</div>
            <div>
              <h2 class="m-0 mb-2 text-[#00583f] text-lg font-extrabold">OUR VISION</h2>
              <p class="m-0 text-xs leading-[1.55] max-w-[480px]">To build a compassionate, educated, empowered, and united community where individuals and families thrive through faith, knowledge, service, leadership, and civic engagement.</p>
            </div>
          </div>
          <div class="grid grid-cols-[64px_1fr] gap-[18px] items-start md:grid-cols-[52px_1fr] md:pl-10 border-t border-[#ddd] pt-7 md:border-t-0 md:pt-0 md:border-l md:pl-10">
            <div class="w-[58px] h-[58px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-[28px] font-bold flex-shrink-0 transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)] md:w-[50px] md:h-[50px]">◎</div>
            <div>
              <h2 class="m-0 mb-2 text-[#00583f] text-lg font-extrabold">OUR MISSION</h2>
              <p class="m-0 text-xs leading-[1.55] max-w-[480px]">Serving humanity through the teachings of the Holy Qur'an and the Sunnah of Prophet Muhammad ﷺ by strengthening families, providing educational opportunities, empowering youth, supporting seniors and vulnerable individuals, assisting immigrants and newcomers, and providing humanitarian and community support.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Programs -->
      <section id="programs" class="mx-auto max-w-[1500px] px-4 py-9 sm:px-6">
        <div class="text-center mb-[14px]">
          <h2 class="text-[#00583f] font-serif text-xl font-extrabold m-0">OUR PROGRAMS &amp; SERVICES</h2>
          <div class="relative w-[260px] max-w-[70%] h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-[#d9a52b] to-transparent [background-size:70%_100%] [background-position:center] [background-repeat:no-repeat]">
            <div class="absolute left-1/2 top-[-13px] -translate-x-1/2 text-[#d9a52b] bg-white px-1.5 text-base">✣</div>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-[6px] sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8">
          <article v-for="program in programs" :key="program.id" class="min-h-[220px] sm:min-h-[225px] md:min-h-[220px] p-[14px_8px_11px] border border-[#ddd] rounded-md text-center flex flex-col items-center bg-gradient-to-b from-white to-[#fcfdf9] transition-all duration-300 hover:border-[#b8cfc4] hover:shadow-[0_10px_28px_rgba(0,65,47,0.08)] hover:-translate-y-[3px]">
            <div class="w-[40px] h-[40px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-2x2 mb-[9px] transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">
              <i :class="program.icon"></i>
            </div>
            <h3 class="m-0 text-[#00583f] text-[11px] leading-[1.18] font-extrabold" v-html="program.title" />
            <p class="text-[9px] sm:text-[8.5px] leading-[1.55] m-[10px_2px_9px] flex-1 text-gray-700">{{ program.description }}</p>
            <a href="#" class="text-[#00583f] text-[9px] font-extrabold transition-all duration-200 hover:text-[#d09b20] hover:tracking-[0.02em]">Learn More →</a>
          </article>
        </div>
      </section>

      <!-- CTA Cards -->
      <section id="involved" class="mx-auto max-w-[1500px] px-4 pb-8 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-[14px]">
          <article class="min-h-[202px] grid grid-cols-1 sm:grid-cols-[1fr_0.95fr] overflow-hidden border border-[#e1e1dc] rounded-md bg-[#f7f8f1] shadow-[0_4px_16px_rgba(0,50,35,0.035)] transition-all duration-300 hover:border-[#bfd1c8] hover:shadow-[0_12px_30px_rgba(0,65,47,0.1)]">
            <div class="p-[15px_15px_12px]">
              <div class="w-[42px] h-[42px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-[22px] font-bold transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">♣</div>
              <h3 class="m-[7px_0] text-sm text-[#004d38] font-extrabold">VOLUNTEER</h3>
              <p class="text-[10px] leading-[1.45] m-0 mb-3">Share your time, skills and passion to make a difference in our community.</p>
              <a href="#" class="inline-flex items-center justify-center gap-2 rounded-md px-[10px] py-2 text-[9px] font-extrabold tracking-wide transition-all duration-200 border border-[#74a895] bg-[#00583f] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)]">BECOME A VOLUNTEER</a>
            </div>
            <img src="/storage/images/volunteer.png" alt="QFCC volunteers" class="w-full h-[150px] sm:h-full sm:min-h-[202px] object-cover transition-transform duration-500 hover:scale-[1.035]">
          </article>

          <article class="min-h-[202px] grid grid-cols-1 sm:grid-cols-[1fr_0.95fr] overflow-hidden border border-[#e1e1dc] rounded-md bg-[#f7f8f1] shadow-[0_4px_16px_rgba(0,50,35,0.035)] transition-all duration-300 hover:border-[#bfd1c8] hover:shadow-[0_12px_30px_rgba(0,65,47,0.1)]">
            <div class="p-[15px_15px_12px]">
              <div class="w-[42px] h-[42px] rounded-full bg-[#d9a52b] text-white flex items-center justify-center text-[22px] font-bold transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">♣</div>
              <h3 class="m-[7px_0] text-sm text-[#004d38] font-extrabold">BECOME A MEMBER</h3>
              <p class="text-[10px] leading-[1.45] m-0 mb-3">Join QFCC and be part of a growing community of families, professionals, educators and community leaders.</p>
              <a href="#" class="inline-flex items-center justify-center gap-2 rounded-md px-[10px] py-2 text-[9px] font-extrabold tracking-wide transition-all duration-200 border border-[#efc55c] bg-[#dca62b] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)]">BECOME A MEMBER</a>
            </div>
            <img src="/storage/images/member.png" alt="QFCC family" class="w-full h-[150px] sm:h-full sm:min-h-[202px] object-cover transition-transform duration-500 hover:scale-[1.035]">
          </article>

          <article id="donate" class="min-h-[202px] grid grid-cols-1 sm:grid-cols-[1fr_0.95fr] overflow-hidden border border-[#e1e1dc] rounded-md bg-[#f7f8f1] shadow-[0_4px_16px_rgba(0,50,35,0.035)] transition-all duration-300 hover:border-[#bfd1c8] hover:shadow-[0_12px_30px_rgba(0,65,47,0.1)]">
            <div class="p-[15px_15px_12px]">
              <div class="w-[42px] h-[42px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-[22px] font-bold transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">♡</div>
              <h3 class="m-[7px_0] text-sm text-[#004d38] font-extrabold">SUPPORT OUR WORK</h3>
              <p class="text-[10px] leading-[1.45] m-0 mb-3">Your support helps us expand educational, humanitarian, youth, senior and family programs.</p>
              <a href="/donate" class="inline-flex items-center justify-center gap-2 rounded-md px-[10px] py-2 text-[9px] font-extrabold tracking-wide transition-all duration-200 border border-[#74a895] bg-[#00583f] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)]">DONATE / SUPPORT QFCC</a>
            </div>
            <img src="/storage/images/support.png" alt="Support QFCC" class="w-full h-[150px] sm:h-full sm:min-h-[202px] object-cover transition-transform duration-500 hover:scale-[1.035]">
          </article>
        </div>
      </section>

      <!-- Events + Quote -->
      <section id="events" class="mx-auto grid max-w-[1500px] gap-6 px-4 pb-10 sm:px-6 lg:grid-cols-[0.95fr_1.8fr]">
        <div class="border border-[#e4e4df] rounded-md p-[12px_12px_9px] bg-white transition-all duration-300 hover:shadow-[0_10px_28px_rgba(0,65,47,0.065)]">
          <div class="text-[#00583f] text-base font-extrabold mb-2">
            <span class="text-[22px] mr-[7px]">▦</span> UPCOMING EVENTS
          </div>

          <div v-for="event in upcomingEvents" :key="event.id" class="grid grid-cols-[45px_1fr_54px] items-center gap-2 py-[7px] border-b border-[#eee] transition-all duration-200 rounded-[5px] hover:bg-[#f8faf5] hover:pl-[5px]">
            <div class="w-10 rounded-[5px] overflow-hidden bg-[#00583f] text-white text-center flex-shrink-0">
              <b class="block bg-[#f2f2eb] text-[#00583f] text-[8px] py-[3px]">{{ event.month }}</b>
              <strong class="block text-[17px] py-[3px]">{{ event.day }}</strong>
            </div>
            <div class="event-text min-w-0">
              <b class="block text-[10px] truncate">{{ event.title }}</b>
              <small class="block text-[8px] leading-[1.4] text-[#555] mt-0.5">{{ event.dateTime }}<br>{{ event.location }}</small>
            </div>
            <img :src="event.image" :alt="event.title" class="w-[54px] h-[37px] object-cover rounded-[3px] flex-shrink-0">
          </div>

          <a href="#" class="block mt-2 text-right text-[#00583f] text-[9px] font-extrabold">VIEW ALL EVENTS →</a>
        </div>

        <div class="relative min-h-[280px] sm:min-h-[330px] overflow-hidden rounded-md bg-[#f4f0e6] flex items-center justify-between border border-[#e7e2d6] transition-all duration-300 hover:shadow-[0_10px_28px_rgba(0,65,47,0.065)]">
          <div class="absolute inset-0 opacity-16 bg-[radial-gradient(#8b7e66_0.6px,transparent_0.6px)] bg-[length:8px_8px]" />
          <div class="relative z-[1] w-full sm:w-[67%] text-center p-[22px_18px] sm:p-[20px_10px_20px_24px]">
            <div class="font-serif text-[#00583f] text-xl sm:text-[20px] leading-[1.8]">وَلْتَكُن مِّنكُمْ أُمَّةٌ يَدْعُونَ إِلَى الْخَيْرِ<br>وَيَأْمُرُونَ بِالْمَعْرُوفِ وَيَنْهَوْنَ عَنِ الْمُنكَرِ</div>
            <p class="font-serif text-xs sm:text-[12px] leading-[1.6] m-[14px_0_8px]">“Let there arise from among you a community inviting<br class="hidden sm:block"> to what is good, encouraging what is right and<br class="hidden sm:block"> discouraging what is wrong.”</p>
            <span class="font-serif text-[11px]">– Qur'an 3:104</span>
          </div>
          <img src="/storage/images/quran.png" alt="Quran on wooden stand" class="relative z-[1] hidden sm:block w-[34%] h-full object-cover object-left-center mix-blend-multiply transition-transform duration-500 hover:scale-[1.025]">
        </div>
      </section>
    </main>
  </div>
</AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const mobileMenuOpen = ref(false)

const programs = ref([
  {
    id: 1,
    icon: 'fas fa-graduation-cap',
    title: 'EDUCATION &amp;<br>LIFELONG LEARNING',
    description: 'Islamic education, tutoring, workshops, seminars, and personal &amp; professional development.'
  },
  {
    id: 2,
    icon: 'fas fa-users',
    title: 'YOUTH<br>DEVELOPMENT',
    description: 'Building leadership, confidence, strong character, and positive community connections.'
  },
  {
    id: 3,
    icon: 'fas fa-home',
    title: 'FAMILY &amp;<br>COMMUNITY SUPPORT',
    description: 'Programs and resources to strengthen families and help individuals overcome challenges.'
  },
  {
    id: 4,
    icon: 'fas fa-user-plus',
    title: 'SENIOR<br>SERVICES',
    description: 'Community engagement, social support, wellness programs, and assistance for seniors.'
  },
  {
    id: 5,
    icon: 'fas fa-plane',
    title: 'IMMIGRANT &amp;<br>NEWCOMER SUPPORT',
    description: 'Guidance, referrals, language support, community orientation and resources for a fresh start.'
  },
  {
    id: 6,
    icon: 'fas fa-utensils',
    title: 'FOOD &amp;<br>HUMANITARIAN ASSISTANCE',
    description: 'Food distribution, emergency assistance, and support for families in need.'
  },
  {
    id: 7,
    icon: 'fas fa-heartbeat',
    title: 'HEALTH &amp;<br>WELLNESS',
    description: 'Health education, wellness awareness, referrals, and programs for healthy living.'
  },
  {
    id: 8,
    icon: 'fas fa-mosque',
    title: 'RELIGIOUS &amp;<br>COMMUNITY SERVICES',
    description: 'Islamic education, religious guidance, Hajj &amp; Umrah information and spiritual development.'
  }
])

const upcomingEvents = ref([
  {
    id: 1,
    month: 'JUN',
    day: '08',
    title: 'QFCC Community Iftar Dinner',
    dateTime: 'Sun, June 8, 2025 · 6:00 PM',
    location: 'Queens, NY',
    image: '/storage/images/event-iftar.jpg'
  },
  {
    id: 2,
    month: 'JUN',
    day: '15',
    title: 'Youth Leadership Workshop',
    dateTime: 'Sun, June 15, 2025 · 2:00 PM',
    location: 'Queens, NY',
    image: '/storage/images/event-youth.jpg'
  },
  {
    id: 3,
    month: 'JUN',
    day: '22',
    title: 'Health &amp; Wellness Seminar',
    dateTime: 'Sun, June 22, 2025 · 1:00 PM',
    location: 'Queens, NY',
    image: '/storage/images/event-health.jpg'
  }
])



</script>