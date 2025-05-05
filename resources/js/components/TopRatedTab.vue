<!-- <template>
    <div class="tab-content">
      <h2>🔥 Trending Movies</h2>
      <div class="movies-grid">
        <div v-for="movie in movies" :key="movie.id">{{ movie.title }}</div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
  
  const movies = ref([]);
  const scrollY = ref(0);
  
  const fetchMovies = async () => {
    const res = await fetch(`https://api.themoviedb.org/3/movie/top_rated?api_key=${import.meta.env.VITE_TMDB_API_KEY}`);
    const data = await res.json();
    movies.value = data.results;
  };
  
  onMounted(() => {
    fetchMovies();
    nextTick(() => window.scrollTo(0, scrollY.value));
  });
  
  onBeforeUnmount(() => {
    scrollY.value = window.scrollY;
  });
  </script>
   -->

   <template>
    <div class="tab-content">
      <h2>🔥 Trending Movies</h2>
      <div class="movies-grid">
        <div v-for="movie in movies" :key="movie.id">{{ movie.title }}</div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
  
  const movies = ref([]);
  const scrollY = ref(0);
  
  const fetchMovies = async () => {
    const res = await fetch(`https://api.themoviedb.org/3/movie/top_rated?api_key
    =${import.meta.env.VITE_TMDB_API_KEY}`);
    const data = await res.json();
    movies.value = data.results;
  };
  
  onMounted(() => {
    fetchMovies();
    nextTick(() => window.scrollTo(0, scrollY.value));
  });
  
  onBeforeUnmount(() => {
    scrollY.value = window.scrollY;
  });
  </script>
  