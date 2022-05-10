import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index'
import Main from "../views/Main"
import Admin from "../views/Admin"
import Auth from "../views/auntificate"
import Posts from "../views/posts/index"
import Post from "../views/posts/post"
import Teacher from "../views/teachers/teacher"
import Category from "../views/categories/category"
import Cource from "../views/cources/cource"
import Cources from "../views/cources/index"
import Parrent from "../views/parrents/index"
import About from "../views/about/index"
import Documents from "../views/documents/index"
import NotFound from "../views/404"
import Layout from "../loyouts/loyout.vue"

Vue.use(VueRouter)

const routes = [{
    path: '/',
    name: 'main',
    component: Main,
  },
  {
    path: '/admin-panel',
    component: Admin,
    meta: {
      requiresAuth: true,
      isAdmin: true
    }
  },
  {
    path: '/login',
    component: Layout,
    children: [{
      path: '',
      component: Auth,
      meta: {
        guest: true
      },
    }, ]
  },
  {
    path: '/bookmarks',
    component: Layout,
    children: [{
      path: '',
      name: 'bookmarks',
      component: () => import('../views/bookmarks'),
      meta: {
        guest: true
      },
    }, ]
  },
  {
    path: '/documents',
    component: Layout,
    children: [{
      path: '',
      component: Documents,
      name: 'documents',
      meta: {
        breadcrumb: [{
            name: 'Главная',
            link: '/'
          },
          {
            name: 'Документы'
          }
        ],
        cookie: true
      },
    }, ]
  },
  {
    path: '/about',
    component: Layout,
    children: [{
      path: '',
      component: About,
      name: 'about',
      meta: {
        breadcrumb: [{
            name: 'Главная',
            link: '/'
          },
          {
            name: 'О нас'
          }
        ],
        cookie: true
      },
    }, ]
  },
  {
    path: '/parrent',
    component: Layout,
    children: [{
      path: '',
      component: Parrent,
      meta: {
        breadcrumb: [{
            name: 'Главная',
            link: '/'
          },
          {
            name: 'Родителям'
          }
        ],
        cookie: true
      },
    }, ]
  },
  {
    path: '/posts',
    component: Layout,
    children: [{
        path: "",
        component: Posts,
        name: "posts",
        meta: {
          breadcrumb: [{
              name: 'Главная',
              link: '/'
            },
            {
              name: 'Блог'
            }
          ],
          cookie: true
        },
      },
      {
        path: ":post",
        component: Post,
        name: "posts-post",
        meta: {
          breadcrumb: [{
              name: 'Главная',
              link: '/'
            },
            {
              name: 'Блог',
              link: '/posts'
            },
            {
              name: ''
            }
          ],
          cookie: true
        },
      },
      {
        path: "",
        redirect: {
          name: 'posts'
        }
      },
    ]
  },

  {
    path: '/teacher/:teacher',
    component: Layout,
    children: [{
        path: "",
        component: Teacher,
        name: "teachers-teacher"
      },
      {
        path: "*/*",
        redirect: {
          name: 'Main'
        }
      },
    ]
  },

  {
    path: '/categories/:category',
    component: Layout,
    children: [{
        path: "",
        component: Category,
        name: "categories-category"
      },
      {
        path: "*/*",
        redirect: {
          name: 'Main'
        }
      },
    ]
  },

  {
    path: '/cources',
    component: Layout,
    children: [{
        path: "",
        component: Cources,
        name: "cources",
        meta: {
          breadcrumb: [{
              name: 'Главная',
              link: '/'
            },
            {
              name: 'Курсы'
            }
          ],
          cookie: true
        },
      },
      {
        path: ":cource",
        component: Cource,
        name: "courses-cource",
        meta: {
          breadcrumb: [{
              name: 'Главная',
              link: '/'
            },
            {
              name: 'Курсы',
              link: '/cources'
            },
            {
              name: ''
            }
          ],
          cookie: true
        },
      },
      {
        path: "*/*",
        redirect: {
          name: 'Main'
        }
      },
    ]
  },

  {
    path: '*',
    component: Layout,
    children: [{
      path: "",
      component: NotFound,
      name: "NotFound"
    }, ]
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
  scrollBehavior(to) {
    if (to.hash) {
      return {
        selector: to.hash,
        behavior: 'smooth',
      }
    }
    return {
      x: 0,
      y: 0
    };
  }
})


router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.isAdmin)) {
    if (store.getters.isAdmin) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.cookie)) {
    if (localStorage.getItem("GDPR:accepted", true)) {
      next()
      return
    }
    next('/')
  } else {
    next()
  }
})




export default router