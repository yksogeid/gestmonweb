<template>
    <Head title="Usuarios" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div class="mb-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold">Gestión de Usuarios</h1>
                <button @click="openCreateModal" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Crear Usuario</button>
            </div>

            <table class="w-full rounded border">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="border p-2">Nombre</th>
                        <th class="border p-2">Correo</th>
                        <th class="border p-2">Rol</th>
                        <th class="border p-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50">
                        <td class="border p-2">{{ user.name }}</td>
                        <td class="border p-2">{{ user.email }}</td>
                        <td class="border p-2">
                            <select v-model="user.role" @change="updateRole(user)" class="rounded border p-1">
                                <option v-for="role in roles" :key="role" :value="role">
                                    {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                                </option>
                            </select>
                        </td>
                        <td class="flex gap-2 border p-2">
                            <button @click="openEditModal(user)" class="text-blue-600 hover:underline">Editar</button>
                            <button @click="deleteUser(user.id)" class="text-red-600 hover:underline">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal de Crear/Editar Usuario -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="relative w-full max-w-md rounded bg-white p-6 shadow">
                <h2 class="mb-4 text-lg font-semibold">{{ isEditMode ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <input v-model="form.name" type="text" placeholder="Nombre" class="w-full rounded border p-2" required />
                        <div v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</div>
                    </div>
                    <div>
                        <input v-model="form.email" type="email" placeholder="Correo electrónico" class="w-full rounded border p-2" required />
                        <div v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</div>
                    </div>
                    <div>
                        <select v-model="form.role" class="w-full rounded border p-2" required>
                            <option value="" disabled>Selecciona un rol</option>
                            <option v-for="role in roles" :key="role" :value="role">
                                {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                            </option>
                        </select>
                        <div v-if="form.errors.role" class="mt-1 text-sm text-red-500">{{ form.errors.role }}</div>
                    </div>
                    <div v-if="!isEditMode">
                        <input v-model="form.password" type="password" placeholder="Contraseña" class="w-full rounded border p-2" required />
                        <div v-if="form.errors.password" class="mt-1 text-sm text-red-500">{{ form.errors.password }}</div>
                    </div>
                    <div v-if="!isEditMode">
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="Confirmar contraseña"
                            class="w-full rounded border p-2"
                            required
                        />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeModal" class="text-gray-600">Cancelar</button>
                        <button type="submit" class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';
import axios from 'axios'; // Asegúrate de tener esto al inicio del script


// Recibe los usuarios desde el backend
const props = defineProps<{
    users: Array<{ id: number; name: string; email: string; role: string }>;
    roles: string[];
}>();

const users = ref(props.users);
const roles = ref(props.roles);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Usuarios', href: '/users' }];

console.log(props.users);

const showModal = ref(false);
const isEditMode = ref(false);
const editingUserId = ref<number | null>(null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: '',
});

function openCreateModal() {
    isEditMode.value = false;
    editingUserId.value = null;
    form.reset();
    showModal.value = true;
}

function openEditModal(user: any) {
    isEditMode.value = true;
    editingUserId.value = user.id;
    form.name = user.name;
    form.email = user.email;
    form.role = user.role;
    form.password = '';
    form.password_confirmation = '';
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    form.reset();
}

function submitForm() {
    if (isEditMode.value && editingUserId.value) {
        form.put(`/users/${editingUserId.value}`, {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
                router.reload(); // Recarga los datos
            },
        });
    } else {
        form.post('/users', {
            onSuccess: () => {
                showModal.value = false;
                form.reset();
                router.reload(); // Recarga los datos
            },
        });
    }
}

function deleteUser(id: number) {
    if (confirm('¿Seguro que deseas eliminar este usuario?')) {
        router.delete(`/users/${id}`, {
            onSuccess: () => {
                router.reload(); // Recarga los datos
            },
        });
    }
}

function updateRole(user: any) {
    axios.put(`/users/${user.id}/role`, {
        role: user.role,
    })
    .then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Rol actualizado',
            text: 'El rol del usuario se actualizó correctamente.',
            timer: 1500,
            showConfirmButton: false,
        });
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar el rol del usuario.',
        });
    });
}
</script>
