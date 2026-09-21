<template>
  <!-- Footer -->
  <footer id="contact" class="footer bg-[#00583f] text-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#d9a52b]/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-[#d9a52b]/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main footer content -->
    <div class="relative mx-auto grid max-w-[1500px] gap-10 px-5 py-12 sm:px-8 lg:grid-cols-[1.25fr_1fr_1.1fr_1.1fr_1.15fr] lg:py-16">

      <!-- ═══════════ BRAND / LOGO COLUMN ═══════════ -->
      <div class="footer-col">
        <a href="/" class="inline-block">
          <img
            src="/storage/images/qfcc-logos.png"
            alt="QFCC"
            class="footer-logo h-16 w-auto object-contain transition-transform duration-300 hover:scale-105"
          />
        </a>

        <p class="mt-4 font-serif text-[#e3b13a] text-base leading-relaxed">
          Together today,<br />building a better tomorrow.
        </p>

        <!-- Social icons — DB driven -->
        <div v-if="socialLinks.length > 0" class="mt-5 flex flex-wrap gap-3">
          <a
            v-for="social in socialLinks"
            :key="social.id"
            :href="social.url"
            :aria-label="social.platform"
            :title="social.platform"
            target="_blank"
            rel="noopener noreferrer"
            class="social-icon group"
          >
            <SvgIcon :name="social.icon" class="w-5 h-5" />
          </a>
        </div>
      </div>

      <!-- ═══════════ QUICK LINKS COLUMN ═══════════ -->
      <div class="footer-col">
        <h4>
          <i class="fas fa-link mr-2 text-[#d9a52b]"></i>QUICK LINKS
        </h4>
        <ul class="footer-links">
          <li v-for="(link, i) in quickLinks" :key="i">
            <a :href="link.url" class="footer-link">
              <i class="fas fa-chevron-right text-[8px] text-[#d9a52b] mr-1.5 opacity-0 group-hover:opacity-100 transition-opacity"></i>
              {{ link.label }}
            </a>
          </li>
        </ul>
      </div>

      <!-- ═══════════ PROGRAMS COLUMN (DB-DRIVEN) ═══════════ -->
      <div class="footer-col">
        <h4>
          <i class="fas fa-th-large mr-2 text-[#d9a52b]"></i>PROGRAMS
        </h4>

        <p v-if="programs.length === 0" class="text-xs text-white/60 italic">
          Programs coming soon.
        </p>

        <ul v-else class="footer-links">
          <li v-for="program in programs" :key="program.id">
            <a :href="program.url" class="footer-link">
              <i class="fas fa-chevron-right text-[8px] text-[#d9a52b] mr-1.5 opacity-0 group-hover:opacity-100 transition-opacity"></i>
              {{ program.title }}
            </a>
          </li>
        </ul>
      </div>

      <!-- ═══════════ CONTACT COLUMN ═══════════ -->
      <div class="footer-col">
        <h4>
          <i class="fas fa-address-card mr-2 text-[#d9a52b]"></i>CONTACT US
        </h4>
        <ul class="contact-list">
          <li>
            <i class="fas fa-map-marker-alt contact-icon"></i>
            <span>Queens, New York City and beyond</span>
          </li>
          <li>
            <i class="fas fa-phone-alt contact-icon"></i>
            <a href="tel:+13472335473" class="hover:text-[#d9a52b] transition-colors">(347) 233-5473</a>
          </li>
          <li>
            <i class="fas fa-envelope contact-icon"></i>
            <a href="mailto:info@QFCC.org" class="hover:text-[#d9a52b] transition-colors">info@QFCC.org</a>
          </li>
          <li>
            <i class="fas fa-globe contact-icon"></i>
            <a href="https://www.QFCC.org" target="_blank" rel="noopener" class="hover:text-[#d9a52b] transition-colors">www.QFCC.org</a>
          </li>
        </ul>
      </div>

      <!-- ═══════════ NEWSLETTER COLUMN ═══════════ -->
      <div class="footer-col">
        <h4>
          <i class="fas fa-paper-plane mr-2 text-[#d9a52b]"></i>NEWSLETTER
        </h4>
        <p class="text-sm opacity-85 mb-3">
          Stay connected with our latest news and upcoming events.
        </p>

        <form @submit.prevent="subscribe" class="space-y-2">
          <div class="relative">
            <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-sm"></i>
            <input
              v-model="email"
              type="email"
              class="newsletter-input"
              placeholder="Your email address"
              required
            />
          </div>
          <button type="submit" class="btn btn-gold w-full justify-center group" :disabled="isSubscribing">
            <i :class="isSubscribing ? 'fas fa-circle-notch fa-spin' : 'fas fa-paper-plane'" class="mr-2 transition-transform group-hover:translate-x-1"></i>
            {{ isSubscribing ? 'SUBSCRIBING...' : 'SUBSCRIBE' }}
          </button>
        </form>

        <p v-if="subscribed" class="mt-2 text-xs text-[#e3b13a] flex items-center gap-1">
          <i class="fas fa-check-circle"></i> Thank you for subscribing!
        </p>
        <p v-if="subscribeError" class="mt-2 text-xs text-rose-300 flex items-center gap-1">
          <i class="fas fa-exclamation-circle"></i> {{ subscribeError }}
        </p>
      </div>
    </div>

    <!-- ═══════════ BOTTOM BAR ═══════════ -->
    <div class="relative border-t border-white/15">
      <div class="mx-auto flex max-w-[1500px] flex-col gap-3 px-5 py-5 text-xs text-white/80 sm:px-8 md:flex-row md:items-center md:justify-between">

        <span class="flex items-center gap-2">
          <i class="fas fa-copyright text-[#d9a52b]"></i>
          © {{ currentYear }} Queens Family and Community Center (QFCC). All rights reserved.
        </span>

        <span class="flex items-center gap-2">
          <i class="fas fa-certificate text-[#d9a52b]"></i>
          A 501(c)(3) Nonprofit Organization
          <span class="text-white/40 mx-1">|</span>
          EIN: 93-4672630
        </span>

        <span class="flex items-center gap-2 font-semibold tracking-wider text-[#e3b13a]">
          <i class="fas fa-star"></i>
          Faith. Service. Community. Impact.
        </span>

      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref, computed, h, defineComponent } from 'vue'
import { usePage } from '@inertiajs/vue3'

/* ═══════════════════════════════════════════════════════════
   INERTIA GLOBAL PROPS — from HandleInertiaRequests middleware
   ═══════════════════════════════════════════════════════════ */
const page = usePage()

const socialLinks    = computed(() => page.props.footerSocialLinks    ?? [])
const programs       = computed(() => page.props.footerPrograms       ?? [])
const upcomingEvents = computed(() => page.props.footerUpcomingEvents ?? [])

/* ═══════════════════════════════════════════════════════════
   STATIC DATA
   ═══════════════════════════════════════════════════════════ */
const currentYear = new Date().getFullYear()

const quickLinks = [
  { label: 'Home',                url: '/' },
  { label: 'About QFCC',          url: '/about' },
  { label: 'Programs & Services', url: '/programs' },
  { label: 'Events',              url: '/event' },
  { label: 'Get Involved',        url: '/get-involved' },
  { label: 'Membership',          url: '/membership' },
  { label: 'Volunteer',           url: '/volunteer' },
  { label: 'Contact Us',          url: '/contact' },
]

/* ═══════════════════════════════════════════════════════════
   NEWSLETTER STATE
   ═══════════════════════════════════════════════════════════ */
const email          = ref('')
const subscribed     = ref(false)
const isSubscribing  = ref(false)
const subscribeError = ref('')

const subscribe = () => {
  if (!email.value) return

  isSubscribing.value = true
  subscribeError.value = ''

  fetch('/newsletter/subscribe', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
    },
    body: JSON.stringify({ email: email.value, name: null }),
  })
    .then((res) => res.json())
    .then((data) => {
      isSubscribing.value = false

      if (!data.success) {
        subscribeError.value = data.message || 'Subscription failed. Please try again.'
        return
      }

      subscribed.value = true
      email.value = ''
      setTimeout(() => (subscribed.value = false), 5000)
    })
    .catch(() => {
      isSubscribing.value = false
      subscribeError.value = 'Network error. Please try again.'
    })
}

/* ═══════════════════════════════════════════════════════════
   SvgIcon COMPONENT — inline SVG (no Font Awesome needed)
   ═══════════════════════════════════════════════════════════ */
const SVG_PATHS = {
  /* Social platform icons (filled) */
  'facebook': [
    'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z',
  ],
  'instagram': [
    'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z',
  ],
  'youtube': [
    'M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z',
  ],
  'twitter': [
    'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
  ],
  'x-twitter': [
    'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
  ],
  'linkedin': [
    'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
  ],
  'tiktok': [
    'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z',
  ],
  'whatsapp': [
    'M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z',
  ],
  'pinterest': [
    'M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z',
  ],
  'telegram': [
    'M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z',
  ],
  'discord': [
    'M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028 14.09 14.09 0 0 0 1.226-1.994.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z',
  ],
  'snapchat': [
    'M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.299 4.847l-.003.06c-.012.18-.022.345-.03.51.075.045.203.09.401.09.3-.016.659-.12 1.033-.301.165-.088.344-.104.464-.104.182 0 .359.029.509.09.45.149.734.479.734.838.015.449-.39.839-1.213 1.168-.089.029-.209.075-.344.119-.45.135-1.139.36-1.333.81-.09.224-.061.524.12.868l.015.015c.06.136 1.526 3.475 4.791 4.014.255.044.435.27.42.509 0 .075-.015.149-.045.225-.24.569-1.273.988-3.146 1.271-.059.091-.12.375-.164.57-.029.179-.074.36-.134.553-.076.271-.27.405-.555.405h-.03c-.135 0-.313-.031-.538-.074-.36-.075-.765-.135-1.273-.135-.3 0-.599.015-.913.074-.6.104-1.123.464-1.723.884-.853.599-1.826 1.288-3.294 1.288-.06 0-.119-.015-.18-.015h-.149c-1.468 0-2.427-.675-3.279-1.288-.599-.42-1.107-.779-1.707-.884-.314-.045-.629-.074-.928-.074-.54 0-.958.089-1.272.149-.211.043-.391.074-.54.074-.374 0-.523-.224-.583-.42-.061-.192-.09-.389-.135-.567-.046-.181-.105-.494-.166-.57-1.918-.222-2.95-.642-3.189-1.226-.031-.063-.052-.15-.055-.225-.015-.243.165-.465.42-.509 3.264-.54 4.73-3.879 4.791-4.02l.016-.029c.18-.345.224-.645.119-.869-.195-.434-.884-.658-1.332-.809-.121-.029-.24-.074-.346-.119-1.107-.435-1.257-.93-1.197-1.273.09-.479.674-.793 1.168-.793.146 0 .27.029.383.074.42.194.789.3 1.104.3.234 0 .384-.06.465-.105l-.046-.569c-.098-1.626-.225-3.651.307-4.837C7.392 1.077 10.739.807 11.727.807l.419-.015h.06z',
  ],
  'reddit': [
    'M12 0C5.373 0 0 5.373 0 12c0 3.314 1.343 6.314 3.515 8.485l-2.286 2.286A.75.75 0 0 0 1.75 24h10.5c6.627 0 12-5.373 12-12S18.627 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.688-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z',
  ],

  /* Generic icons (stroke-based) */
  'mail':     ['M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
  'envelope': ['M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
  'globe':    ['M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
  'link':     ['M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244'],
}

const FILLED_ICONS = [
  'facebook', 'instagram', 'youtube', 'twitter', 'x-twitter', 'linkedin',
  'tiktok', 'whatsapp', 'pinterest', 'telegram', 'discord', 'snapchat', 'reddit',
]

const SvgIcon = defineComponent({
  props: {
    name: { type: String, required: true },
    strokeWidth: { type: [Number, String], default: 1.75 },
  },
  setup(props) {
    return () => {
      // Normalize: 'fab fa-facebook-f' → 'facebook'
      let key = (props.name || 'globe')
        .toLowerCase()
        .trim()
        .replace(/^(fas|far|fab|fa-solid|fa-regular|fa-brands|fa)\s+/, '')
        .replace(/^fa-/, '')
        .replace(/-f$/, '')
        .replace(/^fa-/, '')

      // Common aliases
      const aliases = {
        'facebook-f': 'facebook',
        'twitter-x': 'x-twitter',
        'x': 'x-twitter',
        'ig': 'instagram',
        'yt': 'youtube',
        'wa': 'whatsapp',
      }
      if (aliases[key]) key = aliases[key]

      const paths = SVG_PATHS[key] || SVG_PATHS['globe']
      const isFilled = FILLED_ICONS.includes(key)

      return h('svg', {
        xmlns: 'http://www.w3.org/2000/svg',
        fill: isFilled ? 'currentColor' : 'none',
        viewBox: '0 0 24 24',
        ...(isFilled ? {} : { 'stroke-width': props.strokeWidth, stroke: 'currentColor' }),
        class: 'shrink-0',
      }, paths.map((d, i) =>
        h('path', {
          key: i,
          ...(isFilled ? {} : {
            'stroke-linecap': 'round',
            'stroke-linejoin': 'round',
          }),
          d,
        })
      ))
    }
  },
})
</script>

<style scoped>
/* ===== FOOTER BASE ===== */
.footer {
  position: relative;
}

/* ===== COLUMN TITLES ===== */
.footer-col h4 {
  font-size: 0.8rem;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  color: #d9a52b;
  margin-bottom: 1rem;
  font-weight: 700;
  display: flex;
  align-items: center;
}

/* ===== LOGO ===== */
.footer-logo {
  filter: brightness(0) invert(1);
  max-width: 160px;
}

/* ===== LINKS ===== */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  gap: 0.35rem;
}

.footer-link {
  display: inline-flex;
  align-items: center;
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.85);
  text-decoration: none;
  transition: all 0.2s ease;
  padding: 0.15rem 0;
}

.footer-link:hover {
  color: #d9a52b;
  transform: translateX(4px);
}

.footer-link:hover i {
  opacity: 1 !important;
}

/* ===== CONTACT LIST ===== */
.contact-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: grid;
  gap: 0.6rem;
}

.contact-list li {
  display: flex;
  align-items: flex-start;
  gap: 0.6rem;
  font-size: 0.9rem;
  color: rgba(255, 255, 255, 0.85);
}

.contact-list a {
  color: rgba(255, 255, 255, 0.85);
  text-decoration: none;
}

.contact-icon {
  color: #d9a52b;
  margin-top: 4px;
  width: 16px;
  flex-shrink: 0;
}

/* ===== SOCIAL ICONS ===== */
.social-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.15);
  color: white;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 0.95rem;
}

.social-icon:hover {
  background: #d9a52b;
  border-color: #d9a52b;
  color: #00583f;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(217, 165, 43, 0.35);
}

/* ===== NEWSLETTER ===== */
.newsletter-input {
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 60px;
  padding: 0.7rem 1.2rem 0.7rem 2.5rem;
  width: 100%;
  color: white;
  outline: none;
  transition: all 0.2s ease;
  font-size: 0.9rem;
}

.newsletter-input::placeholder {
  color: rgba(255, 255, 255, 0.5);
}

.newsletter-input:focus {
  border-color: #d9a52b;
  background: rgba(255, 255, 255, 0.12);
  box-shadow: 0 0 0 3px rgba(217, 165, 43, 0.15);
}

/* ===== BUTTON ===== */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.75rem;
  letter-spacing: 0.08em;
  padding: 0.75rem 1.5rem;
  border-radius: 9999px;
  transition: all 0.3s ease;
  text-decoration: none;
  border: none;
  cursor: pointer;
}

.btn-gold {
  background-color: #d9a52b;
  color: #1e1e1e;
}

.btn-gold:hover:not(:disabled) {
  background-color: #c2941f;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(217, 165, 43, 0.3);
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
  .footer-col h4 {
    justify-content: flex-start;
  }

  .footer-link {
    font-size: 0.85rem;
  }
}
</style>