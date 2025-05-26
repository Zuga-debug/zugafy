<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Zugafy</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <router-link class="nav-link" to="/">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/watchlist">Watchlist</router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
      <router-view />
    </main>

    <footer class="bg-light text-center text-muted py-3 mt-auto">
      <small>&copy; 2025 Zugafy. All rights reserved.</small>
    </footer>
  </div>
</template>

<script setup>
// No script needed for layout
</script>

<style scoped>
main {
  min-height: calc(100vh - 120px);
}
</style>
