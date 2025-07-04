<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
  <Head title="Bienvenido a DeskLan CRM">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
    <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
      <nav class="flex items-center justify-end gap-4">
        <Link
          v-if="$page.props.auth?.user"
          :href="route('dashboard')"
          class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
          Ir al Panel
        </Link>
        <template v-else>
          <Link
            :href="route('login')"
            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
          >
            Iniciar sesión
          </Link>
          <Link
            :href="route('register')"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
          >
            Registrarse
          </Link>
        </template>
      </nav>
    </header>

    <div class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
      <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
        <!-- Izquierda: texto -->
        <div class="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
          <h1 class="mb-2 text-2xl font-bold text-[#f53003] dark:text-[#FF4433]">Bienvenido a DeskLan CRM</h1>
          <p class="mb-4 text-[#706f6c] dark:text-[#A1A09A]">
            DeskLan es una plataforma inteligente de soporte técnico. Optimiza la administración de tu infraestructura TI:
            desde la gestión de usuarios hasta el control detallado de IPs y dispositivos.
          </p>
          <ul class="mb-4 flex flex-col gap-2 text-[#1b1b18] dark:text-[#EDEDEC]">
            <li>✔️ Inventario de equipos de cómputo y periféricos</li>
            <li>✔️ Asignación y control de direcciones IP</li>
            <li>✔️ Gestión de VLANs y redes internas</li>
            <li>✔️ Helpdesk con control de tickets y prioridades</li>
            <li>✔️ Panel de administración intuitivo y seguro</li>
          </ul>
          <div class="mt-6 flex gap-4">
            <Link
              :href="route('register')"
              class="rounded bg-[#f53003] px-6 py-2 text-white font-semibold hover:bg-[#d42a00] transition"
            >
              Comenzar ahora
            </Link>
            <a
              href="mailto:soporte@desklan.com"
              class="rounded border border-[#f53003] px-6 py-2 text-[#f53003] font-semibold hover:bg-[#f53003] hover:text-white transition"
            >
              Contactar soporte
            </a>
          </div>
        </div>

        <!-- Derecha: imagen/logo -->
        <div class="relative flex items-center justify-center -mb-px aspect-335/376 w-full shrink-0 overflow-hidden rounded-t-lg bg-[#fff2f2] lg:mb-0 lg:-ml-px lg:aspect-auto lg:w-[438px] lg:rounded-t-none lg:rounded-r-lg dark:bg-[#1D0002]">
          <img src="/storage/imgs/logo-desklann.png" alt="Logo DeskLan" class="w-2/3 lg:w-3/4 object-contain" />
        </div>
      </main>
    </div>

    <footer class="mt-8 text-xs text-[#706f6c] dark:text-[#A1A09A]">
      &copy; {{ new Date().getFullYear() }} DeskLan CRM. Todos los derechos reservados.
    </footer>
  </div>
</template>
