import Vue from 'vue'
import VueRouter from 'vue-router'
import {routes} from './routes.js'
import store from '../store.js'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: routes,
})

router.beforeEach((to, from, next) => {
  // redirect to login page if not logged in and trying to access a restricted page
  const publicPages = ['/login', '/callback']; 
  const authRequired = !publicPages.includes(to.path);
  const {authorize} = to.meta;
  const userProfile = store.state.profile;

  if (authRequired && !userProfile && to.name != 'Login') {
    return next('/login');
  }

  // redirect '/' and '/login' to Profile Home
  if (to.name == 'Home' || ( userProfile && to.name == 'Login')){
    return next('/' + userProfile);
  }

  if (authorize){
    // Profile not authorized, redirect to home
    if ( authorize.lenght < 1 || !authorize.includes(userProfile) ) {
      return next('/404' );
    }
  }
  next();
  
});

export default router;