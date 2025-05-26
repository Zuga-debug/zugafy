<template>
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Discover Movies</h2>
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-primary" :class="{ active: currentTab === 'trending' }" @click="currentTab = 'trending'">Trending</button>
        <button type="button" class="btn btn-outline-primary" :class="{ active: currentTab === 'topRated' }" @click="currentTab = 'topRated'">Top Rated</button>
      </div>
    </div>

  <div class="col-md-3 mb-4" v-for="movie in movies" :key="movie.id">
  <div class="card h-100">
    <img :src="'https://image.tmdb.org/t/p/w500' + movie.poster_path" class="card-img-top" :alt="movie.title" />
    <div class="card-body">
      <h5 class="card-title">{{ movie.title }}</h5>
      <button class="btn btn-sm btn-outline-primary w-100 mt-2" @click="openTrailer(movie.id)">Play Trailer</button>
    </div>
  </div>
</div>


    <!-- Trailer Modal Stub -->
    <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="trailerModalLabel">Trailer</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <iframe
              v-if="trailerKey"
              width="100%"
              height="400"
              :src="`https://www.youtube.com/embed/${trailerKey}`"
              frameborder="0"
              allowfullscreen
            ></iframe>
            <p v-else>No trailer available.</p>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>import { ref, onMounted, watch } from 'vue';

const currentTab = ref('trending');
const movies = ref([]);
const selectedMovie = ref(null);
const trailerKey = ref('');

const fetchMovies = async () => {
  const endpoint =
    currentTab.value === 'trending'
      ? 'https://api.themoviedb.org/3/trending/movie/week'
      : 'https://api.themoviedb.org/3/movie/top_rated';

  try {
    const res = await fetch(`${endpoint}?api_key=${import.meta.env.VITE_TMDB_API_KEY}`);
    const data = await res.json();
    movies.value = data.results.slice(0, 8); // Limit to 8
  } catch (err) {
    console.error('Error fetching movies:', err);
  }
};

const openTrailer = async (movieId) => {
  selectedMovie.value = movieId;
  trailerKey.value = '';

  try {
    const res = await fetch(`https://api.themoviedb.org/3/movie/${movieId}/videos?api_key=${import.meta.env.VITE_TMDB_API_KEY}`);
    const data = await res.json();
    const trailer = data.results.find(video => video.type === 'Trailer' && video.site === 'YouTube');
    trailerKey.value = trailer ? trailer.key : null;
  } catch (err) {
    console.error('Error fetching trailer:', err);
  }

  const modal = new bootstrap.Modal(document.getElementById('trailerModal'));
  modal.show();
};

watch(currentTab, fetchMovies);
onMounted(fetchMovies);

</script>
