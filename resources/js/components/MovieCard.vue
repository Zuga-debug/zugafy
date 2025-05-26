<template>
  <div class="card h-100">
    <img :src="poster" class="card-img-top" alt="Movie Poster" />
    <div class="card-body">
      <h5 class="card-title">{{ title }}</h5>
      <router-link :to="`/movie/${id}`" class="btn btn-outline-primary btn-sm">View</router-link>
    </div>
  </div>
</template>

<script setup>
defineProps(['id', 'title', 'poster'])
</script>
