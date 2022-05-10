//store/modules/auth.js

import axios from 'axios';
const state = {
  status: '',
  favorites: [],
};
const getters = {
  authStatus: state => state.status,
  isBookmark: state => state.favorites,
};
const actions = {
  favoritePosts({
    commit
  }, userId) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios({
          url: `${process.env.VUE_APP_ROOT_API}/favorite/${userId}/${postId}`,
          method: 'POST'
        })
        .then(resp => {
          const favorites = resp.data.favorites
          commit('auth_success')
          commit('favorites', favorites)
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          commit('del_favorites')
          reject(err)
        })
    })
  },
  favoriteChange({
    commit
  }, {
    userId,
    postId
  }) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios({
          url: `${process.env.VUE_APP_ROOT_API}/favorite/${userId}/${postId}`,
          method: 'POST'
        })
        .then(resp => {
          const favorites = resp.data.favorites
          commit('auth_success')
          commit('favorites', favorites)
          resolve(resp)
        })
        .catch(err => {
          commit('auth_error')
          commit('del_favorites')
          reject(err)
        })
    })
  },
  favoritesRemove({
    commit
  }) {
    commit('del_favorites')
  }
};
const mutations = {
  auth_request(state) {
    state.status = 'loading'
  },
  auth_success(state) {
    state.status = 'success';
  },
  favorites(state, favorites) {
    state.favorites = favorites;
  },
  auth_error(state) {
    state.status = 'error'
  },
  del_favorites(state) {
    state.favorites = null
  },
};
export default {
  state,
  getters,
  actions,
  mutations
};