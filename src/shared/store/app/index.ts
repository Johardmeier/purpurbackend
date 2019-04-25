import { Module, ActionTree, MutationTree, GetterTree } from "vuex";
import { RootState } from "../types";
//import { AppState } from "./types";
import { AuthState, AuthStateType } from "@/shared/store/auth/types";
import {authRouteConfig, authRoutes, router} from "@/shared/router";

const namespaced: boolean = true;

// ******************** INTERFACES ************************
export interface AppState {
  showSidemenu:boolean;
//  authRoutes:authRouteConfig[]
}

// ********************* STATE *****************************
export const state: AppState = {
  showSidemenu: true,
//  authRoutes:[]
};

// ******************** ACTIONS *****************************
export const actions: ActionTree<AppState, RootState> = {};

// ******************** MUTATIONS *****************************
export const mutations: MutationTree<AppState> = {
  toggleSidemenu(state) {
    state.showSidemenu = !state.showSidemenu;
  },
};

// ******************* GETTERS
export const getters: GetterTree<AppState, RootState> = {
  showSideMenu(state) { return state.showSidemenu}
  /*
  navGroup(){
    return state.navGroup;
  }
  isLoggedIn(state): boolean {
    return state.status===AuthStateType.LOGGED_IN;
  },
  getRoles(roles){
    if (state.user && state.user.roles)
      return state.user.roles;
    else
      return ["public"];
  },
  userImage(state):string {
    if (state.user && state.user.image)
      return state.user.image;
    else
      return "";
  }*/
};


export const application: Module<AppState, RootState> = {
  namespaced,
  state,
  actions,
  mutations,
  getters
};
