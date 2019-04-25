import { Module, ActionTree, MutationTree, GetterTree } from "vuex";
import { RootState } from "../types";
import { AuthState,AuthStateType } from "./types";
import { User } from "@/shared/store/profile/types";

// @ts-ignore
import { Toast } from "buefy/dist/components/toast";
import { apiService } from "@/shared/services";

const initialUser = null;
const namespaced: boolean = true;

export const state: AuthState = {
  status: AuthStateType.LOGGED_OFF,
  user: initialUser,
  expires: Date.now()
};

export const actions: ActionTree<AuthState, RootState> = {
  logIn({ dispatch, commit }, { username, password }) {
    commit("loginRequest", { username });
    apiService.logIn(username, password).then(
      data => {
        commit("loginSuccess", {name:data.userName, image:data.userImage,roles:data.userRoles});
        Toast.open({
          message: "you successfully logged in as " + data.userName,
          type: "is-success"
        });
        //TODO:: route to AuthRoutes[0]....
      },
      error => {
        commit("loginFailure", error);
        Toast.open({
          message: error.message || "Unbestimmter Loginfehler",
          type: "is-warning"
        });
        apiService.logOut();
      }
    );
  },
  logOut({ commit }) {
    apiService.logOut();
    commit("logout");
  }
};

export const mutations: MutationTree<AuthState> = {
  loginRequest(state) {
    state.status = AuthStateType.LOGGING_IN;
    state.user = null;
  },
  loginSuccess(state, user) {
    state.status = AuthStateType.LOGGED_IN;
    state.user = user;
    //state.expires = expires;
  },
  loginFailure(state) {
    state.status = AuthStateType.LOGGED_OFF;
    state.user = null;
  },
  logout(state) {
    state.status = AuthStateType.LOGGED_OFF;
    state.user = null;
  },
};

export const getters: GetterTree<AuthState, RootState> = {
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
  }
};

export const authentication: Module<AuthState, RootState> = {
  namespaced,
  state,
  actions,
  mutations,
  getters
};
