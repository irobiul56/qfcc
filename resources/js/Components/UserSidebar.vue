<!-- UserSidebar.vue -->
<script setup>
import { defineProps } from 'vue';
import NavLink from '@/Components/NavLink.vue';

const props = defineProps({
  isCollapsed: Boolean
});

// Route helper function for active state
const isRouteActive = (patterns) => {
  const currentRoute = route().current();
  if (!currentRoute) return false;

  return patterns.some(pattern => {
    if (pattern.endsWith('*')) {
      const basePattern = pattern.replace('*', '');
      return currentRoute.startsWith(basePattern);
    }
    return currentRoute === pattern;
  });
};
</script>

<template>
  <aside class="min-h-screen bg-white shadow-lg p-4 transition-all duration-300 border-r border-gray-100 flex flex-col"
    :class="isCollapsed ? 'w-20' : 'w-64'">
    <nav>
      <ul class="space-y-2">
        <!-- Dashboard -->
        <li>
          <NavLink :href="route('dashboard')" :active="isRouteActive(['dashboard', 'dashboard.*'])"
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa fa-dashboard mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Dashboard</span>
            </div>
          </NavLink>
        </li>

        <!-- Programs -->
        <li>
          <NavLink
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-graduation-cap mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Programs</span>
            </div>
          </NavLink>
        </li>

        <!-- Events -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-calendar-days mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Events</span>
            </div>
          </NavLink>
        </li>

        <!-- Event Registrations -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-clipboard-list mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Registrations</span>
            </div>
          </NavLink>
        </li>

        <!-- Donations -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-hand-holding-dollar mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Donations</span>
            </div>
          </NavLink>
        </li>

        <!-- Donation Campaigns -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-bullhorn mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Campaigns</span>
            </div>
          </NavLink>
        </li>

        <!-- Volunteers -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-hands-helping mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Volunteers</span>
            </div>
          </NavLink>
        </li>

        <!-- Members -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-users mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Members</span>
            </div>
          </NavLink>
        </li>

        <!-- Newsletters -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-envelope mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Newsletter</span>
            </div>
          </NavLink>
        </li>

        <!-- Contact Messages -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-address-book mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Contact Messages</span>
            </div>
          </NavLink>
        </li>

        <!-- Gallery -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-regular fa-image mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Gallery</span>
            </div>
          </NavLink>
        </li>

        <!-- Testimonials -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-quote-left mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Testimonials</span>
            </div>
          </NavLink>
        </li>


        <!-- Divider -->
        <li class="pt-3 mt-3 border-t border-gray-200">
          <span v-if="!isCollapsed" class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Settings</span>
        </li>

        <!-- Hero Slides -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-images mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Hero Slides</span>
            </div>
          </NavLink>
        </li>

        <!-- Vision & Mission -->
        <li>
          <NavLink
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-bullseye mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Vision & Mission</span>
            </div>
          </NavLink>
        </li>

        <!-- CTA Cards -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-square-plus mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">CTA Cards</span>
            </div>
          </NavLink>
        </li>

        <!-- Site Settings -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-gear mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Site Settings</span>
            </div>
          </NavLink>
        </li>

        <!-- Social Links -->
        <li>
          <NavLink 
            class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors"
            :class="isCollapsed ? 'justify-center px-2' : 'px-3'">
            <div class="flex items-center">
              <i class="fa-solid fa-share-nodes mr-2" style="font-size:20px"></i>
              <span v-if="!isCollapsed" class="whitespace-nowrap">Social Links</span>
            </div>
          </NavLink>
        </li>
      </ul>
    </nav>
  </aside>
</template>