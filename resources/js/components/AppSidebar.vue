<script setup lang="ts">
import { computed } from 'vue'; // ✅ Falta importar computed
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3'; // ✅ Importa usePage si obtienes permisos desde Inertia
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

// ✅ Obtiene permisos (ajusta según cómo los pases)
const { props } = usePage();
const permissions = props.permissions as string[]; // Asegúrate de pasarlos desde tu controlador

const mainNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [];

    items.push({
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    });
    items.push({
        title: 'Carreras',
        href: '/carreras',
        icon: LayoutGrid,
    });

    if (permissions.includes('ver usuarios')) {
        items.push({
            title: 'Users',
            href: '/users',
            icon: LayoutGrid,
        });
    }

    return items;
});

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <!-- ✅ Slot dentro de un contenedor para mantener consistencia -->
    <div>
        <slot />
    </div>
</template>
