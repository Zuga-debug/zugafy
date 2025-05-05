import { createRouter, createWebHistory } from 'vue-router';

// Pages
import Home from '../pages/Home.vue';
import Watchlist from '../pages/Watchlist.vue';
import MovieDetails from '../pages/MovieDetails.vue';
import Search from '../pages/Search.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home 
     },
    { 
        path: '/watchlist',
        name: 'Watchlist', 
        component: Watchlist 
    },
    { 
        path: '/movie/:id',
        name: 'MovieDetails',
        component: MovieDetails 
    },
    { 
        path: '/search',
         name: 'Search', 
        component: Search
 },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
