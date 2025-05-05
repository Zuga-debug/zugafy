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
    <div class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <button class="close-btn" @click="closeModal">✖</button>
  
        <div v-if="loading" class="loading">Loading trailer...</div>
  
        <iframe
          v-if="videoKey"
          width="100%"
          height="400"
          :src="`https://www.youtube.com/embed/${videoKey}?autoplay=1`"
          frameborder="0"
          allowfullscreen
          allow="autoplay"
        ></iframe>
  
        <div v-else-if="!loading">
          <p>🚫 Trailer not available.</p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, onMounted } from 'vue';
  
  const props = defineProps({
    movieId: {
      type: Number,
      required: true,
    },
  });
  const emit = defineEmits(['close']);
  
  const videoKey = ref(null);
  const loading = ref(true);
  
  const fetchTrailer = async () => {
    loading.value = true;
    try {
      const res = await fetch(
        `https://api.themoviedb.org/3/movie/${props.movieId}/videos?api_key=${import.meta.env.VITE_TMDB_API_KEY}`
      );
      const data = await res.json();
      const trailer = data.results.find(
        (vid) => vid.type === 'Trailer' && vid.site === 'YouTube'
      );
      videoKey.value = trailer?.key || null;
    } catch (error) {
      console.error('Failed to fetch trailer:', error);
      videoKey.value = null;
    } finally {
      loading.value = false;
    }
  };
  
  const closeModal = () => {
    emit('close');
  };
  
  watch(() => props.movieId, fetchTrailer, { immediate: true });
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }
  .modal-content {
    background: #fff;
    padding: 1rem;
    border-radius: 8px;
    position: relative;
    max-width: 700px;
    width: 90%;
  }
  .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    background: none;
    border: none;
    cursor: pointer;
  }
  .loading {
    text-align: center;
    padding: 2rem;
  }
  </style>
  