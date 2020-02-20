import Vue from 'vue'
import Vuex from 'vuex'
import user from './user'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    users:[
      {
        title:'22'
      },
      {
        title:'33'
      }
    ]
  },
  modules: {
    user
  }
})
