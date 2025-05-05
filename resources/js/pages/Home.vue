<!-- <template>
  <div class="page p-8">
    <div class="flex gap-4 mb-6">
      <button
        @click="activeTab = 'trending'"
        :class="[
          'trending_tab px-4 py-2 rounded',
          activeTab === 'trending' ? 'bg-blue-600 text-white' : 'bg-gray-200'
        ]"
      >
        🎬 Trending
      </button>

      <button
        @click="activeTab = 'topRated'"
        :class="[
          'px-4 py-2 rounded',
          activeTab === 'topRated' ? 'bg-blue-600 text-white' : 'bg-gray-200'
        ]"
      >
        ⭐ Top Rated
      </button>
    </div>

    <Spinner v-if="loading" />
    <div class="movies-grid" v-else>
      <div
        v-for="movie in activeTab === 'trending' ? movies : topRated"
        :key="movie.id"
        class="movie-card"
      >
        <router-link :to="`/movie/${movie.id}`">
          <img :src="getImageUrl(movie.poster_path)" alt="Movie Poster" />
        </router-link>
        <h2 class="mt-2 font-medium">{{ movie.title }}</h2>
        <button @click="addToWatchlist(movie)">➕ Add to Watchlist</button>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';
// import spinner from './spinner.vue';

const loading = ref(true);
// const loadingTopRated = ref(true);
const movies = ref([]);
const topRated = ref([]);
const activeTab = ref('trending');

const fetchMovies = async () => {
  try {
    const res1 = await fetch(
      `https://api.themoviedb.org/3/trending/movie/week?api_key=${import.meta.env.VITE_TMDB_API_KEY}`
    );
    const trendingData = await res1.json();
    movies.value = trendingData.results;

    const res2 = await fetch(
      `https://api.themoviedb.org/3/movie/top_rated?api_key=${import.meta.env.VITE_TMDB_API_KEY}`
    );
    const topRatedData = await res2.json();
    topRated.value = topRatedData.results;
  } catch (err) {
    console.error('Fetch error:', err);
  } finally {
    loading.value = false;
  }
};

const getImageUrl = (path) => `https://image.tmdb.org/t/p/w500${path}`;

const addToWatchlist = (movie) => {
  let watchlist = JSON.parse(localStorage.getItem('watchlist')) || [];
  if (!watchlist.some(m => m.id === movie.id)) {
    watchlist.push(movie);
    localStorage.setItem('watchlist', JSON.stringify(watchlist));
    alert('✅ Movie added to Watchlist!');
  } else {
    alert('⚡ Already in Watchlist');
  }
};

onMounted(() => {
  fetchMovies();
  
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
  background: #3490dc;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s;
}
button:hover {
  background: #2779bd;
}
.trending_tab{
  margin-right: 30px;
}
</style> -->

<template>
  <div>
    <div class="tabs">
      <button @click="currentTab = trendingTab">🔥 Trending</button>
      <button @click="currentTab = TopRatedTab">⭐ Top Rated</button>
    </div>

    <transition name="fade" mode="out-in">
      <keep-alive>
        <component :is="currentTab" />
      </keep-alive>
    </transition>
  </div>
</template>

<script setup>
import { shallowRef } from 'vue';
import TrendingTab from '../components/trendingTab.vue';
import TopRatedTab from '../components/TopRatedTab.vue';

const currentTab = shallowRef(TrendingTab); // ✅ safe reference to component

</script>
<style>
.tabs button {
  margin-right: 1rem;
  padding: 0.5rem 1rem;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
