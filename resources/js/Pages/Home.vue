<template>
  <AppLayout title="Welcome">
    <div class="min-h-screen flex flex-col">
      <main class="flex-1">

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- HERO (STATIC — NOT FROM DATABASE)                  -->
        <!-- ═══════════════════════════════════════════════════ -->
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
                <a href="#about" class="inline-flex items-center justify-center gap-2 rounded-md px-4 py-2.5 text-xs font-extrabold tracking-wide transition-all duration-200 border border-[#74a895] bg-[#00583f] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)] sm:min-w-[145px]">
                  LEARN ABOUT QFCC <span>→</span>
                </a>
                <a href="#involved" class="inline-flex items-center justify-center gap-2 rounded-md px-4 py-2.5 text-xs font-extrabold tracking-wide transition-all duration-200 border border-[#efc55c] bg-[#dca62b] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)] sm:min-w-[145px]">
                  GET INVOLVED <span>→</span>
                </a>
              </div>
            </div>
          </div>
        </section>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- VISION / MISSION (FROM DATABASE)                   -->
        <!-- ═══════════════════════════════════════════════════ -->
        <section id="about" class="bg-[#fbfaf4]">
          <div class="mx-auto grid max-w-[1200px] gap-8 px-5 py-9 md:grid-cols-2 md:gap-0 md:px-8">

            <!-- Vision -->
            <div
              v-if="vision"
              class="grid grid-cols-[64px_1fr] gap-[18px] items-start md:grid-cols-[52px_1fr]"
            >
              <div class="w-[58px] h-[58px] rounded-full bg-[#00583f] text-white flex items-center justify-center flex-shrink-0 transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)] md:w-[50px] md:h-[50px]">
                <SvgIcon :name="vision.icon || 'eye'" class="w-7 h-7" />
              </div>
              <div>
                <h2 class="m-0 mb-2 text-[#00583f] text-lg font-extrabold">
                  {{ vision.heading }}
                </h2>
                <p class="m-0 text-xs leading-[1.55] max-w-[480px]">
                  {{ vision.content }}
                </p>
              </div>
            </div>

            <!-- Mission -->
            <div
              v-if="mission"
              class="grid grid-cols-[64px_1fr] gap-[18px] items-start md:grid-cols-[52px_1fr] md:pl-10 border-t border-[#ddd] pt-7 md:border-t-0 md:pt-0 md:border-l md:pl-10"
            >
              <div class="w-[58px] h-[58px] rounded-full bg-[#00583f] text-white flex items-center justify-center flex-shrink-0 transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)] md:w-[50px] md:h-[50px]">
                <SvgIcon :name="mission.icon || 'target'" class="w-7 h-7" />
              </div>
              <div>
                <h2 class="m-0 mb-2 text-[#00583f] text-lg font-extrabold">
                  {{ mission.heading }}
                </h2>
                <p class="m-0 text-xs leading-[1.55] max-w-[480px]">
                  {{ mission.content }}
                </p>
              </div>
            </div>

          </div>
        </section>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- PROGRAMS (FROM DATABASE)                           -->
        <!-- ═══════════════════════════════════════════════════ -->
        <section id="programs" class="mx-auto max-w-[1500px] px-4 py-9 sm:px-6">
          <div class="text-center mb-[14px]">
            <h2 class="text-[#00583f] font-serif text-xl font-extrabold m-0">
              OUR PROGRAMS &amp; SERVICES
            </h2>
            <div class="relative w-[260px] max-w-[70%] h-0.5 mx-auto mt-2 bg-gradient-to-r from-transparent via-[#d9a52b] to-transparent [background-size:70%_100%] [background-position:center] [background-repeat:no-repeat]">
              <div class="absolute left-1/2 top-[-13px] -translate-x-1/2 text-[#d9a52b] bg-white px-1.5 text-base">
                ✣
              </div>
            </div>
          </div>

          <!-- Empty state -->
          <div v-if="programs.length === 0" class="text-center py-12 text-sm text-slate-400">
            No programs available yet.
          </div>

          <div
            v-else
            class="grid grid-cols-2 gap-[6px] sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8"
          >
            <article
              v-for="program in programs"
              :key="program.id"
              class="min-h-[220px] sm:min-h-[225px] md:min-h-[220px] p-[14px_8px_11px] border border-[#ddd] rounded-md text-center flex flex-col items-center bg-gradient-to-b from-white to-[#fcfdf9] transition-all duration-300 hover:border-[#b8cfc4] hover:shadow-[0_10px_28px_rgba(0,65,47,0.08)] hover:-translate-y-[3px]"
            >
              <div class="w-[40px] h-[40px] rounded-full bg-[#00583f] text-white flex items-center justify-center mb-[9px] transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">
                <SvgIcon :name="program.icon" class="w-5 h-5" />
              </div>

              <h3 class="m-0 text-[#00583f] text-[11px] leading-[1.18] font-extrabold whitespace-pre-line">
                {{ formatProgramTitle(program.title) }}
              </h3>

              <p class="text-[9px] sm:text-[8.5px] leading-[1.55] m-[10px_2px_9px] flex-1 text-gray-700">
                {{ program.description }}
              </p>

              <Link
                :href="program.link"
                class="text-[#00583f] text-[9px] font-extrabold transition-all duration-200 hover:text-[#d09b20] hover:tracking-[0.02em]"
              >
                Learn More →
              </Link>
            </article>
          </div>
        </section>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- CTA CARDS (STATIC)                                 -->
        <!-- ═══════════════════════════════════════════════════ -->
        <section id="involved" class="mx-auto max-w-[1500px] px-4 pb-8 sm:px-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-[14px]">

            <!-- Volunteer -->
            <article class="min-h-[202px] grid grid-cols-1 sm:grid-cols-[1fr_0.95fr] overflow-hidden border border-[#e1e1dc] rounded-md bg-[#f7f8f1] shadow-[0_4px_16px_rgba(0,50,35,0.035)] transition-all duration-300 hover:border-[#bfd1c8] hover:shadow-[0_12px_30px_rgba(0,65,47,0.1)]">
              <div class="p-[15px_15px_12px]">
                <div class="w-[42px] h-[42px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-[22px] font-bold transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">
                  ♣
                </div>
                <h3 class="m-[7px_0] text-sm text-[#004d38] font-extrabold">VOLUNTEER</h3>
                <p class="text-[10px] leading-[1.45] m-0 mb-3">
                  Share your time, skills and passion to make a difference in our community.
                </p>
                <Link
                  :href="route('volunteer.create')"
                  class="inline-flex items-center justify-center gap-2 rounded-md px-[10px] py-2 text-[9px] font-extrabold tracking-wide transition-all duration-200 border border-[#74a895] bg-[#00583f] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)]"
                >
                  BECOME A VOLUNTEER
                </Link>
              </div>
              <img
                src="/storage/images/volunteer.png"
                alt="QFCC volunteers"
                class="w-full h-[150px] sm:h-full sm:min-h-[202px] object-cover transition-transform duration-500 hover:scale-[1.035]"
              >
            </article>

            <!-- Member -->
            <article class="min-h-[202px] grid grid-cols-1 sm:grid-cols-[1fr_0.95fr] overflow-hidden border border-[#e1e1dc] rounded-md bg-[#f7f8f1] shadow-[0_4px_16px_rgba(0,50,35,0.035)] transition-all duration-300 hover:border-[#bfd1c8] hover:shadow-[0_12px_30px_rgba(0,65,47,0.1)]">
              <div class="p-[15px_15px_12px]">
                <div class="w-[42px] h-[42px] rounded-full bg-[#d9a52b] text-white flex items-center justify-center text-[22px] font-bold transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">
                  ♣
                </div>
                <h3 class="m-[7px_0] text-sm text-[#004d38] font-extrabold">BECOME A MEMBER</h3>
                <p class="text-[10px] leading-[1.45] m-0 mb-3">
                  Join QFCC and be part of a growing community of families, professionals, educators and community leaders.
                </p>
                <Link
                  :href="route('membership.create')"
                  class="inline-flex items-center justify-center gap-2 rounded-md px-[10px] py-2 text-[9px] font-extrabold tracking-wide transition-all duration-200 border border-[#efc55c] bg-[#dca62b] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)]"
                >
                  BECOME A MEMBER
                </Link>
              </div>
              <img
                src="/storage/images/member.png"
                alt="QFCC family"
                class="w-full h-[150px] sm:h-full sm:min-h-[202px] object-cover transition-transform duration-500 hover:scale-[1.035]"
              >
            </article>

            <!-- Donate -->
            <article id="donate" class="min-h-[202px] grid grid-cols-1 sm:grid-cols-[1fr_0.95fr] overflow-hidden border border-[#e1e1dc] rounded-md bg-[#f7f8f1] shadow-[0_4px_16px_rgba(0,50,35,0.035)] transition-all duration-300 hover:border-[#bfd1c8] hover:shadow-[0_12px_30px_rgba(0,65,47,0.1)]">
              <div class="p-[15px_15px_12px]">
                <div class="w-[42px] h-[42px] rounded-full bg-[#00583f] text-white flex items-center justify-center text-[22px] font-bold transition-all duration-300 hover:translate-y-[-2px] hover:shadow-[0_7px_18px_rgba(0,88,63,0.16)]">
                  ♡
                </div>
                <h3 class="m-[7px_0] text-sm text-[#004d38] font-extrabold">SUPPORT OUR WORK</h3>
                <p class="text-[10px] leading-[1.45] m-0 mb-3">
                  Your support helps us expand educational, humanitarian, youth, senior and family programs.
                </p>
                <Link
                  :href="route('donate')"
                  class="inline-flex items-center justify-center gap-2 rounded-md px-[10px] py-2 text-[9px] font-extrabold tracking-wide transition-all duration-200 border border-[#74a895] bg-[#00583f] text-white hover:translate-y-[-1px] hover:brightness-105 shadow-[0_4px_12px_rgba(0,70,50,0.08)]"
                >
                  DONATE / SUPPORT QFCC
                </Link>
              </div>
              <img
                src="/storage/images/support.png"
                alt="Support QFCC"
                class="w-full h-[150px] sm:h-full sm:min-h-[202px] object-cover transition-transform duration-500 hover:scale-[1.035]"
              >
            </article>

          </div>
        </section>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- EVENTS (FROM DB) + QUOTE (STATIC)                  -->
        <!-- ═══════════════════════════════════════════════════ -->
        <section id="event" class="mx-auto grid max-w-[1500px] gap-6 px-4 pb-10 sm:px-6 lg:grid-cols-[0.95fr_1.8fr]">

          <!-- Upcoming Events — DB driven -->
          <div class="border border-[#e4e4df] rounded-md p-[12px_12px_9px] bg-white transition-all duration-300 hover:shadow-[0_10px_28px_rgba(0,65,47,0.065)]">
            <div class="text-[#00583f] text-base font-extrabold mb-2">
              <span class="text-[22px] mr-[7px]">▦</span> UPCOMING EVENTS
            </div>

            <!-- Empty state -->
            <div v-if="upcomingEvents.length === 0" class="text-center py-8 text-xs text-slate-400">
              No upcoming events at the moment.
            </div>

            <template v-else>
              <Link
                v-for="event in upcomingEvents"
                :key="event.id"
                :href="route('event.show', event.slug)"
                class="grid grid-cols-[45px_1fr_54px] items-center gap-2 py-[7px] border-b border-[#eee] transition-all duration-200 rounded-[5px] hover:bg-[#f8faf5] hover:pl-[5px]"
              >
                <div class="w-10 rounded-[5px] overflow-hidden bg-[#00583f] text-white text-center flex-shrink-0">
                  <b class="block bg-[#f2f2eb] text-[#00583f] text-[8px] py-[3px]">
                    {{ event.month }}
                  </b>
                  <strong class="block text-[17px] py-[3px]">{{ event.day }}</strong>
                </div>
                <div class="event-text min-w-0">
                  <b class="block text-[10px] truncate">{{ event.title }}</b>
                  <small class="block text-[8px] leading-[1.4] text-[#555] mt-0.5">
                    {{ event.dateTime }}<br>{{ event.location }}
                  </small>
                </div>
                <img
                  :src="event.image"
                  :alt="event.title"
                  class="w-[54px] h-[37px] object-cover rounded-[3px] flex-shrink-0"
                >
              </Link>

              <Link
                :href="route('event.create')"
                class="block mt-2 text-right text-[#00583f] text-[9px] font-extrabold"
              >
                VIEW ALL EVENTS →
              </Link>
            </template>
          </div>

          <!-- Qur'an Quote — Static -->
          <div class="relative min-h-[280px] sm:min-h-[330px] overflow-hidden rounded-md bg-[#f4f0e6] flex items-center justify-between border border-[#e7e2d6] transition-all duration-300 hover:shadow-[0_10px_28px_rgba(0,65,47,0.065)]">
            <div class="absolute inset-0 opacity-16 bg-[radial-gradient(#8b7e66_0.6px,transparent_0.6px)] bg-[length:8px_8px]" />
            <div class="relative z-[1] w-full sm:w-[67%] text-center p-[22px_18px] sm:p-[20px_10px_20px_24px]">
              <div class="font-serif text-[#00583f] text-xl sm:text-[20px] leading-[1.8]">
                وَلْتَكُن مِّنكُمْ أُمَّةٌ يَدْعُونَ إِلَى الْخَيْرِ<br>
                وَيَأْمُرُونَ بِالْمَعْرُوفِ وَيَنْهَوْنَ عَنِ الْمُنكَرِ
              </div>
              <p class="font-serif text-xs sm:text-[12px] leading-[1.6] m-[14px_0_8px]">
                "Let there arise from among you a community inviting<br class="hidden sm:block">
                to what is good, encouraging what is right and<br class="hidden sm:block">
                discouraging what is wrong."
              </p>
              <span class="font-serif text-[11px]">– Qur'an 3:104</span>
            </div>
            <img
              src="/storage/images/quran.png"
              alt="Quran on wooden stand"
              class="relative z-[1] hidden sm:block w-[34%] h-full object-cover object-left-center mix-blend-multiply transition-transform duration-500 hover:scale-[1.025]"
            >
          </div>

        </section>

      </main>
    </div>
  </AppLayout>
</template>

<script setup>
import { h, defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

/* ═══════════════════════════════════════════════════════════
   SvgIcon COMPONENT — inline SVG (no Font Awesome needed)
   ═══════════════════════════════════════════════════════════ */
const SVG_PATHS = {
  /* Vision / Mission icons */
  'eye': [
    'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z',
    'M15 12a3 3 0 11-6 0 3 3 0 016 0z',
  ],
  'target': [
    'M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59',
  ],

  /* Program icons */
  'graduation-cap': [
    'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5',
  ],
  'users': [
    'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
  ],
  'home': [
    'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25',
  ],
  'user-plus': [
    'M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z',
  ],
  'plane': [
    'M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5',
  ],
  'utensils': [
    'M7.875 14.25l1.214 1.942a2.25 2.25 0 01.28.75v4.808a.75.75 0 01-1.5 0v-3.942L6.9 16.865a2.25 2.25 0 01-.4-1.276V7.125a.75.75 0 011.5 0v6.375zm11.25 4.316a9.765 9.765 0 001.5-4.601V4.125a.75.75 0 00-1.28-.53l-4.05 4.05a.75.75 0 00-.22.53v8.517c0 .414.336.75.75.75H15c.108 0 .214.008.318.023a.75.75 0 00.79-.899l-.001-.001zM6 10.5h12',
  ],
  'heart-pulse': [
    'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z',
    'M7.5 12h3l1.5-3 2 4.5 1.5-1.5h2.5',
  ],
  'mosque': [
    'M12 2.25c0 0-4.5 3.75-4.5 7.5 0 2.485 2.014 4.5 4.5 4.5s4.5-2.015 4.5-4.5c0-3.75-4.5-7.5-4.5-7.5z',
    'M2.25 21h19.5M4.5 21V10.5c0-1.5 1.5-3 1.5-3M19.5 21V10.5c0-1.5-1.5-3-1.5-3',
    'M8.25 21v-3a3.75 3.75 0 117.5 0v3',
  ],

  /* Fallback */
  'star': [
    'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z',
  ],
}

const SvgIcon = defineComponent({
  props: {
    name: { type: String, required: true },
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    return () => {
      const paths = SVG_PATHS[props.name] || SVG_PATHS['star']

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

/* ═══════════════════════════════════════════════════════════
   PROPS — from HomeController
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  vision:         { type: Object, default: null },
  mission:        { type: Object, default: null },
  programs:       { type: Array,  default: () => [] },
  upcomingEvents: { type: Array,  default: () => [] },
})

/* ═══════════════════════════════════════════════════════════
   HELPERS
   ═══════════════════════════════════════════════════════════ */
/**
 * Break long titles into two lines at natural points.
 * e.g. "EDUCATION & LIFELONG LEARNING" → "EDUCATION &\nLIFELONG LEARNING"
 */
function formatProgramTitle(title) {
  if (!title) return ''

  // Split at "&" if present
  if (title.includes('&')) {
    const parts = title.split('&')
    return parts[0].trim() + ' &\n' + parts[1].trim()
  }

  // Otherwise split at first space if title has 2-3 words
  const words = title.split(' ')
  if (words.length === 2) {
    return words.join('\n')
  }

  return title
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.font-serif {
  font-family: Georgia, 'Times New Roman', serif;
}

* {
  -webkit-font-smoothing: antialiased;
}

html {
  scroll-behavior: smooth;
}

*:focus-visible {
  outline: 2px solid #d9a52b;
  outline-offset: 2px;
}
</style>