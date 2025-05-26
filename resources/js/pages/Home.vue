<template>
  <div class="container">
    <!-- Header & Search -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <h2 class="mb-0">Discover Movies</h2>
      <input
        v-model="searchQuery"
        type="text"
        class="form-control w-auto"
        placeholder="Search movies..."
        @keyup.enter="searchMovies"
      />
      <div class="btn-group" role="group">
        <button
          type="button"
          class="btn btn-outline-primary"
          :class="{ active: currentTab === 'trending' }"
          @click="changeTab('trending')"
        >Trending</button>
        <button
          type="button"
          class="btn btn-outline-primary"
          :class="{ active: currentTab === 'topRated' }"
          @click="changeTab('topRated')"
        >Top Rated</button>
      </div>
    </div>

    <!-- Movie Grid -->
    <div class="row">
      <div class="col-md-3 mb-4" v-for="movie in movies" :key="movie.id">
        <div class="card h-100">
          <img
            :src="movie.poster_path ? 'https://image.tmdb.org/t/p/w500' + movie.poster_path : fallbackImage"
            class="card-img-top"
            :alt="movie.title"
          />
          <div class="card-body">
            <h5 class="card-title">{{ movie.title }}</h5>
            <button class="btn btn-sm btn-outline-primary w-100 mb-2" @click="openTrailer(movie.id)">Play Trailer</button>
            <button
              class="btn btn-sm btn-outline-success w-100"
              @click="toggleWatchlist(movie)"
            >
              {{ isInWatchlist(movie.id) ? '✓ In Watchlist' : '➕ Add to Watchlist' }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <nav class="d-flex justify-content-center my-4" v-if="!searchQuery">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: page === 1 }">
          <button class="page-link" @click="page--" :disabled="page === 1">Previous</button>
        </li>
        <li class="page-item disabled">
          <span class="page-link">Page {{ page }}</span>
        </li>
        <li class="page-item">
          <button class="page-link" @click="page++">Next</button>
        </li>
      </ul>
    </nav>

    <!-- Spinner -->
    <div v-if="loading" class="text-center my-5">
      <div class="spinner-border text-primary" role="status"></div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="trailerModal" tabindex="-1" aria-labelledby="trailerModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Trailer</h5>
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

<script setup>
import { ref, onMounted, watch } from 'vue';

const currentTab = ref('trending');
const page = ref(1);
const movies = ref([]);
const searchQuery = ref('');
const loading = ref(false);
const trailerKey = ref('');
const fallbackImage = 'https://via.placeholder.com/300x450?text=No+Image';
const watchlist = ref(JSON.parse(localStorage.getItem('watchlist')) || []);

const fetchMovies = async () => {
  loading.value = true;

  const baseUrl = searchQuery.value
    ? 'https://api.themoviedb.org/3/search/movie'
    : currentTab.value === 'trending'
    ? 'https://api.themoviedb.org/3/trending/movie/week'
    : 'https://api.themoviedb.org/3/movie/top_rated';

  const queryParams = searchQuery.value
    ? `query=${encodeURIComponent(searchQuery.value)}&page=1`
    : `page=${page.value}`;

  try {
    const res = await fetch(`${baseUrl}?api_key=${import.meta.env.VITE_TMDB_API_KEY}&${queryParams}`);
    const data = await res.json();
    movies.value = data.results || [];
  } catch (error) {
    console.error('Error fetching movies:', error);
  } finally {
    loading.value = false;
  }
};

const searchMovies = () => {
  page.value = 1;
  fetchMovies();
};

const changeTab = (tab) => {
  searchQuery.value = '';
  currentTab.value = tab;
  page.value = 1;
};

const openTrailer = async (movieId) => {
  trailerKey.value = '';

  try {
    const res = await fetch(
      `https://api.themoviedb.org/3/movie/${movieId}/videos?api_key=${import.meta.env.VITE_TMDB_API_KEY}`
    );
    const data = await res.json();
    const trailer = data.results.find(
      (video) => video.type === 'Trailer' && video.site === 'YouTube'
    );
    trailerKey.value = trailer ? trailer.key : null;

    const modal = new bootstrap.Modal(document.getElementById('trailerModal'));
    modal.show();
  } catch (error) {
    console.error('Error fetching trailer:', error);
  }
};

const toggleWatchlist = (movie) => {
  const index = watchlist.value.findIndex((m) => m.id === movie.id);
  if (index === -1) {
    watchlist.value.push(movie);
  } else {
    watchlist.value.splice(index, 1);
  }
  localStorage.setItem('watchlist', JSON.stringify(watchlist.value));
};

const isInWatchlist = (movieId) => {
  return watchlist.value.some((m) => m.id === movieId);
};

watch([currentTab, page], () => {
  if (!searchQuery.value) fetchMovies();
});

onMounted(fetchMovies);
</script>
