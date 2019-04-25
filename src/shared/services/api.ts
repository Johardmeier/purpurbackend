import * as axios from "axios";
import jwt_decode from "jwt-decode";

export const apiService = {
  getData,
  logIn,
  logOut,
  loggedIn,
  postData
};

interface jwtData {
  'iss':string;
  'sub':number;
  'roles':string[];
  'iat':number;
  'exp':number;
}

export interface ppApiResponseData {
  userName:string;
  userFullName: string;
  userImage:string;
  userRoles:string[];
  expires:number;
}


export interface ppApiUser {
  id: number;
  name: string;
  fullName:string;
  email: string;
  image: string;
  roles: string[];
}


// ********************** ROLES **************************



// ********************** AUTH **************************
function getAuthData():(ppApiResponseData|null) {
  let at=localStorage.getItem('auth')||'{}';

  let auth = JSON.parse(at);
  if (auth && auth.token) {
    let decoded:jwtData = jwt_decode(auth.token);
    return {
      userName : auth.name,
      userFullName : auth.fullName,
      userImage: auth.image,
      userRoles: decoded.roles,
      expires: decoded.exp
    }
  }
  return null;
}

function logIn(username:string, password:string):Promise<any> {
  return axios.default({
    method:"post",
    url: makeUrl("/auth/login"),
    auth: {username, password},
    withCredentials:true,
    transformResponse:(data)=>{
      localStorage.setItem("auth", data);
      return data;
    }
    //xsrfCookieName
    })
    .then((response: axios.AxiosResponse) =>{
      return Promise.resolve(getAuthData());
    })
    .catch((error: axios.AxiosError) => {
      localStorage.removeItem("auth");
      let responseData=error.response || {data:{error:"undefined Error"},status:0,statusText:"something went wrong"};
      return Promise.reject({title:responseData.statusText,message:responseData.data.error});
    });
}

function logOut() {
  localStorage.removeItem("auth");
}

function loggedIn():(ppApiResponseData|null) {
  return getAuthData();
}

//TODO:: auto logout when expired OR refresh
// ********************** HELPERS **************************
function makeUrl(endpoint:string="", folder: string=""):string {
  return process.env.VUE_APP_API_ROOT + folder + endpoint + '?XDEBUG_SESSION_START=idea';
}

function makeAuthHeader() { // return authorization header with jwt token
  let auth = JSON.parse(localStorage.getItem('auth')||'{}');

  if (auth && auth.token) {
    return { 'Authorization': 'Bearer ' + auth.token };
  } else {
    return {};
  }
}

function makeCorsHeader() {
  // return {"Access-Control-Allow-Origin": "*"};
  return {};
}

function makeDebugHeader() {
  //return {"Cookie": "XDEBUG_SESSION=1"};
  return {};
}

function makeParams(withRelations: boolean) {
  return withRelations ? {} : {}
}

function makeJsonHeader() {
  return {"Content-Type": "application/json;charset=UTF-8"};
}

//TODO:: Error handling
function getData(endpoint:string, payload: object={}, withErrors=false) {
  return axios.default({
    method: "get",
    url: makeUrl(endpoint,"/api"),
    withCredentials: true,
//    params: makeParams(withRelations),
    headers: Object.assign(makeAuthHeader(),makeCorsHeader()),
    params: payload
  })
  .then((response) => {
    return Promise.resolve(response.data);
  })
  .catch((error) => {
    if (withErrors){
      //make message
    }
    return Promise.reject(error);
  })
}

function postData(endpoint:string, payload: object, withErrors=false) {
  return axios.default({
    method: "post",
//TODO :: Restrict this to dev
    url: makeUrl(endpoint,"/api"),
    withCredentials: true,
    headers: Object.assign(makeAuthHeader(),makeJsonHeader(),makeCorsHeader(),makeDebugHeader()),
    data: payload
  })
    .then((response) => {
      return Promise.resolve(response.data);
    })
    .catch((error) => {
      if (withErrors){
        //make message
      }
      return Promise.reject(error);
    })
}