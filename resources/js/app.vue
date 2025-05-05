<template>
    <div>
      <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/watchlist">Watchlist</router-link>
        <router-link to="/search">🔍 Search</router-link>
      </nav>
      <div class="page">
        <router-view />
      </div>
    </div>
  </template>
  
  <script setup>
  </script>
  