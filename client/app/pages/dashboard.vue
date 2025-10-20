<script lang="ts" setup>

// Use Nuxt's runtime config to read API base URL
const config = useRuntimeConfig();
const { logout } = useSanctumAuth();

async function handleLogout(){
    await logout();
}

</script>

<template>
  <div class="flex min-h-screen bg-base-200">
    <!-- Sidebar -->
    <aside class="w-64 bg-base-100 shadow-lg">
      <div class="p-4 border-b border-base-300">
        <h2 class="text-xl font-bold">Smart Factory</h2>
      </div>
      <nav class="mt-4 space-y-2">
        <NuxtLink to="/dashboard" class="btn btn-ghost w-full justify-start">
          Dashboard
        </NuxtLink>
        <NuxtLink to="/machines" class="btn btn-ghost w-full justify-start">
          Machines
        </NuxtLink>
        <NuxtLink to="/reports" class="btn btn-ghost w-full justify-start">
          Reports
        </NuxtLink>
        <NuxtLink to="/settings" class="btn btn-ghost w-full justify-start">
          Settings
        </NuxtLink>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Navbar -->
      <div class="navbar bg-base-100 shadow-sm px-6">
        <div class="flex-1">
          <h1 class="text-xl font-semibold">Welcome</h1>
        </div>
        <div class="flex-none">
          <button class="btn btn-error btn-sm" @click="handleLogout">Logout</button>
        </div>
      </div>

      <!-- Dashboard Content -->
      <main class="p-6 flex-1 overflow-y-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-4">
          <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
              <h2 class="card-title">Active Machines</h2>
              <p class="text-3xl font-bold text-primary">12</p>
            </div>
          </div>

          <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
              <h2 class="card-title">Alerts</h2>
              <p class="text-3xl font-bold text-error">3</p>
            </div>
          </div>

          <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
              <h2 class="card-title">Productivity</h2>
              <p class="text-3xl font-bold text-success">92%</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
