<template>


  <div class="p-8" v-if="movie">

    <button @click="goBack" class=" btn mb-6 bg-gray-300 hover:bg-gray-400 text-gray-600  ">
      ← Back
    </button>
    <div class="flex flex-col md:flex-row gap-8">
      <img :src="getImageUrl(movie.poster_path)" alt="Poster" class="w-72 rounded shadow" />
      
      <div>
        <h1 class="text-4xl font-bold mb-4">{{ movie.title }}</h1>
        <p class="text-gray-600 mb-4">{{ movie.overview }}</p>
        <p><strong>Release Date:</strong> {{ movie.release_date }}</p>
        <p><strong>Rating:</strong> {{ movie.vote_average }} / 10</p>
      </div>
    </div>
    <!-- watchlist -->
    <button
  @click="toggleWatchlist"
  class="mt-4 px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700"
>
  {{ isInWatchlist ? 'Remove from Watchlist' : 'Add to Watchlist' }}
</button>
  </div>

  <div v-else class="p-8">
    Loading...
  </div>

  <!-- trailer movie -->
  <iframe v-if="trailerUrl" :src="trailerUrl" frameborder="0" allowfullscreen class="w-full h-96 mt-6"></iframe>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const movie = ref(null);
const route = useRoute();
const router = useRouter();

// fetchMovieDetails
const fetchMovieDetails = async (id) => {
  try {
    const response = await fetch(`https://api.themoviedb.org/3/movie/${id}?api_key=${import.meta.env.VITE_TMDB_API_KEY}`);
    const data = await response.json();
    movie.value = data;
  } catch (error) {
    console.error('Error fetching movie details:', error);
  }
};

const getImageUrl = (path) => {
  return `https://image.tmdb.org/t/p/w500${path}`;
};

const trailerUrl = ref('');

// fetchTrailer
const fetchTrailer = async (id) => {
  const res = await fetch(`https://api.themoviedb.org/3/movie/${id}/videos?api_key=${import.meta.env.VITE_TMDB_API_KEY}`);
  const data = await res.json();
  const trailer = data.results.find(video => video.type === 'Trailer' && video.site === 'YouTube');
  trailerUrl.value = trailer ? `https://www.youtube.com/embed/${trailer.key}` : '';
};

const isInWatchlist = ref(false);

const checkWatchlist = async () => {
  const response = await fetch(`http://127.0.0.1:8000/api/watchlist/${route.params.id}`);
  const data = await response.json();
  isInWatchlist.value = data.exists;
};

const toggleWatchlist = async () => {
  const url = `http://127.0.0.1:8000/api/watchlist/${route.params.id}`;
  const method = isInWatchlist.value ? 'DELETE' : 'POST';

  await fetch(url, {
    method,
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      title: movie.value.title,
      poster_path: movie.value.poster_path,
      tmdb_id: movie.value.id,
    }),
  });

  isInWatchlist.value = !isInWatchlist.value;
};

onMounted(() => {
  fetchMovieDetails(route.params.id);
  fetchTrailer(route.params.id);
  checkWatchlist(); // Check if movie is in watchlist
});


const goBack = () =>{
  router.back();
}


</script>

<style scoped>
button{
  background-color: blue;
  color: white;
  padding: 10px;
  margin: 30px;
  border: none;
  box-shadow: 0.7 9 blue;
  border-radius: 6px;
  font-weight: 700;

}
button:hover{
  background-color: rgb(48, 48, 219);
}
</style>
