<template>
  <div class="p-8">
    <h1 class="text-2xl font-bold mb-4">🔍 Search Movies</h1>

    <input
      type="text"
      v-model="query"
      placeholder="Type to search..."
      class="border p-2 rounded w-full max-w-md mb-6"
    />

    <div v-if="loading">Loading...</div>

    <div v-if="movies.length" class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div v-for="movie in movies" :key="movie.id" class="movie-card">
   <button
      @click="addToWatchlist(movie)"
      class="mt-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm"
    >
      ➕ Add to Watchlist
    </button>

        <router-link :to="`/movie/${movie.id}`">
          <img :src="getImageUrl(movie.poster_path)" alt="Poster" class="rounded" />
        </router-link>
        <h2 class="text-sm mt-2 font-semibold">{{ movie.title }}</h2>
      </div>
    </div>

    <button
      v-if="!loading && currentPage < totalPages"
      @click="loadMore"
      class="mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
    >
      Load More
    </button>

    <div v-if="!loading && query && !movies.length" class="text-gray-600 mt-4">
      No results found.
    </div>
  </div>
</template>
<script setup>
import { ref, watch } from 'vue';

const query = ref('');
const movies = ref([]);
const loading = ref(false);
const currentPage = ref(1);
const totalPages = ref(1);
let debounceTimeout = null;

const searchMovies = async (reset = true) => {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(async () => {
    if (!query.value.trim()) {
      movies.value = [];
      return;
    }

    if (reset) {
      currentPage.value = 1;
      movies.value = [];
    }

    loading.value = true;

    try {
      const res = await fetch(
        `https://api.themoviedb.org/3/search/movie?api_key=${import.meta.env.VITE_TMDB_API_KEY}&query=${encodeURIComponent(query.value)}&page=${currentPage.value}`
      );
      const data = await res.json();
      totalPages.value = data.total_pages;

      if (reset) {
        movies.value = data.results;
      } else {
        movies.value = [...movies.value, ...data.results];
      }
    } catch (err) {
      console.error('Search error:', err);
    } finally {
      loading.value = false;
    }
  }, 500);
};

const loadMore = () => {
  currentPage.value++;
  searchMovies(false); // fetch next page
};

const addToWatchlist = (movie) => {
  const list = JSON.parse(localStorage.getItem('watchlist') || '[]');
  if (!list.some((m) => m.id === movie.id)) {
    list.push(movie);
    localStorage.setItem('watchlist', JSON.stringify(list));
  }
};

watch(query, () => searchMovies(true)); // reset on new input

const getImageUrl = (path) => `https://image.tmdb.org/t/p/w500${path}`;
</script>
