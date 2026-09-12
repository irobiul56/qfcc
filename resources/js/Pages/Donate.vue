<template>
  <AppLayout title="Donate to QFCC — Queens Family and Community Center"
    description="Support QFCC's mission to strengthen families, empower youth, support seniors, welcome newcomers, and respond when neighbors need a hand.">
    <main>
      <!-- HERO with blurred background image (Nuclear Option — uses <img>) -->
      <section class="donate-hero">
        <!-- Background image as <img> with object-cover + blur -->
        <img 
          src="/storage/images/calligraphics.jpg" 
          alt="" 
          aria-hidden="true"
          class="donate-hero-bg-img"
        />
        
        <!-- Overlay gradient -->
        <div class="donate-hero-overlay"></div>

        <!-- Gold bottom border -->
        <div class="donate-hero-border"></div>

        <!-- Content -->
        <div class="relative z-[3] mx-auto max-w-[1250px] px-5 py-14 text-center sm:px-8 lg:py-20">
          <p class="donate-kicker">
            <i class="fas fa-hand-holding-heart mr-2"></i>QFCC COMMUNITY GIVING
          </p>
          <h1>Let's create <span>change together.</span></h1>
          <p class="donate-lead">
            Your generosity helps QFCC strengthen families, empower youth, support seniors, welcome
            newcomers, and respond when neighbors need a hand.
          </p>

          <!-- Quick action buttons -->
          <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="#campaigns" class="btn btn-gold">
              <i class="fas fa-donate mr-2"></i>GIVE NOW
            </a>
            <a href="#contact" class="btn btn-outline-light">
              <i class="fas fa-info-circle mr-2"></i>LEARN MORE
            </a>
          </div>

          <!-- Trust indicators -->
          <div class="mt-10 flex flex-wrap justify-center items-center gap-6 text-white/70 text-xs">
            <span class="flex items-center gap-2">
              <i class="fas fa-shield-alt text-[#d9a52b]"></i> Secure Donation
            </span>
            <span class="flex items-center gap-2">
              <i class="fas fa-check-circle text-[#d9a52b]"></i> Tax Deductible
            </span>
            <span class="flex items-center gap-2">
              <i class="fas fa-lock text-[#d9a52b]"></i> 100% Privacy
            </span>
          </div>
        </div>
      </section>

      <!-- CAMPAIGNS / FUNDS -->
      <section id="campaigns" class="donate-campaigns">
        <div class="mx-auto max-w-[1250px] px-5 py-14 sm:px-8 lg:py-20">
          <div class="donate-campaign-heading">
            <div>
              <p class="donate-kicker donate-kicker-light">
                <i class="fas fa-bullseye mr-2"></i>DONATION FUNDS
              </p>
              <h2>Give where the need is greatest.</h2>
            </div>
            <p>
              Every gift supports practical care and stronger communities. Choose a fund that speaks
              to you and help QFCC respond where it matters most.
            </p>
          </div>

          <div class="donate-campaign-grid">
            <a v-for="(campaign, index) in campaigns" :key="index" :href="campaign.link"
              class="donate-campaign-card group">
              <div class="relative overflow-hidden rounded-2xl mb-4">
                <img :src="campaign.image" :alt="campaign.title"
                  class="w-full aspect-video object-cover rounded-2xl transition duration-500 group-hover:scale-105" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute top-3 right-3 w-10 h-10 rounded-full bg-[#d9a52b] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                  <i class="fas fa-heart text-white"></i>
                </div>
              </div>
              <h3>{{ campaign.title }}</h3>
              <p>{{ campaign.description }}</p>
              <span class="donate-campaign-link">
                DONATE <b>→</b>
              </span>
            </a>
          </div>
        </div>
      </section>


      <!-- QUOTE / TRUST -->
      <section class="donate-trust mx-auto max-w-[950px] px-5 py-14 text-center sm:px-8 lg:py-20">
        <span class="donate-quote-mark">"</span>
        <p>Your support makes it possible to meet people with dignity, compassion, and practical help.</p>
        <span class="donate-quote-source">
          <i class="fas fa-quote-right mr-2"></i>QFCC COMMUNITY PRINCIPLE
        </span>
      </section>

      <!-- CTA SECTION -->
      <section id="contact" class="bg-gradient-to-br from-[#00583f] to-[#002d21] px-5 py-14 sm:px-8 lg:py-16">
        <div class="mx-auto max-w-[900px] text-center">
          <div class="w-20 h-20 rounded-full bg-[#d9a52b]/20 flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-heart text-[#d9a52b] text-3xl"></i>
          </div>
          <h2 class="text-3xl font-bold text-white mb-4 font-serif">
            Ready to make a <span class="text-[#d9a52b]">lasting impact?</span>
          </h2>
          <p class="text-white/80 max-w-xl mx-auto mb-8">
            Your gift today helps build a stronger, more compassionate community for generations to come.
          </p>
          <div class="flex flex-wrap justify-center gap-4">
            <a href="#campaigns" class="btn btn-gold text-base px-8 py-3">
              <i class="fas fa-donate mr-2"></i>DONATE NOW
            </a>
            <a href="#" class="btn btn-outline-light text-base px-8 py-3">
              <i class="fas fa-phone mr-2"></i>CONTACT US
            </a>
          </div>
        </div>
      </section>
    </main>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'

// Campaign data — replace with props from controller if needed
const campaigns = [
  {
    title: 'Community Support',
    description: "Keep QFCC's essential services and community programs moving forward.",
    image: '/storage/images/story-mosque.jpg',
    link: '#'
  },
  {
    title: 'Family Relief',
    description: 'Provide compassionate guidance, resources, and stability for families in need.',
    image: '/storage/images/support.png',
    link: '#'
  },
  {
    title: 'Youth Opportunity',
    description: 'Help young people grow through mentorship, leadership, and learning.',
    image: '/storage/images/event-youth.jpg',
    link: '#'
  },
  {
    title: 'Food & Humanitarian Relief',
    description: 'Meet urgent needs with food assistance, outreach, and dependable care.',
    image: '/storage/images/event-health.jpg',
    link: '#'
  },
  {
    title: 'Volunteer Action',
    description: 'Help more volunteers serve neighbors with time, care, and practical support.',
    image: '/storage/images/volunteer.png',
    link: '#'
  },
  {
    title: 'Family Wellbeing',
    description: 'Help families move forward safely, healthfully, and with dignity.',
    image: '/storage/images/why-family.jpg',
    link: '#'
  },
  {
    title: 'Member Support',
    description: 'Build a lasting foundation of services for QFCC community members.',
    image: '/storage/images/member.png',
    link: '#'
  },
  {
    title: 'General Fund',
    description: 'Help QFCC respond quickly wherever the need is greatest.',
    image: '/storage/images/calligraphy.jpg',
    link: '#'
  }
]
</script>

<style scoped>
/* ===== DONATE HERO ===== */
.donate-hero {
  position: relative;
  overflow: hidden;
  min-height: 400px;
}

/* 
  Background image as <img> — the browser resolves /storage/... natively.
  This bypasses all Vite CSS url() resolution issues.
*/
.donate-hero-bg-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  z-index: 0;
  filter: blur(4px) brightness(0.5);
  transform: scale(1.05);
  /* Prevent any drag/selection */
  user-select: none;
  pointer-events: none;
}

/* Overlay gradient on top of the blurred image */
.donate-hero-overlay {
  position: absolute;
  inset: 0;
  z-index: 1;
  background: linear-gradient(135deg, rgba(0, 88, 63, 0.8), rgba(0, 76, 55, 0.9));
  pointer-events: none;
  opacity: 0.7;
}

/* Gold bottom border */
.donate-hero-border {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #d9a52b, #00583f, #d9a52b);
  opacity: 0.7;
  z-index: 2;
  pointer-events: none;
}

/* Ensure content sits above all background layers */
.donate-hero > .relative {
  position: relative;
  z-index: 3;
}

.donate-kicker {
  font-size: 0.8rem;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #d9a52b;
  font-weight: 700;
  margin-bottom: 0.5rem;
}

.donate-kicker-light {
  color: #d9a52b;
}

.donate-hero h1 {
  font-size: 2.8rem;
  font-weight: 800;
  line-height: 1.1;
  max-width: 800px;
  margin: 0.5rem auto 1rem;
  color: #ffffff;
  text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
}

.donate-hero h1 span {
  background: linear-gradient(145deg, #ffffff, #d9a52b);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.donate-lead {
  font-size: 1.2rem;
  max-width: 720px;
  margin: 0 auto;
  color: rgba(255, 255, 255, 0.95);
  font-weight: 400;
  line-height: 1.6;
  text-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
}

/* ===== BUTTONS ===== */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  padding: 0.6rem 1.8rem;
  border-radius: 9999px;
  transition: all 0.3s ease;
  text-decoration: none;
  border: 2px solid transparent;
  cursor: pointer;
}

.btn-gold {
  background-color: #d9a52b;
  color: #1e1e1e;
}

.btn-gold:hover {
  background-color: #c2941f;
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(217, 165, 43, 0.3);
}

.btn-outline-light {
  background-color: transparent;
  color: white;
  border-color: rgba(255, 255, 255, 0.4);
}

.btn-outline-light:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border-color: rgba(255, 255, 255, 0.7);
  transform: translateY(-2px);
}

.btn i {
  transition: transform 0.3s ease;
}

.btn:hover i {
  transform: scale(1.1);
}

/* ===== CAMPAIGNS ===== */
.donate-campaigns {
  background: white;
}

.donate-campaign-heading {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-end;
  gap: 1.5rem;
  margin-bottom: 2.5rem;
}

.donate-campaign-heading h2 {
  font-size: 2rem;
  font-weight: 700;
  color: #0b1e1a;
  margin-top: 0.25rem;
}

.donate-campaign-heading p {
  max-width: 480px;
  color: #2a453c;
  font-size: 1rem;
  line-height: 1.6;
}

.donate-campaign-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 1.8rem;
}

.donate-campaign-card {
  background: #fbfaf4;
  border-radius: 1.5rem;
  padding: 1.2rem 1.2rem 1.5rem;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
  border: 1px solid #f0efe9;
  display: flex;
  flex-direction: column;
  text-decoration: none;
  color: #0b1e1a;
  position: relative;
  overflow: hidden;
}

.donate-campaign-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, #d9a52b, #00583f);
  transform: scaleX(0);
  transition: transform 0.3s ease;
}

.donate-campaign-card:hover::before {
  transform: scaleX(1);
}

.donate-campaign-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 30px -12px rgba(0, 88, 63, 0.15);
  border-color: rgba(0, 88, 63, 0.2);
}

.donate-campaign-card h3 {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.3rem;
  color: #0b1e1a;
}

.donate-campaign-card p {
  font-size: 0.9rem;
  color: #2a453c;
  flex: 1;
  margin-bottom: 1rem;
  line-height: 1.5;
}

.donate-campaign-link {
  font-weight: 600;
  color: #00583f;
  display: inline-flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  letter-spacing: 0.05em;
}

.donate-campaign-link b {
  font-weight: 800;
  transition: transform 0.2s ease;
}

.donate-campaign-card:hover .donate-campaign-link {
  gap: 0.6rem;
  color: #d9a52b;
}

.donate-campaign-card:hover .donate-campaign-link b {
  transform: translateX(3px);
}

/* ===== TRUST QUOTE ===== */
.donate-trust {
  background: #fbfaf4;
  border-top: 1px solid #deded7;
  border-bottom: 1px solid #deded7;
}

.donate-quote-mark {
  font-size: 4rem;
  font-family: Georgia, serif;
  color: #00583f;
  opacity: 0.3;
  display: block;
  line-height: 1;
}

.donate-trust p {
  font-size: 1.6rem;
  font-weight: 500;
  font-family: Georgia, serif;
  color: #0b1e1a;
  max-width: 700px;
  margin: 0 auto 0.5rem;
  line-height: 1.5;
}

.donate-quote-source {
  font-size: 0.8rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  color: #00583f;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 640px) {
  .donate-hero h1 {
    font-size: 2.2rem;
  }

  .donate-lead {
    font-size: 1rem;
  }

  .donate-campaign-heading {
    flex-direction: column;
    align-items: flex-start;
  }

  .donate-campaign-heading p {
    max-width: 100%;
  }

  .donate-trust p {
    font-size: 1.3rem;
  }

  .donate-campaign-grid {
    grid-template-columns: 1fr;
  }
}

/* ===== SMOOTH SCROLLING ===== */
html {
  scroll-behavior: smooth;
}

/* ===== FOCUS STATES ===== */
*:focus-visible {
  outline: 2px solid #d9a52b;
  outline-offset: 2px;
}
</style>