import Vue from 'vue'
import Resource from 'vue-resource'
import Router from 'vue-router'
import axios from 'axios'


import notification from './services/notification';


//Imposrt Component 
import App from './components/App.vue'
import Home from './components/Home.vue'
import Buildings from './components/Buildings.vue'
import Entries from './components/Entries.vue'
import Entry_Details from './components/Entry_Details.vue'

import { store } from './vuex/store.js';


// Install plugins
Vue.use(Router)
Vue.use(Resource)
// Vue.use(axios)




var routes = [
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/buildings',
        name: 'buildings',
        component: Buildings
    },
    {
        path: '/entries',
        name: 'entries',
        component: Entries
    },
    {
        path: '/entry',//me shtu entry ID
        name: 'entry_details',
        component: Entry_Details
    },
    {   
        path:'*',
        redirect:'/home'
    },
    // {
    //   path: '/admin/products/brand/:id',
    //   name: 'productbrand',
    //   component: ProductAddComponent
    // },
]

// Set up a new router
var router = new Router({
  mode: 'history',
  routes: routes
})


new Vue({
    router: router,
    store,
    render: h => h(App)
}).$mount('#admin')

