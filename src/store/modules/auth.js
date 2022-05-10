//store/modules/auth.js

import axios from 'axios';
const state = {
  status: '',
  token: '',
  user: {},
  favorites: []
};
const getters = {
  isLoggedIn: state => state.token,
  authStatus: state => state.status,
  isAdmin: state => state.user.status == 2,
};
const actions = {
  Register({
    commit
  }, data) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios({
          url: `${process.env.VUE_APP_ROOT_API}/register `,
          data: data,
          method: 'POST'
        })
        .then(resp => {
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error', err)
          reject(err)
        })
    })
  },
  LogIn({
    commit
  }, data) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios({
          url: `${process.env.VUE_APP_ROOT_API}/login`,
          data: data,
          method: 'POST'
        })
        .then(resp => {
          const token = resp.data.token
          const user = resp.data.user
          axios.defaults.headers.common['Authorization'] = token
          commit('auth_success', token)
          commit('user', user)
          commit('favorites', user.favorites)
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          reject(err)
        })
    })
  },
  LogOut({
    commit
  }) {
    return new Promise((resolve) => {
      axios({
        url: `${process.env.VUE_APP_ROOT_API}/logout`,
        method: 'POST',
        headers: {
          Authorization: 'Bearer ' + state.token
        }
      })
      commit('LogOut')
      resolve()
    })
  },
  favoritePosts({
    commit
  }, {userId, postId}) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios({
          url: `${process.env.VUE_APP_ROOT_API}/favorite/${userId}/${postId}`,
          method: 'POST'
        })
        .then(resp => {
          const favorites = resp.data.favorites
          commit('favorite_change')
          commit('favorites', favorites)
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          reject(err)
        })
    })
  },
};
const mutations = {
  auth_request(state) {
    state.status = 'loading'
  },
  auth_success(state, token) {
    state.status = 'success';
    state.token = token;
  },
  user(state, user) {
    state.user = user;
  },
  favorites(state, favorites) {
    state.favorites = favorites;
  },
  favorite_change(state) {
    state.status = 'success';
  },
  auth_error(state) {
    state.status = 'error'
  },
  LogOut(state) {
    state.status = ''
    state.token = ''
    state.user = null
    state.favorites = null
  },
};
export default {
  state,
  getters,
  actions,
  mutations
};