<script setup lang="ts">
import { onMounted, ref } from 'vue';

const client = useSanctumClient();

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

onMounted(async () => {
  loading.value = true;
  fetchError.value = null;
  try {
    console.log("Fetching users for admin...");
    // Backend returns a plain JSON array: User::all()
    const res = await client('/api/admin/users', { method: 'GET' });

    if (Array.isArray(res)) {
      users.value = res as MyUser[];
    } else {
      // If the client wraps the body, try to read `.data`, otherwise set empty
      console.warn('Unexpected response shape from /api/admin/users, expected array', res);
      users.value = (res && (res as any).data && Array.isArray((res as any).data)) ? (res as any).data : [];
    }

    console.log("Fetched users:", users.value.length);
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
          <p>
            <strong>Role:</strong>
            <span
              class="badge ml-1"
              :class="{
                'badge-primary': user.role === 'admin',
                'badge-warning': user.role === 'manager',
                'badge-neutral': user.role === 'user',
              }"
            >
              {{ user.role }}
            </span>
          </p>
        </div>
      </li>
    </ul>
  </div>
</template>

