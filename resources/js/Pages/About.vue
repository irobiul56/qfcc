<template>
  <AppLayout
    title="About QFCC"
    description="Learn about Queens Family and Community Center, our mission, vision, and commitment to serving the community."
  >
    <main class="overflow-hidden bg-white">

      <!-- ═══════════════════════════════════════════════════ -->
      <!-- HERO SECTION                                       -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section class="relative isolate min-h-[620px] overflow-hidden lg:min-h-[680px]">
        <img
          src="/storage/images/about-hero.jpg"
          alt="QFCC community gathered together"
          class="absolute inset-0 h-full w-full object-cover object-center"
        />

        <div class="absolute inset-0 bg-gradient-to-r from-[#002d21]/95 via-[#003c2b]/85 to-[#00583f]/30"></div>

        <div class="absolute -left-24 top-20 h-72 w-72 rounded-full bg-[#e0ac2e]/10 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-[#00a878]/10 blur-3xl"></div>

        <div class="relative mx-auto flex min-h-[620px] max-w-[1280px] items-center px-5 py-20 sm:px-8 lg:min-h-[680px] lg:px-12">
          <div class="max-w-3xl text-white">

            <div class="mb-6 inline-flex items-center gap-3">
              <span class="h-px w-10 bg-[#e0ac2e]"></span>
              <span class="text-xs font-bold uppercase tracking-[0.28em] text-[#e0ac2e]">
                About QFCC
              </span>
            </div>

            <h1 class="max-w-3xl font-serif text-4xl font-bold leading-[1.08] tracking-tight sm:text-5xl md:text-6xl lg:text-7xl">
              Rooted in faith,
              <span class="block text-[#e0ac2e]">united in service.</span>
            </h1>

            <p class="mt-7 max-w-2xl text-base leading-8 text-white/85 sm:text-lg">
              Queens Family and Community Center brings people together to learn, grow, serve, and build a stronger future for every family.
            </p>

            <div class="mt-9 flex flex-wrap gap-4">
              <a href="#story" class="group inline-flex items-center gap-3 rounded-full bg-[#00583f] px-7 py-3.5 text-xs font-bold tracking-[0.12em] text-white shadow-lg shadow-black/20 transition-all duration-300 hover:-translate-y-1 hover:bg-[#007052] hover:shadow-xl">
                OUR STORY
                <i class="fas fa-arrow-right text-[11px] transition-transform duration-300 group-hover:translate-x-1"></i>
              </a>

              <Link :href="route('get-involved')" class="group inline-flex items-center gap-3 rounded-full bg-[#e0ac2e] px-7 py-3.5 text-xs font-bold tracking-[0.12em] text-[#002d21] shadow-lg shadow-black/20 transition-all duration-300 hover:-translate-y-1 hover:bg-[#f0c34f] hover:shadow-xl">
                GET INVOLVED
                <i class="fas fa-arrow-right text-[11px] transition-transform duration-300 group-hover:translate-x-1"></i>
              </Link>
            </div>

          </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white/20 to-transparent"></div>
      </section>


      <!-- ═══════════════════════════════════════════════════ -->
      <!-- QUICK STATS                                        -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section class="relative z-10 -mt-10 px-5 sm:px-8">
        <div class="mx-auto grid max-w-[1100px] overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-[0_20px_60px_rgba(0,65,47,.12)] sm:grid-cols-3">
          <div class="border-b border-slate-100 px-6 py-7 text-center sm:border-b-0 sm:border-r">
            <div class="font-serif text-3xl font-bold text-[#00583f]">Community</div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-500">Built Together</p>
          </div>
          <div class="border-b border-slate-100 px-6 py-7 text-center sm:border-b-0 sm:border-r">
            <div class="font-serif text-3xl font-bold text-[#00583f]">Faith</div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-500">Guided by Values</p>
          </div>
          <div class="px-6 py-7 text-center">
            <div class="font-serif text-3xl font-bold text-[#00583f]">Service</div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-500">Driven by Compassion</p>
          </div>
        </div>
      </section>


      <!-- ═══════════════════════════════════════════════════ -->
      <!-- WHO WE ARE                                         -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section id="story" class="relative mx-auto max-w-[1280px] px-5 py-20 sm:px-8 lg:px-12 lg:py-28">
        <div class="grid items-center gap-14 lg:grid-cols-[0.9fr_1.1fr] lg:gap-20">

          <div class="relative">
            <div class="absolute -left-4 -top-4 h-full w-full rounded-[28px] border-2 border-[#e0ac2e]/30 sm:-left-6 sm:-top-6"></div>

            <div class="relative overflow-hidden rounded-[28px] shadow-[0_25px_70px_rgba(0,65,47,.15)]">
              <img
                src="/storage/images/story-mosque.jpg"
                alt="A mosque and community gathering place"
                class="h-[360px] w-full object-cover transition duration-700 hover:scale-105 sm:h-[500px]"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-[#002d21]/45 to-transparent"></div>
            </div>

            <div class="absolute -bottom-6 right-5 rounded-2xl bg-white p-5 shadow-[0_15px_45px_rgba(0,0,0,.12)] sm:right-8">
              <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#00583f]/10 text-[#00583f]">
                  <i class="fas fa-heart text-lg"></i>
                </div>
                <div>
                  <p class="text-xs font-bold uppercase tracking-wider text-[#00583f]">Our Purpose</p>
                  <p class="mt-1 text-sm text-slate-500">Serving humanity</p>
                </div>
              </div>
            </div>
          </div>

          <div>
            <div class="mb-5 flex items-center gap-3">
              <span class="h-[3px] w-10 bg-[#e0ac2e]"></span>
              <span class="text-xs font-bold uppercase tracking-[0.22em] text-[#00583f]">Who We Are</span>
            </div>

            <h2 class="font-serif text-3xl font-bold leading-tight text-[#00583f] sm:text-4xl lg:text-5xl">
              A community built by neighbors,
              <span class="text-[#e0ac2e]">for neighbors.</span>
            </h2>

            <p class="mt-6 text-[15px] leading-8 text-slate-600">
              <strong class="text-[#00583f]">Queens Family and Community Center (QFCC)</strong>
              is a faith-based nonprofit organization dedicated to strengthening families, empowering individuals, and building a compassionate, educated, and united community.
            </p>

            <div class="mt-8 rounded-2xl border border-[#00583f]/10 bg-[#f8faf9] p-6">
              <div class="flex gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#00583f] text-white shadow-lg">
                  <i class="fas fa-mosque"></i>
                </div>
                <div>
                  <h3 class="text-sm font-extrabold uppercase tracking-wider text-[#00583f]">Our Foundation</h3>
                  <p class="mt-2 text-sm leading-7 text-slate-600">
                    Guided by the teachings of the
                    <strong>Holy Qur'an</strong> and the
                    <strong>Sunnah of Prophet Muhammad ﷺ</strong>,
                    QFCC is committed to serving humanity with mercy, dignity, justice, and respect.
                  </p>
                </div>
              </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-3">
              <div class="flex items-center gap-3">
                <i class="fas fa-circle-check text-[#e0ac2e]"></i>
                <span class="text-sm font-semibold text-slate-700">Compassion</span>
              </div>
              <div class="flex items-center gap-3">
                <i class="fas fa-circle-check text-[#e0ac2e]"></i>
                <span class="text-sm font-semibold text-slate-700">Dignity</span>
              </div>
              <div class="flex items-center gap-3">
                <i class="fas fa-circle-check text-[#e0ac2e]"></i>
                <span class="text-sm font-semibold text-slate-700">Service</span>
              </div>
            </div>
          </div>

        </div>
      </section>


      <!-- ═══════════════════════════════════════════════════ -->
      <!-- WHAT WE DO                                         -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section class="relative overflow-hidden bg-[#f8faf9] px-5 py-20 sm:px-8 lg:py-24">
        <div class="absolute -right-32 top-10 h-80 w-80 rounded-full bg-[#e0ac2e]/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-[1200px]">
          <div class="mx-auto max-w-3xl text-center">
            <div class="mb-4 flex items-center justify-center gap-3">
              <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>
              <span class="text-xs font-bold uppercase tracking-[0.22em] text-[#00583f]">What We Do</span>
              <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>
            </div>

            <h2 class="font-serif text-3xl font-bold text-[#00583f] sm:text-4xl">
              Creating meaningful impact,
              <span class="text-[#e0ac2e]">together.</span>
            </h2>

            <p class="mt-5 text-sm leading-7 text-slate-600 sm:text-base">
              We work to address the educational, social, spiritual, health, and humanitarian needs of individuals and families throughout Queens and the greater New York City community.
            </p>
          </div>

          <div class="mt-12 grid gap-6 md:grid-cols-3">
            <article class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,65,47,.12)]">
              <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-[#00583f]/5 transition group-hover:bg-[#e0ac2e]/10"></div>
              <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-2xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-hand-holding-heart"></i>
              </div>
              <h3 class="mt-6 text-sm font-extrabold tracking-wider text-[#00583f]">FAITH &amp; SERVICE</h3>
              <p class="mt-3 text-sm leading-7 text-slate-500">
                Serving humanity through Islamic values of mercy, dignity, justice, and respect.
              </p>
              <div class="mt-6 h-1 w-10 rounded-full bg-[#e0ac2e] transition-all duration-300 group-hover:w-20"></div>
            </article>

            <article class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,65,47,.12)]">
              <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-[#00583f]/5 transition group-hover:bg-[#e0ac2e]/10"></div>
              <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-2xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-users"></i>
              </div>
              <h3 class="mt-6 text-sm font-extrabold tracking-wider text-[#00583f]">FAMILY &amp; COMMUNITY</h3>
              <p class="mt-3 text-sm leading-7 text-slate-500">
                Strengthening families and connecting neighbors to practical support and opportunity.
              </p>
              <div class="mt-6 h-1 w-10 rounded-full bg-[#e0ac2e] transition-all duration-300 group-hover:w-20"></div>
            </article>

            <article class="group relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,65,47,.12)]">
              <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-[#00583f]/5 transition group-hover:bg-[#e0ac2e]/10"></div>
              <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-2xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-graduation-cap"></i>
              </div>
              <h3 class="mt-6 text-sm font-extrabold tracking-wider text-[#00583f]">LEARNING &amp; GROWTH</h3>
              <p class="mt-3 text-sm leading-7 text-slate-500">
                Empowering youth, seniors, newcomers, and individuals through education and leadership.
              </p>
              <div class="mt-6 h-1 w-10 rounded-full bg-[#e0ac2e] transition-all duration-300 group-hover:w-20"></div>
            </article>
          </div>
        </div>
      </section>


      <!-- ═══════════════════════════════════════════════════ -->
      <!-- COMMUNITY + MISSION / VISION (DB-DRIVEN)          -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section class="mx-auto max-w-[1280px] px-5 py-20 sm:px-8 lg:px-12 lg:py-28">
        <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">

          <!-- LEFT — Community Commitment (static) -->
          <div class="flex flex-col justify-center">
            <div class="mb-5 flex items-center gap-3">
              <span class="h-[3px] w-10 bg-[#e0ac2e]"></span>
              <span class="text-xs font-bold uppercase tracking-[0.22em] text-[#00583f]">
                Our Community Commitment
              </span>
            </div>

            <h2 class="font-serif text-3xl font-bold leading-tight text-[#00583f] sm:text-4xl lg:text-5xl">
              Strong families are the foundation of
              <span class="text-[#e0ac2e]">strong communities.</span>
            </h2>

            <p class="mt-6 text-sm leading-8 text-slate-600 sm:text-base">
              We bring together community members, volunteers, professionals, faith leaders, and partner organizations to provide practical support, build leadership, promote civic engagement, and create opportunities for people to learn, grow, serve, and succeed.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
              <span class="rounded-full bg-[#00583f]/10 px-4 py-2 text-xs font-semibold text-[#00583f]">
                <i class="fas fa-users mr-2"></i>Families
              </span>
              <span class="rounded-full bg-[#00583f]/10 px-4 py-2 text-xs font-semibold text-[#00583f]">
                <i class="fas fa-hands-helping mr-2"></i>Volunteers
              </span>
              <span class="rounded-full bg-[#00583f]/10 px-4 py-2 text-xs font-semibold text-[#00583f]">
                <i class="fas fa-globe mr-2"></i>Community
              </span>
            </div>
          </div>


          <!-- RIGHT — Mission/Vision Card (DB-Driven) -->
          <div class="relative overflow-hidden rounded-[28px] bg-gradient-to-br from-[#004d37] to-[#002d21] p-8 text-white shadow-[0_25px_70px_rgba(0,65,47,.2)] sm:p-10">
            <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-[#e0ac2e]/10"></div>
            <div class="absolute -bottom-24 -left-20 h-56 w-56 rounded-full bg-white/5"></div>

            <div class="relative">

              <!-- Vision (from DB) -->
              <div v-if="vision">
                <div class="flex items-center gap-3">
                  <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e0ac2e] text-[#002d21]">
                    <SvgIcon :name="vision.icon || 'eye'" class="w-5 h-5" />
                  </div>
                  <h2 class="font-serif text-2xl font-bold text-[#e0ac2e]">
                    {{ vision.heading }}
                  </h2>
                </div>

                <div
                  class="prose prose-sm prose-invert mt-5 max-w-none text-sm leading-7 text-white/80"
                  v-html="vision.content"
                ></div>
              </div>

              <!-- Divider -->
              <div v-if="vision && mission" class="my-8 h-px bg-white/10"></div>

              <!-- Mission (from DB) -->
              <div v-if="mission">
                <div class="flex items-center gap-3">
                  <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e0ac2e] text-[#002d21]">
                    <SvgIcon :name="mission.icon || 'target'" class="w-5 h-5" />
                  </div>
                  <h2 class="font-serif text-2xl font-bold text-[#e0ac2e]">
                    {{ mission.heading }}
                  </h2>
                </div>

                <div
                  class="prose prose-sm prose-invert mt-5 max-w-none text-sm leading-7 text-white/80"
                  v-html="mission.content"
                ></div>
              </div>

              <!-- Fallback if DB empty -->
              <div v-if="!vision && !mission" class="text-center py-8 text-white/60 text-sm">
                Vision and Mission content coming soon.
              </div>

            </div>
          </div>

        </div>
      </section>


      <!-- ═══════════════════════════════════════════════════ -->
      <!-- OUR COMMITMENT (static)                            -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section class="relative overflow-hidden bg-[#f8faf9] px-5 py-20 sm:px-8 lg:py-24">
        <div class="relative mx-auto max-w-[1200px]">
          <div class="mx-auto max-w-3xl text-center">
            <div class="mb-4 flex items-center justify-center gap-3">
              <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>
              <span class="text-xs font-bold uppercase tracking-[0.22em] text-[#00583f]">Our Commitment</span>
              <span class="h-[3px] w-8 bg-[#e0ac2e]"></span>
            </div>

            <h2 class="font-serif text-3xl font-bold text-[#00583f] sm:text-4xl">
              Serving with Faith,
              <span class="text-[#e0ac2e]">Compassion &amp; Excellence.</span>
            </h2>

            <p class="mt-5 text-sm leading-7 text-slate-600 sm:text-base">
              At Queens Family and Community Center, we believe meaningful service begins with compassion and is sustained through trust, collaboration, and excellence.
            </p>
          </div>

          <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <article class="group rounded-2xl border border-slate-100 bg-white p-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]">
              <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-handshake"></i>
              </div>
              <h3 class="mt-5 text-xs font-extrabold tracking-wider text-[#00583f]">COMMUNITY PARTNERSHIPS</h3>
              <p class="mt-3 text-sm leading-6 text-slate-500">
                Working together with nonprofits, schools, healthcare organizations, and civic leaders.
              </p>
            </article>

            <article class="group rounded-2xl border border-slate-100 bg-white p-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]">
              <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-heart"></i>
              </div>
              <h3 class="mt-5 text-xs font-extrabold tracking-wider text-[#00583f]">COMPASSIONATE SERVICE</h3>
              <p class="mt-3 text-sm leading-6 text-slate-500">
                Treating every individual with dignity, kindness, respect, and care.
              </p>
            </article>

            <article class="group rounded-2xl border border-slate-100 bg-white p-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]">
              <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-seedling"></i>
              </div>
              <h3 class="mt-5 text-xs font-extrabold tracking-wider text-[#00583f]">SUSTAINABLE IMPACT</h3>
              <p class="mt-3 text-sm leading-6 text-slate-500">
                Developing long-term programs that empower individuals and families.
              </p>
            </article>

            <article class="group rounded-2xl border border-slate-100 bg-white p-7 text-center shadow-sm transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_45px_rgba(0,65,47,.1)]">
              <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00583f]/10 text-xl text-[#00583f] transition duration-300 group-hover:bg-[#00583f] group-hover:text-white">
                <i class="fas fa-globe-americas"></i>
              </div>
              <h3 class="mt-5 text-xs font-extrabold tracking-wider text-[#00583f]">OPEN TO ALL</h3>
              <p class="mt-3 text-sm leading-6 text-slate-500">
                Welcoming people of all backgrounds while remaining guided by Islamic values.
              </p>
            </article>
          </div>

          <div class="mt-14 text-center">
            <div class="mx-auto mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-[#e0ac2e]/15 text-[#e0ac2e]">
              <i class="fas fa-quote-left"></i>
            </div>
            <blockquote class="mx-auto max-w-3xl font-serif text-lg italic leading-8 text-[#00583f] sm:text-xl">
              "Together, we strive to build a community where every individual has the opportunity to learn, grow, contribute, and succeed."
            </blockquote>
          </div>
        </div>
      </section>


      <!-- ═══════════════════════════════════════════════════ -->
      <!-- FINAL CTA                                          -->
      <!-- ═══════════════════════════════════════════════════ -->
      <section class="px-5 py-16 sm:px-8 lg:py-24">
        <div class="relative mx-auto max-w-[1200px] overflow-hidden rounded-[30px] bg-gradient-to-br from-[#00583f] to-[#002d21] shadow-[0_25px_70px_rgba(0,65,47,.2)]">
          <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#e0ac2e]/10"></div>
          <div class="absolute -bottom-28 -left-20 h-72 w-72 rounded-full bg-white/5"></div>

          <div class="relative grid items-center lg:grid-cols-[1.1fr_.9fr]">
            <div class="p-8 sm:p-12 lg:p-14">
              <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#e0ac2e] text-xl text-[#002d21]">
                <i class="fas fa-heart"></i>
              </div>

              <p class="text-xs font-bold uppercase tracking-[0.22em] text-[#e0ac2e]">
                Make A Difference
              </p>

              <h2 class="mt-3 font-serif text-3xl font-bold text-white sm:text-4xl">
                Be part of the
                <span class="text-[#e0ac2e]">QFCC community.</span>
              </h2>

              <p class="mt-5 max-w-xl text-sm leading-7 text-white/75 sm:text-base">
                Whether you share your time, your skills, or your support, there is a place for you here. Together, we can create meaningful and lasting change.
              </p>

              <Link :href="route('get-involved')" class="group mt-7 inline-flex items-center gap-3 rounded-full bg-[#e0ac2e] px-7 py-3.5 text-xs font-bold tracking-[0.12em] text-[#002d21] transition-all duration-300 hover:-translate-y-1 hover:bg-[#f0c34f]">
                GET INVOLVED
                <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
              </Link>
            </div>

            <div class="relative h-[300px] lg:h-full lg:min-h-[390px]">
              <img
                src="/storage/images/why-family.jpg"
                alt="QFCC families and community members"
                class="absolute inset-0 h-full w-full object-cover"
              />
              <div class="absolute inset-0 bg-gradient-to-r from-[#002d21]/30 to-transparent"></div>
            </div>
          </div>
        </div>
      </section>

    </main>
  </AppLayout>
</template>

<script setup>
import { h, defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

/* ═══════════════════════════════════════════════════════════
   PROPS — from AboutController
   ═══════════════════════════════════════════════════════════ */
const props = defineProps({
  vision:  { type: Object, default: null },
  mission: { type: Object, default: null },
})

/* ═══════════════════════════════════════════════════════════
   SvgIcon COMPONENT — inline SVG
   ═══════════════════════════════════════════════════════════ */
const SVG_PATHS = {
  'eye':    [
    'M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z',
    'M15 12a3 3 0 11-6 0 3 3 0 016 0z',
  ],
  'target': [
    'M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59',
  ],
  'star':   [
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
      // Accept 'eye', 'fas fa-eye', 'fa-eye', etc.
      let key = props.name || 'star'
      key = key.replace(/^(fas|far|fab|fa-solid|fa-regular|fa-brands|fa)\s+/, '').replace(/^fa-/, '')

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