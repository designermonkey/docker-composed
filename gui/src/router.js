import Vue from 'vue'
import VueMeta from 'vue-meta'
import VueRouter from 'vue-router'

import routes from '@/routes'

Vue.use(VueMeta)
Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  linkActiveClass: 'active',
  linkExactActiveClass: 'exact',
  fallback: false,
  routes
})

export default router
