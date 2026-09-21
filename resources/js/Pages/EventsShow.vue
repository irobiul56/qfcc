<template>
  <AppLayout
    :title="`${event.title} | QFCC Events`"
    :description="event.description"
  >
    <main>
      <!-- ═══════════════════════════════════════════════════════ -->
      <!-- HERO — Full-width image with overlay                    -->
      <!-- ═══════════════════════════════════════════════════════ -->
      <section class="relative h-[60vh] min-h-[500px] overflow-hidden">
        <!-- Background image -->
        <img
          :src="event.image"
          :alt="event.title"
          class="absolute inset-0 h-full w-full object-cover"
        />

        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#002d21] via-[#002d21]/70 to-[#002d21]/30"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#002d21]/60 to-transparent"></div>

        <!-- Decorative pattern -->
        <div class="pointer-events-none absolute inset-0 opacity-[0.08] events-hero-pattern"></div>

        <!-- Content -->
        <div class="relative mx-auto flex h-full max-w-[1200px] flex-col justify-end px-5 pb-12 sm:px-8 lg:px-12 lg:pb-16">
          <!-- Breadcrumb -->
          <nav class="absolute top-24 left-5 flex items-center gap-2 text-xs text-white/70 sm:left-8 lg:left-12">
            <Link :href="route('event.create')" class="hover:text-white transition-colors">
              Events
            </Link>
            <i class="fas fa-chevron-right text-[9px] text-white/40"></i>
            <span class="text-white font-medium truncate max-w-[200px]">{{ event.title }}</span>
          </nav>

          <!-- Category badge -->
          <div class="mb-4 flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center rounded-full bg-[#e0ac2e] px-4 py-2 text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#002d21] shadow-lg shadow-[#e0ac2e]/30">
              <i class="fas fa-tag mr-2"></i>{{ event.category }}
            </span>

            <span
              v-if="event.is_full"
              class="inline-flex items-center rounded-full bg-rose-600 px-4 py-2 text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-white shadow-lg"
            >
              <i class="fas fa-lock mr-2"></i>SOLD OUT
            </span>

            <span
              v-else-if="event.spots_left !== null && event.spots_left <= 10"
              class="inline-flex items-center rounded-full bg-white/15 backdrop-blur-md px-4 py-2 text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-white ring-1 ring-white/30"
            >
              <span class="mr-2 inline-block h-2 w-2 animate-pulse rounded-full bg-[#e0ac2e]"></span>
              ONLY {{ event.spots_left }} SPOTS LEFT
            </span>
          </div>

          <!-- Title -->
          <h1 class="mb-5 max-w-[900px] font-serif text-[clamp(2rem,5vw,3.5rem)] font-bold leading-[1.05] text-white animate-slide-up">
            {{ event.title }}
          </h1>

          <!-- Meta row -->
          <div class="flex flex-wrap items-center gap-x-6 gap-y-3 text-white/90 animate-slide-up animation-delay-200">
            <span class="flex items-center gap-2 text-sm font-medium">
              <i class="fas fa-calendar-day text-[#e0ac2e]"></i>
              {{ event.date_full }}
            </span>
            <span class="flex items-center gap-2 text-sm font-medium">
              <i class="fas fa-clock text-[#e0ac2e]"></i>
              {{ event.time_range }}
            </span>
            <span v-if="event.location" class="flex items-center gap-2 text-sm font-medium">
              <i class="fas fa-map-marker-alt text-[#e0ac2e]"></i>
              {{ event.location }}
            </span>
          </div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════════════════ -->
      <!-- MAIN CONTENT                                             -->
      <!-- ═══════════════════════════════════════════════════════ -->
      <section class="bg-white">
        <div class="mx-auto grid max-w-[1200px] gap-10 px-5 py-12 sm:px-8 lg:grid-cols-[1.5fr_1fr] lg:gap-14 lg:py-16">

          <!-- LEFT — Description & Details -->
          <div>
            <!-- About section -->
            <div class="mb-10">
              <p class="mb-3 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
                <i class="fas fa-info-circle mr-2"></i>ABOUT THIS EVENT
              </p>
              <h2 class="mb-6 font-serif text-[clamp(1.5rem,3vw,2rem)] font-bold leading-tight text-[#00583f]">
                What to expect
              </h2>
              <div class="prose prose-slate max-w-none">
                <p class="whitespace-pre-line text-[0.95rem] leading-[1.85] text-slate-600">
                  {{ event.description }}
                </p>
              </div>
            </div>

            <!-- Details grid -->
            <div class="mb-10">
              <p class="mb-4 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
                <i class="fas fa-list mr-2"></i>EVENT DETAILS
              </p>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- Date -->
                <div class="group flex items-start gap-4 rounded-xl border border-slate-100 bg-[#fbfaf4] p-5 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#e0ac2e]/30 hover:shadow-[0_8px_25px_rgba(224,172,46,0.1)]">
                  <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-[#e0ac2e]/15 text-[#e0ac2e] transition-transform group-hover:scale-110">
                    <i class="fas fa-calendar-check text-base"></i>
                  </div>
                  <div class="min-w-0">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">Date</p>
                    <p class="mt-1 text-sm font-bold text-[#00583f]">{{ event.date_full }}</p>
                  </div>
                </div>

                <!-- Time -->
                <div class="group flex items-start gap-4 rounded-xl border border-slate-100 bg-[#fbfaf4] p-5 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#e0ac2e]/30 hover:shadow-[0_8px_25px_rgba(224,172,46,0.1)]">
                  <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-[#e0ac2e]/15 text-[#e0ac2e] transition-transform group-hover:scale-110">
                    <i class="fas fa-clock text-base"></i>
                  </div>
                  <div class="min-w-0">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">Time</p>
                    <p class="mt-1 text-sm font-bold text-[#00583f]">{{ event.time_range }}</p>
                  </div>
                </div>

                <!-- Location -->
                <div v-if="event.location" class="group flex items-start gap-4 rounded-xl border border-slate-100 bg-[#fbfaf4] p-5 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#e0ac2e]/30 hover:shadow-[0_8px_25px_rgba(224,172,46,0.1)]">
                  <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-[#e0ac2e]/15 text-[#e0ac2e] transition-transform group-hover:scale-110">
                    <i class="fas fa-map-marker-alt text-base"></i>
                  </div>
                  <div class="min-w-0">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">Location</p>
                    <p class="mt-1 text-sm font-bold text-[#00583f]">{{ event.location }}</p>
                    <p v-if="event.address" class="mt-0.5 text-xs text-slate-500">{{ event.address }}</p>
                  </div>
                </div>

                <!-- Capacity -->
                <div v-if="event.capacity" class="group flex items-start gap-4 rounded-xl border border-slate-100 bg-[#fbfaf4] p-5 transition-all duration-300 hover:-translate-y-0.5 hover:border-[#e0ac2e]/30 hover:shadow-[0_8px_25px_rgba(224,172,46,0.1)]">
                  <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-[#e0ac2e]/15 text-[#e0ac2e] transition-transform group-hover:scale-110">
                    <i class="fas fa-users text-base"></i>
                  </div>
                  <div class="min-w-0">
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">Capacity</p>
                    <p class="mt-1 text-sm font-bold text-[#00583f]">{{ event.capacity }} seats</p>
                    <p v-if="event.spots_left !== null" class="mt-0.5 text-xs text-slate-500">
                      {{ event.registered_count }} registered · {{ event.spots_left }} spots left
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Share section -->
            <div class="rounded-xl border border-slate-100 bg-[#fbfaf4] p-5">
              <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                  <p class="text-[10px] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                    <i class="fas fa-share-alt mr-1"></i>Share this event
                  </p>
                  <p class="mt-1 text-xs text-slate-500">Invite friends and family to join us.</p>
                </div>
                <div class="flex gap-2">
                  <a
                    :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(event.title)}&url=${encodeURIComponent(pageUrl)}`"
                    target="_blank"
                    rel="noopener"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-slate-200 transition-all hover:-translate-y-0.5 hover:bg-[#00583f] hover:text-white hover:ring-[#00583f]"
                    title="Share on Twitter"
                  >
                    <i class="fab fa-twitter text-sm"></i>
                  </a>
                  <a
                    :href="`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(pageUrl)}`"
                    target="_blank"
                    rel="noopener"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-slate-200 transition-all hover:-translate-y-0.5 hover:bg-[#00583f] hover:text-white hover:ring-[#00583f]"
                    title="Share on Facebook"
                  >
                    <i class="fab fa-facebook-f text-sm"></i>
                  </a>
                  <a
                    :href="`https://wa.me/?text=${encodeURIComponent(event.title + ' ' + pageUrl)}`"
                    target="_blank"
                    rel="noopener"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-slate-200 transition-all hover:-translate-y-0.5 hover:bg-[#00583f] hover:text-white hover:ring-[#00583f]"
                    title="Share on WhatsApp"
                  >
                    <i class="fab fa-whatsapp text-sm"></i>
                  </a>
                  <button
                    @click="copyLink"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-600 ring-1 ring-slate-200 transition-all hover:-translate-y-0.5 hover:bg-[#00583f] hover:text-white hover:ring-[#00583f]"
                    title="Copy link"
                  >
                    <i :class="copied ? 'fas fa-check text-sm text-emerald-500' : 'fas fa-link text-sm'"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- RIGHT — Registration Card (sticky) -->
          <aside class="lg:sticky lg:top-24 lg:self-start">
            <div class="relative overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-[0_10px_40px_rgba(0,65,47,0.08)]">
              <!-- Top accent bar -->
              <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#e0ac2e] via-[#00583f] to-[#e0ac2e]"></div>

              <!-- Header -->
              <div class="border-b border-slate-100 px-7 pb-6 pt-7">
                <p class="mb-2 flex items-center text-[0.65rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
                  <i class="fas fa-ticket-alt mr-2"></i>REGISTRATION
                </p>
                <h3 class="font-serif text-2xl font-bold leading-tight text-[#00583f]">
                  Reserve your spot
                </h3>
              </div>

              <!-- Body -->
              <div class="space-y-5 p-7">
                <!-- Date display -->
                <div class="flex items-center gap-4 rounded-xl bg-[#fbfaf4] p-4">
                  <div class="flex h-16 w-16 flex-shrink-0 flex-col items-center justify-center rounded-xl bg-[#00583f] text-white shadow-md">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#e0ac2e]">
                      {{ event.month }}
                    </span>
                    <span class="font-serif text-2xl font-bold leading-none">
                      {{ event.day }}
                    </span>
                  </div>
                  <div class="min-w-0">
                    <p class="text-sm font-bold text-[#00583f]">{{ event.date_full }}</p>
                    <p class="mt-0.5 text-xs text-slate-500">
                      <i class="fas fa-clock mr-1"></i>{{ event.time_range }}
                    </p>
                  </div>
                </div>

                <!-- Spots indicator -->
                <div v-if="event.capacity">
                  <div class="mb-2 flex items-center justify-between text-xs">
                    <span class="font-semibold text-slate-600">
                      <i class="fas fa-users mr-1 text-[#e0ac2e]"></i>Availability
                    </span>
                    <span :class="event.is_full ? 'font-bold text-rose-600' : 'text-slate-500'">
                      {{ event.is_full ? 'FULL' : `${event.spots_left} / ${event.capacity} left` }}
                    </span>
                  </div>
                  <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                    <div
                      :class="[
                        'h-full rounded-full transition-all duration-700',
                        event.is_full ? 'bg-rose-500' : (event.spots_left <= 5 ? 'bg-[#e0ac2e]' : 'bg-[#00583f]')
                      ]"
                      :style="{ width: `${Math.min(100, (event.registered_count / event.capacity) * 100)}%` }"
                    ></div>
                  </div>
                </div>

                <!-- Register button -->
                <button
                  @click="openRegistration"
                  :disabled="event.is_full"
                  :class="[
                    'group w-full inline-flex items-center justify-center rounded-full px-6 py-4 text-xs font-extrabold uppercase tracking-[0.1em] transition-all duration-300',
                    event.is_full
                      ? 'cursor-not-allowed bg-slate-200 text-slate-400'
                      : 'bg-[#00583f] text-white hover:-translate-y-0.5 hover:bg-[#003c2b] hover:shadow-[0_10px_30px_rgba(0,88,63,0.3)]'
                  ]"
                >
                  <template v-if="!event.is_full">
                    SAVE YOUR SPOT
                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                  </template>
                  <template v-else>
                    <i class="fas fa-lock mr-2"></i>EVENT FULL
                  </template>
                </button>

                <!-- Info list -->
                <div class="space-y-3 border-t border-slate-100 pt-5">
                  <div v-if="event.location" class="flex items-center gap-2.5 text-xs text-slate-600">
                    <i class="fas fa-map-marker-alt w-4 text-[#e0ac2e]"></i>
                    <span>{{ event.location }}</span>
                  </div>
                  <div class="flex items-center gap-2.5 text-xs text-slate-600">
                    <i class="fas fa-check-circle w-4 text-[#e0ac2e]"></i>
                    <span>Free registration</span>
                  </div>
                  <div v-if="event.capacity" class="flex items-center gap-2.5 text-xs text-slate-600">
                    <i class="fas fa-users w-4 text-[#e0ac2e]"></i>
                    <span>Limited to {{ event.capacity }} guests</span>
                  </div>
                  <div class="flex items-center gap-2.5 text-xs text-slate-600">
                    <i class="fas fa-envelope w-4 text-[#e0ac2e]"></i>
                    <span>Confirmation sent by email</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Need help card -->
            <div class="mt-5 rounded-2xl border-l-4 border-[#e0ac2e] bg-[#fbfaf4] p-5">
              <div class="flex items-start gap-3">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-[#e0ac2e]/20 text-[#e0ac2e]">
                  <i class="fas fa-question text-sm"></i>
                </div>
                <div>
                  <p class="mb-1 text-sm font-extrabold uppercase tracking-wider text-[#00583f]">
                    Questions?
                  </p>
                  <p class="text-xs leading-6 text-slate-600">
                    Reach out to us at
                    <a href="mailto:info@QFCC.org" class="font-semibold text-[#00583f] hover:underline">
                      info@QFCC.org
                    </a>
                    and we'll help you out.
                  </p>
                </div>
              </div>
            </div>
          </aside>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════════════════ -->
      <!-- RELATED EVENTS                                          -->
      <!-- ═══════════════════════════════════════════════════════ -->
      <section v-if="relatedEvents?.length" class="bg-[#fbfaf4]">
        <div class="mx-auto max-w-[1200px] px-5 py-12 sm:px-8 lg:py-16">
          <div class="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
              <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#00583f]">
                <i class="fas fa-compass mr-2"></i>MORE TO EXPLORE
              </p>
              <h2 class="font-serif text-[clamp(1.5rem,3.5vw,2.25rem)] font-bold leading-tight text-[#00583f]">
                You might also like
              </h2>
            </div>
            <Link
              :href="route('event.create')"
              class="inline-flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f] transition-colors hover:text-[#e0ac2e] group"
            >
              VIEW ALL EVENTS
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
            </Link>
          </div>

          <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <Link
              v-for="related in relatedEvents"
              :key="related.id"
              :href="route('event.show', related.slug)"
              class="group relative flex flex-col overflow-hidden rounded-[20px] bg-white shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,65,47,0.15)]"
            >
              <div class="absolute inset-x-0 top-0 z-10 h-1 origin-left scale-x-0 bg-gradient-to-r from-[#e0ac2e] to-[#00583f] transition-transform duration-500 group-hover:scale-x-100"></div>

              <div class="relative h-[200px] overflow-hidden">
                <img
                  :src="related.image"
                  :alt="related.title"
                  class="block h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <span class="absolute right-4 top-4 flex min-w-[54px] flex-col items-center rounded-xl bg-white px-3 py-2 text-center shadow-md">
                  <b class="text-[0.6rem] font-extrabold uppercase tracking-wider text-[#e0ac2e]">
                    {{ related.month }}
                  </b>
                  <strong class="font-serif text-xl font-bold leading-none text-[#00583f]">
                    {{ related.day }}
                  </strong>
                </span>
                <span
                  v-if="related.is_full"
                  class="absolute left-4 top-4 inline-flex items-center rounded-full bg-rose-600 px-3 py-1.5 text-[0.6rem] font-extrabold uppercase tracking-wider text-white shadow-lg"
                >
                  <i class="fas fa-lock mr-1.5"></i>FULL
                </span>
              </div>

              <div class="flex flex-1 flex-col p-6">
                <p class="mb-3 flex items-center text-[0.6rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">
                  <i class="fas fa-tag mr-1"></i>{{ related.category }}
                </p>
                <h3 class="mb-3 font-serif text-lg font-bold leading-tight text-[#00583f]">
                  {{ related.title }}
                </h3>
                <p class="mb-4 flex-1 text-xs leading-6 text-slate-600 line-clamp-2">
                  {{ related.description }}
                </p>
                <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                  <span class="flex items-center text-[11px] font-semibold text-slate-500">
                    <i class="fas fa-clock mr-1"></i>{{ related.time }}
                  </span>
                  <i class="fas fa-arrow-right text-xs text-[#00583f] transition-transform group-hover:translate-x-1"></i>
                </div>
              </div>
            </Link>
          </div>
        </div>
      </section>

      <!-- ═══════════════════════════════════════════════════════ -->
      <!-- CTA STRIP                                                -->
      <!-- ═══════════════════════════════════════════════════════ -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#002d21] via-[#003c2b] to-[#00583f] text-white">
        <div class="pointer-events-none absolute inset-0 opacity-[0.08] events-hero-pattern"></div>
        <div class="relative mx-auto flex max-w-[1200px] flex-col gap-6 px-5 py-14 sm:px-8 md:flex-row md:items-center md:justify-between lg:px-12 lg:py-16">
          <div>
            <p class="mb-2 flex items-center text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-[#e0ac2e]">
              <i class="fas fa-hands-helping mr-2"></i>BE PART OF THE STORY
            </p>
            <h2 class="font-serif text-[clamp(1.5rem,3.5vw,2.25rem)] font-bold leading-tight">
              There is always room<br />for one more.
            </h2>
          </div>
          <Link
            :href="route('get-involved')"
            class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group"
          >
            GET INVOLVED
            <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
          </Link>
        </div>
      </section>
    </main>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- REGISTRATION MODAL                                       -->
    <!-- ═══════════════════════════════════════════════════════ -->
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
            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 flex items-start justify-between gap-4 flex-shrink-0">
              <div class="min-w-0 flex-1">
                <p class="text-[11px] font-bold text-[#e0ac2e] uppercase tracking-wider">
                  Event Registration
                </p>
                <h2 class="text-lg font-bold text-[#00583f] mt-0.5 truncate">
                  {{ event.title }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                  <i class="fas fa-calendar mr-1"></i>
                  {{ event.date_full }} · {{ event.time_range }}
                </p>
              </div>
              <button
                @click="closeModal"
                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all flex-shrink-0"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>

            <!-- Body -->
            <div class="p-6 overflow-y-auto flex-1">

              <!-- Spots left banner -->
              <div
                v-if="event.spots_left !== null && event.spots_left !== undefined"
                class="mb-5 p-3 rounded-lg bg-[#fbfaf4] border border-[#e0ac2e]/30 flex items-center gap-2.5"
              >
                <i class="fas fa-users text-[#e0ac2e]"></i>
                <p class="text-xs text-[#00583f] font-semibold">
                  <span class="font-extrabold">{{ event.spots_left }}</span>
                  spots left
                  <span class="text-slate-500 font-normal">of {{ event.capacity }}</span>
                </p>
              </div>

              <!-- Success -->
              <div v-if="registrationSuccess" class="text-center py-6">
                <div class="w-16 h-16 mx-auto rounded-full bg-emerald-100 flex items-center justify-center mb-4">
                  <i class="fas fa-check text-2xl text-emerald-600"></i>
                </div>
                <h3 class="text-lg font-bold text-[#00583f] mb-2">You're registered!</h3>
                <p class="text-sm text-slate-600 mb-5 leading-relaxed">
                  We've reserved your spot for <strong>{{ event.title }}</strong>.
                  A confirmation will be sent to <strong>{{ submittedEmail }}</strong>.
                </p>
                <div class="p-3 rounded-lg bg-[#fbfaf4] border border-[#e0ac2e]/30 inline-block">
                  <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                    Registration Reference
                  </p>
                  <p class="font-mono font-bold text-[#00583f] text-lg">
                    #{{ registrationId }}
                  </p>
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

                <!-- Error -->
                <div
                  v-if="errorMessage"
                  class="flex items-start gap-2.5 p-3 rounded-lg bg-rose-50 border border-rose-200"
                >
                  <i class="fas fa-exclamation-circle text-rose-500 text-sm mt-0.5"></i>
                  <p class="text-xs text-rose-700">{{ errorMessage }}</p>
                </div>

                <!-- Actions -->
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
import { ref, reactive } from 'vue'

/* --- Props --- */
const props = defineProps({
  event:         { type: Object, required: true },
  relatedEvents: { type: Array,  default: () => [] },
})

/* --- Page URL for sharing --- */
const pageUrl = typeof window !== 'undefined' ? window.location.href : ''

/* --- Copy link state --- */
const copied = ref(false)

function copyLink() {
  if (typeof navigator !== 'undefined' && navigator.clipboard) {
    navigator.clipboard.writeText(pageUrl)
    copied.value = true
    setTimeout(() => (copied.value = false), 2000)
  }
}

/* --- Registration modal --- */
const showModal = ref(false)
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

function openRegistration() {
  if (props.event.is_full) return

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
}

async function submitRegistration() {
  isSubmitting.value = true
  errorMessage.value = ''

  try {
    const response = await fetch(route('event.register', props.event.id), {
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

    // Update local state
    if (props.event) {
      props.event.spots_left = data.spots_left
      if (data.spots_left === 0) props.event.is_full = true
      props.event.registered_count = (props.event.registered_count || 0) + 1 + (form.guests || 0)
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
.animation-delay-200 { animation-delay: 200ms; }

.font-serif { font-family: Georgia, 'Times New Roman', serif; }

html { scroll-behavior: smooth; }

*:focus-visible { outline: 2px solid #e0ac2e; outline-offset: 2px; }

/* Line clamping for descriptions */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>