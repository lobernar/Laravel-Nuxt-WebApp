<script lang="ts" setup>
useHead({
  title: 'Welcome'
})
</script>

<template>
  <div class="flex flex-col items-center justify-center min-h-screen bg-base-200">
    <h1 class="text-5xl font-bold mb-6 text-primary">Welcome to my Laravel + Nuxt Web App</h1>
    <p class="text-lg text-base-content mb-6">Please log in to continue</p>

    <NuxtLink to="/login" class="btn btn-primary btn-lg">
      Go to Login
    </NuxtLink>
  </div>
</template>

<style scoped>
</style>
