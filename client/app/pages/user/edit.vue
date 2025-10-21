<script setup lang="ts">

const { refreshIdentity} = useSanctumAuth();
const client = useSanctumClient();
const config = useRuntimeConfig();

// This middleware checks if the user is authenticated. If not, it will redirect 
// a user to the page specified in the redirect.onAuthOnly option (default is /login).
definePageMeta({
  middleware: ['sanctum:auth']
})

interface MyUser {
  id: number
  name: string
  email: string
  avatar?: string
  role?: string
  created_at?: string
  last_login?: string
}

const user = useSanctumUser<MyUser>();

const form = reactive({
  name: "",
  email: "",
  role: "User",
  password: "",
})

watchEffect(() => {
  if (user.value) {
    form.name = user.value.name ?? ""
    form.email = user.value.email ?? ""
    form.role = user.value.role ?? "User"
  }
})

async function updateUser() {
  try {
    await client(`${config.public.apiBase}/api/user/update`, {
      method: "PUT",
      body: {
        name: form.name,
        email: form.email,
        ...(form.password ? { password: form.password } : {}),
      },
    });

    // Refresh user identity after update 
    await refreshIdentity();
    
    navigateTo('info');

  } catch (error) {
    console.error("Update error:", error);
  }
}

</script>

<template>
  <div class="max-w-3xl mx-auto mt-10 card bg-base-100 shadow-xl border border-base-300 relative">
    <div class="card-body">
      <!-- Header -->
      <h2 class="card-title text-2xl font-bold text-primary mb-2">
        ✏️ Edit Profile
      </h2>
      <p class="text-sm text-gray-400 mb-6">
        Update your personal information below.
      </p>
      <!-- Form -->
      <form @submit.prevent="updateUser" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <!-- Name -->
          <div class="form-control">
            <label class="label"><span class="label-text font-medium">Username</span></label>
            <input
              v-model="form.name"
              type="text"
              placeholder="Username"
              class="input input-bordered w-full"
              required
            />
          </div>

          <!-- Email -->
          <div class="form-control">
            <label class="label"><span class="label-text font-medium">Email Address</span></label>
            <input
              v-model="form.email"
              type="email"
              placeholder="you@example.com"
              class="input input-bordered w-full"
              required
            />
          </div>

          <!-- Role -->
          <div class="form-control">
            <label class="label"><span class="label-text font-medium">Role</span></label>
            <select v-model="form.role" class="select select-bordered w-full">
              <option>User</option>
              <option>Admin</option>
              <option>Manager</option>
            </select>
          </div>

          <!-- Password -->
          <div class="form-control">
            <label class="label"><span class="label-text font-medium">Password</span></label>
            <input
              v-model="form.password"
              type="password"
              placeholder="Leave blank to keep current password"
              class="input input-bordered w-full"
            />
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-8">
          <NuxtLink to="info" class="link link-hover text-primary">← Back</NuxtLink>
          <button type="submit" class="btn btn-primary">💾 Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</template>