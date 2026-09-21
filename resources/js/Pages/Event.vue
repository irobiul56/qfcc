<template>
  <AppLayout
    title="Events | QFCC"
    description="Join Queens Family and Community Center at our upcoming events."
  >
    <main>
      <!-- ================= HERO ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#002d21] via-[#003c2b] to-[#00583f] text-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.08] events-hero-pattern"></div>

        <div class="relative mx-auto grid max-w-[1500px] items-end gap-8 px-5 py-16 sm:px-8 lg:grid-cols-[1.05fr_.95fr] lg:px-12 lg:py-24">
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
                <svg class="absolute -bottom-2 left-0 h-2 w-full" viewBox="0 0 200 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0 4C50 8 150 8 200 4C150 0 50 0 0 4Z" fill="rgba(224, 172, 46, 0.3)" />
                </svg>
              </span>
            </h1>

            <p class="mt-7 max-w-[480px] text-[1.05rem] leading-7 text-white/85">
              From shared meals to meaningful conversations, our events turn community values into real connection.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
              <a href="#upcoming" class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group">
                SEE UPCOMING EVENTS
                <i class="fas fa-arrow-down ml-2 transition-transform group-hover:translate-y-1"></i>
              </a>
              <Link :href="route('get-involved')" class="inline-flex items-center justify-center rounded-full border-2 border-white/20 px-6 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:border-white/40 hover:bg-white/10 group">
                GET INVOLVED
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </Link>
            </div>
          </div>

          <!-- Next gathering card (featured) -->
          <div v-if="featured" class="animate-slide-up animation-delay-300">
            <Link
              :href="route('event.show', featured.slug)"
              class="group block relative overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] p-7 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-[#e0ac2e]/30 hover:bg-white/10"
            >
              <div class="absolute inset-x-0 top-0 h-[3px] bg-gradient-to-r from-[#e0ac2e] to-transparent"></div>

              <span class="mb-3 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
                <span class="mr-2 inline-block h-2 w-2 animate-pulse rounded-full bg-[#e0ac2e]"></span>
                NEXT GATHERING
              </span>

              <strong class="mb-3 block font-serif text-2xl font-bold leading-tight text-white group-hover:text-[#e0ac2e] transition-colors">
                {{ featured.title }}
              </strong>

              <div class="mb-5 flex items-center gap-4 border-b border-white/10 pb-5">
                <b class="text-xs font-extrabold uppercase tracking-[0.1em] text-[#e0ac2e]">
                  {{ featured.month }} {{ featured.day }}
                </b>
                <span class="text-sm text-white/70">{{ featured.location }} · {{ featured.time }}</span>
              </div>

              <span class="inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-white transition-colors group-hover:text-[#e0ac2e]">
                VIEW EVENT DETAILS
                <i class="fas fa-arrow-up-right-from-square ml-2 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-1"></i>
              </span>
            </Link>
          </div>
        </div>

        <div class="absolute bottom-6 left-1/2 hidden -translate-x-1/2 animate-bounce text-white/40 lg:block">
          <i class="fas fa-chevron-down text-xl"></i>
        </div>
      </section>

      <!-- ================= INTRO ================= -->
      <section class="bg-[#fbfaf4]">
        <div class="mx-auto grid max-w-[1200px] items-end gap-5 px-5 py-12 sm:px-8 md:grid-cols-[.7fr_1.3fr] lg:py-16">
          <div>
            <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
              <i class="fas fa-calendar-alt mr-2"></i>THE QFCC CALENDAR
            </p>
            <h2 class="font-serif text-[clamp(1.75rem,4vw,2.75rem)] font-bold leading-tight text-[#00583f]">
              Make room<br />for community.
            </h2>
          </div>
          <p class="text-base leading-[1.85] text-slate-600">
            Our calendar is filled with opportunities to grow, connect, and care for one another. Join us at an upcoming gathering and help make the next moment meaningful.
          </p>
        </div>
      </section>

      <!-- ================= FEATURED EVENT ================= -->
      <section v-if="featured" id="featured" class="mx-auto max-w-[1200px] px-5 py-10 sm:px-8 lg:py-16">
        <div class="grid items-center gap-10 md:grid-cols-[1.1fr_1fr] md:gap-14">
          <!-- Image (clickable) -->
          <Link
            :href="route('event.show', featured.slug)"
            class="group relative block overflow-hidden rounded-[20px] shadow-[0_20px_60px_rgba(0,65,47,0.15)]"
          >
            <img
              :src="featured.image"
              :alt="featured.title"
              class="block h-[380px] w-full object-cover transition-transform duration-700 group-hover:scale-105 md:h-[480px]"
            />
            <span class="absolute left-5 top-5 inline-flex items-center rounded-full bg-[#e0ac2e] px-4 py-2.5 text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#002d21] shadow-[0_4px_15px_rgba(224,172,46,0.4)]">
              <i class="fas fa-star mr-2"></i>FEATURED EVENT
            </span>

            <span
              v-if="featured.is_full"
              class="absolute right-5 top-5 inline-flex items-center rounded-full bg-rose-600 px-4 py-2.5 text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-white shadow-lg"
            >
              <i class="fas fa-lock mr-2"></i>SOLD OUT
            </span>
          </Link>

          <!-- Copy -->
          <div>
            <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
              <i class="fas fa-calendar-day mr-2"></i>{{ featured.date_label }}
            </p>

            <Link :href="route('event.show', featured.slug)" class="block group/title">
              <h2 class="mt-2 mb-5 font-serif text-[clamp(1.75rem,3.5vw,2.5rem)] font-bold leading-tight text-[#00583f] transition-colors group-hover/title:text-[#e0ac2e]">
                {{ featured.title }}
              </h2>
            </Link>

            <p class="mb-7 text-[0.95rem] leading-[1.85] text-slate-600">
              {{ featured.description }}
            </p>

            <div class="mb-6 flex flex-wrap gap-6 border-y border-slate-200 py-5">
              <span class="flex flex-col gap-1 text-sm font-semibold text-slate-600">
                <b class="flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                  <i class="fas fa-clock mr-1"></i>TIME
                </b>
                {{ featured.time }}
              </span>
              <span class="flex flex-col gap-1 text-sm font-semibold text-slate-600">
                <b class="flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                  <i class="fas fa-map-marker-alt mr-1"></i>PLACE
                </b>
                {{ featured.location }}
              </span>
              <span v-if="featured.capacity" class="flex flex-col gap-1 text-sm font-semibold text-slate-600">
                <b class="flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                  <i class="fas fa-users mr-1"></i>CAPACITY
                </b>
                {{ featured.capacity }} seats
              </span>
            </div>

            <div class="flex flex-wrap gap-3">
              <Link
                :href="route('event.show', featured.slug)"
                class="inline-flex items-center justify-center rounded-full bg-[#00583f] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#003c2b] hover:shadow-[0_10px_30px_rgba(0,88,63,0.3)] group"
              >
                VIEW DETAILS
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </Link>

              <button
                @click="openRegistration(featured)"
                :disabled="featured.is_full"
                :class="[
                  'inline-flex items-center justify-center rounded-full px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] transition-all duration-300 group',
                  featured.is_full
                    ? 'cursor-not-allowed bg-slate-200 text-slate-400'
                    : 'bg-[#e0ac2e] text-[#002d21] hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)]'
                ]"
              >
                <i v-if="!featured.is_full" class="fas fa-ticket-alt mr-2 transition-transform group-hover:scale-110"></i>
                <i v-else class="fas fa-lock mr-2"></i>
                {{ featured.is_full ? 'FULL' : 'REGISTER' }}
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= UPCOMING EVENTS ================= -->
      <section id="upcoming" class="bg-gradient-to-b from-white to-[#fbfaf4]">
        <div class="mx-auto max-w-[1200px] px-5 py-12 sm:px-8 lg:py-16">
          <div class="mb-10 flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
            <div>
              <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
                <i class="fas fa-forward mr-2"></i>WHAT'S NEXT
              </p>
              <h2 class="font-serif text-[clamp(1.75rem,4vw,2.5rem)] font-bold leading-tight text-[#00583f]">
                Upcoming events
              </h2>
            </div>

            <!-- Filter tabs -->
            <div class="flex flex-wrap gap-2" role="group" aria-label="Event filters">
              <button
                :class="[
                  'inline-flex items-center rounded-full border-2 px-5 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.1em] transition-all duration-300',
                  activeFilter === 'all'
                    ? 'border-[#00583f] bg-[#00583f] text-white shadow-[0_6px_20px_rgba(0,88,63,0.25)]'
                    : 'border-slate-200 bg-white text-slate-600 hover:-translate-y-0.5 hover:border-[#00583f] hover:text-[#00583f]'
                ]"
                @click="activeFilter = 'all'"
              >
                <i class="fas fa-th-large mr-2"></i>ALL EVENTS
              </button>
              <button
                v-for="cat in categories"
                :key="cat.value"
                :class="[
                  'inline-flex items-center rounded-full border-2 px-5 py-2.5 text-[0.7rem] font-extrabold uppercase tracking-[0.1em] transition-all duration-300',
                  activeFilter === cat.value
                    ? 'border-[#00583f] bg-[#00583f] text-white shadow-[0_6px_20px_rgba(0,88,63,0.25)]'
                    : 'border-slate-200 bg-white text-slate-600 hover:-translate-y-0.5 hover:border-[#00583f] hover:text-[#00583f]'
                ]"
                @click="activeFilter = cat.value"
              >
                <i class="fas fa-tag mr-2"></i>{{ cat.label }}
              </button>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Event cards (clickable) -->
            <Link
              v-for="event in filteredEvents"
              :key="event.id"
              :href="route('event.show', event.slug)"
              class="group relative flex flex-col overflow-hidden rounded-[20px] bg-white shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,65,47,0.15)]"
            >
              <div class="absolute inset-x-0 top-0 z-10 h-1 origin-left scale-x-0 bg-gradient-to-r from-[#e0ac2e] to-[#00583f] transition-transform duration-500 group-hover:scale-x-100"></div>

              <div class="relative h-[220px] overflow-hidden">
                <img
                  :src="event.image"
                  :alt="event.title"
                  class="block h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <span class="absolute right-4 top-4 flex min-w-[58px] flex-col items-center rounded-xl bg-white px-3 py-2 text-center shadow-[0_4px_15px_rgba(0,0,0,0.15)]">
                  <b class="text-[0.6rem] font-extrabold uppercase tracking-[0.1em] text-[#e0ac2e]">{{ event.month }}</b>
                  <strong class="font-serif text-2xl font-bold leading-none text-[#00583f]">{{ event.day }}</strong>
                </span>

                <span
                  v-if="event.is_full"
                  class="absolute left-4 top-4 inline-flex items-center rounded-full bg-rose-600 px-3 py-1.5 text-[0.6rem] font-extrabold uppercase tracking-[0.1em] text-white shadow-lg"
                >
                  <i class="fas fa-lock mr-1.5"></i>FULL
                </span>
              </div>

              <div class="flex flex-1 flex-col p-7">
                <p class="mb-3 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">
                  <i class="fas fa-tag mr-1"></i>{{ event.category }}
                </p>

                <h3 class="mb-3 font-serif text-xl font-bold leading-tight text-[#00583f] transition-colors group-hover:text-[#e0ac2e]">
                  {{ event.title }}
                </h3>

                <p class="mb-5 flex-1 text-sm leading-7 text-slate-600 line-clamp-2">
                  {{ event.description }}
                </p>

                <div class="flex items-center justify-between border-t border-slate-100 pt-5">
                  <span class="flex items-center text-xs font-semibold text-slate-500">
                    <i class="fas fa-clock mr-1"></i>{{ event.time }}
                  </span>
                  <span
                    :class="[
                      'inline-flex h-9 w-9 items-center justify-center rounded-full transition-all duration-300 group/arrow',
                      event.is_full
                        ? 'bg-slate-100 text-slate-300'
                        : 'bg-[#fbfaf4] text-[#00583f] group-hover:bg-[#00583f] group-hover:text-white'
                    ]"
                  >
                    <i v-if="!event.is_full" class="fas fa-arrow-right transition-transform group-hover/arrow:translate-x-0.5"></i>
                    <i v-else class="fas fa-lock"></i>
                  </span>
                </div>
              </div>
            </Link>

            <!-- Empty state -->
            <article
              v-if="filteredEvents.length === 0"
              class="col-span-full flex flex-col items-center justify-center rounded-[20px] border-2 border-dashed border-slate-200 bg-white/60 py-16 text-center"
            >
              <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[#fbfaf4] text-xl text-[#00583f]">
                <i class="fas fa-calendar-times"></i>
              </div>
              <h3 class="mb-2 font-serif text-xl font-bold text-[#00583f]">No events in this category</h3>
              <p class="text-sm text-slate-500">Check back soon — new events are added regularly.</p>
            </article>

            <!-- Propose event card -->
            <article class="relative flex flex-col items-start justify-center overflow-hidden rounded-[20px] bg-gradient-to-br from-[#00583f] to-[#002d21] p-8 text-white">
              <div class="pointer-events-none absolute -right-1/2 -top-1/2 h-[200%] w-[200%]" style="background: radial-gradient(circle, rgba(224, 172, 46, 0.08) 0%, transparent 70%);"></div>
              <div class="relative mb-6 flex h-[60px] w-[60px] items-center justify-center rounded-full border-2 border-dashed border-[#e0ac2e]/40 bg-[#e0ac2e]/15 text-xl text-[#e0ac2e] transition-all duration-300 hover:rotate-90 hover:scale-110 hover:bg-[#e0ac2e]/25">
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
              <Link :href="route('contact')" class="relative mt-auto inline-flex items-center rounded-full border-2 border-[#e0ac2e]/30 px-5 py-3 text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e] transition-all duration-300 hover:border-[#e0ac2e] hover:bg-[#e0ac2e] hover:text-[#002d21] group">
                PROPOSE AN EVENT
                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
              </Link>
            </article>
          </div>
        </div>
      </section>

      <!-- ================= CTA ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#fbfaf4] to-white">
        <div class="pointer-events-none absolute -right-24 -top-24 h-[300px] w-[300px] rounded-full" style="background: radial-gradient(circle, rgba(224, 172, 46, 0.1) 0%, transparent 70%);"></div>
        <div class="relative mx-auto flex max-w-[1200px] flex-col gap-7 px-5 py-12 sm:px-8 md:flex-row md:items-center md:justify-between lg:py-16">
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
            <Link :href="route('get-involved')" class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group">
              GET INVOLVED
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </Link>
          </div>
        </div>
      </section>
    </main>

    <!-- ═══════════ REGISTRATION MODAL ═══════════ -->
    <Transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        @click.self="closeModal"
      >
        <Transition
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
        >
          <div
            v-if="showModal"
            class="w-full max-w-lg bg-white rounded-2xl shadow-2xl ring-1 ring-slate-200/80 overflow-hidden max-h-[90vh] flex flex-col"
          >
            <div class="px-6 py-5 border-b border-slate-100 flex items-start justify-between gap-4 flex-shrink-0">
              <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-[#e0ac2e] uppercase tracking-wider">
                  Event Registration
                </p>
                <h2 class="text-lg font-bold text-[#00583f] mt-0.5 truncate">
                  {{ activeEvent?.title }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                  <i class="fas fa-calendar mr-1"></i>
                  {{ activeEvent?.date_label || (activeEvent?.month + ' ' + activeEvent?.day) }}
                  · {{ activeEvent?.time }}
                </p>
              </div>
              <button
                @click="closeModal"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all flex-shrink-0"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>

            <div class="p-6 overflow-y-auto flex-1">
              <div
                v-if="activeEvent?.spots_left !== null && activeEvent?.spots_left !== undefined"
                class="mb-5 p-3 rounded-lg bg-[#fbfaf4] border border-[#e0ac2e]/30 flex items-center gap-2.5"
              >
                <i class="fas fa-users text-[#e0ac2e]"></i>
                <p class="text-xs text-[#00583f] font-semibold">
                  <span class="font-extrabold">{{ activeEvent.spots_left }}</span>
                  spots left
                  <span class="text-slate-500 font-normal">of {{ activeEvent.capacity }}</span>
                </p>
              </div>

              <!-- Success -->
              <div v-if="registrationSuccess" class="text-center py-6">
                <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                  <i class="fas fa-check text-2xl text-emerald-600"></i>
                </div>
                <h3 class="text-lg font-bold text-[#00583f] mb-2">You're registered!</h3>
                <p class="text-sm text-slate-600 mb-5 leading-relaxed">
                  We've reserved your spot for <strong>{{ activeEvent?.title }}</strong>.
                  A confirmation will be sent to <strong>{{ submittedEmail }}</strong>.
                </p>
                <div class="p-3 rounded-lg bg-[#fbfaf4] border border-[#e0ac2e]/30 inline-block">
                  <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                    Registration Reference
                  </p>
                  <p class="font-mono font-bold text-[#00583f] text-lg">#{{ registrationId }}</p>
                </div>
                <div class="mt-6">
                  <button
                    @click="closeModal"
                    class="px-6 py-2.5 bg-[#00583f] text-white font-semibold rounded-lg text-sm hover:bg-[#003c2b] transition-all"
                  >
                    Done
                  </button>
                </div>
              </div>

              <!-- Form -->
              <form v-else @submit.prevent="submitRegistration" class="space-y-4">
                <div>
                  <label class="block text-[11px] font-extrabold uppercase tracking-wider text-[#00583f] mb-1.5">
                    <i class="fas fa-user mr-1 text-[#e0ac2e]"></i>Full Name
                    <span class="text-rose-500">*</span>
                  </label>
                  <input
                    v-model="form.full_name"
                    type="text"
                    required
                    placeholder="Jane Doe"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-[#fbfaf4]/50 text-sm outline-none transition-all focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
                  />
                </div>

                <div>
                  <label class="block text-[11px] font-extrabold uppercase tracking-wider text-[#00583f] mb-1.5">
                    <i class="fas fa-envelope mr-1 text-[#e0ac2e]"></i>Email
                    <span class="text-rose-500">*</span>
                  </label>
                  <input
                    v-model="form.email"
                    type="email"
                    required
                    placeholder="you@example.com"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-[#fbfaf4]/50 text-sm outline-none transition-all focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
                  />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-[11px] font-extrabold uppercase tracking-wider text-[#00583f] mb-1.5">
                      <i class="fas fa-phone mr-1 text-[#e0ac2e]"></i>Phone
                    </label>
                    <input
                      v-model="form.phone"
                      type="tel"
                      placeholder="(123) 456-7890"
                      class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-[#fbfaf4]/50 text-sm outline-none transition-all focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
                    />
                  </div>
                  <div>
                    <label class="block text-[11px] font-extrabold uppercase tracking-wider text-[#00583f] mb-1.5">
                      <i class="fas fa-user-plus mr-1 text-[#e0ac2e]"></i>Extra Guests
                    </label>
                    <select
                      v-model.number="form.guests"
                      class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-[#fbfaf4]/50 text-sm outline-none transition-all focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
                    >
                      <option :value="0">Just me</option>
                      <option v-for="n in 10" :key="n" :value="n">
                        +{{ n }} {{ n === 1 ? 'guest' : 'guests' }}
                      </option>
                    </select>
                  </div>
                </div>

                <div>
                  <label class="block text-[11px] font-extrabold uppercase tracking-wider text-[#00583f] mb-1.5">
                    <i class="fas fa-comment mr-1 text-[#e0ac2e]"></i>Notes
                    <span class="text-slate-400 font-normal normal-case">(optional)</span>
                  </label>
                  <textarea
                    v-model="form.notes"
                    rows="2"
                    placeholder="Dietary restrictions, accessibility needs, etc."
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-[#fbfaf4]/50 text-sm outline-none transition-all focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10 resize-none"
                  ></textarea>
                </div>

                <div
                  v-if="errorMessage"
                  class="flex items-start gap-2.5 p-3 rounded-lg bg-rose-50 border border-rose-200"
                >
                  <i class="fas fa-exclamation-circle text-rose-500 text-sm mt-0.5"></i>
                  <p class="text-xs text-rose-700">{{ errorMessage }}</p>
                </div>

                <div class="flex gap-2 pt-2">
                  <button
                    type="button"
                    @click="closeModal"
                    class="flex-1 px-5 py-3 bg-white text-slate-700 font-medium rounded-xl text-sm border border-slate-200 hover:bg-slate-50 transition-all"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="flex-1 px-5 py-3 bg-[#00583f] text-white font-bold rounded-xl text-xs uppercase tracking-wider hover:bg-[#003c2b] transition-all disabled:opacity-60 inline-flex items-center justify-center gap-2"
                  >
                    <i v-if="!isSubmitting" class="fas fa-check"></i>
                    <i v-else class="fas fa-circle-notch fa-spin"></i>
                    {{ isSubmitting ? 'Reserving…' : 'Confirm Registration' }}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref, reactive, computed } from 'vue'

const props = defineProps({
  featured:   { type: Object, default: null },
  events:     { type: Array,  default: () => [] },
  categories: { type: Array,  default: () => [] },
})

/* --- Filter --- */
const activeFilter = ref('all')

const filteredEvents = computed(() => {
  if (activeFilter.value === 'all') return props.events
  return props.events.filter((e) => e.event_type === activeFilter.value)
})

/* --- Registration modal --- */
const showModal = ref(false)
const activeEvent = ref(null)
const isSubmitting = ref(false)
const registrationSuccess = ref(false)
const registrationId = ref(null)
const submittedEmail = ref('')
const errorMessage = ref('')

const form = reactive({
  full_name: '',
  email: '',
  phone: '',
  guests: 0,
  notes: '',
})

function openRegistration(event) {
  if (event.is_full) return

  activeEvent.value = event
  showModal.value = true
  registrationSuccess.value = false
  registrationId.value = null
  submittedEmail.value = ''
  errorMessage.value = ''

  Object.assign(form, {
    full_name: '',
    email: '',
    phone: '',
    guests: 0,
    notes: '',
  })
}

function closeModal() {
  showModal.value = false
  activeEvent.value = null
}

async function submitRegistration() {
  if (!activeEvent.value) return

  isSubmitting.value = true
  errorMessage.value = ''

  try {
    const response = await fetch(route('event.register', activeEvent.value.id), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
      },
      body: JSON.stringify(form),
    })

    const data = await response.json()

    if (!response.ok || !data.success) {
      errorMessage.value = data.message || 'Registration failed. Please try again.'
      return
    }

    registrationId.value = data.registration.id
    submittedEmail.value = data.registration.email
    registrationSuccess.value = true

    // Live update
    if (activeEvent.value) {
      activeEvent.value.spots_left = data.spots_left
      if (data.spots_left === 0) activeEvent.value.is_full = true
    }

    const match = props.events.find((e) => e.id === activeEvent.value?.id)
    if (match) {
      match.spots_left = data.spots_left
      if (data.spots_left === 0) match.is_full = true
    }
  } catch (err) {
    errorMessage.value = 'Network error. Please try again.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.events-hero-pattern {
  background-image: radial-gradient(circle at 20% 30%, rgba(224, 172, 46, 0.4) 1.5px, transparent 1.5px),
    radial-gradient(circle at 80% 70%, rgba(224, 172, 46, 0.4) 1.5px, transparent 1.5px);
  background-size: 50px 50px;
  background-position: 0 0, 25px 25px;
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(40px); }
  to   { opacity: 1; transform: translateY(0); }
}
.animate-slide-up { animation: slideUp 0.9s ease-out forwards; opacity: 0; }
.animation-delay-300 { animation-delay: 300ms; }

.font-serif { font-family: Georgia, 'Times New Roman', serif; }

html { scroll-behavior: smooth; }

*:focus-visible { outline: 2px solid #e0ac2e; outline-offset: 2px; }

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>