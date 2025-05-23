<template>
   
    <nav class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">Clinic App</a>
                </div>
            </div>
            <div class="flex items-center">
                <div id="notification-bell"></div>
                <div class="ml-4 flex items-center">
                    <span class="text-gray-700">{{ currentUser.user_name }}</span>
                    <a href="{{ route('logout') }}" class="ml-4 text-gray-600 hover:text-gray-900">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
</template>
<script setup>
import axios from "axios";
import { nextTick, onMounted, ref, watch } from "vue";

const props = defineProps({
  
    currentUser: {
        type: Object,
        required: true,
    },
});
</script>