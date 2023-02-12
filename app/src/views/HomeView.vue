<template>
  <div class="home flex justify-content-center align-items-center mt-2">
    <Card class="home-card">
      <template #title> Hi there :) </template>
      <template #content>
        <div>
          I'm Dalibor and this is the
          <router-link :to="{ name: 'forms' }">result</router-link> of my coding
          challenge
        </div>
      </template>
    </Card>
  </div>
</template>

<script setup></script>

<style scoped>
.home-card {
  width: 400px;
}
</style>
