<template>
  <Toast position="top-right" />
  <div class="main">
    <Menubar :model="items">
      <template #start>
        <a href="/" class="pr-3">
          <img
            alt="edda"
            src="https://dealflow.edda.co/img/edda_letters.png"
            class="logo"
            to="/"
          />
        </a>
      </template>
    </Menubar>
    <RouterView />
  </div>
  <ConfirmDialog class="confirm-dialog"></ConfirmDialog>
</template>

<script setup>
import { ref } from "vue";
import { RouterView } from "vue-router";

const items = ref([
  {
    label: "Forms",
    items: [
      {
        label: "Form control center",
        to: "/forms",
        icon: "pi pi-fw pi-list",
      },
      {
        label: "Create new form",
        to: "/create-form",
        icon: "pi pi-fw pi-plus",
      },
    ],
  },
]);
</script>

<style>
.main {
  height: 100vh;
  width: 100%;
}
.logo {
  width: auto;
  max-height: 36px;
}
</style>
