import {Module, ActionTree, MutationTree} from 'vuex';
import {RootState} from "../types";
import {timeout} from "q";

interface AlertState{
  type:string|null;
  message:string|null;
  title:string|null;
}

const namespaced:boolean=true;

export const state: AlertState = {
  type: null,
  message:null,
  title:null,
};

export const actions: ActionTree<AlertState,RootState>={
  success({ commit }, message) {
    //commit('success', message);
    //setTimeout(() => commit('clear'),3000)

  },
  error({ commit }, message) {
    commit('error', message);
    setTimeout(() => commit('clear'),3000)
  },
  clear({ commit }) {
    commit('clear');
  }
};

export const mutations: MutationTree<AlertState> = {
  success(state, message) {
    state.type = 'alert-success';
    state.message = message.message;
    state.title = message.title||"Erfolg";
  },
  error(state, message) {
    state.type = 'alert-danger';
    state.message = message.message;
    state.title = message.title||"Fehler";
  },
  clear(state) {
    state.type = null;
    state.message = null;
    state.title = null;
  }
};

export const alert: Module<AlertState,RootState>={
  namespaced,state,actions,mutations
};
