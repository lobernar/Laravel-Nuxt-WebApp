<script setup lang="ts">
const { logout } = useSanctumAuth();
const client = useSanctumClient();
const config = useRuntimeConfig();

// This middleware checks if the user is authenticated. If not, it will redirect 
// a user to the page specified in the redirect.onAuthOnly option (default is /login).
definePageMeta({
  middleware: ['sanctum:auth']
})

interface MyUser {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    role?: string;
    created_at?: string;
}
const user = useSanctumUser<MyUser>();

const formatDate = (dateStr?: string) => {
  if (!dateStr) return ""
  return new Date(dateStr).toLocaleDateString("en-US", {
    year: "numeric",
    month: "long",
    day: "numeric",
  })
}

async function deleteProfile() { 
  try {
    await client(`${config.public.apiBase}/api/user/delete`, {
      method: "DELETE",
    });

    await logout();

  } catch (error) {
    console.error("Delete profile error:", error);
  }
}

</script>
<template>
  <div class="max-w-4xl mx-auto mt-10">
    <div class="card bg-base-100 shadow-xl border border-base-300">
      <div class="card-body">
        <div class="flex items-center justify-between">
          <h2 class="card-title text-2xl font-bold text-primary">
            👤 My Information
          </h2>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Profile Section -->
          <div class="card bg-base-200 shadow-md">
            <div class="card-body items-center text-center">
              <div class="avatar">
                <div class="w-24 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                  <img
                    :src="user?.avatar || 'https://ui-avatars.com/api/?name=' + user?.name"
                    alt="User Avatar"
                  />
                </div>
              </div>
              <h3 class="mt-3 text-xl font-semibold">{{ user?.name }}</h3>
              <p class="text-sm text-gray-400">{{ user?.email }}</p>
              <div class="badge badge-secondary mt-2">{{ user?.role || 'User' }}</div>
            </div>
          </div>

          <!-- Details Section -->
          <div class="card bg-base-200 shadow-md">
            <div class="card-body">
              <h3 class="card-title mb-3">Account Details</h3>
              <ul class="space-y-2">
                <li class="flex justify-between">
                  <span class="font-medium">Name:</span>
                  <span>{{ user?.name }}</span>
                </li>
                <li class="flex justify-between">
                  <span class="font-medium">Email:</span>
                  <span>{{ user?.email }}</span>
                </li>
                <li class="flex justify-between">
                  <span class="font-medium">Role:</span>
                  <span class="badge badge-outline badge-primary">{{ user?.role || 'User' }}</span>
                </li>
                <li class="flex justify-between">
                  <span class="font-medium">Joined:</span>
                  <span>{{ formatDate(user?.created_at) || '—' }}
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-8">
            <NuxtLink to="/dashboard" class="link link-hover text-primary">
                ← Back
            </NuxtLink>

            <!-- Right Buttons -->
            <div class="card-actions justify-end">
                <button class="btn btn-outline btn-error" @click="deleteProfile">
                Delete Profile
                </button>
                <NuxtLink to="edit" class="btn btn-outline">Edit Information</NuxtLink>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>