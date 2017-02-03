import Vue from 'vue'
import VueMoment from 'vue-moment'
import VueRouter from 'vue-router'
import VueRecource from 'vue-resource'
import store from './store/index.js'
import VeeValidate from 'vee-validate';
Vue.use(VueMoment);
Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(VueRecource);
Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementsByName('csrf-token')[0].getAttribute('content');
Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token');

const router = new VueRouter({
    mode: 'history',
    routes: [
    	{
    		path:'/',
    		component:require('./components/home.vue'),
            name:'home'
    	},
        {
            path:'/pictures/:id(\\d+)',
            component:require('./components/picture.vue'),
            name:'picture'
        },
        {
            path:'/update/:id(\\d+)',
            component:require('./components/update.vue'),
            name:'update',
            meta:{auth:true}
        },
        {
            path:'/create',
            component:require('./components/create.vue'),
            name:'create',
            meta:{auth:true}
        },
        {
            path:'/notfound',
            component:require('./components/404.vue'),
            name:'404'
        },
        {
            path:'/login',
            component:require('./components/login.vue'),
            name:'login'
        },
        {
            path:'/reg',
            component:require('./components/reg.vue'),
            name:'reg'
        },
        {
            path:'*',
            redirect:
            {
                name:'home'
            }
        }
    ],
    scrollBehavior(to,from,savedPosition){
        if(savedPosition){
            return savedPosition;
        }else{
            return {x:0,y:0}
        }
    }
});
router.beforeEach((to,from,next)=>{
    if(to.matched.some(r=>r.meta.auth)&&localStorage.getItem('id_token')==null){
        next({
            path:'/login',
            query:{redirect:to.fullPath}
        })
    }else{
        next();
    }
})
new Vue({
    el:'#app',
    router,
    store,
    render:h=>h(require('./App.vue'))
});
