import Vue from "vue";
import Vuex, {StoreOptions} from "vuex";
import {RootState} from './types';
import {profile} from './profile';
import {alert} from './alert';
import {authentication} from './auth';
import {application} from './app';
import {models} from './models';



Vue.use(Vuex);

const store:StoreOptions<RootState> = {
  state: {
    version: '1.0.0'
  },
  modules: {
    profile, alert, authentication, application, models
  }
/*  mutations: {

  },
  actions: {

  }*/
};

export default new Vuex.Store<RootState>(store);