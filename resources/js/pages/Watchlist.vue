<template>
  <div class="p-8">
    <h1 class="text-3xl font-bold mb-6">⭐ My Watchlist</h1>

    <div v-if="loading" class="text-gray-600">Loading watchlist...</div>

    <div v-else-if="watchlist.length === 0" class="text-gray-600">
      Your Watchlist is empty. 😢
    </div>

    <div class="movies-grid" v-else>
      <div v-for="movie in watchlist" :key="movie.id" class="movie-card">
        <img :src="getImageUrl(movie.poster_path)" alt="Movie Poster" />
        <h2>{{ movie.title }}</h2>
        <button @click="removeFromWatchlist(movie.movie_id)">🗑 Remove</button>
        <button @click="playTrailer(movie)">▶️ Play Trailer</button>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const watchlist = ref([]);
const loading = ref(false);

const getImageUrl = (path) => {
  return path ? `https://image.tmdb.org/t/p/w500${path}` : 'https://via.placeholder.com/300x450?text=No+Image';
};

const loadWatchlist = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/watchlist');
    watchlist.value = res.data;
  } catch (err) {
    console.error('Error fetching watchlist:', err);
  } finally {
    loading.value = false;
  }
};

const playTrailer = async (movie) => {
  const apiKey = 'your_tmdb_api_key';
  const res = await axios.get(`https://api.themoviedb.org/3/movie/${movie.movie_id}/videos?api_key=${apiKey}`);
  const trailer = res.data.results.find(v => v.type === 'Trailer' && v.site === 'YouTube');
  if (trailer) {
    window.open(`https://www.youtube.com/watch?v=${trailer.key}`, '_blank');
  } else {
    alert('No trailer available');
  }
};


const removeFromWatchlist = async (movieId) => {
  try {
    await axios.delete(`/api/watchlist/${movieId}`);
    watchlist.value = watchlist.value.filter(m => m.movie_id !== movieId);
  } catch (err) {
    console.error('Failed to remove movie:', err);
  }
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
