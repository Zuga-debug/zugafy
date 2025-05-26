<template>
  <div class="container mt-4">
    <div v-if="movie">
      <h2>{{ movie.title }}</h2>
      <img :src="getImageUrl(movie.poster_path)" class="img-fluid mb-3" />
      <p>{{ movie.overview }}</p>
      <button class="btn btn-primary" @click="playTrailer">▶ Play Trailer</button>
      <button class="btn btn-outline-success" @click="addToWatchlist">➕ Watchlist</button>
    </div>
    <TrailerModal :show="showTrailer" :trailerUrl="trailerUrl" @close="showTrailer = false" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import TrailerModal from '../components/TrailerModal.vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const route = useRoute();
const movie = ref(null);
const showTrailer = ref(false);
const trailerUrl = ref('');

const getImageUrl = (path) => `https://image.tmdb.org/t/p/w500${path}`;

const fetchMovie = async () => {
  const { data } = await axios.get(`/api/tmdb/movie/${route.params.id}`);
  movie.value = data;
  // Get trailer link
  trailerUrl.value = 'https://www.youtube.com/embed/' + data.trailer_key;
};

const playTrailer = () => {
  showTrailer.value = true;
};

const addToWatchlist = async () => {
  await axios.post('/api/watchlist', {
    movie_id: movie.value.id,
    title: movie.value.title,
    poster_path: movie.value.poster_path,
  });
};

onMounted(fetchMovie);
</script>
