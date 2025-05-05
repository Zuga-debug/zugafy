<template>
  <div class="p-8">
    <h1 class="text-3xl font-bold mb-6">⭐ My Watchlist</h1>

    <div v-if="watchlist.length === 0" class="text-gray-600">
      Your Watchlist is empty. 😢
    </div>

    <div class="movies-grid" v-else>
      <div v-for="movie in watchlist" :key="movie.id" class="movie-card">
        <img :src="getImageUrl(movie.poster_path)" alt="Movie Poster" />
        <h2>{{ movie.title }}</h2>
        <button @click="removeFromWatchlist(movie.id)">🗑 Remove</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const watchlist = ref([]);

const getImageUrl = (path) => {
  return `https://image.tmdb.org/t/p/w500${path}`;
};

const loadWatchlist = () => {
  const saved = JSON.parse(localStorage.getItem('watchlist')) || [];
  watchlist.value = saved;
};

const removeFromWatchlist = (id) => {
  watchlist.value = watchlist.value.filter(m => m.id !== id);
  localStorage.setItem('watchlist', JSON.stringify(watchlist.value));
};

onMounted(() => {
  loadWatchlist();
});
</script>

<style scoped>
.movies-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.movie-card {
  background: white;
  border: 1px solid #ddd;
  padding: 12px;
  border-radius: 8px;
  text-align: center;
}

.movie-card img {
  width: 100%;
  border-radius: 6px;
}

.movie-card h2 {
  font-size: 16px;
  margin-top: 10px;
}

button {
  margin-top: 10px;
  background: #e3342f;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s;
}
button:hover {
  background: #cc1f1a;
}
</style>
