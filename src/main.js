import Vue from 'vue'
import App from './App.vue'
import router from './router';
import store from './store';
import axios from 'axios';
import './index.css'
import VueQuillEditor from 'vue-quill-editor'
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import VueMeta from 'vue-meta'
import YmapPlugin from 'vue-yandex-maps'


axios.defaults.withCredentials = false
axios.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded'
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

Vue.prototype.$http = axios;
const token = store.state.auth.token
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}

Vue.prototype.$scrollTop = function () {
  var element = document.getElementById("app");
  var top = element.offsetTop;
  window.scrollTo({
    top: top,
    behavior: 'smooth'
  });
}


Vue.prototype.$http.interceptors.response.use(undefined, function (error) {
  if (error) {
    const originalRequest = error.config;
    if (error.response.status === 401 && !originalRequest._retry) {

      originalRequest._retry = true;
      store.dispatch('LogOut')
      return router.push('/login')
    }
  }
})

const settings = {
  apiKey: '',
  lang: 'ru_RU',
  coordorder: 'latlong',
  enterprise: false,
  version: '2.1'
}

Vue.config.productionTip = false
Vue.use(YmapPlugin, settings);
Vue.use(VueMeta, {
  refreshOnceOnNavigation: true
})
new Vue({
  store,
  VueQuillEditor,
  router,
  render: h => h(App)
}).$mount('#app')