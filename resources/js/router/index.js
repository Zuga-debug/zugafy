import { createRouter, createWebHistory } from 'vue-router'
import Home from '../pages/Home.vue'
import Trending from '../pages/Trending.vue'
import TopRated from '../pages/TopRated.vue'
import MovieDetails from '../pages/MovieDetails.vue'
import Watchlist from '../pages/Watchlist.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/trending', component: Trending },
  { path: '/top-rated', component: TopRated },
  { path: '/movie/:id', component: MovieDetails },
  { path: '/watchlist', component: Watchlist, meta: { requiresAuth: true } },
  {
  path: '/movie/:id',
  name: 'MovieDetail',
  component: () => import('@/Pages/MovieDetails.vue'),
}
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  });
router.beforeEach(async (to, from, next) => {
  const isLoggedIn = !!localStorage.getItem('user');

  if (to.meta.requiresAuth && !isLoggedIn) {
    next('/login');
  } else {
    next();
  }
});

export default router;