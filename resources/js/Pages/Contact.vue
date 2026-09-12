<template>
  <AppLayout
    title="Contact Us | QFCC"
    description="Whether you need support, want to collaborate, or simply have a question, the QFCC team is here to listen and help you find the next step."
  >
    <main>
      <!-- ================= HERO ================= -->
      <section class="relative overflow-hidden bg-gradient-to-br from-[#002d21] via-[#003c2b] to-[#00583f] text-white">
        <!-- Decorative pattern -->
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
                class="inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group"
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
              href="tel:+17188718030"
              class="group flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-[0_4px_15px_rgba(0,0,0,0.03)] transition-all duration-300 hover:-translate-y-1 hover:border-[#00583f]/20 hover:shadow-[0_15px_35px_rgba(0,88,63,0.1)]"
            >
              <span
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-[#00583f]/10 text-xl text-[#00583f] transition-all duration-300 group-hover:rotate-[8deg] group-hover:scale-110 group-hover:bg-[#00583f] group-hover:text-white"
              >
                <i class="fas fa-phone-alt"></i>
              </span>
              <span class="flex flex-col">
                <small class="text-[0.6rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">
                  CALL US
                </small>
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
                <small class="text-[0.6rem] font-extrabold uppercase tracking-[0.15em] text-[#e0ac2e]">
                  EMAIL US
                </small>
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
          <div
            class="mt-8 flex items-start gap-4 rounded-2xl border-l-4 border-[#e0ac2e] bg-[#fbfaf4] p-5"
          >
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
          action="#"
          method="post"
          class="relative overflow-hidden rounded-2xl border border-slate-100 bg-white p-7 shadow-[0_10px_40px_rgba(0,65,47,0.08)] sm:p-10"
        >
          <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#e0ac2e] via-[#00583f] to-[#e0ac2e]"></div>

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
            <label class="flex flex-col gap-2">
              <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                <i class="fas fa-user mr-1 text-[#e0ac2e]"></i>YOUR NAME
              </span>
              <input
                type="text"
                name="name"
                placeholder="First and last name"
                required
                class="rounded-xl border border-slate-200 bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
              />
            </label>

            <label class="flex flex-col gap-2">
              <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
                <i class="fas fa-envelope mr-1 text-[#e0ac2e]"></i>EMAIL ADDRESS
              </span>
              <input
                type="email"
                name="email"
                placeholder="you@example.com"
                required
                class="rounded-xl border border-slate-200 bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
              />
            </label>
          </div>

          <label class="mt-5 flex flex-col gap-2">
            <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
              <i class="fas fa-comment-dots mr-1 text-[#e0ac2e]"></i>WHAT CAN WE HELP WITH?
            </span>
            <select
              name="topic"
              class="appearance-none rounded-xl border border-slate-200 bg-[#fbfaf4]/50 bg-[url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2214%22 height=%2214%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2300583f%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22/></svg>')] bg-[length:14px] bg-[right_1rem_center] bg-no-repeat px-4 py-3.5 pr-10 text-sm text-slate-700 outline-none transition-all duration-300 focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
            >
              <option>Choose a topic</option>
              <option>Programs and services</option>
              <option>Volunteer or membership</option>
              <option>Partnerships</option>
              <option>General question</option>
            </select>
          </label>

          <label class="mt-5 flex flex-col gap-2">
            <span class="text-[0.65rem] font-extrabold uppercase tracking-[0.15em] text-[#00583f]">
              <i class="fas fa-pen mr-1 text-[#e0ac2e]"></i>YOUR MESSAGE
            </span>
            <textarea
              name="message"
              rows="5"
              placeholder="Tell us a little about what you need..."
              class="resize-none rounded-xl border border-slate-200 bg-[#fbfaf4]/50 px-4 py-3.5 text-sm text-slate-700 outline-none transition-all duration-300 placeholder:text-slate-400 focus:border-[#00583f] focus:bg-white focus:ring-4 focus:ring-[#00583f]/10"
            ></textarea>
          </label>

          <!-- Footer -->
          <div class="mt-7 flex flex-col gap-4 border-t border-slate-100 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="flex items-center text-xs leading-5 text-slate-500 sm:max-w-[280px]">
              <i class="fas fa-shield-alt mr-2 text-[#e0ac2e]"></i>
              We respect your privacy and will only use your details to respond.
            </p>
            <button
              type="submit"
              class="inline-flex items-center justify-center rounded-full bg-[#00583f] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-white transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#003c2b] hover:shadow-[0_10px_30px_rgba(0,88,63,0.3)] group"
            >
              SEND MESSAGE
              <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
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

            <!-- Points -->
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
              class="mt-8 inline-flex items-center justify-center rounded-full bg-[#e0ac2e] px-8 py-3.5 text-xs font-extrabold uppercase tracking-[0.1em] text-[#002d21] transition-all duration-300 hover:-translate-y-0.5 hover:bg-[#c9991f] hover:shadow-[0_10px_30px_rgba(224,172,46,0.35)] group"
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
import AppLayout from '@/Layouts/AppLayout.vue'
</script>

<style scoped>
/* ---------- Custom pattern for hero ---------- */
.contact-hero-pattern {
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

/* ---------- Custom select arrow spacing fix ---------- */
select {
  background-position: right 1rem center;
}
</style>