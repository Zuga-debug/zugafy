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

    <TrailerModal
      v-if="showModal"
      :movie-id="selectedMovieId"
      @close="showModal = false"
    />  </div>
</template> -->

<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else class="movies-grid">
      <div v-for="movie in movies" :key="movie.id">
        <img :src="getImageUrl(movie.poster_path)" />
        <button @click="openModal(movie.id)">Play Trailer</button>
      </div>
    </div>

    <TrailerModal
      v-if="showModal"
      :movie-id="selectedMovieId"
      @close="showModal = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import TrailerModal from '../components/TrailerModal.vue';

const movies = ref([]);
const loading = ref(true);
const showModal = ref(false);
const selectedMovieId = ref(null);

const getImageUrl = (path) => `https://image.tmdb.org/t/p/w500${path}`;

const openModal = (id) => {
  selectedMovieId.value = id;
  showModal.value = true;
};

const fetchTrendingMovies = async () => {
  try {
    const res = await fetch(`https://api.themoviedb.org/3/trending/movie/week?api_key=${import.meta.env.VITE_TMDB_API_KEY}`);
    const data = await res.json();
    movies.value = data.results;
  } catch (error) {
    console.error('Error fetching movies', error);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchTrendingMovies);
</script>


<!-- <script setup>
import { ref } from 'vue';
import TrailerModal from './TrailerModal.vue';

const showModal = ref(false);
const selectedMovieId = ref(null);

function openTrailer(id) {
  selectedMovieId.value = id;
  showModal.value = true;
}
</script> -->

<!-- <template>
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
-->
