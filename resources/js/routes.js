import VueRouter from 'vue-router';
import store from './vuex.js';

let routes = [{
        path: '/login',
        name: 'login',
        component: require('./components/Login.vue').default
    }, {
        path: '/register',
        name: 'register',
        component: require('./components/register.vue').default
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: require('./components/admin/dashboard.vue').default,
        meta: {
            middlewareAuth: true
        },
    },
    {
        path: '/dashboardUser',
        path: '/dashboardUser',
        name: 'dashboard',
        component: require('./components/user/dashboard.vue').default,
        meta: {
            middlewareAuth: true
        },
    },
    {
        path: '/sensors',
        name: 'sensors',
        component: require('./components/Sensors.vue').default,
        meta: {
            middlewareAuth: true
        },
    },
    {
        path: '/rega',
        name: 'rega',
        component: require('./components/Rega.vue').default,
        meta: {
            middlewareAuth: true
        },
    },
    {
        path: '/removerPerson',
        name: 'removerPerson',
        component: require('./components/removePerson.vue').default,
        meta: {
            middlewareAuth: true
        },
    },
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.middlewareAuth && (store.state.user == null)) {
        next('/login');
        return;
    }
    next();
});

export default router;
