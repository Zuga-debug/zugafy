<!-- 
<template>
    <div v-if="show" class="modal-overlay" @click.self="close">
      <div class="modal-content">
        <iframe
          v-if="videoKey"
          width="100%"
          height="400"
          :src="`https://www.youtube.com/embed/${videoKey}`"
          frameborder="0"
          allowfullscreen
        ></iframe>
        <p v-else>❌ Trailer not available</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { watch, ref } from 'vue';
  
  const props = defineProps({
    show: Boolean,
    movieId: Number,
  });
  
  const emit = defineEmits(['close']);
  
  const videoKey = ref('');
  
  watch(
    () => props.movieId,
    async (id) => {
      if (!id) return;
      videoKey.value = '';
      const res = await fetch(
        `https://api.themoviedb.org/3/movie/${id}/videos?api_key=${import.meta.env.VITE_TMDB_API_KEY}`
      );
      const data = await res.json();
      const trailer = data.results.find(
        (v) => v.type === 'Trailer' && v.site === 'YouTube'
      );
      videoKey.value = trailer?.key || '';
    },
    { immediate: true }
  );
  
  function close() {
    emit('close');
  }
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
  }
  .modal-content {
    background: #fff;
    padding: 1rem;
    border-radius: 8px;
    max-width: 800px;
    width: 90%;
  }
  </style>
   -->

  <template>
  <div class="modal fade show d-block" tabindex="-1" v-if="show">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Trailer</h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <iframe
            class="w-100"
            :src="trailerUrl"
            height="400"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps(['show', 'trailerUrl']);
</script>
