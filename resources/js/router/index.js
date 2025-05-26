import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Trending from '../pages/Trending.vue'
import TopRated from '../pages/TopRated.vue'
import MovieDetails from '../pages/MovieDetails.vue'
import Watchlist from '../pages/Watchlist.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/trending', component: Trending },
  { path: '/top-rated', component: TopRated },
  { path: '/movie/:id', component: MovieDetails },
  { path: '/watchlist', component: Watchlist },
  {
  path: '/movie/:id',
  name: 'MovieDetail',
  component: () => import('@/Pages/MovieDetails.vue'),
}
]

export default createRouter({
  history: createWebHistory(),
  routes
})
