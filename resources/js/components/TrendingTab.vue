<!-- <template>
  <div class="movies-grid">
    <div v-for="movie in movies" :key="movie.id" class="movie-card">
      <router-link :to="`/movie/${movie.id}`">
        <img :src="getImageUrl(movie.poster_path)" alt="Movie Poster" />
      </router-link>

      <h2>{{ movie.title }}</h2>
      <button @click="addToWatchlist(movie)">➕ Watchlist</button>
      <button @click="openTrailer(movie.id)">▶ Play Trailer</button>
    </div>

    <TrailerModal :show="showModal" :movieId="selectedMovieId" @close="showModal = false" />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import TrailerModal from './TrailerModal.vue';

const showModal = ref(false);
const selectedMovieId = ref(null);

function openTrailer(id) {
  selectedMovieId.value = id;
  showModal.value = true;
}
</script> -->
<template>
  <div class="page">
    <h1>🎬 Trending Movies</h1>

    <Spinner v-if="loading" />

    <div class="movies-grid" v-else>
      <div v-for="movie in movies" :key="movie.id" class="movie-card">
        <router-link :to="`/movie/${movie.id}`">
          <img :src="getImageUrl(movie.poster_path)" alt="Movie Poster" />
        </router-link>
        <h2>{{ movie.title }}</h2>
        
        <button @click="addToWatchlist(movie)">➕ Add to Watchlist</button>
        <button @click="playTrailer(movie.id)">▶️ Play Trailer</button>
      </div>
    </div>

    <!-- Trailer Modal -->
    <TrailerModal
      v-if="showModal"
      :movie-id="selectedMovieId"
      @close="showModal = false"
    />

    <TrailerModal
      v-if="showModal"
      :movieId="selectedMovieId"
      @close="showModal = false" />

    

    
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
// import Spinner from '../components/Spinner.vue';
import TrailerModal from '../components/TrailerModal.vue'; // ✅ Make sure this path is correct

const loading = ref(true);
const movies = ref([]);
const showModal = ref(false);
const selectedMovieId = ref(null);

const fetchMovies = async () => {
  try {
    const response = await fetch(
      `https://api.themoviedb.org/3/trending/movie/week?api_key=${import.meta.env.VITE_TMDB_API_KEY}`
    );
    const data = await response.json();
    movies.value = data.results;
  } catch (error) {
    console.error('Error fetching movies:', error);
  } finally {
    loading.value = false;
  }
};

const getImageUrl = (path) => {
  return `https://image.tmdb.org/t/p/w500${path}`;
};

const addToWatchlist = (movie) => {
  let watchlist = JSON.parse(localStorage.getItem('watchlist')) || [];

  const exists = watchlist.find((m) => m.id === movie.id);
  if (!exists) {
    watchlist.push(movie);
    localStorage.setItem('watchlist', JSON.stringify(watchlist));
    alert('✅ Movie added to Watchlist!');
  } else {
    alert('⚡ Already in Watchlist');
  }
};

const playTrailer = (id) => {
  selectedMovieId.value = id;
  showModal.value = true;
};

onMounted(() => {
  fetchMovies();
});
</script>

<style scoped>
.page {
  padding: 1rem;
}
.movies-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 1rem;
}
.movie-card {
  background: #f9f9f9;
  padding: 0.5rem;
  border-radius: 8px;
  text-align: center;
}
.movie-card img {
  width: 100%;
  border-radius: 4px;
}
</style>
