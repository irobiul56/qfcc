<template>
  <!-- Footer -->
  <footer id="contact" class="footer bg-[#00583f] text-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#d9a52b]/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-[#d9a52b]/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main footer content -->
    <div class="relative mx-auto grid max-w-[1500px] gap-10 px-5 py-12 sm:px-8 lg:grid-cols-[1.25fr_1fr_1.1fr_1.1fr_1.15fr] lg:py-16">
      
      <!-- Brand / Logo Column -->
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
        
        <!-- Social icons with Font Awesome -->
        <div class="mt-5 flex gap-3">
          <a 
            v-for="(social, i) in socialLinks" 
            :key="i"
            :href="social.url" 
            :aria-label="social.label"
            class="social-icon group"
          >
            <i :class="social.icon"></i>
          </a>
        </div>
      </div>

      <!-- Quick Links Column -->
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

      <!-- Programs Column -->
      <div class="footer-col">
        <h4>
          <i class="fas fa-th-large mr-2 text-[#d9a52b]"></i>PROGRAMS
        </h4>
        <ul class="footer-links">
          <li v-for="(program, i) in programs" :key="i">
            <a :href="program.url" class="footer-link">
              <i class="fas fa-chevron-right text-[8px] text-[#d9a52b] mr-1.5 opacity-0 group-hover:opacity-100 transition-opacity"></i>
              {{ program.label }}
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Column -->
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
            <a href="tel:+17188718030" class="hover:text-[#d9a52b] transition-colors">(347) 233-5473</a>
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

      <!-- Newsletter Column -->
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
          <button type="submit" class="btn btn-gold w-full justify-center group">
            <i class="fas fa-paper-plane mr-2 transition-transform group-hover:translate-x-1"></i>
            SUBSCRIBE
          </button>
        </form>
        
        <p v-if="subscribed" class="mt-2 text-xs text-[#e3b13a] flex items-center gap-1">
          <i class="fas fa-check-circle"></i> Thank you for subscribing!
        </p>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="relative border-t border-white/15">
      <div class="mx-auto flex max-w-[1500px] flex-col gap-3 px-5 py-5 text-xs text-white/80 sm:px-8 md:flex-row md:items-center md:justify-between">
        <span class="flex items-center gap-2">
          <i class="fas fa-copyright text-[#d9a52b]"></i>
          © 2025 Queens Family and Community Center (QFCC). All rights reserved.
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
import { ref } from 'vue'

const email = ref('')
const subscribed = ref(false)

// Social links data
const socialLinks = [
  { label: 'Facebook', url: '#', icon: 'fab fa-facebook-f' },
  { label: 'Instagram', url: '#', icon: 'fab fa-instagram' },
  { label: 'YouTube', url: '#', icon: 'fab fa-youtube' },
  { label: 'Email', url: 'mailto:info@QFCC.org', icon: 'fas fa-envelope' }
]

// Quick links data
const quickLinks = [
  { label: 'Home', url: '/' },
  { label: 'About QFCC', url: '/about' },
  { label: 'Programs & Services', url: '#programs' },
  { label: 'Events', url: '#events' },
  { label: 'Get Involved', url: '#involved' },
  { label: 'Membership', url: '#' },
  { label: 'Volunteer', url: '#' },
  { label: 'Contact Us', url: '#contact' }
]

// Programs data
const programs = [
  { label: 'Family & Community Services', url: '#' },
  { label: 'Youth Development & Education', url: '#' },
  { label: 'Health & Wellness', url: '#' },
  { label: 'Volunteer & Civic Engagement', url: '#' },
  { label: 'Humanitarian Relief & Food Assistance', url: '#' },
  { label: 'Humanitarian Services', url: '#' },
  { label: 'Immigrant & Refugee Support', url: '#' },
  { label: 'Religious & Spiritual Services', url: '#' }
]

// Newsletter subscribe handler
const subscribe = () => {
  if (!email.value) return
  // TODO: Wire to your backend API
  // await axios.post('/api/newsletter', { email: email.value })
  console.log('Subscribe:', email.value)
  subscribed.value = true
  email.value = ''
  setTimeout(() => { subscribed.value = false }, 4000)
}
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

.btn-gold:hover {
  background-color: #c2941f;
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(217, 165, 43, 0.3);
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