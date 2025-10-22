<script setup lang="ts">
import { onMounted, ref } from 'vue';

const client = useSanctumClient();

useHead({
  title: 'Admin Dashboard'
})

// This middleware checks if the user is authenticated and has the 'admin' role.
definePageMeta({
  middleware: ['sanctum:auth', 'admin']
})

interface MyUser {
    id: number;
    name: string;
    email: string;
    role: string;
}
const users = ref<MyUser[]>([]);
const loading = ref(false);
const fetchError = ref<null | string>(null);

async function updateRole(userToUpdate: MyUser){
  try {
    await client('api/admin/user/promote', {
      method: 'PUT',
      body: {
        user_id: userToUpdate.id,
        role: userToUpdate.role
      }
    })
    refreshNuxtData();
  } catch (error){
    console.error("Error promoting user:", error);
  }
}

onMounted(async () => {
  loading.value = true;
  fetchError.value = null;
  try {
    console.log("Fetching users for admin...");
    // Backend returns a plain JSON array: User::all()
    const res = await client('/api/admin/users', { method: 'GET' });

    let fetchedUsers: MyUser[] = []

    if (Array.isArray(res)) {
      fetchedUsers = res as MyUser[];
    } else {
      // If the client wraps the body, try to read `.data`, otherwise set empty
      console.warn('Unexpected response shape from /api/admin/users, expected array', res);
      fetchedUsers = (res && (res as any).data && Array.isArray((res as any).data)) ? (res as any).data : [];
    }
    // Sort ascending by ID
    users.value = fetchedUsers.sort((a, b) => a.id - b.id)

  } catch (err: any) {
    console.error("Error fetching users:", err);
    fetchError.value = err?.message || String(err);
  } finally {
    loading.value = false;
  }
});

</script>

<template>
  <div class="p-6">
    <div class="flex items-center justify-between mt-8">
      <NuxtLink to="/dashboard" class="link link-hover text-primary">
          ← Back
      </NuxtLink>
    </div>
    <h1 class="text-3xl font-bold text-center mt-10">Admin Dashboard</h1>

    <ul v-if="users" class="max-w-4xl mx-auto mt-6 space-y-4">
      <li
        v-for="user in users"
        :key="user.id"
        class="card bg-base-100 shadow-md border border-base-300"
      >
        <div class="card-body">
          <h2 class="card-title">User ID: {{ user.id }}</h2>
          <p><strong>Name:</strong> {{ user.name }}</p>
          <p><strong>Email:</strong> {{ user.email }}</p>

          <!-- Role display and editor -->
          <div class="flex items-center gap-3">
            <p><strong>Role:</strong></p>

            <select
              v-model="user.role"
              class="select select-bordered select-sm"
            >
              <option value="user">User</option>
              <option value="manager">Manager</option>
              <option value="admin">Admin</option>
            </select>

            <button
              class="btn btn-primary btn-sm"
              @click="updateRole(user)">
              Apply
            </button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>