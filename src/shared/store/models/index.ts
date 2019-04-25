import { Module, ActionTree, MutationTree, GetterTree } from "vuex";
import { RootState } from "../types";
import {apiService} from "@/shared/services";
// import {Toast} from "buefy";
// import { AppState } from "./types";
// import { AuthState, AuthStateType } from "@/shared/store/auth/types";
// import {authRouteConfig, authRoutes, router} from "@/shared/router";

const namespaced: boolean = true;

// ******************** INTERFACES ************************
/*
Artist
Booking
- BookingAgent
- BookingMeans
Customer
Language
Performance
- PerformanceType
Play
- PlayCapacity
- PlayCapacityrow
- PlayPricediscountAdult
- PlayPricediscountGroup
- PlayPricediscountJunior
- PlayPricestructure
Role
*/
/*
Booking
- BookingAgent
- BookingMeans
Customer
Performance
- PerformanceType
Play
- PlayCapacity
- PlayCapacityrow
- PlayPricediscountAdult
- PlayPricediscountGroup
- PlayPricediscountJunior
- PlayPricestructure
Role
*/
export interface PlayType {
  id:number;
  created_at: Date;
  updated_at: Date;
  deleted_at: Date;
  name:string;
  image:string;
  description:string;
  prosuction_infos:string;
  min_age:Number;
  duration: Number;
  artist_id: Number;
  price_structure_id: Number;
  capacity_id: Number;
  language_id: Number;
  additional_webpage_message: string;
  remarks: string;
}

export interface ArtistType {
  id:number;
  created_at: Date;
  updated_at: Date;
  deleted_at: Date;
  name:string;
  url:string;
}

export interface LanguageType {
  id:number;
  created_at: Date;
  updated_at: Date;
  deleted_at: Date;
  name:string;
  short:string;
}

export interface PerformanceType {
  id:number;
  created_at: Date;
  updated_at: Date;
  deleted_at: Date;
  value:string;
  remarks:string;
}

export interface PlayCapacityType {
  id:number;
  created_at: Date;
  updated_at: Date;
  deleted_at: Date;
  name:string;
  remarks:string;
}

export interface PlayPricestructureType {
  id:number;
  created_at: Date;
  updated_at: Date;
  deleted_at: Date;
  name:string;
  remarks:string;
  adult_price: number;
  junior_price: number;
}

export interface PlayCapacityrowType {
  id:number;
  created_at: Date;
  updated_at: Date;
  play_capacity_id: number;
  adults: number;
  juniors: number;
}

export interface ModelsState {
  Artist: ArtistType[];
  Language: LanguageType[];
  PerformanceType: PerformanceType[];
  PlayCapacity: PlayCapacityType[];
  PlayCapacityrow: PlayCapacityrowType[];
  PlayPricestructure: PlayPricestructureType[];
  Play:PlayType[];
  [key: string]: any;
}
// ********************* STATE *****************************
export const state: ModelsState = {
  Artist: [],
  Language: [],
  PerformanceType: [],
  PlayCapacityrow: [],
  PlayCapacity: [],
  PlayPricestructure: [],
  Play: []
};

// ******************** ACTIONS *****************************

// model: ---
// data: ...
// type: ...
// relation: id; relation: model; relation: data;

// TODO:: eventually integrate helpers, if no other actions are created
export const actions: ActionTree<ModelsState, RootState> = {
  new({commit}, payload){
    updateHelper(commit, payload.model, payload.data, "newModel")
  },
  update({commit}, payload){
    updateHelper(commit, payload.model, payload.data, "updateModel")
  },
  addBelongTo({commit}, payload){
    updateHelper(commit, payload.model, payload.data, "addBelongsToModels", {id: payload.parentId, model: payload.parentModel})
  },
  replaceBelongsTo({commit}, payload){
    updateHelper(commit, payload.model, payload.data, "replaceBelongsToModels", {id: payload.parentId, model: payload.parentModel})
  },
  load({commit}, payload){
    return LoadHelper(commit, payload.model)
  }
};

// ******************** MUTATIONS *****************************
export const mutations: MutationTree<ModelsState> = {
//  updateModelArtist(commit, artists){ state.Artist = artists; },
  updateModel(commit, payload){ state[payload.model] = payload.data; },
};

// ******************* GETTERS
export const getters: GetterTree<ModelsState, RootState> = {
  //Artist() { return state.Artist; },
  model:(state) => (modelName: any) => {
    return state[modelName];
  }
};

// ******************** HELPERS *****************************
function LoadHelper(commit:any, modelName: string){
  return apiService.getData("/models", {model: modelName} ).then(u => {
    commit('updateModel' , u);
  });
}

function updateHelper(commit:any, modelName: string, data: Object, type: string, relation: Object={}){
  let payload={model : modelName, data: data, type: type, relation: relation };
  console.log(payload);
  apiService.postData("/models", payload ).then(u => {
    commit('updateModel', u);
  })
  .catch(reason => console.log(reason));
}

export const models: Module<ModelsState, RootState> = {
  namespaced,
  state,
  actions,
  mutations,
  getters
};
